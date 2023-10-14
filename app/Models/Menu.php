<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    // Define Table
    protected $table = 'menus';

    // Relations
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_code', 'code');
    }

    public function cart(): HasMany
    {
        return $this->HasMany(Cart::class, 'menu_id', 'id');
    }

    public function checkout(): HasMany
    {
        return $this->HasMany(Checkout::class, 'menu_id', 'id');
    }
}
