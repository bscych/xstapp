@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="data-original-title">
                <h2><i class=""></i>编辑课程信息</h2>
            </div>
            <div class="box-content">

               
                <form role="form" method="POST" action="{{ route('class.update',['id'=>$class->class_id]) }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active">
                            <div class="box-content">

                                @method('PUT')
                     @csrf
                                <div class="row">
                                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                                        <label class="control-label ">课程名称 ：{{$class->course_name}}</label>
                                         <input type="text" class="form-control hidden" name="course_id" value="{{$class->class_id }}" >   
                                    </div>
                                  
                                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                                        <label class="control-label ">课程类别 ：{{$class->name}}</label>
                                    </div>
                                    
                                     <div class="form-group  col-md-2">
                                        <label class="control-label">开始日期 ：{{$class->start_date}} </label>
                                     </div>

                                     <div class="form-group  col-md-2">
                                        <label class="control-label">结束日期 ：{{$class->end_date}} </label>
                                     </div>                              
                                </div>
                                 <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                                        <label class="control-label">班级名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ $class->class_name }}" >   

                                    </div>
                                   
                            
                                    <div class="form-group  col-md-4">
                                        <label class="control-label">授课老师 ： </label>
                                        <select class="form-control " name="teacher_id" >
                                            @foreach($teachers as $teacher)
                                            @if($class->teacher_id===$teacher->id)
                                            <option selected="selected" value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @else
                                             <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                 <div class="row">
                                    <div class="form-group  col-md-12" >
                                        <label class="control-label">每周上课频率：</label>
                                       @for($i=0;$i<7;$i++)
                                        <label class="checkbox-inline"><input type="checkbox"  name="{{$i}}" {{$class->which_day_1->contains($i)?'checked':''}} > 周{{$i==0?'日':$i}}</label>
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