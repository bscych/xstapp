@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>账务总览</h2>
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
    
    @for($i=2018;$i<=date_format(date_create(),"Y");$i++)
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>{{$i}}年</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @for($j=1;$j<=12;$j++)
                    <div class="col-md-1"><h6><a href="{{ URL::to('detail/' .$i.'/'.$j) }}">{{$j}}月</a></h6></div>
                   @endfor
                </div>

            </div>
        </div>
    </div>
    @endfor
</div>

@endsection
