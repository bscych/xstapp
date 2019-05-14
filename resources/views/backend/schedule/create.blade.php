@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> 签到</h2>
            </div>
            <div class="box-content">
                <p>

                </p>
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>日期:{{$date}}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{$student->name}} </td>
                            <td>
                                <label class="checkbox-inline"><input type="checkbox"  onChange="submit({{$student->id}},'attended',{{$student->student_id}}, '{{ url('/schedule') }}')"  id="{{'attended'.$student->student_id}}" {{$student->attended==1?'checked="checked"':''}} >出勤</label>
                               @if($meal_flags->has_lunch==1)
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}},'lunch',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'lunch'.$student->student_id}}" {{$student->lunch==1?'checked="checked"':''}} >午餐</label>
                               @endif
                               @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}},'dinner',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'dinner'.$student->student_id}}" {{$student->dinner==1?'checked="checked"':''}} >晚餐</label>
                                @endif
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
