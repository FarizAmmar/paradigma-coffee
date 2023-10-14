<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\TableOrder;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(string $uuid, string $menu_id)
    {
        $cart = new Cart();

        $cart->uuid = $uuid;
        $cart->menu_id = $menu_id;

        $cart->save();

        return back();
    }
}
