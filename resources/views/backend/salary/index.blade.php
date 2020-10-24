@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>薪资</h2>
            </div>
              <div class="box-content">
                <form role="form" method="GET" action="{{route('salary.index') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group inline {{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                            <label class="control-label">年 ： </label>
                            <input type="number" class="form-control" name="year" value="{{ old('name') }}" placeholder="{{$which_month}}">  
                        </div>
                        
                        <div class="form-group inline {{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                            <label class="control-label">月 ： </label>
                            <input type="number" class="form-control" name="month" value="{{ old('name') }}">  
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class=" btn btn-primary inline">
                                查询
                            </button>
                         
                        </div>
                    </div>
                </form>
            </div>

           
            <div class="box-content">
                <div>{{$which_month}}</di>
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>姓名</th>
                            <th>工作天数</th>
                            <th>差的天数到整月</th> 
                            <th>请假天数</th> 
                            <th>法定工作天数</th>
                             <th>操作</th>                           
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($data as $d)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{app\User::find(data_get($d,'user')->user_id)->name}}</td>
                            <td>{{data_get($d,'total_working_days')-data_get($d,'missing_number')-data_get($d,'leaving_number')}}</td> 
                            <td>{{data_get($d,'missing_number')}}</td> 
                            <td>{{data_get($d,'leaving_number')}}</td>  
                            <td>{{data_get($d,'total_working_days')}}</td>                              
                             <td>                               
                                 <a href="{{route('salary.show',[1])}}" class="btn btn-primary btn-sm" >详细</a>                               
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
