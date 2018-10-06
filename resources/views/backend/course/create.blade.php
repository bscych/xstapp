@extends('layouts.app_backend')

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
                <form role="form" method="POST" action="{{ url('/course') }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="box-content">

                                @csrf
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                                        <label class="control-label">课程名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">   

                                    </div>
                                    <div class="form-group{{ $errors->has('courseCategory_id') ? ' has-error' : '' }}  col-md-3">
                                        <label class="control-label">课程类别 ： </label>
                                        <select class="form-control" name="courseCategory_id" id="courseCategory_id">
                                            @foreach($courseCategories as $courseCategory)
                                            <option value="{{$courseCategory->id}}">{{$courseCategory->constant_value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}  col-md-3">
                                        <label class="control-label">总时长 ： </label>
                                        <input id="duration" type="" class="form-control" name="duration" value="{{ old('duration') }}" placeholder="0">   

                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}  col-md-3">
                                        <label class="control-label">单位 ： </label>
                                        <select class="form-control" name="unit">
                                            <option value="月">月</option>
                                            <option value="课时">课时</option>
                                        </select>

                                    </div>
                                    <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : ''}}  col-md-3">
                                        <label class="control-label">课程单价 ： </label>
                                        <input type="number" id="unit_price" class="form-control" name="unit_price" value="{{ old('unit_price') }}" placeholder="0">   

                                    </div>
                                    <div class="form-group{{ $errors->has('unit_price') ? ' has-error' : ''}}  col-md-3">
                                        <label class="control-label">总价格 ： </label>
                                        <label id="total_price" class="control-label"></label>   

                                    </div>

                                </div>

                                <div class="row">

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
                                    <div class="form-group  col-md-3">
                                        <label class="control-label">开始日期 ： </label>
                                        <input type="date" id="startDate" class="form-control" name="startDate" value="{{ old('startDate') }}">   
                                    </div>

                                     <div class="form-group  col-md-3">
                                        <label class="control-label">结束日期 ： </label>
                                        <input type="date" id="endDate" class="form-control" name="endDate" value="{{ old('endDate') }}">   
                                    </div>
                                </div>
                                <div class="row tg">
                                    <div class="form-group  col-md-3" >
                                        <label class="control-label">重复规律 ： </label>
                                        <select class="form-control" name="frequence"id="frequence">
                                            <option value="1">每周1次</option>
                                            <option value="2">每周2次</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row tg">
                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">每周 ： </label>
                                        <select class="form-control" name="whichDay1"id="whichDay1">
                                            <option value="1">周一</option>
                                            <option value="2">周二</option>
                                            <option value="3">周三</option>
                                            <option value="4">周四</option>
                                            <option value="5">周五</option>
                                            <option value="6">周六</option>
                                            <option value="0">周日</option>
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">开始时间 ： </label>
                                        <input type="time" id="start1" class="form-control col-md-2" name="start1" value="{{ old('start1') }}"> 
                                    </div>
                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">结束时间 ： </label>
                                        <input type="time" id="end1" class="form-control col-md-2" name="end1" value="{{ old('end1') }}"> 
                                    </div>

                                </div>

                                <div class="row tg tb2">
                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">每周 ： </label>
                                        <select class="form-control" name="whichDay2"id="whichDay2">
                                            <option value="1">周一</option>
                                            <option value="2">周二</option>
                                            <option value="3">周三</option>
                                            <option value="4">周四</option>
                                            <option value="5">周五</option>
                                            <option value="6">周六</option>
                                            <option value="0">周日</option>
                                        </select>
                                    </div>

                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">开始时间 ： </label>
                                        <input type="time" id="start2" class="form-control col-md-2" name="start2" value="{{ old('start2') }}"> 
                                    </div>
                                    <div class="form-group  col-md-2 " id="time_block">
                                        <label class="control-label">结束时间 ： </label>
                                        <input type="time" id="end2" class="form-control col-md-2" name="end2" value="{{ old('end2') }}"> 
                                    </div>

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
