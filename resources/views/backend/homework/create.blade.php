@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>创建作业</h2>
            </div>
            <div class="box-content">


                <form role="form" method="POST" action="{{ url('/homework') }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="box-content">
                                @csrf

                                <div class="row">

                                    <div class="form-group{{ $errors->has('school_name') ? ' has-error' : '' }}  col-md-4">
                                        <label class="control-label"> 学校</label>
                                        <select class="form-control" name="school_name">
                                            @foreach($schools as $school)
                                            <option value="{{$school->name}}">{{$school->name}}</option>                                          
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group{{ $errors->has('grade') ? ' has-error' : '' }}  col-md-4">
                                        <label class="control-label"> 年级</label>
                                        <select class="form-control" name="grade">
                                            @for ($i = 0; $i < 9; $i++)
                                            <option value="{{$i+1}}">{{$i+1}}</option> 
                                            @endfor                                         
                                        </select>    

                                    </div>
                                    <div  class="form-group{{ $errors->has('class') ? ' has-error' : '' }}  col-md-4">
                                        <label class="control-label"> 班级</label>
                                        <select class="form-control" name="class">
                                            @for ($i = 0; $i < 9; $i++)
                                            <option value="{{$i+1}}">{{$i+1}}</option> 
                                            @endfor                                         
                                        </select>   

                                    </div>
                                </div>
                                <div class="row panel-body">

                                    <div class="form-group{{ $errors->has('chinese') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">语文作业 1 ： </label>
                                        <input type="text" class="form-control" name="c_1" value="{{ old('name') }}">  
                                        <label class="control-label">语文作业 2 ： </label>
                                        <input type="text" class="form-control" name="c_2" value="{{ old('name') }}">
                                        <label class="control-label">语文作业 3 ： </label>
                                        <input type="text" class="form-control" name="c_3" value="{{ old('name') }}">
                                        <label class="control-label">语文作业 4 ： </label>
                                        <input type="text" class="form-control" name="c_4" value="{{ old('name') }}">
                                        <label class="control-label">语文作业 5 ： </label>
                                        <input type="text" class="form-control" name="c_5" value="{{ old('name') }}">
                                    </div>

                                    <div class="form-group{{ $errors->has('math') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">数学作业 1 ： </label>
                                        <input type="text" class="form-control" name="m_1" value="{{ old('name') }}">  
                                        <label class="control-label">数学作业 2 ： </label>
                                        <input type="text" class="form-control" name="n_2" value="{{ old('name') }}">
                                        <label class="control-label">数学作业 3 ： </label>
                                        <input type="text" class="form-control" name="m_3" value="{{ old('name') }}">
                                        <label class="control-label">数学作业 4 ： </label>
                                        <input type="text" class="form-control" name="m_4" value="{{ old('name') }}">
                                        <label class="control-label">数学作业 5 ： </label>
                                        <input type="text" class="form-control" name="m_5" value="{{ old('name') }}">
                                    </div>

                                </div>

                                <div class="row panel-body">
                                    <div class="form-group{{ $errors->has('english') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">英语作业 1 ： </label>
                                        <input type="text" class="form-control" name="e_1" value="{{ old('name') }}">  
                                        <label class="control-label">英语作业 2 ： </label>
                                        <input type="text" class="form-control" name="e_2" value="{{ old('name') }}">
                                        <label class="control-label">英语作业 3 ： </label>
                                        <input type="text" class="form-control" name="e_3" value="{{ old('name') }}">
                                        <label class="control-label">英语作业 4 ： </label>
                                        <input type="text" class="form-control" name="e_4" value="{{ old('name') }}">
                                        <label class="control-label">英语作业 5 ： </label>
                                        <input type="text" class="form-control" name="e_5" value="{{ old('name') }}">
                                    </div>

                                    <div class="form-group{{ $errors->has('other') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">托管附加 1 ： </label>
                                        <input type="text" class="form-control" name="o_1" value="{{ old('name') }}">  
                                        <label class="control-label">托管附加 2 ： </label>
                                        <input type="text" class="form-control" name="o_2" value="{{ old('name') }}">
                                        <label class="control-label">托管附加 3 ： </label>
                                        <input type="text" class="form-control" name="o_3" value="{{ old('name') }}">
                                        <label class="control-label">托管附加 4 ： </label>
                                        <input type="text" class="form-control" name="o_4" value="{{ old('name') }}">
                                        <label class="control-label">托管附加 5 ： </label>
                                        <input type="text" class="form-control" name="o_5" value="{{ old('name') }}">
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
