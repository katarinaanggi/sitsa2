<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\IncomesExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('income.income', [
            'title' => "Income"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('income.add_income',[
            'title' => "Tambah Income"
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
            'date'     => 'required|date',
            'amount'   => 'required|numeric',
            'total'   => 'required|numeric',
            'desc'     => 'required|string',
        ];
        
        $messages = [
            'required'  => ':attribute harus diisi.',
            'string'    => ':attribute harus berupa karakter.',
            'number'    => ':attribute harus berupa angka.',
            'date'      => ':attribute harus berupa tanggal.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{
                $current_timestamp = Carbon::now()->toDateTimeString();
                $data['nama'] = $request->name;
                $data['tanggal'] = $request->date;
                $data['jumlah'] = $request->amount;
                $data['total'] = $request->total;
                $data['deskripsi'] = $request->desc;
                $data['created_at'] = $current_timestamp;
                $data['updated_at'] = $current_timestamp;
                
                Income::insert($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Ditambahkan!'
                ]);
            }
			catch(Exception $e){
			  return redirect()->route('admin.income')->with('error', 'Data belum berhasil ditambahkan');
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income  $income)
    {
        return view('income.edit_income', compact('income'));
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
            'name'     => 'required|string',
            'date'     => 'required|date',
            'amount'   => 'required|numeric',
            'total'   => 'required|numeric',
            'desc'     => 'required|string',
        ];
        
        $messages = [
            'required'  => ':attribute harus diisi.',
            'string'    => ':attribute harus berupa karakter.',
            'number'    => ':attribute harus berupa angka.',
            'date'      => ':attribute harus berupa tanggal.',
        ];
        
		$validator = Validator::make($request->all(),$rules,$messages);
        
		if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		else{
            try{                
                $current_timestamp = Carbon::now()->toDateTimeString();
                DB::table('incomes')->where('id', $id)->update([
                    'nama' => $request->name,
                    'tanggal' => $request->date,
                    'jumlah' => $request->amount,
                    'total' => $request->total,
                    'deskripsi' => $request->desc,
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
    public function destroy($id)
    {
        Income::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }

    /**
     * Export all resource to excel
     *
     * @return \Illuminate\Http\Response
     */
    public function fileExport() 
    {
        return new IncomesExport;
    }
}
