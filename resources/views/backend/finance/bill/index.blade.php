@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i>账单管理</h2>
            </div>
            <div class="box-content">
                <p>
                 <!--   <a class="btn btn-primary" href="{{ route('bill.create') }}">创建账单</a> -->
                <h5>{{$bills->count()===0?'账单已对完':''}}</h5>  
		 
		 @if($has_created_bill_for_lastMonth)
                   
                    @else
                     <a class="btn btn-primary" href="{{ route('batchBillByYearMonth',['year'=>now()->month===1?now()->subYear()->year:now()->year,'month'=>now()->subMonth()->month]) }}">批量生成{{now()->subMonth()->month}}月账单</a>  
                    @endif
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">编号</th>
                            <th>账单内容</th>
                            <th class="hidden-sm hidden-xs">学生名字</th>
                            
                            <th class="hidden-sm hidden-xs">类别</th>
                            <th class="hidden-sm hidden-xs">涉及课程</th>
                            <th class="hidden-sm hidden-xs">账单状态（创建，已确认，已支付，已关闭）</th>
                            <th class="hidden-sm hidden-xs">账单金额</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td>{{ $model->comment.$model->income_category }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->student_name }}</td>
                           
                            <td class="hidden-sm hidden-xs">{{ $model->income_category}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->class_id}}</td>
                           
                            <td>{{ $model->state}}</td>
                            <td class="hidden-sm hidden-xs">{{'￥'.$model->total}}</td>
                            <td class="center">
                                <!--a class="btn btn-info" href="{{ URL::to('spend/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑账单
                                </a-->
                                @if($model->state!='closed')
                                <a class="btn btn-info" href="{{route('closeBill',['id'=>$model->id]) }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    确认支付、关闭账单
                                </a>
                                @endif
                                <!--a class="btn btn-danger" href="{{ URL::to('constantCategory/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a-->
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
