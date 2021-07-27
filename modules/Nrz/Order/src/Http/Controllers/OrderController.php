<?php

namespace Nrz\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Nrz\Order\Http\Resources\OrderResourceCollection;
use Nrz\Order\Http\Requests\OrderRequest;
use Nrz\Order\Models\Order;
use Nrz\Order\Notifications\ChangeOrderStatusNotification;
use Nrz\Order\Repo\OrderRepo;
use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\AttributeValue;
use Nrz\Product\Models\Product;
use Nrz\Product\Repo\ProductRepo;


class OrderController extends Controller
{

    public function index(OrderRepo $orderRepo)
    {
        $orders = auth()->user()->is_admin
            ? $orderRepo->getAllOrder()
            : $orderRepo->getAllUserOrder();
        return new OrderResourceCollection($orders);
    }

    public function store(OrderRequest $request, OrderRepo $orderRepo, ProductRepo $productRepo)
    {

        $product = $productRepo->findByName($request->product);

        $this->setAttrAndVal($orderRepo, $request->options, $product,$request->quantity, $request->consume_location);
        return response([
            "سفارش شما با موفقیت ثبت شد !"
        ], 200);

    }

    public function setAttrAndVal($orderRepo, $options, $product,$quantity,$consumeLocation)
    {
        foreach ($options as $opt) {
            $value = $orderRepo->findValueByName($opt['value']);
            $attr = $orderRepo->findAttributeByName($opt['attribute']);

            if ($this->checkValueAttrId($value, $attr,$product)) {
                $order = $this->createNewOrder($orderRepo,$product,$quantity, $consumeLocation);
                $orderRepo->setAttributeAndValue($order, $product, $attr, $value);
            } else {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "value" => "خطا در مقدار اتربیوت"
                ]);
            }


        }
    }

    public function createNewOrder($orderRepo,$product, $quantity, $consumeLocation)
    {
        return  $orderRepo->store($product, $quantity, $consumeLocation);
    }

    public function checkValueAttrId($value, $attr,$prdouct)
    {
        return $value->attribute_id == $attr->id && $attr->products[0]->id == $prdouct->id;
    }

    public function cancelOrder($order,OrderRepo $orderRepo)
    {
        $order = $orderRepo->findById($order);
        abort_if(auth()->user()->id != $order->user_id, 403);
        abort_if(!auth()->user()->is_admin && $order->status != 'waiting', 403);
        $orderRepo->updateStatus($order);

        return response([
            "سفارش شما با موفقیت کنسل شد !"
        ], 200);

    }

    public function update($order, OrderRequest $request,OrderRepo $orderRepo,ProductRepo $productRepo)
    {
        $order = $orderRepo->findById($order);
        abort_if((auth()->user()->id != $order->user_id) &&!auth()->user()->is_admin, 403);
        abort_if(!auth()->user()->is_admin && $order->status != 'waiting', 403);
        $product= $productRepo->findProductForOrder($request->product,$order);
        $orderRepo->update($order,$request->consume_location,$request->quantity,$product);
        if ($request->product) {
            $this->setAttrAndValueForOrderUpdate($request->options,$order,$product,$orderRepo);
        }
        return response([
            "msg" => "سفارش شما با موفقیت آپدیت شد !"
        ], 200);

    }

    public function updateStatus($order, Request $request,OrderRepo $orderRepo)
    {
        abort_if(!auth()->user()->is_admin, 403);
        $request->validate([
            "status" => ["required", Rule::in(Order::STATUSES)]
        ]);
        $order = $orderRepo->findById($order);
        $status = $orderRepo->updateStatus($order,$request->status);
        if ($status) {
            $order->user->notify(new ChangeOrderStatusNotification($order, $request->status));
        }
        return response([
            "msg" => "وضعیت سفارش با موفقیت تغییر یافت"
        ], 200);

    }

    public function setAttrAndValueForOrderUpdate($options,$order,$product,$orderRepo)
    {
        foreach ($options as $opt) {
            $value = $orderRepo->findValuesByName($opt['value']);
            $attr = $orderRepo->findAttributesByName($opt['attribute']);
            if ($this->checkValueAttrId($value,$attr,$product)) {
                $orderRepo->syncAttrAndValForOrderUpdate($order,$product,$attr,$value);
            } else {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "value" => "خطا در مقدار اتربیوت"
                ]);
            }


        }
    }


}
