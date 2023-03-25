<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('product.product', [
            'title' => "Product"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('product.add_product',[
            'title' => "Tambah Produk",
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required|string|max:50|min:5',
            'pic'       => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'category'  => 'required',
            'brand'     => 'required',
            'price'     => 'required|numeric',
            'stock'     => 'required|numeric',
            'desc'      => 'required|string',
		];
        
        $messages = [
            'required'  => 'harus diisi.',
            'max'       => ':attribute terlalu panjang, maksimal :max karakter.',
            'min'       => ':attribute terlalu pendek, minimal :min karakter.',
            'string'    => ':attribute harus berupa karakter.',
            'numeric'   => ':attribute harus berupa angka.',
            'image'     => 'tipe file tidak didukung, silahkan masukkan gambar.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                $current_timestamp = Carbon::now()->toDateTimeString();
                $data['nama'] = $request->name;
                $data['harga'] = $request->price;
                $data['stok'] = $request->stock;
                $data['deskripsi'] = $request->desc;
                $data['category_id'] = $request->category;
                $data['brand_id'] = $request->brand;
                $data['created_at'] = $current_timestamp;
                $data['updated_at'] = $current_timestamp;
                if($request->hasFile('pic')){
                    $file = $request->file('pic');
                    if($request->filled('picname')){
                        $fileName = time().'_'.$request->picname.'.'.strtolower($file->getClientOriginalExtension());
                    }
                    else {
                        $fileName = time().'_'.$file->getClientOriginalName();
                    }
                    $filePath = $file->storeAs('products', $fileName, 'public');
                    
                    $data['gambar'] = $fileName;
                    $data['pic_path'] = '/uploads/' . $filePath;
                }
                Product::insert($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
                return response()->json([
                    'error' => true,
                    'message' => 'Data belum berhasil ditambahkan!'
                ]);
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $relateds = DB::select('select * from products where id <> '.$product->id.' and (category_id = '.$product->category_id.' or brand_id = '.$product->brand_id.')');
        return view('product-details',[
            "title" => "SITSA | Product Details",
            "product" => $product,
            "categories" => Category::all(),
            "brands" => Brand::all(),
            "relateds" => $relateds
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product  $product)
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('product.edit_product',[
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name'      => 'required|string|max:50|min:5',
            'category'  => 'required',
            'brand'     => 'required',
            'price'     => 'required|numeric',
            'stock'     => 'required|numeric',
            'desc'      => 'required|string',
		];
        
        $messages = [
            'required'  => 'harus diisi.',
            'max'       => ':attribute terlalu panjang, maksimal :max karakter.',
            'min'       => ':attribute terlalu pendek, minimal :min karakter.',
            'string'    => ':attribute harus berupa karakter.',
            'numeric'   => ':attribute harus berupa angka.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                //insert pic jika ada
                if($request->hasFile('pic')){
                    $file = $request->file('pic');

                    //validasi extension file
                    $validator2 = Validator::make([
                        'file'  => $file,
                        'pic'   => strtolower($file->getClientOriginalExtension()),
                    ],[
                        'pic'      => 'in:png,jpg,jpeg,svg',
                    ],[
                        'in' => 'tipe tidak sesuai.'
                    ]);
                    if ($validator2->fails()) {
                        return response()->json($validator2->errors(), 422);
                    }
                    //menghapus file sebelumnya
                    Storage::disk('public')->delete('products/'.$product->gambar);
                    
                    //mengubah nama file dan path file
                    if($request->filled('picname')){
                        $fileName = time().'_'.$request->picname.'.'.strtolower($file->getClientOriginalExtension());
                    }
                    else {
                        $fileName = time().'_'.$file->getClientOriginalName();
                    }
                    $filePath = '/uploads/' . $file->storeAs('products', $fileName, 'public');
                }
                
                $current_timestamp = Carbon::now()->toDateTimeString();
                DB::table('products')->where('id', $product->id)->update([
                    'nama'          => $request->name,
                    'harga'         => $request->price,
                    'stok'          => $request->stock,
                    'deskripsi'     => $request->desc,
                    'category_id'   => $request->category,
                    'brand_id'      => $request->brand,
                    'gambar'        => $fileName,
                    'pic_path'      => $filePath,
                    'updated_at'    => $current_timestamp
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Diubah!!'
                ]);
            }
			catch(Exception $e){
                return response()->json([
                    'error' => true,
                    'message' => 'Data Gagal Diubah!!'
                ]);
            }
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  string  $pic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $pic)
    {
        Storage::disk('public')->delete('products/'.$pic);

        Product::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

    /**
     * Show the form for creating a new resource's stock.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function addStock(Product  $product)
    {
        return view('product.add_stock',[
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource's stock in storage.
     *
     * @param  int  $id \App\Models\Product  $product
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStock(Request $request, Product $product)
    {
        $rules = [
            'tambahstok'     => 'required|numeric',
        ];
        
        $messages = [
            'required'  => 'harus diisi.',
            'numeric'   => 'stok harus berupa angka.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                $current_timestamp = Carbon::now()->toDateTimeString();
                $jumlah = $product->stok + $request->tambahstok;
                DB::table('products')->where('id', $product->id)->update([
                    'stok'         => $jumlah,
                    'updated_at'    => $current_timestamp
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
                return response()->json([
                    'error' => true,
                    'message' => 'Data belum berhasil ditambahkan!'
                ]);
			}
		}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request('search'));
        // dd(auth()->user()->cart);
        return view('home',[
            "title" => "SITSA | Home",
            // "products" => Product::latest()->filter(request(['search']))->get(),
            "products" => Product::all(),
            "categories" => Category::all(),
            "brands" => Brand::all()
        ]);
    }

    public function shop(){
        return view('shop',[
            "title" => "SITSA | Shop",
            "products" => Product::filter(request(['search', 'category', 'brand']))->get(['products.*'])->paginate(4)->withQueryString(),
            "latest_products" => Product::latest()->limit(6)->get(),
            "categories" => Category::all(),
            "brands" => Brand::all()
        ]);
    }

    public function add_one_to_cart(Product $product){
        if ($product->stok = 0) {
            Alert::error('Gagal', 'Stok produk habis');
            return redirect()->back();
        } else {
            $data = [
                'user_id' => auth()->user()->id
            ];
            
            if (auth()->user()->cart) {
                $cart = auth()->user()->cart;
            } else {
                $cart = Cart::create($data);
            }
            
            $detail = $cart->cart_details->where('product_id', $product->id)->first();
            // dd($detail);
            if ($detail) {
                if ($detail->product->stok >= $detail->jumlah + 1) {
                    $data = [
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'jumlah' => $detail->jumlah + 1
                    ];
                    Cart_Detail::where('product_id',$product->id)
                                ->update($data);
                } else {
                    Alert::error('Gagal', 'Jumlah produk di keranjang melebihi stok produk');
                    return redirect()->back();
                }                
            } else {
                $data = [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'jumlah' => 1
                ];
                Cart_Detail::create($data);
            }
            Alert::success('Berhasil', 'Produk berhasil ditambahkan ke keranjang');
            return redirect()->back();            
        }
        
    }

    public function add_to_cart(Product $product, Request $request){
        if ($product->stok >= $request->jumlah) {
            $data = [
            'user_id' => auth()->user()->id
            ];
            
            if (auth()->user()->cart) {
                $cart = auth()->user()->cart;
            } else {
                $cart = Cart::create($data);
            }

            $detail = $cart->cart_details->where('product_id', $product->id)->first();
            if ($detail) {
                if($detail->product->stok >= $detail->jumlah + $request->jumlah){
                    $data = [
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'jumlah' => $detail->jumlah + $request->jumlah
                    ];
                    Cart_Detail::where('product_id',$product->id)
                                ->update($data);
                }else{
                    Alert::error('Gagal', 'Jumlah produk di keranjang melebihi stok produk');
                    return redirect()->back();
                }
            } else {
                $data = [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'jumlah' => $request->jumlah
                ];
                Cart_Detail::create($data);
            }        

            Alert::success('Berhasil', 'Produk berhasil ditambahkan ke keranjang');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Jumlah pesanan melebihi stok yang ada');
            return redirect()->back();
        }
        
        
    }
}
