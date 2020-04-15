<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|Collection
     */
    public function main()
    {
        return view('index', ['title' => 'Main page']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Product[]|Collection
     */
    public function index(Request $request)
    {
        $data = Product::all();
        foreach ($data as &$row) {
            $row->discount_value = round($row->price - ($row->price / 100 * $row->discount), 2);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Product[]|Collection
     */
    public function history()
    {
        return view('orders-history', ['title' => 'Order history']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Product[]|Collection
     */

    public function historyData()
    {
        $basket = null;
        if (!empty(auth()->user()) && auth()->user()->id > 0) {
            $basket = Basket::select('id','address','email','updated_at', 'price')->where('uid', auth()->user()->id)->where('ordered', 1)->get();
            foreach($basket as $basketItem){
                foreach ($basketItem->items as $item){
                    $item->itemProperty;
                }
            }
        }
        return $basket;
    }
}
