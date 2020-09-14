@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" >
                <h2> 账务总览 </h2>
                 <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-4"><h6><a href="#">总支出：{{$totalSpend}}</a></h6></div>
                    <div class="col-md-4"><h6><a href="#">总收入：{{$totalIncome}}</a></h6></div>                   
                    <div class="col-md-4"><h6><a href="#">差：{{$totalIncome-$totalSpend}}</a></h6></div>
                </div>

            </div>
        </div>
    </div>
 <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" >
                <h2> 2019年 </h2>
                 <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @for($j=11;$j<=12;$j++)
                    <div class="col-md-1"><h6><a href="{{ URL::to('detail/2019/'.$j) }}">{{$j}}月</a></h6></div>
                    @endfor
                </div>

            </div>
        </div>
    </div>

    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" >
                <h2> {{Carbon\Carbon::now()->year}}年 </h2>
                 <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @for($j=1;$j<=now()->month;$j++)
                    <div class="col-md-1"><h6><a href="{{ URL::to('detail/' .Carbon\Carbon::now()->year.'/'.$j) }}">{{$j}}月</a></h6></div>
                    @endfor
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
