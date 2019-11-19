@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 课程列表</h2>
            </div>
           
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>课程名称</th>
                        <th>统计报表</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $model)
                    <tr>
                        <td class="">{{ $model->name }}</td>
                        <td> 
                            <a class="btn btn-primary" href="{{ route('getScheduleStatistics',['month'=>date('m'),'class_id'=>$model->id])}}">
                               考勤报表
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
