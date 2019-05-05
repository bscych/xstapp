@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 本周菜谱</h2>
              
            </div>
         
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>日期</th>

                            <!--th>上午间点</th-->
                            <th>午餐</th>
                            <!--th>下午间点</th-->
                            <th>晚餐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                       @if($menu!=null)
                        <tr>
                            <td>{{ $menu->which_day}}</td>
                            @if(false)
                            <td>
                                @foreach($menu->morning_snack as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            @endif
                            <td>
                                @foreach($menu->lunch as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            @if(false)
                            <td>
                                @foreach($menu->afternoon_snack as $meal)
                                {{ $meal}}<br>
                                @endforeach
                            </td>
                            @endif
                            <td>
                                @foreach($menu->dinner as $meal)
                                {{ $meal}}<br>
                                @endforeach
                            </td>
                          
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
