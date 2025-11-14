<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTextColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'color_id',
    ];
}
