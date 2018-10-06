@extends('layouts.app_backend')

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
                        <input type="text" class="form-control hidden" name="class_id" value="{{$class_id}}">
                        <input type="text" class="form-control hidden" name="date" value="{{$date}}">  
                        <div class="col-md-1">
                            <h5 class="">周{{date_format(date_create($date),'w')==0?'日':date_format(date_create($date),'w')}}</h5>
                          
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>{{date_format(date_create($date),'Y-m-d')}}
                                    </button>
                          
                    </form>
                </div>
                @endforeach
            </div>         



        </div>
    </div>
</div>
</div>
@endsection
