@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 查询</h2>
            </div>
            <div class="box-content">
                <form role="form" method="GET" action="{{route('visitor.index') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group inline {{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                            <label class="control-label">姓名 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">  
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class=" btn btn-primary inline">
                                查询
                            </button>
                            <a class="btn btn-primary" href="{{ route('visitor.create') }}">新增</a>     
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">#</th>
                            <th>姓名</th>
                            <th class="hidden-sm hidden-xs">性别</th>
                            <th class="hidden-sm hidden-xs">生日</th>
                            <th class="hidden-sm hidden-xs">父母</th>
                            <th class="hidden-sm hidden-xs">联系电话</th>
                            <th class="hidden-sm hidden-xs">关心课程</th>
                            <th class="hidden-sm hidden-xs">联系历史</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}}</td>
                            <td><a >{{ $model->name }}</a></td>
                            <td class="hidden-sm hidden-xs">{{ $model->gender }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->birthday }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->parent_name}}</td>
                             <td class="hidden-sm hidden-xs">{{ $model->phone}}</td>
                             <td class="hidden-sm hidden-xs">{{ $model->interests}}</td>
                              <td class="hidden-sm hidden-xs">
                                  <ol>
                                  @foreach(collect(json_decode($model->contact_history,JSON_UNESCAPED_UNICODE)) as $history)                                  
                                  <li>{{ $history}}</li>
                                  @endforeach
                                  </ol>
                              </td>
                            <td class="center">
                                <form action="{{ route('visitor.destroy',$model->id)}}" method="post">
                                    <a class="btn btn-primary btn-setting" href="" onclick="$('#visitor_id').val({{$model->id}})">
                                        增加联系记录
                                    </a>
                                  
                                    <a class="btn btn-primary" href="{{ route('visitor.convertToStudent',['visitor_id'=>$model->id]) }}">
                                        转化为学生
                                    </a> 
                                </form>
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

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" st    yle="display: hidden;">
    <div class="modal-dialog">
        <form role="form" method="POST" action="{{ route('visitor.addContactHistory') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>到访记录</h3>
                </div>

                <div class="modal-body">
                    <p>                           
                            <input type="hidden" id='visitor_id' name='visitor_id' value="">
                            <div class="">
                                <label class="control-label">到访记录 ： </label>
                                <textarea  id='contact_history' name='contact_history' value="" ></textarea>
                                <label class="control-label">沟通日期（默认不填，为今天） ： </label>
                                <input type="date" id='date' name='date' value="" >
                            </div>
                    </p>
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