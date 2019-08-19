@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 支出管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/spend/create') }}">新支出</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">编号</th>
                            <th>支出名称</th>
                            <th class="hidden-sm hidden-xs">支出科目</th>
                            <th>支出金额</th>
                        
                            <th class="hidden-sm hidden-xs">发生时间</th>
                            <th>备注</th>
                            <th class="hidden-sm hidden-xs">录入人</th>
                            <th class="hidden-sm hidden-xs"> 录入时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->name_of_account }}</td>
                            <td>{{ $model->amount}}</td>
                        
                            <td class="hidden-sm hidden-xs">{{ $model->which_day}}</td>
                            <td>{{ $model->comment}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->operator}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->created_at}}</td>
                           

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
