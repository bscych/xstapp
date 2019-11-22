@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <h3><i class="glyphicon glyphicon-th"></i>{{$month.'月'}}考勤</h3>

        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>

                    <tr>
                        <th class="text-center"><small>日期</small></th>
                        <th class="text-center"><small>出勤人数</small></th>


                    </tr>
                </thead>
                @php
                $totalLessons = 0;$total =0;
                @endphp
                <tbody>
                    @foreach($dates as $whichday)
                    @if($schedule_students->where('schedule_id','=',$whichday->id)->sum('attended')>0)
                    @php
                    $totalLessons++;
                    @endphp
                    <tr>
                        <td class="text-center">{{$whichday->date}}</td>
                        <td class="text-center">
                            {{$schedule_students->where('schedule_id','=',$whichday->id)->sum('attended')}}
                            @php
                            $total =$total+$schedule_students->where('schedule_id','=',$whichday->id)->sum('attended');
                            @endphp
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td class="text-center">课时合计：{{$totalLessons}}</td>
                        <td class="text-center">人次合计：{{$total}}</td>
                    </tr>
                </tbody>
            </table>
            <p><a href="{{route('get_schedule_detail_by_month',['month'=>$month,'class_id'=>$class_id ])}}">本月明细</a>
                @hasanyrole('admin|superAdmin')
                <a href="#" class="btn btn-primary btn-sm btn-setting">补签到</a>
               
                @endhasanyrole

            </p>
        </div>      

    </div>
</div>
</div>


 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
     <form role="form" method="GET" action="{{route('reCheckIn')}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>选择补签日期</h3>
                </div>
                <div class="modal-body">
                    <input type="date" name="date" class="form-control">
                    <input type="hidden" name="class_id" value="{{$class_id}}">
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
                    <button type="submit" class="btn btn-primary">签到</button>
                </div>
            </div>
        </div>
     </form>
    </div>
@endsection