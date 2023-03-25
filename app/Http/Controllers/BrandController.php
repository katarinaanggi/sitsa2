<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brand.brand', [
            'title' => "Brand"
        ]);
    }

    /**
     * Display a listing of the product by brand.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function showbybrand(Brand  $brand)
    {
        $products = Product::where('brand_id', $brand->id)->get();
        return view('brand.showbybrand',[
            'title' => $brand->nama,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.add_brand',[
            'title' => "Tambah Brand"
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
            'name'     => 'required|string',
            'pic'      => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ];
        
        $messages = [
            'required'  => ':attribute harus diisi.',
            'max'       => ':attribute terlalu panjang, maksimal :max karakter.',
            'min'       => ':attribute terlalu pendek, minimal :min karakter.',
            'string'    => ':attribute harus berupa karakter.',
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
                    $filePath = $file->storeAs('brands', $fileName, 'public');
                    
                    $data['gambar'] = $fileName;
                    $data['pic_path'] = '/uploads/' . $filePath;
                }
                Brand::insert($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
			  return redirect()->route('admin.brand')->with('error', 'Data belum berhasil ditambahkan');
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit_brand', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $rules = [
            'name'      => 'required|string'
        ];
        
        $messages = [
            'required'  => ':attribute harus diisi.',
            'max'       => ':attribute terlalu panjang, maksimal :max karakter.',
            'min'       => ':attribute terlalu pendek, minimal :min karakter.',
            'string'    => ':attribute harus berupa karakter.',
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
                    Storage::disk('public')->delete('brands/'.$brand->gambar);
                    
                    //mengubah nama file dan path file
                    if($request->filled('picname')){
                        $fileName = time().'_'.$request->picname.'.'.strtolower($file->getClientOriginalExtension());
                    }
                    else {
                        $fileName = time().'_'.$file->getClientOriginalName();
                    }
                    $filePath = '/uploads/' . $file->storeAs('brands', $fileName, 'public');
                }
                
                $current_timestamp = Carbon::now()->toDateTimeString();
                DB::table('brands')->where('id', $brand->id)->update([
                    'nama' => $request->name,
                    'gambar' => $fileName,
                    'pic_path' => $filePath,
                    'updated_at' => $current_timestamp
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $pic)
    {
        Storage::disk('public')->delete('brands/'.$pic);

        Brand::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
}
