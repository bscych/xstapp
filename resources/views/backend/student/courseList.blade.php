@extends('layouts.app_backend')

@section('content')


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{$student->name.'的课程列表'}}</h2>
            </div>
   
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
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
                                @if($course->course_category_id==12)
                                <a class="btn btn-primary" href="{{ URL::to('getKidsCourse/'.$student->id) }}">
                                    <i class="fa fa-btn fa-user"></i>考勤管理
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
