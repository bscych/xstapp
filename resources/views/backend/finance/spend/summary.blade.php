@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 支出管理</h2>
            </div>
            <div class="box-content">
                <!--p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/spend/create') }}">新支出</a>      
                </p-->
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>总支出</th>
                            <th>支出名称</th>
                            <th>支出科目</th>
                            <th>支出金额</th>
                            <th>支出方式</th>
                            <th>发生时间</th>
                            <th>录入人</th>
                            <th>录入时间</th>
                            <!--th>操作</th-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->name_of_account }}</td>
                            <td>{{ $model->amount}}</td>
                            <td>{{ $model->payment_method}}</td>
                            <td>{{ $model->which_day}}</td>
                            <td>{{ $model->operator}}</td>
                            <td>{{ $model->created_at}}</td>
                            <!--td class="center">
                                <a class="btn btn-info" href="{{ URL::to('spend/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑键名称
                                </a>
                                <a class="btn btn-info" href="{{ URL::to('constantValue/?constant_name_id=' . $model->id) }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    显示该键名称的对应值
                                </a>
                                <!--a class="btn btn-danger" href="{{ URL::to('constantCategory/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a-->
                            </td-->

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>{{ $models->links() }}</div>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
