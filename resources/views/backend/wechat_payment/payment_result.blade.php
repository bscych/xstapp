@extends('layouts.wechat')

@section('content')
<div class=" row">


<div class="col-md-3 col-sm-3 col-xs-6">
        <a class="well top-block" href="{{route('wechat.pay')}}">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Pay test</div>
           
        </a>
     <input type="text" name="total">
    <p>
        @foreach($msg as $ms)
        {{$ms}}
        @endforeach
    </p>
    </div>
</div>


@endsection
