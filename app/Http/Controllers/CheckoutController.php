<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Checkout;
use App\Events\CartEvents;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $menus = Menu::all();
        return view('guest.pages.cart', [
            'title' => 'Checkout',
            'brand' => 'Your Cart',
            'categories' => $categories,
            'menus' => $menus,
        ]);
    }

    public function waitingList()
    {
        $orders = Checkout::latest()->paginate(10);
        return view('employee.pages.order.waiting', [
            'title' => 'Waiting List',
            'orders' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $uuid = $request->input('user_id');
        $menu_ids = $request->input('menu_id');
        $select_items = $request->input('select-item');
        $quantityInputs = $request->input('quantityInput');

        // dd($uuid, $menu_ids, $select_items);

        if ($request->has('delete-selected-items')) {
            if ($select_items != null) {
                foreach ($select_items as $items) {
                    $this->DeleteRecordCart($uuid, $items);
                }
            }

            $this->DeleteRecordCheckout($uuid);
            return back();
        }


        if (!$this->Checkrecord($uuid)) {
        }


        for ($i = 0; $i < count($menu_ids); $i++) {
            $checkout = new Checkout();
            $checkout->uuid = $uuid;
            $checkout->menu_id = $menu_ids[$i];
            $checkout->order_qty = $quantityInputs[$i];
            $checkout->save();
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
        $order = Checkout::where('uuid', $uuid)->update(['payment' => $payment]);

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

    // Checkrecord function
    private function Checkrecord(string $uuid): bool
    {
        $lpass = false;
        $order = Checkout::where('uuid', $uuid)->get();

        if (!$order) {
            return $lpass = true;
            dd($order);
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
