@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        
           
                <!--h3><a href="{{ URL::to('getScheduleByMonthClass/' .($month-1).'/'. $class_id ) }}"><<上月({{$month-1==0?12:$month-1}}月）考勤    </a></h3-->
                <h3><i class="glyphicon glyphicon-th"></i>{{$month.'月'}}考勤</h3>
            
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            <th class="text-center"><small>日期</small></th>
                            <th class="text-center"><small>出勤</small></th>
                            <th class="text-center"><small>午餐</small></th>
                            <th class="text-center"><small>晚餐</small></th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $whichday)
                        <tr>
                            <td class="text-center">{{$whichday->date}}</td>
                            <td class="text-center">
                                {{$schedule_students->where('schedule_id','=',$whichday->id)->sum('attended')}}
                            </td>
                            <td class="text-center">
                                {{$schedule_students->where('schedule_id','=',$whichday->id)->sum('lunch')}}
                            </td>
                            <td class="text-center">
                                {{$schedule_students->where('schedule_id','=',$whichday->id)->sum('dinner')}}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <p><a href="{{URL::to('getScheduleByMonthClass_detail/' .$month.'/'. $class_id )}}">本月明细</a></p>
            </div>      
       
    </div>
</div>
</div>
@endsection
