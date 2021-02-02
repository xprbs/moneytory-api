<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Credit;
use Validator;
use App\Models\User;
use Carbon\Carbon;

class CreditController extends Controller
{
    
    public function account()
    {
        $data = User::where('email', Auth::user()->email)->first();
        return response()->json($data, 200);
    }

    public function check()
    {
        $income = Credit::where('kategori', 'income')->sum('jumlah');
        $outcome = Credit::where('kategori', 'outcome')->sum('jumlah');
        $data = $income - $outcome;
        $latest = Credit::where('email', Auth::user()->email)->latest()->first();
        return response()->json([
            'email' => Auth::user()->email,
            'current_balance' => $data,
            'last_updated' => $latest
        ], 200);
    }

    public function add(Request $request)
    {
        $email = Auth::user()->email;

        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
            'kategori' => 'required|string|max:10',
            'keterangan' => 'required|string|max:50'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }else{
            Credit::create([
                'email' => $email,
                'jumlah' => $request->jumlah,
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'created_at' => Carbon::now()
            ]);
            return response()->json(['msg' => 'success'], 200);
        }
    }

    public function history()
    {
        $data = Credit::where('email', Auth::user()->email)->latest()->get();
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Credit::where('email', Auth::user()->email)->where('id', $id)->first();
        if ($data != null){

            Credit::where('email', Auth::user()->email)->where('id', $id)->update([
                'jumlah' => $request->get('jumlah'),
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json(['msg' => 'success updated'], 202);
        }else{
            return response()->json(['msg' => 'not found'], 404);
        }
    }

    public function delete($id)
    {
        $data = Credit::where('id', $id)->where('email', Auth::user()->email)->first();
        if ($data != null){
            $credit = Credit::find($id);
            $credit->delete();

            return response()->json(['msg' => 'success deleted'], 202);
        }else{
            return response()->json(['msg' => 'not found'], 404);
        }
    }

    public function sort($param)
    {
        $data = Credit::where('email', Auth::user()->email)->where('kategori', $param)->get();
        if ($data != null){
            return response()->json($data, 200);
        }else{
            return response()->json(['msg' => 'not found'], 404);
        }
    }
}
