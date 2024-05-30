<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'section_id', 'course_owner', 'price', 'number_of_participants', 'status', 'description', 'image'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'course_owner');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
