@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i> 新增</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/visitor') }}">

                    @csrf
                    <div class="row">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">姓名（必填项） ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{$errors->first('name')}}">   

                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">性别 ： </label>
                            <select class="form-control" name="gender" >
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </div>

                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('birthday') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">生日 ： </label>
                            <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}"></input>

                        </div>  
                        <div class="form-group{{ $errors->has('parent_name') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">父母： </label>
                            <input type="text" class="form-control" name="parent_name" value="{{ old('parent_name') }}">   
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">联系电话（必填项） ： </label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">   
                        </div>

                        <div class="form-group{{ $errors->has('interests') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">关注课程 ： </label>
                            <input type="text" class="form-control" name="interests" value="{{ old('interests') }}">   
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>提交
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection