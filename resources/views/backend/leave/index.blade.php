@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 请假</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ route('leave.create')}}">请假</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>开始日期</th>
                            <th>结束日期</th>
                            <th>备注</th>
                            <th>状态</th>
                            @if(auth()->user()->id===1 || auth()->user()->id===3)
                             <th>申请人</th>
                             <th>操作</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $loop->index+1}}</td>
                            <td>{{$leave->from}}</td>
                            <td>{{$leave->to}}</td>
                            <td>{{$leave->comment}}</td>
                            @php $status_st = ''; if($leave->status==='0') $status_st='申请中';if($leave->status==='1')$status_st='申请通过';if($leave->status==='2')$status_st='申请不通过' @endphp
                            <td>{{$status_st}}</td>   
                              @if(auth()->user()->id===1 or auth()->user()->id===3)
                             <td>{{app\User::find($leave->user_id)->name}}</td>
                             <td>
                                 @if($leave->status!='1')
                                 <a href="#" class="btn btn-primary btn-setting" onclick="$('#leave_id').val({{$leave->id}})">审批</a>
                                 @endif
                             </td>
                            @endif
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


<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: hidden;">
    <div class="modal-dialog">
        <form role="form" method="POST" action="{{ route('leave.update',['id'=>0]) }}">
           @method('PUT')
           @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>审批</h3>
                </div>
                <div class="modal-body">
                    <p>                            
                              <input type="hidden" id='leave_id' name='leave_id' value="">
                            <div class="">
                                <label class="control-label">审批意见 ： </label>
                                <select class="l" name="status">                                  
                                    <option value="1">同意</option>
                                   <option value="2">不同意</option>
                                </select>
                            </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>                  
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>保存
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>