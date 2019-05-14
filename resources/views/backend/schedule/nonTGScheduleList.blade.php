@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        
           
         
                <h3><i class="glyphicon glyphicon-th"></i>{{$course->name}}考勤列表, 一共{{$course->duration}}次课</h3>
            
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            <th class="text-center"><small>学生名字</small></th>
                            <th class="text-center"><small>出勤次数</small></th>
                            <th class="text-center"><small>还剩课时数</small></th>
                            <th class="text-center"><small>是否要催费</small></th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-center">{{$student->name}}</td>
                            <td class="text-center">
                                {{$student_schedules->where('student_id','=',$student->id)->sum('attended')}}
                            </td>
                            <td class="text-center">
                                {{($course->duration) - ($student_schedules->where('student_id','=',$student->id)->sum('attended'))}}
                            </td>
                            <td class="text-center">
                              @if( ($course->duration) - ($student_schedules->where('student_id','=',$student->id)->sum('attended')) <= 2 )
                             <span class="label label-danger">催费</span>
                              @else
                            <span class="label label-success">正常</span>
                              @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
               
            </div>      
       
    </div>
</div>
</div>
@endsection
