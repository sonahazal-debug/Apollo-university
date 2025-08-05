<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasFactory;


    protected $table = 'student_exams';


    protected $fillable=[
         'student_id',
         'course_id',
         'category_id',
         'exam_id',
         'question_id',
         'option'
    ];

    public function question()
{
    return $this->belongsTo(QuestionManagement::class, 'question_id');
}


public function exam() {
    return $this->belongsTo(ExamManagement::class, 'exam_id');
}


}
