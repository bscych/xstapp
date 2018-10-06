@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="black"></i> 创建新数据字典键</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/constantName') }}">

                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('constant_name') ? ' has-error' : '' }}">
                        <label class="control-label">数据字典名称 ： </label>
                        <input type="text" class="form-control input-lg" name="constant_name" value="{{ old('constant_name') }}">   

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
