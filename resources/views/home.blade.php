@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            @hasanyrole('admin|superAdmin|cook')
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{date('Y-m-d',time())}}用餐报表</h2>
            </div>

            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>班级名称</th>
                            <th>午餐</th>
                            <th>晚餐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                        <tr>
                            <td>{{$course->name}} </td>
                            <td>{{ $schedule_students->where('course_id',$course->id)->sum('lunch') }}</td>
                            <td>{{ $schedule_students->where('course_id',$course->id)->sum('dinner')}}</td>
                        </tr>
                        @endforeach
                        <tr><td>总计</td><td>{{ $schedule_students->sum('lunch') }}</td><td>{{ $schedule_students->sum('dinner') }}</td></tr>
                    </tbody>
                </table>
            </div>
            @endhasanyrole
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


@endsection
