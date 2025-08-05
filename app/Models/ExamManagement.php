<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ExamManagement extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'exam_managements';

    public const EXAM_MODE_SELECT = [
        'paid' => 'paid',
        'free' => 'free',
    ];

    public const STATUS_SELECT = [
        'active'   => 'active',
        'inactive' => 'inactive',
    ];

    protected $dates = [
        'start_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TIME_STATUS_SELECT = [
        'previous' => 'previous',
        'upcoming' => 'upcoming',
    ];

    protected $fillable = [
   
        'exam_id',
        'exam_name',
        'exam_mode',
        'start_date',
        'start_time',
        'end_time',
        'description',
        'status',
        'course_id',
        'time_status',
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

    public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}



    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }



    public function getTimeStatusAttribute()
{
    if (!$this->start_date || !$this->start_time || !$this->end_time) {
        return 'Unknown';
    }

    $now = Carbon::now();
    $startDateTime = Carbon::parse($this->start_date . ' ' . $this->start_time);
    $endDateTime = Carbon::parse($this->start_date . ' ' . $this->end_time);

    if ($now->lt($startDateTime)) {
        return 'Upcoming';
    } elseif ($now->between($startDateTime, $endDateTime, true)) {
        return 'Ongoing';
    } else {
        return 'Over';
    }
}


public function getStartTimeAttribute($value)
{
    return $value ? Carbon::parse($value)->format('h:i A') : null;
}

public function getEndTimeAttribute($value)
{
    return $value ? Carbon::parse($value)->format('h:i A') : null;
}



public function getIsEditableAttribute()
{
    if (!$this->start_date || !$this->start_time) {
        return false;
    }

    $startDateTime = Carbon::parse($this->start_date . ' ' . $this->start_time);
    return now()->lt($startDateTime);
}

    



}
