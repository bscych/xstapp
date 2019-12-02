@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>交费类别</h2>
            </div>
             <div class="box-content">
                 <h2><i class=""></i>选择课程类别</h2>
                 <p>
                     @foreach($incomesCategories as $category)
                    <a class="btn btn-primary btn-lg" href="{{ route('income.create',['student_id'=>$student_id,'category'=>$category->name]) }}">{{$category->name}}</a>
                    @endforeach
                </p>
            
            </div>
            
           
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
