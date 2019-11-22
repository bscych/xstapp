@extends('layouts.wechat')

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
                </form>
            </div>

            @endif
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>操作</th>
                        <th class="hidden-sm hidden-xs">编号</th>
                        <th>课程名称</th>
                        <th class="hidden-sm hidden-xs">班级名称</th>
                        <th class="hidden-sm hidden-xs">责任教师</th>
                        <th class="hidden-sm hidden-xs">学生人数</th>
                        <th>统计报表</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $model)
                    <tr>
                        <td class="center">
                            <form role="form" method="GET" action="{{ url('/schedule')}}">
                                @csrf
                                @if($students->where('classmodel_id',$model->id)->count()>0)
                                <input type="text" class="form-control hidden" name="class_id" value="{{$model->id}}">  
                                <button type="submit" class="btn btn-primary">
                                  考勤管理
                                </button>
                                @endif
                            </form>
                        </td>
                        <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                        <td class="hidden-sm hidden-xs">{{ $model->course_name }}</td>
                        <td >{{ $model->course_name.$model->name }}</td>

                        <td class="hidden-sm hidden-xs">{{ $model->teacher_name }}</td>
                        <td class="hidden-sm hidden-xs">
                             @if($students->where('classmodel_id',$model->id)->count()>0)
                            <a class="" href="{{ route('getTCKStudentStatus',['month'=>date('m'),'class_id'=>$model->id])}}">
                               {{ $students->where('classmodel_id',$model->id)->count()}}
                            </a>
                             @else
                             {{ $students->where('classmodel_id',$model->id)->count()}}
                            @endif
                            </td>
                            <td> <form method="POST" action="{{route('class.destroy',['id'=>$model->id])}}">
                                  
                            @if($students->where('classmodel_id',$model->id)->count()>0)
                            <a class="btn btn-primary btn-sm" href="{{ route('getScheduleStatistics',['month'=>date('m'),'class_id'=>$model->id])}}">
                               考勤报表
                            </a>
                            @endif
                            @hasanyrole('admin|superAdmin')
                            <a class="btn btn-primary btn-sm" href="{{route('class.edit',[$model->id])}}">编辑</a>
                            @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">注销</button>
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
