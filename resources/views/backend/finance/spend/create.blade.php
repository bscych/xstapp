@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i> 创建新支出条目</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/spend') }}">

                    @csrf
                    <div class="row">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">支出名称 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">   

                        </div>

                        <div class="form-group{{ $errors->has('name_of_account') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">会计科目 ： </label>
                            <select class="form-control" name="name_of_account" >
                                @foreach($name_of_accounts as $name_of_account)
                                <option value="{{$name_of_account->id}}">{{$name_of_account->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">金额 ： </label>
                            <input type="number" class="form-control" name="amount" value="{{ old('amount') }}">   

                        </div>

                        <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">支付方式 ： </label>
                            <select class="form-control" name="payment_method" >
                                @foreach($paymentMethods as $paymentMethod)
                                <option value="{{$paymentMethod->name}}">{{$paymentMethod->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('which_day') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">发生日期 ： </label>
                            <input type="date" class="form-control" name="which_day" value="{{ old('which_day') }}"></input>

                        </div>

                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('finance_year') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">财务年份 ： </label>
                            <select class="form-control" name="finance_year"> 
                                @for($i=2018;$i<=date_format(date_create(),"Y");$i++)
                                @if($i==date_format(date_create(),"Y"))
                                <option value="{{$i}}" selected ="selected">{{$i}}年</option>
                                @else
                                <option value="{{$i}}">{{$i}}年</option>
                                @endif
                                @endfor
                            </select>

                        </div>
                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('finance_month') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">财务月份 ： </label>
                            <select class="form-control" name="finance_month">
                                @for($i=1;$i<=12;$i++)
                                @if(date_format(date_create(),'m')==$i)
                                <option value="{{$i}}" selected ="selected">{{$i}}月</option>
                                @else
                                <option value="{{$i}}">{{$i}}月</option>
                                @endif
                                @endfor
                            </select>
                        </div>

                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('comment') ? ' has-error' : '' }} col-md-12">
                            <label class="control-label">备注 ： </label>
                            <input type="text" class="form-control" name="comment" value="{{ old('comment') }}"></input>
                        </div>

                    </div>
                    <div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" onclick="">
                                <i class="fa fa-btn fa-user"></i>提交
                            </button>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
