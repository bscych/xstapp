@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>编辑课程信息</h2>
            </div>
            <div class="box-content">


                <form role="form" method="POST" action="{{ route('course.update',['id'=>$model->id]) }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="box-content">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                                        <label class="control-label">课程名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ $model->name }}">   

                                    </div>
                                    <div class="form-group{{ $errors->has('courseCategory_id') ? ' has-error' : '' }}  col-md-3">
                                        <label class="control-label">课程类别 ： </label>
                                        <select class="form-control" name="course_category_id" id="courseCategory_id">
                                            @foreach($courseCategories as $courseCategory)
                                            <option value="{{$courseCategory->id}}" {{$courseCategory->id==$model->course_category_id?'selected':''}}>{{$courseCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}  col-md-3">
                                        <label class="control-label">总时长 ： </label>
                                        <input id="duration" type="" class="form-control" name="duration" value="{{ $model->duration }}" placeholder="0">   

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
                                        <input type="number" id="unit_price" class="form-control" name="unit_price" value="{{ $model->unit_price }}" placeholder="0">   

                                    </div>

                                    <div class="form-group{{ $errors->has('snack_fee') ? ' has-error' : ''}}  col-md-3">
                                        <label class="control-label">间点费 ： </label>
                                        <input type="text" id="unit_price" class="form-control" name="snack_fee" value="{{ $model->snack_fee }}" placeholder="0">   

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group  col-md-4">
                                        <label class="control-label">授课老师 ： </label>
                                        <select class="form-control" name="teacher_id" >
                                            @foreach($teachers as $teacher)
                                            <option value="{{$teacher->id}}" {{$model->teacher_id==$teacher->id?'selected':''}}>{{$teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group  col-md-3">
                                        <label class="control-label">开始日期 ： </label>
                                        <input type="date" id="startDate" class="form-control" name="start_date" value="{{ $model->start_date}}">   
                                    </div>

                                    <div class="form-group  col-md-3">
                                        <label class="control-label">结束日期 ： </label>
                                        <input type="date" id="endDate" class="form-control" name="end_date" value="{{$model->end_date }}">   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group  col-md-3">
                                        <label class="control-label">是否提供午餐 ： </label>
                                        <select name="has_lunch" class="form-control">
                                            <option value="1" {{$model->has_lunch==1?'selected':''}}>是</option>
                                            <option value="0" {{$model->has_lunch==0?'selected':''}}>否</option>
                                        </select>   
                                    </div>

                                    <div class="form-group  col-md-3">
                                        <label class="control-label">是否提供晚餐 ： </label>
                                        <select name="has_dinner" class="form-control">
                                            <option value="1" {{$model->has_dinner==1?'selected':''}}>是</option>
                                            <option value="0" {{$model->has_dinner==0?'selected':''}}>否</option>
                                        </select>     
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label class="control-label">是否纳入用餐统计报表 ： </label>
                                        <select name="in_count" class="form-control">
                                            <option value="1" {{$model->in_count==1?'selected':''}}>是</option>
                                            <option value="0" {{$model->in_count==0?'selected':''}}>否</option>
                                        </select>  
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
