<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSlot extends Model
{
    use HasFactory;

    protected $table = 'page_slots';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name'];
}
