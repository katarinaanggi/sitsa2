<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class AdminController extends Controller
{
    //Membuat admin baru
    public function create(Request $request){
        $rules = [
			'name'      => 'required|string|max:50|min:5',
			'email'     => 'required|email|unique:admins,email',
			'password'  => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
		];

        $messages = [
            'required'  => ':attribute harus diisi.',
            'unique'    => ':attribute sudah terpakai.',
            'max'       => ':attribute terlalu panjang, maksimal :max karakter.',
            'min'       => ':attribute terlalu pendek, minimal :min karakter.',
            'string'    => ':attribute harus berupa karakter.',
            'email'     => ':attribute harus berupa email.',
            'same'      => 'Konfirmasi password tidak sama dengan password.',
            'cpassword.required'  => 'confirm password harus diisi.',
            'cpassword.min'       => 'confirm password terlalu pendek, minimal :min karakter.'
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
			return redirect()->route('admin.register')->withInput()->withErrors($validator)->with('error', 'Data belum berhasil ditambahkan');
		}
		else{
            try {
                $admin = new Admin();
                $admin->nama = $request->name;
                $admin->email = $request->email;
                $admin->password = \Hash::make($request->password);
                
                $save = $admin->save();
                return redirect()->back()->with('success', 'Anda berhasil melakukan registrasi');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Terdapat kesalahan, Anda gagal melakukan registrasi');
            }
        }

    }

    //Autentikasi login
    public function check(Request $request){
        //Validating inputs
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:30',
            'g-recaptcha-response' => 'required|captcha'
        ],[
            'email.exists' => 'Email tidak terdaftar sebagai admin',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password terlalu pendek, minimal :min karakter',
            'password.max' => 'Password terlalu panjang, maksimum :max karakter',
            'g-recaptcha-response' => [
                'required' => 'Tolong lakukan verfikasi bahwa anda bukan robot.',
                'captcha' => 'Captcha error! Coba lag nanti.',
            ],
        ]);

        $creds = $request->only('email','password');
        $remember_me = $request->has('remember_me') ? true : false; 
        $password = bcrypt($request->password);
        if(Auth::guard('admin')->attempt($creds, $remember_me)){
            // if($request->remember_me){
            //     setcookie('login_email', $request->email, time()+60*60*24*7);
            //     setcookie('login_password', $request->password, time()+60*60*24*7);
            //     return redirect()->route('admin.home')->with('error','Password salah, login gagal');
            // }
            return redirect()->route('admin.home');
        }
        else{
            return redirect()->route('admin.login')->with('error','Password salah, login gagal');
        }
    }

    //Logout
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function index()
    {
        // get this month income
        $income = Income::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->sum('total');
        // get this month expense
        $expense = Expense::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->sum('total');

        if(Carbon::now()->now()->month == 1){
            // get last month income
            $lastincome = Income::whereYear('tanggal', date('Y', strtotime('-1 year')))
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->sum('total');
            // get last month expense
            $lastexpense = Expense::whereYear('tanggal', date('Y', strtotime('-1 year')))
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->sum('total');
        } 
        else {
            // get last month income
            $lastincome = Income::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->sum('total');
            // get last month expense
            $lastexpense = Expense::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->sum('total');
        }

        $profit = $income - $expense; //30
        $lastprofit = $lastincome - $lastexpense; //-20

        // selisih data bulan ini dan bulan lalu
        $incomepersen = divnum($income, $lastincome) * 100;
        $expensepersen = divnum(($expense - $lastexpense), $lastexpense) * 100;
        $profitpersen = divnum(($profit - $lastprofit), $profit) * 100;

        //order
        $order = Order::all();
        $produkTerjual = Order_Detail::sum('jumlah');
        $categories = Category::withSum('orderdetails', 'jumlah')->get();
        $skincare = (int) $categories[0]->orderdetails_sum_jumlah;
        $makeup = (int) $categories[1]->orderdetails_sum_jumlah;
        $bodycare = (int) $categories[2]->orderdetails_sum_jumlah;
        $haircare = (int) $categories[3]->orderdetails_sum_jumlah;
        $lainnya = (int) $categories[4]->orderdetails_sum_jumlah;
        $chart = LarapexChart::donutChart()
            ->setTitle('Order Statistic Chart')
            ->setLabels(['Skin Care', 'Make Up', 'Body Care', 'Hair Care', 'Lainnya'])
            ->setDataset([$skincare, $makeup, $bodycare, $haircare, $lainnya])
            ->setColors(['#ffab00', '#ff3e1d', '#71dd37', '#03c3ec', '#696cff']);

        return view('dashboard.home',[
            'title' => "Dashboard",
            'income' => $income,
            'expense' => $expense,
            'expensepersen' => $expensepersen,
            'incomepersen' => $incomepersen,
            'profitpersen' => $profitpersen,
            'order' => $order,
            'categories' => $categories,
            'produkTerjual' => $produkTerjual,
            'chart' => $chart,
        ]);
    }

    public function show(){
        return view('dashboard.profile', [
            'title' => "Profil"
        ]);
    }

    public function markNotification(Request $request)
    {
        if($request->input('id')){
            auth()->guard('admin')->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('id'));
                })
                ->markAsRead();
        }
        else{
            auth()->guard('admin')->user()->unreadNotifications->markAsRead();
        }

        return response()->noContent();
    }

    function changeProfile(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules,[
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.'
        ]);

		if ($validator->fails()) {
			return redirect()->route('admin.profile')->withInput()->withErrors($validator)->with('error', 'Data belum berhasil diubah');
		}
		else{
            $current_timestamp = Carbon::now()->toDateTimeString();
            DB::table('admins')->where('id', $id)->update([
                'nama' => $request->name,
                'email' => $request->email,
                'updated_at' => $current_timestamp
            ]);
            return redirect()->route('admin.profile')->with('success', 'Personal Information berhasil diubah');
        }
    }

    function changePassword(Request $request, $id)
    {
        
        $rules = [
            'oldpassword' => 'min:5|required',
            'newpassword' => 'min:5|required',
            'cnewpassword' => 'required|min:5|same:newpassword'
        ];
        
        $validator = Validator::make($request->all(),$rules,[
            'oldpassword.min' => 'Password lama terlalu pendek, minimal :min karakter.',
            'newpassword.min' => 'Password baru terlalu pendek, minimal :min karakter.',
            'cnewpassword.min' => 'Konfirmasi password terlalu pendek, minimal :min karakter.',
            'oldpassword.required' => 'Password lama harus diisi.',
            'newpassword.required' => 'Password baru harus diisi.',
            'cnewpassword.required' => 'Konfirmasi password harus diisi.',
            'cnewpassword.same' => 'Konfirmasi password harus sama dengan password baru.'
        ]);
        
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('tab', 'Password');
		}
		else{
            if (!(Hash::check($request->get('oldpassword'), Auth::guard('admin')->user()->password))) {
                return redirect()->back()->with('error','Password tidak sesuai.')
                                         ->with('tab', 'Password');
            }
    
            if(strcmp($request->get('oldpassword'), $request->get('newpassword')) == 0){
                return back()
                                 ->with('error','Password baru tidak boleh sama dengan password saat ini.')
                                 ->with('tab', 'Password');
            }
            //Change Password
            $current_timestamp = Carbon::now()->toDateTimeString();
            $user = Auth::guard('admin')->user();
            $user->password = bcrypt($request->get('newpassword'));
            $user->updated_at = $current_timestamp;
            $user->save();
            return redirect()->route('admin.profile')->with('success','Password berhasil diubah!');
        }
    }

    public function forgotPassword()
    {
        return view('dashboard.forgot_password', [
            'title' => "Forgot Password"
        ]);
    }

    public function resetLink(Request $request)
    {
        //Validate
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ],[
            'email.exists' => 'Email tidak terdaftar sebagai admin',
            'email.required' => 'Email harus diisi',
        ]);

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $action_link = route('admin.show_reset', ['token' => $token, 'email' => $request->email]);
        $body = "Kami telah menerima permintaan untuk reset password yang anda kirimkan melalui akun anda di Sri Ayu Beauty Shop. Anda dapat mereset password dengan meng-klik link di bawah ini.";
        
        Mail::send('dashboard.sendResetPass', ['action_link'=>$action_link, 'body'=>$body], function($message) use ($request){
            $message->from('sriayubeautyshop@gmail.com', 'Sri Ayu Beauty Shop');
            $message->to($request->email)->subject('Reset Password');
        });
        return back()->with('warning', 'Kami sudah mengirimkan link reset password. Segera cek inbox anda!');
    }
    
    public function showReset(Request $request, $token = null) 
    {
        return view('dashboard.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:5|confirmed',
            'password_confirmation'=>'required',
        ]);

        $check_token = DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$check_token){
            return back()->withInput()->with('error', 'Invalid token');
        }else{

            Admin::where('email', $request->email)->update([
                'password'=>Hash::make($request->password)
            ]);

            DB::table('password_resets')->where([
                'email'=>$request->email
            ])->delete();

            return redirect()->route('admin.login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
        }
    }
}
