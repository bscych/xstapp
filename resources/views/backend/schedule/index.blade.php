@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>本周考勤</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @foreach($calendar as $date)
                    <form role="form" method="GET" action="{{ url('/schedule/create')}}">
                        @csrf
                        <input type="hidden" name="class_id" value="{{$class_id}}">
                        <input type="hidden" name="date" value="{{data_get($date,'date')}}">  
                         <div class="col-md-3">
                            <h5 class="">周{{ \Illuminate\Support\Carbon::make(data_get($date,'date'))->dayOfWeek===0?'日':\Illuminate\Support\Carbon::make(data_get($date,'date'))->dayOfWeek}}</h5>

                            @if(data_get($date,'submittable'))
                            <button type="submit" class="btn btn-primary">
                                {{data_get($date,'date')}}
                            </button>
                            @else
                            <a class="btn btn-primary disabled">
                                {{data_get($date,'date')}}
                            </a>
                            @endif
                        </div>     
                    </form>
                    @endforeach
                </div>         
            </div>
        </div>
    </div>
</div>
@endsection
