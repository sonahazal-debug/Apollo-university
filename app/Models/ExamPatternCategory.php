<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPatternCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'exam_pattern_id',
        'from',
        'to',
        'category_id',
        'correct_mark',
        'negative_mark'
    ];


    public function examPattern()
    {
        return $this->belongsTo(ExamPattern::class, 'exam_pattern_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryManagement::class, 'category_id');
    }


//     public function patternCategories()
// {
//     return $this->hasMany(ExamPatternCategory::class, 'category_id', 'category_id');
// }

    

}
