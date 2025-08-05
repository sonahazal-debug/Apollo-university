<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Controller;
use App\Models\CategoryManagement;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\ExamCategory;
use App\Models\ExamManagement;
use App\Models\ExamPattern;
use App\Models\HomeContent;
use App\Models\QuestionManagement;
use App\Models\ResultManagement;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentExam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\Browser\ExamManagementTest;

use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function homePage(){
        $randomStudentId = 'STU' . strtoupper(Str::random(8));
        $homeContent=HomeContent::latest()->first();
        $setting=Setting::latest()->first();
        $courses = Course::pluck('course_name', 'id');


        $coursePages=Course::latest()->get();

        return view('frontend.index',compact('randomStudentId','coursePages','homeContent','setting','courses'));
    }


    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255', // Optional field with email validation if present
            'phone' => [
                'required',
                'digits:10',
                'regex:/^[6-9][0-9]{9}$/'
            ],
            'alternate_phone' => [
                'nullable',
                'digits:10',
                'regex:/^[6-9][0-9]{9}$/'
            ],
            'college' => 'required|string|max:255',
            'student_id' => 'required|string',
            'course' => 'required',
        ], [
            'phone.regex' => 'Phone number must start with 6, 7, 8, or 9.',
            'alternate_phone.regex' => 'Alternate phone number must start with 6, 7, 8, or 9.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'alternate_phone.digits' => 'Alternate phone number must be exactly 10 digits.',
        ]);

        // Always create new student (no check for existing record)
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'college' => $request->college,
            'student_id' => $request->student_id,
            'course' => $request->course,
        ]);

        session(['student' => $student->toArray()]);

        return redirect()->route('home')->with('success', 'Login successful!');
    }




    public function logout()
    {
        session()->forget('student');
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }



    // public function   testSeries(){
    //     $exams=ExamManagement::latest()->get();
    //     return view('frontend.test-series',compact('exams'));
    // }




    public function testSeries()
{
    $exams = ExamManagement::all();

    //dd($exams);

    foreach ($exams as $exam) {
        $currentDateTime = Carbon::now();
        $examStart = Carbon::parse($exam->start_date . ' ' . $exam->start_time);
        $examEnd = Carbon::parse($exam->start_date . ' ' . $exam->end_time);

        // Determine status
        if ($currentDateTime->lt($examStart)) {
            $exam->status = "Upcoming";
            $exam->countdown_time = $examStart->format('Y-m-d H:i:s');
        } elseif ($currentDateTime->between($examStart, $examEnd)) {
            $exam->status = "Ongoing";
        } else {
            $exam->status = "Exam Over";
        }
    }

    $student = (object) Session::get('student');

    $setting=Setting::latest()->first();



    return view('frontend.test-series', compact('exams','student','setting'));
}



public function examPage($course_id, $exam_name,$exam_id,$student_id)
{

    //dd($course_id);
    //dd($id);

   //dd($student_id);
    // Optionally decode if exam_name was passed as urlencode()
    $decodedExamName = urldecode($exam_name);

    // Fetch the specific exam based on course_id and exam_name
    $exam = ExamManagement::where('course_id', $course_id)
                ->where('exam_name', $decodedExamName)
                ->firstOrFail();


     //           dd($exam->start_time);

    $courseCategory = CourseCategory::where('course_id', $course_id)->pluck('category_id');

    $categories = CategoryManagement::whereIn('id', $courseCategory)->get();

    $questionsByCategory = [];

    foreach ($categories as $category) {
        $questionsByCategory[$category->id] = QuestionManagement::where('course_id', $course_id)
            ->where('exam_id', $exam->id)
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->get();
    }



    $totalQ = ExamCategory::where('course_id', $course_id)->get();

    $student = (object) Session::get('student');

    $savedQ = StudentExam::where('exam_id', $exam->id)
        ->where('student_id', $student->id)
        ->count();

        //dd($exam->start_time);

    $setting = Setting::latest()->first();

    $studentId = StudentExam::where('exam_id', $exam->id)
        ->where('student_id', $student->id)
        ->first();
        session()->flash('show_exam_popup', true);

       // dd($studentId);
    return view('frontend.exam-page', compact(
        'exam',
        'categories',
        'questionsByCategory',
        'student',
        'totalQ',
        'savedQ',
        'setting',
        'studentId'
        // 'savedAnswers'
    ));
}


