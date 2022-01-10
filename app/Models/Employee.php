<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

	public function departement() {
		return $this->belongsTo('App\Models\Departement');
	}

	public function position() {
		return $this->belongsTo('App\Models\Position');
	}
}
