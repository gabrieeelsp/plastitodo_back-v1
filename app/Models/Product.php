<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'is_enable', 'description', 'costo', 'porc_min', 'porc_may'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
