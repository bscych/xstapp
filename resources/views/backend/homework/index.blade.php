@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 作业管理</h2>
            </div>
            <div class="box-content">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ URL::to('/homework/create') }}">添加作业</a>      
                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>学校</th>
                            <th>班级</th>
                            <th>作业内容</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($homeworks as $model)
                        <tr>
                            <td>{{$model->date}} </td>
                            <td>{{ $model->school_name }}</td>
                            <td>{{ $model->grade.'年'.$model->class.'班' }}</td>
                            <td>{{__('语文:')}}
                                  @foreach(collect(json_decode($model->chinese,JSON_UNESCAPED_UNICODE)) as $chinese_task)
                                {{$loop->index+1 .'. '.$chinese_task}}
                                @endforeach
                               <br>
                                {{__('数学:')}}
                                  @foreach(collect(json_decode($model->math,JSON_UNESCAPED_UNICODE)) as $math_task)
                                {{$loop->index+1 .'. '.$math_task}}
                                @endforeach
                                <br>
                                 {{__('英语:')}}
                                  @foreach(collect(json_decode($model->english,JSON_UNESCAPED_UNICODE)) as $english_task)
                                {{$loop->index+1 .'. '.$english_task}}
                                @endforeach
                                <br>
                                 {{__('托管附加:')}}
                                  @foreach(collect(json_decode($model->other,JSON_UNESCAPED_UNICODE)) as $other_task)
                                {{$loop->index+1 .'. '.$other_task}}
                                @endforeach
                                </td>

                            <td class="center">
                                <a href="{{route('homework.edit',[$model->id])}}" class="btn btn-primary btn-sm">修改</a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
