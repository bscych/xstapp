@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-th"></i>我的孩子</h2>
                <div class="box-icon">
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    @foreach($students as $student)

                    <div class="col-md-3">

                        <a class="btn btn-primary" href="{{ URL::to('getKidsCourse/'.$student->id) }}">
                            <i class="glyphicon glyphicon-edit icon-white"></i>
                           {{$student->name}}
                        </a>
                    </div>
                    @endforeach
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection
