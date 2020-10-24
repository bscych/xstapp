@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 今天的留言</h2>
            </div>     


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>留言时间</th>
                            <th>留言人</th>
                            <th>留言对象</th>
                            <th>留言内容</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notes as $model)
                        <tr>
                            <td>{{ $model->created_at}} </td>
                            <td>{{ $model->name.$model->relationship }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->note }}</td>       
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
