<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultManagement extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'result_managements';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'student_id',
        'exam_id',
        'course_id',
        'total_questions',
        'total_attempted',
        'total_correct',
        'total_wrong',
        'score',
        'rank',
        'student_code',
        'not_attempted',
        'percentage',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // App\Models\ResultManagement.php

public function exam()
{
    return $this->belongsTo(ExamManagement::class, 'exam_id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}


}
