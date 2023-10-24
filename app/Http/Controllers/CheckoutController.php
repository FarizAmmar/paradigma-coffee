<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Checkout;
use App\Events\CartEvents;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // New
        $uuid = $request->cookie('UUID');

        if (!$uuid) {
            $uuid = Str::uuid();

            return redirect()->route('guest.menu')
                ->cookie('UUID', $uuid, 60 * 24);
        }

        $categories = Category::all();
        $menus = Menu::all();

        $carts = Cart::where('uuid', $uuid)->get();
        $groupCarts = $carts->groupBy('menu_id');

        $summary = DB::table('carts')
            ->selectRaw('uuid, SUM(menu_price) as total_amount')
            ->where('uuid', $uuid)
            ->groupBy('uuid')
            ->first();

        return view('guest.pages.cart', [
            'title' => 'Checkout',
            'brand' => 'Your Cart',
            'categories' => $categories,
            'menus' => $menus,
            'uuid' => $uuid,
            'summary' => $summary,
            'groupedCarts' => $groupCarts,
        ]);
    }

    public function waitingList()
    {
        $orders = Checkout::where('order_status', 'W')->latest()->paginate(10);
        return view('employee.pages.order.waiting', [
            'title' => 'Waiting List',
            'orders' => $orders
        ]);
    }

    public function order()
    {

        $orders = Checkout::where('order_status', 'P')->latest();
        return view('employee.pages.order.order', [
            'title' => 'Orders',
            'orders' => $orders->get(),
        ]);
    }

    public function store(Request $request)
    {
        $uuid = $request->input('user_id');
        $menu_ids = $request->input('menu_id');
        $select_items = $request->input('select-item');
        $quantityInputs = $request->input('quantityInput');

        if ($request->has('delete-selected-items')) {
            if ($select_items != null) {
                foreach ($select_items as $items) {
                    $this->DeleteRecordCart($uuid, $items);
                }
            }

            $this->DeleteRecordCheckout($uuid);
            return back();
        }

        foreach ($menu_ids as $key => $menu_id) {
            if (!$this->Checkrecord($uuid, $menu_id)) {
                $checkout = new Checkout();
                $checkout->uuid = $uuid;
                $checkout->menu_id = $menu_id;
                $checkout->order_qty = $quantityInputs[$key];
                $checkout->save();
            } else {
                $this->UpdateRecord($uuid, $menu_id, $quantityInputs[$key]);
            }
        }

        // Buat sesseion modal table no
        session()->flash('ShowTableOrder', true);
        return back();
    }

    // Table input
    public function save_table(Request $request)
    {
        session()->flash('ShowPayment');

        Checkout::where('uuid', $request->input('uuid'))->update(['table_no' => $request->input('table_no')]);

        return back();
    }

    //
    public function payment(string $uuid, string $payment)
    {
        // Update payment method
        $order = Checkout::where('uuid', $uuid)->update(['payment' => $payment, 'order_status' => 'W']);

        if ($order) {
            $orders = Checkout::where('uuid', $uuid)->get();

            foreach ($orders as $ordersend) {
                $message = "You have a new order!";
                event(new CartEvents($message, $ordersend));
            }
        }

        // Delete Cart
        $this->DeleteRecordCart($uuid, '');

        return redirect(route('guest.invoice'));
    }

    public function orderStatus(string $uuid, string $status, string $menu_id)
    {
        session()->flash('MessageModal', true);
        Checkout::where(['uuid' => $uuid, 'menu_id' => $menu_id])->update(['order_status' => $status]);

        return response()->json(['status' => $status, 'message' => 'Pesanan sudah di terima.']);
    }

    private function UpdateRecord(string $uuid, string $menu_id): bool
    {
        $lpass = false;

        $checkout = Checkout::where(['uuid' => $uuid, 'menu_id' => $menu_id])->first();
        $cart = Cart::where(['uuid' => $uuid, 'menu_id' => $menu_id])->first();

        $checkout->order_qty = $cart->order_qty;
        $checkout->save();

        if ($checkout->save()) {
            return $lpass = true;
        }

        return $lpass;
    }

    // Checkrecord function
    private function Checkrecord(string $uuid, string $menu_id): bool
    {
        $lpass = false;
        $order = Checkout::where(['uuid' => $uuid, 'menu_id' => $menu_id])->first();

        if ($order != null) {
            return $lpass = true;
        }

        return $lpass;
    }

    // Deleterecord Function
    private function DeleteRecordCheckout(string $uuid): bool
    {
        $lpass = false;

        $orders = Checkout::where('uuid', $uuid)->get();

        if ($orders) {
            foreach ($orders as $order) {
                $order->delete();
            }
            return $lpass = true;
        }

        return $lpass;
    }

    private function DeleteRecordCart(string $uuid, string $menu_id): bool
    {
        $lpass = false;

        if ($menu_id != '') {
            $carts = Cart::where(['uuid' => $uuid, 'menu_id' => $menu_id])->get();
            foreach ($carts as $cart) {
                $cart->delete();
            }

            return $lpass = true;
        }

        $carts = Cart::where('uuid', $uuid)->get();

        if ($carts) {
            foreach ($carts as $cart) {
                $cart->delete();
            }
            return $lpass = true;
        }

        return $lpass;
    }
}
