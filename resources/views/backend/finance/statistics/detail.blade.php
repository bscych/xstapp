@extends('layouts.wechat')

@section('content')

<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>总览</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
               <div class="row">

                     
                 <div class="col-md-4"><h6><a href="">  </a>
                        <a href="#">收入总计：{{$totalIncomes}}</a>
                        </h6>

                </div>
                <div class="col-md-4"><h6><a href="">  </a>
                        <a href="#">收入支出：{{$totalSpends->sum('amount')}}</a>
                        </h6>

                </div>

                <div class="col-md-4">
                    <h6><a href="">  </a>
                        <a href="#">差：{{$totalIncomes-$totalSpends->sum('amount')}}</a>
                        </h6>
                </div>



            </div>
        </div>
    </div>


    
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2> 收入 </h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
               <div class="row">
                   
                     @foreach($incomes as $income)
                    <div class="col-md-3"><h6><a href="">  </a>
                        <a href="{{ URL::to('detail/' .$parameters.'/incomes/'.$income[2]) }}">{{$income[0].':'.$income[1]}}</a>
                        </h6></div>
                 @endforeach
                 <div class="col-md-12"><h6><a href="">  </a>
                        <a href="#">总计：{{$totalIncomes}}</a>
                        </h6></div>
                 
                </div>

            </div>
        </div>
    </div>
    
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2> 支出 </h2>
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
                        <a href="{{ URL::to('detail/' .$parameters.'/spends/'.$spend[2]) }}">{{$spend[0].':'.$spend[1]}}</a>
                        </h6></div>
                 @endforeach
                 <div class="col-md-12"><h6><a href="">  </a>
                        <a href="#">总计：{{$totalSpends->sum('amount')}}</a>
                        </h6></div>
                </div>

            </div>
        </div>
    </div>
    
 <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2> 用餐详细 </h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                 
                    <div class="col-md-3"><h6><a href="#">午餐：{{$lunch}}</a>
                       
                        </h6></div>
                      <div class="col-md-3"><h6><a href="#">晚餐：{{$dinner}}</a>
                      
                        </h6></div>
              
                 <div class="col-md-12"><h6><a href="">  </a>
                        <a href="#">总计：{{$lunch+$dinner}}</a>
                        </h6></div>
                </div>

            </div>
        </div>
    </div>    
       
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2> 单独采购总计 </h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                 
                 <div class="col-md-12"><h6><a href="">  </a>
                        <a href="{{url('/purchase_detail/'.$parameters)}}">总计：{{$purchase->sum('amount')}}</a>
                        </h6></div>
                </div>

            </div>
        </div>
    </div>    
    
</div>
</div>
@endsection
