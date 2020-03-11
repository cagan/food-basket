<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Jobs\NotifyUser;
use App\Order;
use App\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $order;

    /**
     * Display a listing of the resource.
     *
     * @return OrderCollection
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();

        return new OrderCollection(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderCreateRequest  $request
     * @return OrderResource
     */
    public function store(OrderCreateRequest $request)
    {
        $pizzaIds = $request->input('pizzas.*.id');
        $billingType = $request->input('billing_type');
        $user = auth()->user();

        $totalAmount = $this->totalAmount($pizzaIds);
        $order = Order::create(
            [
                'user_id' => $user->id,
                'billing_type' => $billingType,
                'total_amount' => $totalAmount,
                'order_code' => '#' . mb_strtoupper(Str::random(6)),
            ]
        );

        $order->pizzas()->attach($pizzaIds);

//        event(new OrderCreated($order, $user));

        OrderCreated::dispatch($order, $user);

//        NotifyUser::dispatch();


        return (new OrderResource($order));
    }

    public function totalAmount(array $pizzaIds): float
    {
        return Pizza::select('price')->whereIn('id', $pizzaIds)->get()->sum('price');
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
