@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 课管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/course/create') }}">创建新课</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>课程名称</th>
                            <th>课程类别</th>
                          
                            <th>课程总时长</th>
                           
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->courseCategoryName }}</td>
                          
                            <td>{{ $model->duration }}</td>
                           

                            <td class="center">
                                <!--a class="btn btn-info" href="{{ URL::to('course/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑
                                </a>
                                <a class="btn btn-danger" href="{{ URL::to('course/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a-->
                               
                                <form role="form" method="GET" action="{{ url('/class')}}">
                                    @csrf
                                     <a class="btn btn-primary" href="{{ URL::to('getStudentList/' . $model->id ) }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    学生列表
                                    </a>
                                    
                                    <input type="text" class="form-control hidden" name="course_id" value="{{ $model->id}}">   
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>班级管理
                                    </button>
                                    </div>
                                </form>
                                  <form action="{{ route('course.destroy',$model->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">结课</button>
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
