@extends('layouts.app_backend')

@section('content')

<div class="row">
    
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>收入</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                   
                  <div class="col-md-3"><h6><a href="">总收入：{{$totalIncomes}}</a></h6></div>
                  <div class="col-md-3"><h6><a href="">已扣费用:{{$totalEnroll}}</a></h6></div>
                  <div class="col-md-3"><h6><a href="">未扣费用：{{$totalRemain}}</a></h6></div>
                  </div>

            </div>
        </div>
    </div>
    
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>支出</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                   @foreach($spends as $spend)
                    <div class="col-md-3"><h6><a href="">  </a>
                        <a href="{{ URL::to('detail/' .$parameters.'/'.$spend[2]) }}">{{$spend[0].':'.$spend[1]}}</a>
                        </h6></div>
                 @endforeach
                 <div class="col-md-12"><h6><a href="">  </a>
                        <a href="#">总计：{{$totalSpends->sum('amount')}}</a>
                        </h6></div>
                </div>

            </div>
        </div>
    </div>
        
        <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>营收</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                   
                    <div class="col-md-1"><h6><a href="">月</a></h6></div>
                 
                </div>

            </div>
        </div>
    </div>
    
</div>

@endsection
