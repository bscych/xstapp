@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{$student->name.'的课程列表'}}</h2>
            </div>

            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{$course->name}} </td>

                            <td class="center">
                                <a class="btn btn-primary" href="{{ route('schedule.index',['class_id'=>$course->classmodel_id,'student_id'=>$student->id,'AGENT'=>'WECHAT'])}}">
                                    <i class="fa fa-btn fa-user"></i>订餐
                                </a>
                            </td>
                            
                            <td class="center">
                                <a class="btn btn-primary" href="{{ route('schedule.index',['class_id'=>$course->classmodel_id,'student_id'=>$student->id,'AGENT'=>'WECHAT'])}}">
                                    <i class="fa fa-btn fa-user"></i>订餐记录
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


@endsection
