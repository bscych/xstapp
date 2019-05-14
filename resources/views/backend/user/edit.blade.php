@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 编辑用户信息</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/user/'.$user->id) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">姓名 ： </label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">   

                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('角色') }}</label>

                        <div class="col-md-6">

                            <select id="role" class="form-control" name="role" required>
                                @foreach($roles as $role)
                              
                                <option value="{{$role->name}}" {{$user->role_id==$role->id?'selected':''}}>{{$role->name}}</option>
                              
                                @endforeach
                            </select>
                        </div>
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
