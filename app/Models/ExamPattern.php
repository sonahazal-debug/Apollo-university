<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamPattern extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'exam_patterns';

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
        'course_id',
        'status',
        'pass_perc',
        'pass_mark',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryManagement::class, 'category_id');
    }

    

    public function examCategory()
    {
        return $this->hasMany(ExamCategory::class, 'exam_pattern_id');
    }

   


}
