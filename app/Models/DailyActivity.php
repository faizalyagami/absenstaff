<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

	protected $table = 'daily_jobs';

	public function dailyActivityAttachments() {
		return $this->hasMany('App\Models\DailyActivityAttachment', 'daily_job_id');
	}

	public function employee() {
		return $this->belongsTo('App\Models\Employee');
	}
}
