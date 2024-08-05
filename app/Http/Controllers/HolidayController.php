<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Holidays;

class HolidayController extends Controller
{
    //

     /**
     * Create a new controller instance.
     */
    public function __construct(
       
    ) {

    }

    public function insertHolidayData() {

        $json = Storage::json('public/holiday.json');
       
         $sampleData = $json['response']['holidays']; 
        //$sampleData = Holidays::orderBy('date_of_holiday','desc')->get();
        
        
        // insert code
        $insert_data = [];

        foreach($sampleData as $key=>$value) {
            $data = [
                'holiday_name'=>$value['name'],
                'date_of_holiday'=>$value['date']['iso'],
                'month'=>$value['date']['datetime']['month'],
                'description'=>$value['description'],
                'type'=>implode(',', $value['type']),
                'created_at'=>date('Y-m-d H:i:s')
            ];

            $insert_data[] = $data;
        }
        

        Holidays::insert($insert_data);
    } 

    public function list(Request $request) {
       
        
        $sampleData = Holidays::orderBy('month','asc')->get();
        if ($request->ajax()) {
                        
            return DataTables::of($sampleData)->editColumn('month', function($sampleData){
                $formatDate = date('F', mktime(0, 0, 0, $sampleData['month'], 10));
                return $formatDate;
            })
        //     ->addColumn('action', function ($sampleData) {
                 
        //     $showBtn =  '<button ' .
        //                     ' class="btn btn-outline-info" ' .
        //                     ' onclick="showHoliday(' . $sampleData['id'] . ')">Show' .
        //                 '</button> ';
 
        //     $editBtn =  '<button ' .
        //                     ' class="btn btn-outline-success" ' .
        //                     ' onclick="editProject(' . $sampleData['id'] . ')">Edit' .
        //                 '</button> ';
 
        //     $deleteBtn =  '<button ' .
        //                     ' class="btn btn-outline-danger" ' .
        //                     ' onclick="destroyProject(' . $sampleData['id'] . ')">Delete' .
        //                 '</button> ';
 
        //     return $showBtn . $editBtn . $deleteBtn;
        // })
        // ->rawColumns(
        // [
        //     'action',
        // ])
        ->make(true);
       }
              
        return view('holidaylist');
    }

    public function calendarList(Request $request) {
       
       
            $data = Holidays::whereDate('date_of_holiday', '>=', '2024-01-01')
                    ->whereDate('date_of_holiday',   '<=', '2025-12-31')
                    ->get(['id','holiday_name', 'date_of_holiday']);

            $events = [];          
            foreach($data as $dt) {
                $events[] = [
                'id'=>$dt['id'],    
                'title'=>$dt['holiday_name'],
                'type'=>$dt['type'],
                'start'=>$dt['date_of_holiday'],
                'end'=>$dt['date_of_holiday']
                ];  
            }          

       
       
        return view('calendar-page',['events'=>$events]);
    }

     /**
     * Create holiday event 
     */

    public function creatEvent(Request $request){
        $data = $request->all();
        $insertHoliday = ['date_of_holiday'=>$data['date_of_holiday'],'holiday_name'=>$data['holiday_name'],'month'=>date('m', strtotime($data['date_of_holiday']))];
        $events = Holidays::insert($insertHoliday);
        return response()->json($events);
    }

     /**
     * Delete holiday
     */

     public function deleteHoliday(Request $request){
       
        $event = Holidays::find($request->id);
        return $event->delete();
    } 

    /**
     * Show detail of the holiday
     */
    
     public function showHolidayDetail(Request $request) {
      
        $holidayDetail = Holidays::find($request->id);

        return response()->json(['holidayDetail'=>$holidayDetail]);

     }

}
