<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;

class DailyLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        ini_set('max_execution_time', 0);
        $order=DB::table('order')->get();
        $today=new DateTime();
        $today_date=$today->format('Y-m-d');
        foreach ($order as $key => $value) {
            $period_start = new DateTime($value->period_from);
            $period_end = new DateTime($value->period_to);
            $received_apps=DB::table('delivery')->where('client_id',$value->client_id)->whereDate('delivery_date','<',$today_date)->get()->count();
            $left_to_delivey=$value->period_app_limit-$received_apps;
            $days_left = $today->diff($period_end)->format("%r%a"); //3
            $time_since_period_start=$period_start->diff($today)->format("%r%a") * 24 * 60 * 60;
            $time_period_full=$today->diff($period_end)->format("%r%a") * 24 * 60 * 60;
            if($left_to_delivey > 0 && $days_left > 0 && !(($received_apps/$value->period_app_limit) < ($time_since_period_start/ $time_period_full))){
                $daily_app_limit=$left_to_delivey/$days_left;
                DB::table('order')->where('client_id',$value->client_id)->update(['daily_app_limit'=>$daily_app_limit]);
            }
       
        }
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
