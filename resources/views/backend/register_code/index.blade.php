@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 注册码查询</h2>
            </div>
            <div class="box-content">
                <form role="form" method="GET" action="{{route('code.index') }}">

                    @csrf
                    <div class="row">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                            <label class="control-label">姓名 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">   

                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i>查询
                        </button>
                    </div>
                </form>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>学号</th>
                            <th>姓名</th>
                            <th>注册码</th>
                            <th>注册状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($codes as $model)
                        <tr>
                            <td>{{ $model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->code }}</td>
                            <td>注册码{{$model->deleted_at==null?'未使用':'已经在'.$model->deleted_at.'日被'.$model->relationship.'使用了' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
