@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 角色管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary" href="{{ URL::to('/role/create') }}">创建新角色</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>角色名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{$role->id}} </td>
                            <td>{{$role->name}}</td>
                           
                              <td class="center">
                                  <a href="{{route('role.show',['id'=>$role->id])}}" class="btn btn-info">赋权</a>
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
