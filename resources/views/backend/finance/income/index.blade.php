@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 收入管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <!--a class="btn btn-primary btn-lg" href="{{ URL::to('/income/create') }}">新支出</a-->      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">编号</th>
                            <th>收入名称</th>
                            <th class="hidden-sm hidden-xs">缴费人</th>
                            <th class="hidden-sm hidden-xs">收入金额</th>
                            <th class="hidden-sm hidden-xs">收入方式</th>
                            <th class="hidden-sm hidden-xs">发生时间</th>
                            <th>备注</th>
                            <th class="hidden-sm hidden-xs">录入人</th>
                            <!--th>操作</th-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incomes as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->paid_by }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->amount}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->payment_method}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->created_at}}</td>
                             <td>{{ $model->comment}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->operator}}</td>
                           
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
                <div>{{ $incomes->links() }}</div>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
