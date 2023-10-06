<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Define Table
    protected $table = 'categories';
    // Define primary key non integer or numeric
    protected $primaryKey = 'code';
    // if primary key non integer should be fals, to force not incrementing
    public $incrementing = false;

    // Relation
}
