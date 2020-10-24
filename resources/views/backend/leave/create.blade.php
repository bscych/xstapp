@extends('layouts.wechat')

@section('content')
<form role="form" method="POST" action="{{ route('leave.store') }}"> 
    @csrf
    <div class="row">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
            <label class="control-label">开始日期(必填项) ： </label>
            <input type="date" class="form-control" name="from" >   

        </div>
        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-3">
            <label class="control-label">结束日期(非必填，请一天假可不填) ： </label>
            <input type="date" class="form-control" name="to" >   
        </div>

        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('birthday') ? ' has-error' : '' }} col-md-3">
            <label class="control-label">备注 ： </label>
            <input type="text" class="form-control" name="comment" placeholder="备注"></input>
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
<script>

</script>
@endsection
