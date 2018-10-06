@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 班级管理</h2>
            </div>
            <div class="box-content">
                @if($course_id!=null)
                <form role="form" method="GET" action="{{ url('/class/create')}}">
                    @csrf
                    <input type="text" class="form-control hidden" name="course_id" value="{{$course_id}}">   
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>创建新班级
                    </button>
            </div>
            </form>
            @endif
        </div>


        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>课程名称</th>
                        <th>班级名称</th>
                        <th>所在教室</th>
                        <th>责任教师</th>
                        <th>学生人数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $model)
                    <tr>
                        <td>{{$model->id}} </td>
                        <td>{{ $model->course_name }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->classroom_name }}</td>
                        <td>{{ $model->teacher_name }}</td>
                        <td>{{ $students->where('classmodel_id',$model->id)->count()}}</td>
                        <td class="center">
                            
                          
                            <form role="form" method="GET" action="{{ url('/schedule')}}">
                                <!--a class="btn btn-primary" href="{{ URL::to('class/' . $model->id . '/edit') }}">
                                <i class="glyphicon glyphicon-edit icon-white"></i>
                                编辑
                            </a-->
                                @csrf
                                @if($students->where('classmodel_id',$model->id)->count()>0)
                                <input type="text" class="form-control hidden" name="class_id" value="{{$model->id}}">  
                                   <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>考勤管理
                                </button>
                                @endif
                                <!--a class="btn btn-danger" href="{{ URL::to('class/' . $model->id) }}">
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                删除
                            </a-->
                            </form>
                            
                           
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