public function finishSubmit(Request $request)
{
    //dd($request);
    $data = $request->all();

    $studentId = $data['student_id'];
    $courseId = $data['course_id'];
    $examId = $data['exam_id'];
    $answers = $data['answers'];

    DB::beginTransaction();

    try {
        foreach ($answers as $questionId => $answer) {
            StudentExam::create([
                'student_id'   => $studentId,
                'course_id'    => $courseId,
                'exam_id'      => $examId,
                'question_id'  => $questionId,
                'category_id'  => $answer['category_id'] ?? null,
                'option' => $answer['option'],
            ]);
        }

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'Answers submitted successfully.']);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json(['status' => 'error', 'message' => 'Failed to submit answers.', 'error' => $e->getMessage()], 500);
    }

}


public function finishPage($student_id, $course_id, $exam_id)
{
    $student = Student::find($student_id);
    $setting = Setting::latest()->first();

    return view('frontend.finish-page', compact('student', 'setting', 'student_id', 'course_id', 'exam_id'));
}

// public function key(){
//     $setting = Setting::latest()->first();
//     return view('frontend.key-sheet',compact('setting'));
// }
public function resultSheet($student_id,$course_id,$exam_id)
{
   // dd($exam_id);
    $Course_exam_Student_singleData = StudentExam::where('student_id', $student_id)->
    where('course_id',$course_id)->where('exam_id',$exam_id)->first(); //studentExam student Data single


    $totalMax_attempt_Q = ExamCategory::where('course_id', $Course_exam_Student_singleData->course_id)->sum('max_attemt_q'); //total q

    // dd($totalQ);

    $get_examName = ExamManagement::where('id',$Course_exam_Student_singleData ->exam_id)
    ->where('course_id',$Course_exam_Student_singleData ->course_id)->first(); //getExam name

    //dd($examName );

    $studentName = Student::where('id', $student_id)->first(); //student-data

    // dd($studentName );

    $totalAttemptedCount = StudentExam::where('student_id', $student_id)->
    where('course_id',$course_id)->where('exam_id',$exam_id)->count();

    //dd($totalAttempted );

    $studentAnswers = StudentExam::where('student_id', $student_id)
    ->where('course_id', $course_id)
    ->where('exam_id', $exam_id)
    ->get();

// Get all question details that the student attempted
$AdminUploadedquestions = QuestionManagement::whereIn('id', $studentAnswers->pluck('question_id'))->get();

// Create a map of question_id => correct_answer
$correctAnswersMap = $AdminUploadedquestions->pluck('answer', 'id');

// Filter student answers where student's selected option matches the correct answer
$rightAnswers = $studentAnswers->filter(function ($studentAnswer) use ($correctAnswersMap) {
    return isset($correctAnswersMap[$studentAnswer->question_id]) &&
           $studentAnswer->option === $correctAnswersMap[$studentAnswer->question_id];
});


    $correctAnsCount=$rightAnswers->count(); //correct answers Count

    //dd( $correctAnsCount);

    $inCorrectAns = $totalAttemptedCount - $correctAnsCount; //wrong answers

   //dd($inCorrectAns );

   $negativeMark = ExamCategory::where('course_id', $Course_exam_Student_singleData->course_id)
   ->pluck('negative_mark')
   ->first();

   //dd( $negativeMark);
$negativeMarks = $negativeMark * $inCorrectAns;

//dd($negativeMarks);


    $examPattern = ExamPattern::where('course_id', $Course_exam_Student_singleData->course_id)->first();
    // for pass_mark and pass_percentage get
    //dd( $examPattern);
    $passMark = $examPattern->pass_mark ?? 0;
    $passPerc = $examPattern->pass_perc ?? 0;

    //dd( $passMark);

    $finalCorrectScore = $correctAnsCount - $negativeMarks;  //final score
    // dd($finalScore );
    $percentage = $totalMax_attempt_Q  > 0 ? ($finalCorrectScore  / $totalMax_attempt_Q ) * 100 : 0; //percentage
   // dd($percentage );
    $status = ($finalCorrectScore >= $passMark && $percentage >= $passPerc) ? 'Pass' : 'Fail'; //fail pass status
    //dd($status);
    $studentCode = Student::where('id', $student_id)->value('student_id'); //studentID Code String
    //dd($studentCode );
    $notAttempted = $totalMax_attempt_Q - $totalAttemptedCount;
    //dd($notAttempted );
    $data = [
        'student_id' => $student_id,
        'exam_id' => $exam_id,
        'course_id' => $course_id,
        'total_questions' => $totalMax_attempt_Q,
        'total_attempted' => $totalAttemptedCount,
        'total_correct' => $correctAnsCount,
        'total_wrong' => $inCorrectAns,
        'score' => $finalCorrectScore ,
        'student_code' => $studentCode,
        'not_attempted' => $notAttempted,
        'percentage' => $percentage,
        'status' => $status,
    ];

    try {
        $existing = ResultManagement::where('student_id', $student_id)
            ->where('exam_id', $exam_id)
            ->first();

        if ($existing) {
            $existing->update($data);
        } else {
            ResultManagement::create($data);
        }
    } catch (\Exception $e) {
        Log::error('Failed to save ResultManagement:', [
            'error' => $e->getMessage(),
            'data' => $data,
        ]);
        return back();
    }

    $setting = Setting::latest()->first();



    return view('frontend.result-sheet', compact(
        'setting',
        'totalMax_attempt_Q',
        'get_examName',
        'studentName',
        'totalAttemptedCount',
        'correctAnsCount',
        'inCorrectAns',
        'finalCorrectScore',
        'notAttempted',
        'percentage',
        'status'
    ));


}



}








// public function finishSubmit(Request $request)
// {
//     dd($request);

//     $answersJson = $request->input('final_answers');

//     $answers = json_decode($answersJson, true);
//     //dd($answers);


//     $studentId = $request->input('student_id');
//     $examId    = $request->input('exam_id');
//     $courseId  = $request->input('course_id');

//     // Optional: get category ID from form or map by question ID
//     $categoryId = $request->input('category_id');

//     foreach ($answers as $questionId => $selectedOption) {
//         StudentExam::create([
//             'student_id'  => $studentId,
//             'exam_id'     => $examId,
//             'course_id'   => $courseId,
//             'category_id' => $categoryId,
//             'question_id' => $questionId,
//             'option'      => $selectedOption
//         ]);
//     }


//     return redirect()->back()->with('success', 'Exam submitted successfully!');
// }






// public function resultSheet(Request $request, $student_id)
// {
//     // ✅ Step 1: Get exam info from DB
//     $firstStudentExam = StudentExam::where('student_id', $student_id)->first();

//     if (!$firstStudentExam) {
//         return back()->with('error', 'Student exam record not found.');
//     }

//     $course_id = $firstStudentExam->course_id ?? $request->input('course_id');
//     $exam_id   = $firstStudentExam->exam_id ?? $request->input('exam_id');

//     // ✅ Step 2: Save submitted answers (JS object) into StudentExam model
//     if ($request->has('answers_json')) {
//         $submittedAnswers = json_decode($request->input('answers_json'), true);

