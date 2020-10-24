@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="data-original-title">
                <h2><i class=""></i>编辑课程信息</h2>
            </div>
            <div class="box-content">

               
                <form role="form" method="POST" action="{{ route('class.store') }}">
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
                                    
                                     <div class="form-group  col-md-2">
                                        <label class="control-label">开始日期 ：{{$course->start_date}} </label>
                                     </div>

                                     <div class="form-group  col-md-2">
                                        <label class="control-label">结束日期 ：{{$course->end_date}} </label>
                                     </div>                              
                                </div>
                                 <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                                        <label class="control-label">班级名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" >   

                                    </div>
                                   
                            
                                    <div class="form-group  col-md-4">
                                        <label class="control-label">授课老师 ： </label>
                                        <select class="form-control " name="teacher_id" >
                                            @foreach($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                 <div class="row">
                                    <div class="form-group  col-md-12" >
                                        <label class="control-label">每周上课频率（每天托管不需要选择哪天，如果选择哪天了，只是当天能打卡，订餐）：</label>
                                        @for($i=0;$i<7;$i++)
                                        <label class="checkbox-inline"><input type="checkbox" name="{{$i}}">周{{$i===0?'日':$i}}</label>
                                        @endfor
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