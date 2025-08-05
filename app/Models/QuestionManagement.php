<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class QuestionManagement extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'question_managements';

    public const QUESTION_TYPE_SELECT = [
        'MCQ' => 'MCQ',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ANSWER_SELECT = [
        'option1' => 'option1',
        'option2' => 'option2',
        'option3' => 'option3',
        'option4' => 'option4',
    ];

    protected $fillable = [
        'exam_id',
        'question',
        'question_type',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'course_id',
        'answer',
        'category_id',
  
        'difficulty_level',
        'explaination',
   
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function category()
    {
        return $this->belongsTo(CategoryManagement::class, 'category_id');
    }

    public function exam()
{
    return $this->belongsTo(ExamManagement::class, 'exam_id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}


}
