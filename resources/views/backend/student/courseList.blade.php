@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>{{$student->name}}</h2>
                <div class="box-icon">
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @foreach($courses as $course)

                    <div class="col-md-3">

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i>{{$course->name}}
                        </button>
                    </div>
                    @endforeach
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection
