@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 菜谱管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/menu/create') }}">创建新菜谱</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>日期</th>

                            <th>上午间点</th>
                            <th>午餐</th>
                            <th>下午间点</th>
                            <th>晚餐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->which_day}}</td>
                            <td>
                                @foreach(collect(json_decode($menu->morning_snack,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->lunch,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->afternoon_snack,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{ $meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->dinner,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{ $meal}}<br>
                                @endforeach
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
