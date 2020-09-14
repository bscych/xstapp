<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Homework;
class HomeworkController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $today= now()->format('Y-m-d');
        $homeworks = Homework::where('date',$today)->get();
//        foreach($homeworks as $homework){
//            $chinese = collect(json_decode($homework->chinese));
//            $homework->chinese = $chinese;
//        }
        return view('backend.homework.index', ['homeworks' => $homeworks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $schools = \App\Model\Constant::where('parent_id', 44)->get();
        return view('backend.homework.create', ['schools' => $schools]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $school_name = $request->input('school_name');
        $grade = $request->input('grade');
        $class = $request->input('class');
        $chinese = collect();
        $math = collect();
        $english = collect();
        $other = collect();
        for ($i = 1; $i < 6; $i++) {
//            提取语文作业
            $chinese_task = $request->input('c_' . $i);
            if (strlen(trim($chinese_task,' ')) > 0) {
                $chinese->push($chinese_task);
            }
//extract 数学作业
            $math_task = $request->input('m_' . $i);
            if (strlen(trim($math_task)) > 0) {
                $math->push($math_task);
            }
//            extract 英语作业
            $english_task = $request->input('e_' . $i);
            if (strlen(trim($english_task)) > 0) {
                $english->push($english_task);
            }
//extract 其他作业
            $other_task = $request->input('o_' . $i);
            if (strlen(trim($other_task)) > 0) {
                $other->push($other_task);
            }
        }
        $homework = new homework;
        $homework->school_name = $school_name;
        $homework->grade = $grade;
        $homework->class = $class;
        $homework->chinese = $chinese->toJson(JSON_UNESCAPED_UNICODE);
        $homework->math = $math->toJson(JSON_UNESCAPED_UNICODE);
        $homework->english = $english->toJson(JSON_UNESCAPED_UNICODE);
        $homework->other = $other->toJson(JSON_UNESCAPED_UNICODE);
        $homework->date = now()->format('Y-m-d');
        $homework->save();
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
