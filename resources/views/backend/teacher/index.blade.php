@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>老师管理</h2>
            </div>


            <div class="box-content">
                <div>
                    <a class="btn btn-primary btn-sm" href="{{ route('staff.create') }}">新增老师</a>
                </div>
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>姓名</th>
                            <th>基本工资</th>     
                            <th>入职日期</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>  
                                @if($model->deleted_at===null)
                                <a href="#" data-toggle="modal" data-target="#{{$model->id}}">{{ $model->name }}</a>  
                                @else
                                {{ $model->name }}
                                @endif
                            </td>
                            <td>{{ $model->salary }}</td>
                            <td>{{ $model->start_at}}</td>      
                         
                            <td class="center">                            
                                <form action="{{route('staff.destroy',['id'=>$model->id])}}" method="POST">
                                    @method('DELETE ')
                                    @csrf                                  
                                    <button class="btn btn-sm btn-danger" type="submit" >离职</button>
                                </form>
                                 <div class="modal fade in" id="{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: hidden;">
                                    <div class="modal-dialog">
                                        <form role="form" method="POST" action="{{ route('staff.update',['id'=>$model->id]) }}">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                    <h3>修改老师信息</h3>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group row">
                                                        <label class="col-md-6 control-label">基本工资 ： </label>
                                                        <input name="salary" value="{{ $model->salary}}" type="number" class="col-md-6 form-control">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-6 control-label">入职时间 ： </label>
                                                        <input name="start_at" value="{{ $model->start_at}}" type="date" class="col-md-6 form-control">
                                                    </div>                                                 

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>                  
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-btn fa-user"></i>保存
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                           

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
