@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>本周考勤</h2>

            </div>
            <div class="box-content">
                <div class="row">
                    @foreach($calendar as $date)
                    <form role="form" method="GET" action="{{ url('/schedule/create')}}">
                        @csrf
                        <input type="text" class="form-control hidden" name="class_id" value="{{$class_id}}">
                        <input type="text" class="form-control hidden" name="student_id" value="{{$student_id}}">
                        <input type="text" class="form-control hidden" name="AGENT" value="WECHAT">
                        <input type="text" class="form-control hidden" name="date" value="{{$date}}">  
                        <div class="col-md-3">
                            <h5 class="">周{{date_format(date_create($date),'w')==0?'日':date_format(date_create($date),'w')}}</h5>

                            @if($holidays->where('which_day',$date)->count()==1)
                            <a class="btn btn-primary disabled">
                                <i class="fa fa-btn fa-user"></i>{{date_format(date_create($date),'Y-m-d')}}
                            </a>
                            @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>{{date_format(date_create($date),'Y-m-d')}}
                            </button>
                            @endif
                    </form>
                </div>
                @endforeach
            </div>         
        </div>
    </div>
</div>
</div>
@endsection
