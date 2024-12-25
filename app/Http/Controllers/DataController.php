<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index(Request $request){
        $search = $request->input('q');
        $data = Data::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(25);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Itemset',
            'subTitle' => null,
            'data' => $data
        ];

        return view('pages.data',  $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'family_number_id' => 'required',
            'name' => 'required',
            'district' => 'required',
            'income' => 'required',
            'spending' => 'required',
            'job' => 'required',
            'disability_type' => 'required',
            'residence_condition' => 'required',
            'electricity_capacity' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('data')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $data = New Data();
        $data->family_number_id = $request->family_number_id;
        $data->name = $request->name;
        $data->district = $request->district;
        $data->income = $request->income;
        $data->spending = $request->spending;
        $data->job = $request->job;
        $data->disability_type = $request->disability_type;
        $data->residence_condition = $request->residence_condition;
        $data->electricity_capacity = $request->electricity_capacity;
        $data->save();
        return redirect()->route('data')->with('success', 'Data has been added successfully');
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'family_number_id' => 'required',
            'name' => 'required',
            'district' => 'required',
            'income' => 'required',
            'spending' => 'required',
            'job' => 'required',
            'disability_type' => 'required',
            'residence_condition' => 'required',
            'electricity_capacity' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('data')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }
        $data = Data::find($id);
        $data->family_number_id = $request->family_number_id;
        $data->name = $request->name;
        $data->district = $request->district;
        $data->income = $request->income;
        $data->spending = $request->spending;
        $data->job = $request->job;
        $data->disability_type = $request->disability_type;
        $data->residence_condition = $request->residence_condition;
        $data->electricity_capacity = $request->electricity_capacity;
        $data->save();
        return redirect()->route('data')->with('success', 'Data has been updated successfully');
    }

    public function destroy($id){
        $data = Data::find($id);
        $data->delete();
        return redirect()->route('data')->with('success','Data has been deleted successfully');
    }

    public function import(Request $request){

    }
}
