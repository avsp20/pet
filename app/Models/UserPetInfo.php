<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPetInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "customer_pet_info";

    protected $fillable = [
    	'user_id', 'location', 'tag', 'pet_name', 'pet_type', 'pet_status', 'gender', 'age', 'weight', 'date_of_birth', 'breed_and_color', 'additional_pet_info', 'date_received', 'date_cremated', 'date_delivered', 'processing_checklist', 'cremation_type', 'frame_color', 'urn_details', 'special_info', 'additional_items'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
