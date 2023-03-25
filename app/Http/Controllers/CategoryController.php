<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.category', [
            'title' => "Category"
        ]);
    }

    /**
     * Display a listing of the product by category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function showbycategory(Category  $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        return view('category.showbycategory',[
            'title' => $category->nama,
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
        return view('category.add_category',[
            'title' => "Tambah Kategori"
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
            'name'     => 'required|string|max:50|min:5',
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
                    $filePath = $file->storeAs('categories', $fileName, 'public');
                    
                    $data['gambar'] = $fileName;
                    $data['pic_path'] = '/uploads/' . $filePath;
                }
                Category::insert($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
			  return redirect()->route('admin.category')->with('error', 'Data belum berhasil ditambahkan');
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category  $category)
    {
        return view('category.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category  $category)
    {
        $rules = [
            'name'      => 'required|string|max:50|min:5'
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
                    Storage::disk('public')->delete('categories/'.$category->gambar);
                    
                    //mengubah nama file dan path file
                    if($request->filled('picname')){
                        $fileName = time().'_'.$request->picname.'.'.strtolower($file->getClientOriginalExtension());
                    }
                    else {
                        $fileName = time().'_'.$file->getClientOriginalName();
                    }
                    $filePath = '/uploads/' . $file->storeAs('categories', $fileName, 'public');
                }
                
                $current_timestamp = Carbon::now()->toDateTimeString();
                DB::table('categories')->where('id', $category->id)->update([
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $pic)
    {
        Storage::disk('public')->delete('categories/'.$pic);

        Category::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 

    }
}
