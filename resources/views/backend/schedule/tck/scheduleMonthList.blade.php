@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
                <h3><i class="glyphicon glyphicon-th"></i>{{$month.'月'}}考勤</h3>
            
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            <th class="text-center"><small>日期</small></th>
                            <th class="text-center"><small>出勤人数</small></th>
                            
                          
                        </tr>
                    </thead>
                  @php
                    $totalLessons = 0;$total =0;
                  @endphp
                    <tbody>
                        @foreach($dates as $whichday)
                        @if($schedule_students->where('schedule_id','=',$whichday->id)->sum('attended')>0)
                          @php
                            $totalLessons++;
                          @endphp
                        <tr>
                            <td class="text-center">{{$whichday->date}}</td>
                            <td class="text-center">
                                {{$schedule_students->where('schedule_id','=',$whichday->id)->sum('attended')}}
                                 @php
                                    $total =$total+$schedule_students->where('schedule_id','=',$whichday->id)->sum('attended');
                                 @endphp
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td class="text-center">课时合计：{{$totalLessons}}</td>
                            <td class="text-center">人次合计：{{$total}}</td>
                        </tr>
                    </tbody>
                </table>
                <p><a href="{{route('get_schedule_detail_by_month',['month'=>$month,'class_id'=>$class_id ])}}">本月明细</a></p>
            </div>      
       
    </div>
</div>
</div>
@endsection
