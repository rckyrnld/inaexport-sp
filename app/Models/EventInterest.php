<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventInterest extends Model
{
	protected $primaryKey = 'id';

    protected $table = "event_interest";
    
    protected $guarded = [];
}