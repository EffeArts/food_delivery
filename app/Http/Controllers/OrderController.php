<?php

namespace App\Http\Controllers;

use App\order;
use App\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title= "Order";
        $orders = Order::with('order_item','order_item.menu','status')
            ->orderBy('id','desc')
            ->paginate('20');
//        return  $orders;
        return view('Admin.order.order',compact('page_title','orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $newDat ="";
        $gTotal = 0;
        $subTotal =0;
        $sessions = session()->get('cart');
        foreach ($sessions as $newSession){
            $subTotal = ($newSession['price'])*($newSession['quantity']);
            $gTotal += $subTotal;
        }
        $order =Order::create([
                    "owner"=>$request->owner,
                    "phone" =>$request->phone,
                    "location" => $request->location,
                    "street"=> $request->location,
                    "location_info" => $request->location_info,
                    "payment_method" => $request->payment_method,
                    "total_price" => $gTotal,
                    "status_id" => 1,
                ]);
        foreach ($sessions as $session){

            Order_item::create([
                "menu_id" => $session['id'],
                "order_id" => $order->id,
                "price" => $session['price'],
                "quantity" => $session['quantity'],
                "sub_total" => ($session['price'])*($session['quantity'])
            ]);
    }
        session()->forget('cart');
        return redirect()->back()->with('success','Order Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }
}
