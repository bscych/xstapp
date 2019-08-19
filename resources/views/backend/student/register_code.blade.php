@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2> {{$student->name."的注册码信息"}}</h2>
            </div>
            <div class="box-content">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="">注册码</th>
                            <th class="">与学生的关系</th>
                            <th class="">注册时间</th                         >

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registerCodes as $model)
                        <tr>
                            <td>{{$model->code}} </td>
                            <td>{{ $model->relationship }}</td>
                            <td>{{ $model->deleted_at }}</td>
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               <div class="float-right"><a class="btn btn-primary" href="{{route('newRegisterCode',['student_id'=>$student->id])}}">新增注册码</a></div>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
