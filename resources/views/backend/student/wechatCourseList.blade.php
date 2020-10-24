@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{$student->name.'的课程列表'}}</h2>
            </div>

            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        @if($course->course_category_id==12)
                        <tr>
                            <td>{{$course->name}} </td>

                            <td class="center">
                                <a class="btn btn-primary" href="{{ route('schedule.index',['class_id'=>$course->classmodel_id,'student_id'=>$student->id,'AGENT'=>'WECHAT'])}}">
                                    <i class="fa fa-btn fa-user"></i>订餐
                                </a>
                                <a class="btn btn-primary" href="{{ route('get_schedule_detail_by_month',['month'=>date('m'),'class_id'=>$course->classmodel_id,'student_id'=>$student->id,'AGENT'=>'WECHAT'])}}">
                                    <i class="fa fa-btn fa-user"></i>订餐记录
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <!--div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{'今天的留言'}} </h2>
            </div>

            <div class="box-content">
                <div><small>留言是让父母给托管班老师的留言、需要注意的问题，比如今天要在几点前吃完饭，几点来接，几点上什么课，附加的家庭作业等等....请在当天3点前（周三12点前）留言,最多200字</small></div>
                <p> 
                    @php $dayWeek = now()->dayOfWeek;  $endTimeOnWed = now()->setTime(12, 0); $endTime = now()->setTime(15, 0); $clsStr = 'btn btn-primary btn-setting';
                     if($dayWeek===3){
                        if(now()->greaterThan($endTimeOnWed)){
                         $clsStr = 'btn btn-primary btn-setting disabled';
                        }
                     }else{
                        if(now()->greaterThan($endTime)){
                        $clsStr = 'btn btn-primary btn-setting disabled';
                        }
                     }
                    @endphp                  
                    <a href="#" class="{{$clsStr}}" onclick="">留言</a>
                    
                </p>
                <p>当前留言：{{$note===null?'':$note->note}}</p>
               
            </div>
        </div-->
    </div>
    <!--/span-->

</div><!--/row-->


@endsection


<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: hidden;">
    <div class="modal-dialog">
        @if($note!=null)
             <form role="form" method="POST" action="{{ route('parentnote.update',[$note->id]) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>留言</h3>
                </div>
                <div class="modal-body">                
                    <input type="hidden" value="{{$student->id}}" name="student_id">
                    <textarea class="autogrow form-control" name="note">{{$note->note}} </textarea>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>                  
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>保存
                    </button>
                </div>
            </div>
        </form>
        @else
         <form role="form" method="POST" action="{{ route('parentnote.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>留言</h3>
                </div>
                <div class="modal-body">                
                    <input type="hidden" value="{{$student->id}}" name="student_id">
                    <textarea class="autogrow form-control" name="note"></textarea>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>                  
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>保存
                    </button>
                </div>
            </div>
        </form>
        @endif
        
     
    </div>
</div>
