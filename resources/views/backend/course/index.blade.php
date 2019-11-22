@extends('layouts.wechat')

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
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">编号</th>
                            <th>课程名称</th>
                            <th class="hidden-sm hidden-xs">课程类别</th>

                            <th class="hidden-sm hidden-xs">课程总时长</th>

                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td class="hidden-sm hidden-xs"> {{ $model->courseCategoryName }}</td>

                            <td class="hidden-sm hidden-xs">{{ $model->duration }}</td>


                            <td class="center">
                                <form action="{{ route('course.destroy',$model->id)}}" method="post">
                                    <a class="btn btn-primary" href="{{route('course.edit',['id'=>$model->id]) }}"> 编辑</a>
                                    <a class="btn btn-primary" href="{{ URL::to('getStudentList/' . $model->id ) }}">学生列表 </a>
                                    <a class="btn btn-primary" href="{{ route('class.index', ['course_id'=>$model->id])}}"> 班级管理</a>
                                    @hasanyrole('admin|superAdmin')
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">结课</button>
                                    @endhasanyrole
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
