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
            </div>
            </form>
            @endif
        </div>


        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                <thead>
                    <tr>
                        <th>操作</th>
                        <th>班级名称</th>
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
                                <input type="text" class="form-control hidden" name="AGENT" value="WECHAT">  
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>考勤管理
                                </button>
                                @endif
                            </form>

                        </td>
                        <td>{{  $model->course_name."-".$model->name }}</td>
                        <td> 
                            @if($students->where('classmodel_id',$model->id)->count()>0)
                            <a class="btn btn-primary" href="{{ route('getScheduleStatistics',['month'=>date('m'),'class_id'=>$model->id,'AGENT'=>'WECHAT']) }}">
                                <i class="glyphicon glyphicon-edit icon-white"></i>
                                考勤报表
                            </a>
                            @endif
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
