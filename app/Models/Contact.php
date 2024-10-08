<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'user_id',
        'image_id'
    ];

    protected $with = [
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
