@extends('layouts.app_backup')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 编辑学生信息</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/student/'.$model->id) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label class="control-label">学号 ： </label>
                        <input type="text" class="form-control" name="code" value="{{ $model->code }}">   

                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">姓名 ： </label>
                        <input type="text" class="form-control" name="name" value="{{ $model->name }}">   

                    </div>

                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label class="control-label">联系电话 ： </label>
                        <input type="text" class="form-control" name="mobile" value="{{ $model->mobile }}">   

                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">电子邮件/家庭住址 ： </label>
                        <input type="text" class="form-control" name="email" value="{{ $model->email }}">
                    </div>

                    <div class="form-group{{ $errors->has('wechat') ? ' has-error' : '' }}">
                        <label class="control-label">微信 ： </label>
                        <input type="text" class="form-control" name="wechat" value="{{ $model->wechat }}">
                    </div>

                    <div class="form-group{{ $errors->has('qq') ? ' has-error' : '' }}">
                        <label class="control-label">QQ ： </label>
                        <input type="text" class="form-control" name="qq" value="{{ $model->qq }}">
                    </div>

                    <div class="form-group{{ $errors->has('primaryschool') ? ' has-error' : '' }}">
                        <label class="control-label">就读学校 ： </label>
                        <input type="text" class="form-control" name="primaryschool" value="{{ $model->primaryschool }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i>提交
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
