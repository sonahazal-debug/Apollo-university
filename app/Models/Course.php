<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'courses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'   => 'active',
        'inactive' => 'inactive',
    ];

    protected $fillable = [
        'course_name',
        'status',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function category()
    {
        return $this->belongsTo(CategoryManagement::class, 'category_id');
    }

    public function courseCategories()
    {
        return $this->hasMany(CourseCategory::class, 'course_id');
    }

    public function examPattern()
    {
        return $this->hasMany(ExamPattern::class, 'course_id');
    }


    public function examPatternCategory()
    {
        return $this->hasMany(ExamPatternCategory::class, 'course_id');
    }

}
