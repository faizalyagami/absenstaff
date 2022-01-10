<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivityAttachment extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

	protected $table = 'attachments';

	public function dailyActivity() {
		return $this->hasMany('App\Models\DailyActivity', 'daily_job_id');
	}
}
