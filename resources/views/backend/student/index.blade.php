@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 查询学生</h2>
            </div>
            <div class="box-content">
                <form role="form" method="GET" action="{{route('student.index') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group inline {{ $errors->has('name') ? ' has-error' : '' }} col-md-2">
                            <label class="control-label">姓名 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">   
                            
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class=" btn btn-primary inline">
                                查询
                            </button>
                         <a class="btn btn-primary" href="{{ URL::to('/student/create') }}">新增学生</a>     
                    </div>
                    </div>

                    
                </form>
                
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">学号</th>
                            <th>姓名</th>
                            <th class="hidden-sm hidden-xs">性别</th>
                            <th class="hidden-sm hidden-xs">生日</th>
                            <th class="hidden-sm hidden-xs">就读学校</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td><a  href="{{ URL::to('student/'. $model->id) }}">{{ $model->name }}</a></td>
                            <td class="hidden-sm hidden-xs">{{ $model->gender }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->birthday }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->school}}</td>

                            <td class="center">
                                <form action="{{ route('student.destroy',$model->id)}}" method="post">
                                    <a class="btn btn-info" href="{{ URL::to('student/' . $model->id . '/edit') }}">
                                        编辑
                                    </a>
                                    <a class="btn btn-primary" href="{{ URL::to('student/'. $model->id) }}">
                                        详细信息
                                    </a>
                                    <a class="btn btn-primary" href="{{ route('showCourseCategory',['student_id'=>$model->id]) }}">
                                        交费
                                    </a>

                                    <a class="btn btn-primary" href="{{ URL::to('refund/'. $model->id) }}">
                                        退费
                                    </a>
                                    <a class="btn btn-primary" href="{{ route('registerCodeList',['student_id'=>$model->id]) }}">
                                        注册码管理
                                    </a>
                                    @if ($model-> balance > 0)
                                    <a class="btn btn-primary" href="{{ URL::to('income/create?student_id='. $model->id) }}">
                                        扣费
                                    </a>
                                    <a class="btn btn-primary" href="{{ URL::to('getCourseList/'. $model->id) }}">
                                        报名
                                    </a>

                                    @endif
                                    @if ($model-> balance == 0)
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">注销</button>
                                    @endif
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>{{ $students->links() }}</div>
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

@endsection
