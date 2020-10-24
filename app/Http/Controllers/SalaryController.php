<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $month = $request->input('month')===null?now()->month:$request->input('month');
        $year = $request->input('year')===null?now()->year:$request->input('year');
        return view('backend.salary.index')->with('data', $this->getDataByMonth($year, $month))->with('which_month',$year.'年'.$month.'月的薪资查询');
    }

    private function getDataByMonth($year, $month) {
        $teachers = \App\Model\Teacher::where('start_at', '<>', null)->where('deleted_at', null)->get();
        $theData = collect();
        $all_working_days = $this->getWorkingDays($year, $month);
        foreach ($teachers as $teacher) {
            $data = [];
            $leaving_number = 0;
            $allLeaves = $this->getLeaveDateByUser($teacher->user_id);
            foreach ($allLeaves as $leave) {
                if ($all_working_days->contains($leave)) {
                    $leaving_number++;
                }
            }
            $missing_number = $this->calculateMissingDaysByUser($year, $month, $teacher->user_id)->count();
            data_fill($data, 'user', $teacher);
            data_fill($data, 'leaving_number', $leaving_number);
            data_fill($data, 'missing_number', $missing_number);
            data_fill($data, 'total_working_days', $all_working_days->count());
            $theData->push($data);
        }
        return $theData;
    }
    /*
     * calculate user's missing-days in case the teacher starts from the middle of the month 
     */
    private function calculateMissingDaysByUser($year,$month,$user_id) {
        $teacher  = \App\Model\Teacher::where('user_id',$user_id)->first();
        $queryMonth = \Illuminate\Support\Carbon::create($year, $month,1);
        $teacher_start_date = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $teacher->start_at);
        $missing_date = collect();
//       the month and year are same as teacher's joining data
        if($queryMonth->month===$teacher_start_date->month and $queryMonth->year===$teacher_start_date->year){
           for($date=$queryMonth;$date<$teacher_start_date;$date->addDay() ){
               $this->is_a_working_day($date)?$missing_date->push($date->format('Y-m-d')):null;
           }
        }
          return $missing_date;
    }

    private function getLeaveDateByUser($user_id) {
        $allLeaves = collect();
        $leaves = \App\Model\Leave::where('user_id', $user_id)->get();
        foreach ($leaves as $leave) {
           $allLeaves = $allLeaves->concat($this->getWorkingDatesByLeave($leave));
        }
        return $allLeaves;
    }

    private function getWorkingDatesByLeave(\App\Model\Leave $leave) {
        $leaves = collect();
        if ($leave->to === null) {
            $leaves->push($leave->from);
        } else {
            $from = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $leave->from);
            $to = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $leave->to);
            for ($date = $from; $date <= $to; $date->addDay()) {
                $this->is_a_working_day($date) ? $leaves->push($date->format('Y-m-d')) : null;
            }
        }
        return $leaves;
    }

    private function getWorkingDays($year, $month) {
        $theMonth = \Illuminate\Support\Carbon::create($year, $month);
        $how_many_working_days = collect();
        for ($i = 1; $i <= $theMonth->daysInMonth; $i++) {
            $theMonth->day($i);
            $this->is_a_working_day($theMonth) ? $how_many_working_days->push($theMonth->format('Y-m-d')) : null;
        }
        return $how_many_working_days;
    }

    private function is_a_working_day(\Illuminate\Support\Carbon $date) {
        if ($date->dayOfWeek === 6 || $date->dayOfWeek === 0) {
            return \App\Model\Holiday::where('which_day', $date->format('Y-m-d'))->first() === null ? false : true;
        } else {
            return \App\Model\Holiday::where('which_day', $date->format('Y-m-d'))->first() === null ? true : false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view('backend.salary.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
