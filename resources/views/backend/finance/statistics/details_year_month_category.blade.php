@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 详细信息</h2>
            </div>
            <div class="box-content">
                <p>
                   总计：{{$spends->sum('amount')}}
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr> <th>序号</th>
                            <th>编号</th>
                            <th>名称</th>
                            <th>科目</th>
                            <th>金额</th>
                            <th>发生时间</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($spends as $model)
                        <tr>
                            <td>{{$loop->index+1}} </td>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->name_of_account }}</td>
                            <td>{{ $model->amount}}</td>
                            <td>{{ $model->which_day}}</td>
                            </td-->

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
