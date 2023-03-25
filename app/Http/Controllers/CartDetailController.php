<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart_Detail;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Events\Ordered;

class CartDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart_Detail  $cart_Detail
     * @return \Illuminate\Http\Response
     */
    public function show(Cart_Detail $cart_Detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart_Detail  $cart_Detail
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        $total = 0;
        foreach($user->cart->cart_details as $cd){
            $total += $cd->jumlah * $cd->product->harga;
        }

        return view('cart',[
            "title" => "SITSA | Shopping Cart",
            "categories" => Category::all(),
            "brands" => Brand::all(),
            "details" => $user->cart->cart_details,
            "total" => $total,
        ]);
    }

    function getSubtotal(){
        $stotal = 0;
        foreach (auth()->user()->cart->cart_details as $item){
            $stotal += $item->jumlah * $item->product->harga;
        }
        return $stotal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart_Detail  $cart_Detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Cart_Detail::where('id', $request->id)->update(['jumlah' => $request->jumlah]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart_Detail  $cart_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart_Detail::destroy($id);

        Alert::success('Berhasil', 'Produk berhasil dihapus dari keranjang');
        return redirect()->back();
    }

    public function checkout(User $user){
        $total = 0;
        foreach($user->cart->cart_details as $cd){
            $total += $cd->jumlah * $cd->product->harga;
        }
        $fee = 8000;
        return view('checkout', [
            "fee" => $fee,
            "total" => $total,
            "total_online" => $total+$fee
        ]);
    }

    public function order(User $user, Request $request){
        // dd($request);
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        $j = auth()->user()->cart->cart_details->sum('jumlah');
        $rules = [
            'jenis' => ['required']
        ];

        $request->validate($rules, [
            'jenis.required' => 'Jenis pemesanan harus diisi.',
        ]);

        $data = [
            'user_id' => $user->id,
            'status' => 'Menunggu pembayaran',
            'total' => $request->total,
            'jumlah' => $j,
            'jenis' => $request->jenis,
        ];
        $order = Order::create($data);
        Ordered::dispatch($order);

        $cart_details = $user->cart->cart_details;
        foreach ($cart_details as $cart_detail) {
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart_detail->product_id,
                'jumlah' => $cart_detail->jumlah
            ];
            if($cart_detail->product->stok >= $cart_detail->jumlah){
                $cart_detail->product->update(['stok' => $cart_detail->product->stok - $cart_detail->jumlah]);
            }
            else{
                Order::destroy($order->id);
                return response()->json([
                    "error" => true,
                    'message' => 'Jumlah pesanan melebihi stok produk'
                ]);
            }
            Order_Detail::create($data);
            Cart_Detail::destroy($cart_detail->id);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibuat'
        ]);
    }
}
