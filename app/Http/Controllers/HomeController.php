<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Checkout;
use App\Events\CartEvents;
use App\Models\TableOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Home or Menu For Guest
     */
    public function index(Request $request)
    {
        $uuid = $request->cookie('UUID');

        if (!$uuid) {
            $uuid = Str::uuid();

            return redirect()->route('guest.menu')
                ->cookie('UUID', $uuid, 60 * 24);
        }

        $categories = Category::all();
        $menus = Menu::all();

        $carts = Cart::where('uuid', $uuid)->get();

        $groupedCarts = $carts->groupBy('menu_id');

        return view("guest.pages.menu", [
            'title' => 'Menus',
            'brand' => 'Paradigma Coffee',
            'menus' => $menus,
            'categories' => $categories,
            'groupedCarts' => $groupedCarts,
            'uuid' => $uuid
        ]);
    }

    public function invoice(Request $request)
    {
        $uuid = $request->cookie('UUID');

        $orders = Checkout::where('uuid', $uuid)->get();

        $groupedOrder = $orders->groupBy('menu_id');
        // $latestGroupedOrder = collect();

        // foreach ($groupedOrder as $items => $item) {
        //     $latestItem = $item->sortByDesc('created_at')->first();
        //     $latestGroupedOrder->put($items, $latestItem);
        // }

        return view("guest.pages.invoice", [
            'title' => 'Invoice',
            'groupedOrder' => $groupedOrder,
            'uuid' => $uuid
        ]);
    }

    public function resetCookie()
    {
        return redirect(route('guest.menu'))->withCookie(Cookie::forget('UUID'));
    }
}