//         if (is_array($submittedAnswers)) {
//             foreach ($submittedAnswers as $questionId => $selectedOption) {
//                 // Get the category_id from QuestionManagement if needed
//                 $question = \App\Models\QuestionManagement::find($questionId);
//                 $category_id = $question ? $question->category_id : null;

//                 // ✅ Insert into StudentExam
//                 StudentExam::updateOrCreate(
//                     [
//                         'student_id'  => $student_id,
//                         'question_id' => $questionId,
//                     ],
//                     [
//                         'course_id'   => $course_id,
//                         'exam_id'     => $exam_id,
//                         'category_id' => $category_id,
//                         'option'      => $selectedOption,
//                     ]
//                 );
//             }
//         }
//     }

//     // ✅ Step 3: Begin Result Calculation
//     $totalQ = ExamCategory::where('course_id', $course_id)->sum('max_attemt_q');
//     $examName = ExamManagement::find($exam_id);
//     $studentName = Student::find($student_id);
//     $totalAttempted = StudentExam::where('student_id', $student_id)->count();

//     $studentAnswers = StudentExam::where('student_id', $student_id)->get();
//     $questions = QuestionManagement::whereIn('id', $studentAnswers->pluck('question_id'))->get()->keyBy('id');

//     $rightAnswers = $studentAnswers->filter(function ($answer) use ($questions) {
//         $question = $questions->get($answer->question_id);
//         return $question && $question->answer === $answer->option;
//     });

//     $countCorrect = $rightAnswers->count();
//     $studentAllQCount = $studentAnswers->count();
//     $inCorrectAns = $studentAllQCount - $countCorrect;

//     $negative = ExamCategory::where('course_id', $course_id)->first();
//     $negativeMarks = $negative->negative_mark * $inCorrectAns;

//     $examPattern = ExamPattern::where('course_id', $examName->course_id)->first();
//     $passMark = $examPattern->pass_mark ?? 0;
//     $passPerc = $examPattern->pass_perc ?? 0;

//     $finalScore = $countCorrect - $negativeMarks;
//     $percentage = $totalQ > 0 ? ($finalScore / $totalQ) * 100 : 0;
//     $status = ($finalScore >= $passMark && $percentage >= $passPerc) ? 'Pass' : 'Fail';

//     $studentCode = Student::where('id', $student_id)->value('student_id');
//     $notAttempted = $totalQ - $totalAttempted;

//     $data = [
//         'student_id' => $student_id,
//         'exam_id' => $exam_id,
//         'course_id' => $course_id,
//         'total_questions' => $totalQ,
//         'total_attempted' => $totalAttempted,
//         'total_correct' => $countCorrect,
//         'total_wrong' => $inCorrectAns,
//         'score' => $finalScore,
//         'student_code' => $studentCode,
//         'not_attempted' => $notAttempted,
//         'percentage' => $percentage,
//         'status' => $status,
//     ];

//     try {
//         $existing = ResultManagement::where('student_id', $student_id)
//             ->where('exam_id', $exam_id)
//             ->first();

//         if ($existing) {
//             $existing->update($data);
//         } else {
//             ResultManagement::create($data);
//         }
//     } catch (\Exception $e) {
//         Log::error('Failed to save ResultManagement:', [
//             'error' => $e->getMessage(),
//             'data' => $data,
//         ]);
//         return back()->with('error', 'Something went wrong while saving result.');
//     }

//     $setting = Setting::latest()->first();

//     return view('frontend.result-sheet', compact(
//         'setting',
//         'totalQ',
//         'examName',
//         'studentName',
//         'totalAttempted',
//         'countCorrect',
//         'inCorrectAns',
//         'finalScore',
//         'percentage',
//         'status'
//     ));
// }








 // $correctAnswers=
    // $rightAnswers = $studentAnswers->filter(function ($answer) use ($questions) {
    //     $question = $questions->get($answer->question_id);
    //     return $question && $question->answer === $answer->option;
    // });   //right answers
