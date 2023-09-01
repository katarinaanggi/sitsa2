<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Income;
use App\Models\Product;
use App\Events\OrderBatal;
use App\Models\Cart_Detail;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $orders = $user->orders->where('status', '<>','Selesai');
        
        return view('orders',[
            "title" => "Orders",
            "orders" => $orders->paginate(4)->withQueryString(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('order.order', [
            'title' => "Order"
        ]);
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
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        return view('order.order_details',[
            'order' => $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function history(user $user)
    {
        $orders = $user->orders->where('status', 'Selesai');
        
        return view('history',[
            "title" => "History",
            "orders" => $orders->paginate(4)->withQueryString(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        return view('pay',[
            "title" => "Pembayaran",
            "order" => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        $rules = [
            'pic'      => 'required|image|mimes:jpg,png,jpeg',
		];
        
        $messages = [
            'required'  => ':Attribute harus diisi.',
            'image'     => 'Tipe file tidak didukung. Silakan masukan gambar.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            $data = [
                "status" => "Menunggu konfirmasi"
            ];
            $file_name = $request->file('pic')->getClientOriginalName();
            $file_path = $request->file('pic')->storeAs('payments', $file_name, 'public');
            $data['bukti_transfer'] = $file_name;
            $data['bukti_transfer_path'] = '/uploads/'.$file_path;

            Order::where('id', $order->id)
            ->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload'
            ]);
		}
    }

    public function repay(Order $order){
        return view('repay',[
            "title" => "Unggah Ulang Pembayaran",
            "order" => $order,
        ]);
    }

    public function reupload(Request $request, Order $order){
        $rules = [
            'pic'      => 'required|image|mimes:jpg,png,jpeg',
		];
        
        $messages = [
            'required'  => ':Attribute harus diisi.',
            'image'     => 'Tipe file tidak didukung. Silakan masukan gambar.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            // mengganti status
            $data = [
                "status" => "Menunggu konfirmasi"
            ];
            //menghapus file sebelumnya
            Storage::disk('public')->delete('payments/'.$order->bukti_transfer);
                    
            //mengubah nama file dan path file
            $file_name = $request->file('pic')->getClientOriginalName();
            $file_path = $request->file('pic')->storeAs('payments', $file_name, 'public');
            $data['bukti_transfer'] = $file_name;
            $data['bukti_transfer_path'] = '/uploads/'.$file_path;

            Order::where('id', $order->id)
            ->update($data);
            // dd($order->bukti_transfer_path);
            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload'
            ]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        OrderBatal::dispatch($order);
        foreach($order->order_details as $od){
            $stok = Product::where('id',$od->product_id)->first()->stok;
            Product::where('id',$od->product_id)->update(['stok' => $stok+$od->jumlah]);
        }
        DB::delete('delete from order_details where order_id ='.$order->id);
        Order::destroy($order->id);
        Alert::success('Berhasil', 'Pemesanan berhasil dibatalkan');
        return redirect()->route('orders',auth()->user()->id);
    }

    public function complete(Order $order){
        Order::where('id', $order->id)->update(['status' => 'Selesai']);
        Alert::success('Berhasil', 'Pemesanan berhasil diselesaikan');
        return redirect()->back();
    }

    public function reorder(Order $order)
    {
        $jum = 0;
        foreach ($order->order_details as $odetail) {
            $cdetail = auth()->user()->cart->cart_details->where('product_id', $odetail->product_id)->first();
            $product = Product::where('id', $odetail->product->id)->first();
            if ($cdetail && $odetail->product->stok >= $cdetail->jumlah + $odetail->jumlah) {
                $data = [
                    'cart_id' => auth()->user()->cart->id,
                    'product_id' => $odetail->product->id,
                    'jumlah' => $cdetail->jumlah + $odetail->jumlah
                ];
                Cart_Detail::where('product_id',$odetail->product->id)
                            ->update($data);
                $jum += $odetail->jumlah;
            } elseif(!$cdetail && $odetail->product->stok >= $odetail->jumlah){
                $data = [
                    'cart_id' => auth()->user()->cart->id,
                    'product_id' => $odetail->product->id,
                    'jumlah' => $odetail->jumlah
                ];
                Cart_Detail::create($data);
                $jum += $odetail->jumlah;                
            }
        }
        if($jum == 0){
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }else{
            return redirect()->back()->with('success', $jum.' produk berhasil ditambahkan ke keranjang.');
        }
    }

    /**
     * Create new income and change order's status to Pembayaran terkonfirmasi
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function confirmPayment(Order $order) 
    {
        $current_timestamp = Carbon::now()->toDateTimeString();
        $current_date = Carbon::now()->toDateString();
        if($order->jenis === 'pickup'){
            $status = "Pesanan dapat diambil";
        }
        else{
            $status = "Pembayaran terkonfirmasi";
        }
        DB::table('orders')->where('id', $order->id)->update([
            'status'        => $status,
            'admin_id'      => auth()->guard('admin')->user()->id,
            'updated_at'    => $current_timestamp
        ]);
        
        $desc = '';
        foreach ($order->order_details as $od) {
            $desc = $desc.$od->jumlah.'x '.$od->product->nama.'; ';
        }
        // dd($desc);
        Income::create([
            'nama' => 'Produk terjual',
            'tanggal' => $current_date,
            'jumlah' => $order->jumlah,
            'total' => $order->total,
            'deskripsi' => 'Order #'.$order->id.': '.$desc,
            'admin_id'  => auth()->guard('admin')->user()->id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran telah dikonfirmasi!'
        ]);
    }

    /**
     * Create new income and change order's status to Gagal dikonfirmasi
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function notConfirm(Order $order) 
    {
        $current_timestamp = Carbon::now()->toDateTimeString();
        $current_date = Carbon::now()->toDateString();
        DB::table('orders')->where('id', $order->id)->update([
            'status'         => "Gagal dikonfirmasi",
            'updated_at'    => $current_timestamp
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi Gagal dikonfirmasi!'
        ]);
    }

    /**
     * Show the form for creating a new resource's Resi.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function addResi(order $order)
    {
        return view('order.add_Resi',[
            'order' => $order
        ]);
    }
    
    /**
     * Store a newly created resource's Resi in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateResi(Request $request, $id)
    {
        $rules = [
            'resi'     => 'required|string',
        ];
        $messages = [
            'required'  => 'harus diisi.',
            'string'   => 'resi harus berupa karakter.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                if(Order::find($id)->status != "Pembayaran terkonfirmasi"){
                    return response()->json([
                        'error' => true,
                        'message' => 'Pembayaran belum dikonfirmasi!'
                    ]);
                }
                $current_timestamp = Carbon::now()->toDateTimeString();
                DB::table('orders')->where('id', $id)->update([
                    'resi'         => $request->resi,
                    'status'       => "Dalam pengiriman",
                    'updated_at'   => $current_timestamp
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Resi Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
                return response()->json([
                    'error' => true,
                    'message' => 'Resi belum berhasil ditambahkan!'
                ]);
			}
		}
    }
}
