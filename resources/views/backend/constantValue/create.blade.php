@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i> 创建新数据字典值</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/constantValue') }}">

                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('constant_value') ? ' has-error' : '' }}">
                        <label class="control-label">数据字典名称 ： </label>
                        <input type="text" class="form-control" name="constant_value" value="{{ old('constant_value') }}">   
                        <input type="hidden" class="form-control" name="constant_name_id" value="{{ $constant_name_id }}">  
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
