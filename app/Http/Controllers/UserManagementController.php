<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usermanagement.userManage', [
            'title' => "User Management"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usermanagement.add_user',[
            'title' => "Tambah User"
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
			'email'     => 'required|email|unique:users,email',
			'phone'     => 'required|numeric|min:5',
			'address'    => 'required',
			'password'  => 'required|min:5',
		];
        
        $messages = [
            'required'  => 'Field :attribute harus diisi.',
            'unique'    => 'Field :attribute sudah terpakai.',
            'max'       => 'Field :attribute terlalu panjang, maksimal :max karakter.',
            'min'       => 'Field :attribute terlalu pendek, minimal :min karakter.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'email'     => 'Field :attribute harus berupa email.',
            'numeric'   => 'Field :attribute harus berupa numeric.',
            'same'      => 'Konfirmasi password tidak sama dengan password.',
            'cpassword.required'  => 'Field konfirmasi password harus diisi.',
            'cpassword.min'       => 'Field konfirmasi password terlalu pendek, minimal :min karakter.'
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                $current_timestamp = Carbon::now()->toDateTimeString();
                $data['nama'] = $request->name;
                $data['email'] = $request->email;
                $data['hp'] = $request->phone;
                $data['alamat'] = $request->address;
                $data['password'] =  Hash::make($request->password);
                $data['created_at'] = $current_timestamp;
                $data['updated_at'] = $current_timestamp;
                User::insert($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
			  return redirect()->route('admin.userManagement')->with('error', 'Data belum berhasil ditambahkan');
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = User::find($id);
        // $name = $user->name;
        // return view('usermanagement.detail',[
        //     'title' => "Detail User ".$name,
        //     'user' => $user
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('usermanagement.edit_user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
			'name'      => 'required|string|max:50|min:5',
			'email'     => 'required|email|unique:users,email,'.$id,
			'phone'     => 'required|numeric|min:5',
			'address'   => 'required',
		];

        $messages = [
            'required'  => 'Field :attribute harus diisi.',
            'unique'    => 'Field :attribute sudah terpakai.',
            'max'       => 'Field :attribute terlalu panjang, maksimal :max karakter.',
            'min'       => 'Field :attribute terlalu pendek, minimal :min karakter.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'email'     => 'Field :attribute harus berupa email.',
            'numeric'   => 'Field :attribute harus berupa numeric.'
        ];

		$validator = Validator::make($request->all(),$rules, $messages);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}
		else{
            try{
                $current_timestamp = Carbon::now()->toDateTimeString();
                $data = User::find($id);
                $data->nama = $request->name;
                $data->email = $request->email;
                $data->hp = $request->phone;
                $data->alamat = $request->address;
                $data->updated_at = $current_timestamp;
                $data->save();
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
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

    /**
     * Reset password.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset($id)
    {
        $resetpass = Hash::make(User::find($id)->value('email'));
        User::where('id','=', $id)->update(['password' => $resetpass]);
        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset. Password menjadi email dari user tersebut.',
        ]); 
    }
}
