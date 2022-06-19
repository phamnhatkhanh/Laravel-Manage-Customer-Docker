<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $search_name= '';
        $search_phone= '';
        $from_age='';
        $to_age='';
        $err=array();
        $customers = Customer::all();
        return view('customer.index')->with(['customers'=>$customers,'search_name'=>$search_name,'search_phone'=>$search_phone,'from_age'=>$from_age,'to_age'=>$to_age])->with('errors',$err);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Customer::create([
            'name'=>$request->full_name,
            'address'=>$request->address,
            'number_phone'=>$request->number_phone,
            'birthday'=>$request->birth_date
        ]);
        return \redirect('/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('customer.edit')->with('customer',Customer::where('id',$id)->first());
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
        Customer::where('id',$id)->update([
         'name'=>$request->full_name,
            'address'=>$request->address,
            'number_phone'=>$request->number_phone,
            'birthday'=>$request->birth_date
        ]);
        return \redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('id',$id);
        $customer->delete();
        return redirect('/customer');
    }
    public function filter_customer(Request $request){
        $search_name= $request->search_name;
        $search_phone= $request->search_phone;
        $from_age= $request->from_age;
        $to_age= $request->to_age;
        $err=array();

        //validation age
        if(empty ($request->from_age) && empty ($request->from_age)   ){
            $from_age= 0;
            $to_age= 200;
        }elseif(  $to_age < 0 || $from_age < 0 ){
            $err[]='Input value cannot be negative';
        }elseif($from_age>$to_age){
             $err[]='Invalid data';
        }else{
             $from_age= $request->from_age;
            $to_age= $request->to_age;
        }
        if(empty ($request->search_phone)    ){
             $search_phone='';
        }elseif( is_numeric($search_phone)){
            $search_phone= $request->search_phone;

        }else{
            $err[]='Phone number is not correct';
        }


        $customers = DB::table('customers')
            ->where('name','LIKE', '%'.$search_name.'%')
            ->where('number_phone','LIKE', '%'.$search_phone.'%')
            ->where('birthday','<=',Carbon::now()->subYear($from_age))
            ->where('birthday','>=',Carbon::now()->subYear($to_age))
            ->get();

        // Keep data in form after submission
        $search_name= $request->search_name;
        $search_phone= $request->search_phone;
        $from_age= $request->from_age;
        $to_age= $request->to_age;

         return view('customer.index')->with(['customers'=>$customers,'search_name'=>$search_name,'search_phone'=>$search_phone,'from_age'=>$from_age,'to_age'=>$to_age])
         ->with('errors',$err);

    }
}
