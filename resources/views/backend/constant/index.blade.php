@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 数据字典值管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary" href="{{ URL::to('/constant/create?id='.$id) }}">创建新数据字典值</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>数据字典键名称</th>
                         
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($constants as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{$model->name}}</td>
                           
                              <td class="center">
                                <!--a class="btn btn-info" href="{{ URL::to('constantName/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑键名称
                                </a-->
                                @if ($model->parent_id==null)
                                <a class="btn btn-info" href="{{ URL::to('constant/?id=' . $model->id) }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    显示该键名称的对应值
                                </a>
                                @endif
                                <!--a class="btn btn-danger" href="{{ URL::to('constantCategory/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a-->
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
