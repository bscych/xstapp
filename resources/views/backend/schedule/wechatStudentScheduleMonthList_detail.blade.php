@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
    <h5 class="text-center">
        @if($lastMonth != $month)
        <small class="pull-left"> <a class="text-left" href="{{route('get_schedule_detail_by_month',['month'=>$lastMonth,'class_id'=>$class_id,'student_id'=>$student_id,'AGENT'=>'WECHAT'])}}">上月订餐详情</a> </small>  
        @endif
        {{$month.'月'}}订餐详情</h5>
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            <th rowspan="2"class="text-center"><small>日期</small></th>
                            @foreach($students as $student)
                            <th colspan="2" class="text-center"><small>{{$student->name}}</small></th>
                            @endforeach

                        </tr>
                        <tr>
                            @foreach($students as $student)
                            <!--th class="text-center"><small>出勤</small></th-->
                            <th class="text-center"><small>午餐</small></th>
                            <th class="text-center"><small>晚餐</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $whichday)
                        <tr>

                            <td class="text-center">{{$whichday->date}}</td>
                            @foreach($students as $student)

                            @if ($schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()!=null)
                            <!--td class="text-center">
                                {{$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->attended==0?'':$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->attended}}
                            </td-->
                            <td class="text-center">
                                {{$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->lunch==0?'':$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->lunch}}
                            </td>
                            <td class="text-center">
                                {{$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->dinner==0?'':$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->dinner}}
                            </td>
                            @else
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            @endif

                            @endforeach

                        </tr>
                        @endforeach

                        <tr>
                            <td class="text-center"><small>合计</small></td>
                            @foreach($students as $student)
                            <!--td class="text-center">{{$schedule_students->where('student_id','=',$student->id)->where('attended','=',1)->count()}}<small>天</small></td-->
                            <td colspan="2" class="text-center">{{$schedule_students->where('student_id','=',$student->id)->where('lunch','=',1)->count()+$schedule_students->where('student_id','=',$student->id)->where('dinner','=',1)->count()}}<small> 餐</small></td>
                            @endforeach

                        </tr>
                        <tr>
                            <td class="text-center" rowspan="2"><small>餐费总计</small></td>
                            @foreach($students as $student)

                            <td colspan="3" class="text-center">{{(($schedule_students->where('student_id','=',$student->id)->where('attended','=',1)->count()) * $snack_fee)+(($schedule_students->where('student_id','=',$student->id)->where('lunch','=',1)->count()+$schedule_students->where('student_id','=',$student->id)->where('dinner','=',1)->count()) * 15)}}</td>
                            @endforeach
                        </tr>

                    </tbody>
                </table>

            </div>      
     

</div>
</div>
@endsection
