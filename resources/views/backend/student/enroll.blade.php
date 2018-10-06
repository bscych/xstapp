@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>
                    <a class="" href="{{ URL::to('student/' .$student->id) }}">{{$student->name}} </a>

                    可以报名的课程列表，当前账户余额：{{$student->balance}}</h2>
            </div>
            <div class="box-content">

                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>

                            <th>课程费用</th>
                            <th>课程类别</th>
                            <th>课程名称</th>
                            <th>班级</th>
                            <th>责任教师</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $model)
                        @foreach($classes->where('course_id',$model->course_id) as $class)
                        <tr>
                            @if ( ($loop->first) && ($classes->where('course_id',$model->course_id))->count()>1 )
                            <td rowspan="{{$classes->where('course_id',$model->course_id)->count()}}">{{$model->duration*$model->unit_price}}</td>
                            <td rowspan="{{$classes->where('course_id',$model->course_id)->count()}}">{{$model->courseCategoryName }}</td>
                            <td rowspan="{{$classes->where('course_id',$model->course_id)->count()}}">{{$model->name}}</td>
                            @elseif  ( $loop->first && ($classes->where('course_id',$model->course_id))->count()==1 )
                            <td >{{$model->duration*$model->unit_price}}</td>
                            <td >{{$model->courseCategoryName }}</td>
                            <td >{{$model->name}}</td>
                            @else

                            @endif
                            <td>{{$class->name}} </td>
                            <td>{{$class->teacher_id}}</td>
                            <td class="center">
                                @if( $student->balance - $model->duration*$model->unit_price>=0 )
                                <form role="form" method="POST" action="{{ url('/enroll') }}">

                                    @csrf
                                    <input  name="student_id" type="hidden" value="{{$student->id}}"/>
                                    <input  name="course_id" type="hidden" value="{{$model->course_id}}"/>
                                    <input  name="class_id" type="hidden" value="{{$class->classmodel_id}}"/>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>报名
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection