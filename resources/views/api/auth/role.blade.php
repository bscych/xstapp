@extends('layouts.wechat')

@section('content')
<div class=" row">
    <div class="box-content"   >
        <p>
            <a class="btn btn-primary btn-lg" style="font-size: 50px" href="{{route('showParentRegisterForm')}}"><i class="glyphicon glyphicon-heart" ></i> 我是家长</a>
        </p>
        <p>
            <a class="btn btn-primary btn-lg"  style="font-size: 50px" href="{{route('showTeacherRegisterForm')}}"><i class="glyphicon glyphicon-star" ></i> 我是老师</a>
        </p>

    </div>
</div>


@endsection
