@extends('layouts.wechat')

@section('content')
<div class=" row">
@foreach($students as $student)
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="well top-block" href="{{route('wechat.kidsClass',['student_id'=>$student->id])}}">
            <i class="glyphicon glyphicon-star green"></i>

            <div>{{$student->name}}</div>
           
        </a>
    </div>
@endforeach
</div>


@endsection
