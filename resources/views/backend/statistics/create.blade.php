@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 用餐班级统计</h2>
            </div>
            <div class="box-content">
                <p>

                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
                    <thead>
                        <tr>
                            <th>班级名称</th>
                            <th>是否参与统计</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                        <tr>
                            <td>{{$course->name}} </td>
                            <td>
                                <label class="checkbox-inline"><input type="checkbox"  onChange="updateCourse({{$course->id}}, '{{ url('/statistics') }}')"  id="{{$course->id}}" {{$course->in_count==1?'checked="checked"':''}} >加入统计</label>
                               </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
  
</script>
    <!--/span-->

</div><!--/row-->

@endsection
