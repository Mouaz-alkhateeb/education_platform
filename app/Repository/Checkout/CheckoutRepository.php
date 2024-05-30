<?php

namespace App\Repository\Checkout;

use App\Models\Cart;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        $records = Order::query();
        return $records->get();
    }

    public function model()
    {
        return Order::class;
    }


    public function place_order($data)
    {
        DB::beginTransaction();
        try {

            $order = new Order();
            $order->user_id = Auth::id();
            $order->first_name = $data['first_name'];
            $order->last_name = $data['last_name'];
            $order->phone = $data['phone'];
            $order->email = $data['email'];
            $order->city = $data['city'];
            $order->country = $data['country'];
            $order->address1 = $data['address1'];
            $order->address2 = $data['address2'];
            $order->pin_code = $data['pin_code'];
            $order->status = 0;


            $total = 0;
            $cartItems_total = Cart::where('user_id', Auth::id())->get();
            foreach ($cartItems_total as $course) {
                $total += $course->courses->price;
            }

            $order->total_price = $total;
            $order->save();


            $cartItems = Cart::where('user_id', Auth::id())->get();

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $item->course_id,
                    'price' => $item->courses->price
                ]);
            }

            $course = Course::where('id', $item->course_id)->first();
            $course->update();


            $cartItems = Cart::where('user_id', Auth::id())->get();
            Cart::destroy($cartItems);


            DB::commit();
            return response()->json(['message' => 'Order Placed Successfully..!!']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Order placement failed..!!'], 500);
        }
    }

    public function my_orders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return  $orders;
    }
}
