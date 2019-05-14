@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 菜品管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/menuItem/create') }}">创建新菜品</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>菜品名称</th>
                            
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menuItems as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                          
                           

                            <td class="center">
                                <a class="btn btn-info" href="{{ URL::to('menuItem/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑
                                </a>
                               
                            
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
