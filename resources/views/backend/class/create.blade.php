@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>创建课程信息</h2>
            </div>
            <div class="box-content">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#info">课程基本信息</a></li>
                </ul>
                <form role="form" method="POST" action="{{ url('/class') }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="box-content">

                                @csrf
                                <div class="row">
                                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                                        <label class="control-label ">课程名称 ：{{$course->name}}</label>
                                         <input type="text" class="form-control hidden" name="course_id" value="{{$course->id }}" >   
                                    </div>
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                                        <label class="control-label ">课程类别 ：{{$courseCategories->firstWhere('id',$course->course_category_id)->name}}</label>
                                    </div>
                                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                                        <label class="control-label ">课程类别 ：{{$courseCategories->firstWhere('id',$course->course_category_id)->name}}</label>
                                    </div>
                                    
                                     <div class="form-group  col-md-2">
                                        <label class="control-label">开始日期 ：{{$course->start_date}} </label>
                                     </div>

                                     <div class="form-group  col-md-2">
                                        <label class="control-label">结束日期 ：{{$course->end_date}} </label>
                                    </div>
                                </div>
                               @if($course->which_day_1!=null)
                               <div class="row">
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">每周 ：{{$course->which_day_1}} </label>
                                    </div>
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">开始时间 ：{{$course->block1_start_time}}</label>
                                       
                                    </div>
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">结束时间 ：{{$course->block1_end_time}} </label>
                                    </div>

                                </div>
                               @endif
                                 @if($course->which_day_2!=null)
                                 <div class="row">
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">每周 ：{{$course->which_day_2}} </label>
                                    </div>
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">开始时间 ：{{$course->block2_start_time}}</label>
                                       
                                    </div>
                                    <div class="form-group  col-md-3 " id="time_block">
                                        <label class="control-label">结束时间 ：{{$course->block2_end_time}} </label>
                                    </div>

                                </div>
                               @endif 
                                <div class="row">    
                                    
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                                        <label class="control-label">班级名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" >   

                                    </div>
                                   
                            
                                    <div class="form-group  col-md-4">
                                        <label class="control-label">授课老师 ： </label>
                                        <select class="form-control" name="teacher_id" >
                                            @foreach($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group  col-md-4">
                                        <label class="control-label">所用教室 ： </label>
                                        <select class="form-control" name="classroom_id" >
                                            @foreach($classrooms as $classroom)
                                            <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                   
                                </div>

                                <div class="row">
                                    <div class="form-group  col-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i>提交
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--/span-->

</div><!--/row-->

@endsection