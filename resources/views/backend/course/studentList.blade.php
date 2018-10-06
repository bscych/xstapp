@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 学生列表，共{{$students->count()}}名</h2>
            </div>
            <div class="box-content">
                <p>
                </p>
            </div>

            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>名字</th>
                            <th>性别</th>
                            <th>就读学校班级</th>
                            <th>班级</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->gender }}</td>
                            <td>{{ $model->grade.'年'.$model->class_room.'班' }}</td>
                            @if( $model->classmodel_id ==null)
                            <td><h4 class="red">未进入班级</h4></td>
                            @else
                            <td><h5 class="green">{{$classes->firstWhere('id',$model->classmodel_id)->name }} </h5></td>
                            @endif
                            <td><a href="#" class="btn btn-info btn-setting" onclick="$('#student_id').val({{$model->id}})">分班</a></td>
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

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" st    yle="display: hidden;">
    <div class="modal-dialog">
        <form role="form" method="POST" action="{{ url('/divide') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>分班</h3>
                </div>

                <div class="modal-body">
                    <p>
                             <input type="hidden" name='course_id' value="{{$course_id}}">   
                              <input type="hidden" id='student_id' name='student_id' value="">
                            <div class="">
                                <label class="control-label">班级列表 ： </label>
                                <select class="l" name="class_id" id="class_id">
                                    @foreach($classes as $class)
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                    </p>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
                  
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>保存
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
var student_id="";
</script>