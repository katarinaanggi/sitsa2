<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create(){
        return view('register',[
            "title" => "Registrasi Pelanggan"
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nama' => 'required|max:255|regex:/^([^0-9]*)$/',
            'hp' => 'required|unique:users,hp|numeric|digits_between:10,13',
            'alamat' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|confirmed|min:4|max:255',
        ];      
        
        $validatedData = $request->validate($rules,
        [
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'nama.regex' => 'Nama hanya berisi huruf.',
            'hp.required' => 'Nomor HP/telepon harus diisi.',
            'hp.unique' => 'Nomor HP/telepon sudah terdaftar.',
            'hp.numeric' => 'Nomor HP/telepon harus berupa angka.',
            'hp.digits_between' => 'Nomor HP/telepon harus antara 10 dan 13 digit.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 4 karakter.',
            'password.max' => 'Password tidak boleh lebih dari 255 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        Cart::create(['user_id' => $user->id]);

        return redirect()->route('login')->with('success', 'Akun berhasil ditambahkan. Silakan login.');
    }

    public function edit(User $user){
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }
        
        return view('edit_profile',[
            "title" => "Edit Profil",
            "user" => $user
        ]);
    }

    public function update(Request $request, User $user){
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        $rules = [
            'nama' => 'required|max:255|regex:/^([^0-9]*)$/',
            'alamat' => 'required'
        ];
        
        if(!$request->email || $request->email != auth()->user()->email){
            $rules['email'] = 'required|email:dns|unique:users,email';
        }

        if(!$request->hp || $request->hp != auth()->user()->hp){
            $rules['hp'] = 'required|unique:users,hp|numeric|digits_between:10,13';
        }

        $validatedData = $request->validate($rules,
        [
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'nama.regex' => 'Nama hanya berisi huruf.',
            'hp.required' => 'Nomor HP/telepon harus diisi.',
            'hp.unique' => 'Nomor HP/telepon sudah terdaftar.',
            'hp.numeric' => 'Nomor HP/telepon harus berupa angka.',
            'hp.digits_between' => 'Nomor HP/telepon harus antara 10 dan 13 digit.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat harus diisi.'
        ]);

        User::where('id', auth()->user()->id)
                ->update($validatedData);

        return redirect('/profile/edit/'.auth()->user()->id)->with('success', 'Perubahan profil berhasil disimpan');
    }

    public function destroy(User $user){
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        DB::table('carts')->where('user_id',$user->id)->delete();        
        DB::table('orders')->where('user_id',$user->id)->delete();        
        User::find($user->id)->delete();       
        
        Auth::logout();
        return redirect()->route('home');
    }

    public function edit_password(User $user){
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        return view('change_password',[
            "title" => "Ubah Password",
            "user" => $user
        ]);
    }
    
    public function update_password(User $user, Request $request){
        // dd($request);
        if (Auth::guest() || auth()->user()->id != $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('loginError', "Silakan login kembali.");
        }

        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:4', 'max:255'],
            'new_confirm_password' => ['required','same:new_password'],
        ];

        $messages = [
            'current_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password minimal :min karakter.',
            'new_password.max' => 'Password tidak boleh lebih dari :max karakter.',
            'new_confirm_password.required' => 'Konfirmasi password harus diisi.',
            'new_confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ];

        $validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);
        }
    }

    public function forgot_password()
    {
        return view('forgot_password', [
            'title' => "Forgot Password"
        ]);
    }

    public function resetLink(Request $request)
    {
        //Validate
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ],[
            'email.exists' => 'Email belum terdaftar',
            'email.required' => 'Email harus diisi',
        ]);

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $action_link = route('show_reset', ['token' => $token, 'email' => $request->email]);
        $body = "Kami telah menerima permintaan untuk reset password yang anda kirimkan melalui akun anda di Sri Ayu Beauty Shop. Anda dapat mereset password dengan meng-klik link di bawah ini.";
        
        Mail::send('sendResetPass', ['action_link'=>$action_link, 'body'=>$body], function($message) use ($request){
            $message->from('sriayubeautyshop@gmail.com', 'Sri Ayu Beauty Shop');
            $message->to($request->email)->subject('Reset Password');
        });
        return back()->with('warning', 'Kami sudah mengirimkan link reset password. Segera cek inbox anda!');
    }
    
    public function showReset(Request $request, $token = null) 
    {
        return view('reset_password')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:4|confirmed',
            'password_confirmation'=>'required',
        ]);

        $check_token = DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$check_token){
            return back()->withInput()->with('error', 'Invalid token');
        }else{

            User::where('email', $request->email)->update([
                'password'=>Hash::make($request->password)
            ]);

            DB::table('password_resets')->where([
                'email'=>$request->email
            ])->delete();

            return redirect()->route('login')->with('success', 'Password Anda berhasil diubah. Silakan login dengan password baru')->with('verifiedEmail', $request->email);
        }
    }
}
