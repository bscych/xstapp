@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
   
            
                <h3><a  href="{{route('get_schedule_detail_by_month',['month'=>($month-1),'class_id'=>$class_id])}}"><<上月({{$month-1==0?12:$month-1}}月）考勤    </a></h3>
                <h3><i class="glyphicon glyphicon-th"></i>{{$month.'月'}}考勤</h3>
              
          
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            <th class="text-center"><small>日期</small></th>
                            @foreach($students as $student)
                            <th class="text-center"><small>{{$student->name}}</small></th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $whichday)
                        <tr>

                            <td class="text-center">{{$whichday->date}}</td>
                            @foreach($students as $student)

                            @if ($schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()!=null)
                            <td class="text-center">
                                {{$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->attended==0?'':$schedule_students->where('student_id','=',$student->id)->where('schedule_id','=',$whichday->id)->first()->attended}}
                            </td>
                           
                            @else
                           
                            <td class="text-center"></td>
                          
                            @endif

                            @endforeach

                        </tr>
                        @endforeach

                        <tr>
                            <td class="text-center"><small>合计</small></td>
                            @foreach($students as $student)
                            <td class="text-center">{{$schedule_students->where('student_id','=',$student->id)->where('attended','=',1)->count()}}<small>天</small></td>
                            @endforeach

                        </tr>

                    </tbody>
                </table>

            </div>      
     
    </div>
</div>
</div>
@endsection
