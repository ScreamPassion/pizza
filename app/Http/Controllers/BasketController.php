<?php

namespace App\Http\Controllers;

use App\Basket;
use App\BasketItems;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|null
     */
    public function checkout(Request $request)
    {
        return view('checkout');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|null
     */
    public function checkoutSubmit(Request $request)
    {
        //TODO хорошо бы сделать бекенд проверку полей, хотя с другой стороны - необходимости в этом особой нет,
        // даже если пользователь по какой то причине введет невалидный email или адрес,
        // навредит он только себе, т.к. eloquent не пропустит инъекций,
        // и максимум проблем - пользователю на почту в перспективе не будут приходить письма.

        $basket = Basket::where($this->credentials($request))->where('ordered', 0)->first();
        $price = 0;
        if ($basket->id) {
            foreach ($basket->items as $item) {
                $price += $item->itemProperty->price - ($item->itemProperty->price / 100 * $item->itemProperty->discount);
            }
            $basket->ordered = 1;
            $basket->price = $price;
            $basket->address = $request->input('address');
            $basket->email = $request->input('email');
            $basket->name = $request->input('name');
            $basket->save();
        }
    }

    private function credentials(Request $request, $cr = [])
    {
        if (!empty(auth()->user()) && auth()->user()->id > 0) {
            $res['uid'] = auth()->user()->id;
        } else {
            $res['session'] = $request->session()->get('_token');
        }
        return array_merge($res, $cr);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|null
     */
    public function index(Request $request)
    {
        $result = null;
        $basket = Basket::where($this->credentials($request))->where('ordered', 0)->first();
        if ($basket) {
            foreach ($basket->items as $item) {
                $item->itemProperty;
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $order = Basket::firstOrNew($this->credentials($request, ['ordered' => 0]));

        if ($order->id <= 0) {
            $order->save();
        }
        $item = BasketItems::firstOrNew(['order_id' => $order->id, 'product_id' => $id]);

        $item->item_count++; // Todo += $request->input('count');
        $product = Product::findOrFail($id);
        $item->price += round($product->price - ($product->price / 100 * $product->discount), 2);
        $item->order_id = $order->id;
        $item->save();

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $order = Basket::firstOrNew($this->credentials($request, ['ordered' => 0]));

        if ($order->id > 0) {
            BasketItems::where(['order_id' => $order->id, 'id' => $id])->delete();
        }

        return response()->json(null);
    }
}
