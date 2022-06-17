<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrnDisplay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "urns_display";

    protected $fillable = [
    	'title', 'image', 'content', 'status'
    ];
}
