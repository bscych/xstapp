@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i> 创建新特殊日期</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/holiday') }}">

                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">日期名称 ： </label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">   

                    </div>

                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label class="control-label">日期类型 ： </label>
                        
                         <select class="form-control" name="type" >
                                <option value="0">假期</option>
                                <option value="1">工作日</option>
                            </select>

                    </div>
                    <div class="form-group{{ $errors->has('which_day') ? ' has-error' : '' }}">
                        <label class="control-label">日期 ： </label>
                        <input type="date" class="form-control" name="which_day" value="{{ old('which_day') }}">   

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
