<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function store(string $uuid, string $menu_id)
    {
        // Check Record
        if (!$this->CheckRecord($uuid, $menu_id)) {

            $this->SaveRecord($uuid, $menu_id);
            return back();
        }

        if (!$this->UpdateRecord($uuid, $menu_id)) {
            return back();
        }

        return back();
    }

    private function CheckRecord(string $uuid, string $menu_id): bool
    {
        $lpass = false;

        $cart = Cart::where(['uuid' => $uuid, 'menu_id' => $menu_id])->get();

        if (count($cart) > 0) {
            return $lpass = true;
        }

        return $lpass;
    }

    private function SaveRecord(string $uuid, string $menu_id): bool
    {
        $lpass = false;

        $menu = Menu::where('id', $menu_id)->first();

        $cart = new Cart();

        $cart->uuid = $uuid;
        $cart->menu_id = $menu_id;
        $cart->menu_price = $menu->amount;
        $cart->order_qty = 1;

        if ($cart->save()) {
            return $lpass = true;
        }

        return $lpass;
    }

    private function UpdateRecord(string $uuid, string $menu_id): bool
    {
        $lpass = false;

        $cart = Cart::where(['uuid' => $uuid, 'menu_id' => $menu_id])->first();

        $cart->order_qty = $cart->order_qty + 1;

        if ($cart->save()) {
            return $lpass = true;
        }

        return $lpass;
    }

    public function UpdateQuantity(string $uuid, string $menu_id, string $qty)
    {
        $cart = Cart::where(['uuid' => $uuid, 'menu_id' => $menu_id])->first();

        if (!$cart) {
            // Tambahkan penanganan jika item keranjang tidak ditemukan
            return response()->json(['error' => 'Item keranjang tidak ditemukan'], 404);
        }

        $menu = Menu::where('id', $menu_id)->first();

        $cart->order_qty = $qty;
        $cart->menu_price = $menu->amount * $qty;

        $cart->save();

        $summary = DB::table('carts')
            ->selectRaw('uuid, SUM(menu_price) as total_amount')
            ->where('uuid', $uuid)
            ->groupBy('uuid')
            ->first();

        // Mengemas data yang ingin dikirim sebagai respons JSON
        $responseData = [
            'cart' => $cart,
            'summary' => $summary,
        ];

        return response()->json($responseData);
    }
}
