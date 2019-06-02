@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{$date}}订餐记录</h2>
            </div>
            <div class="box-content">

                @if($menu==null)
                <span>菜谱还没准备好</span>
                @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            @if($meal_flags->has_lunch==1)
                            <th style="width: 50%">午餐</th>
                            @endif
                             @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                            <th style="width: 50%">晚餐</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            @if($meal_flags->has_lunch==1)
                            <td>
                                @foreach($menu->lunch as $lunch)
                                <span>{{$lunch}} </span><br>
                                @endforeach
                            </td>
                            @endif
                            @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                            <td>
                                @foreach($menu->dinner as $dinner)
                                <span>{{$dinner}}</span><br>
                                @endforeach
                            </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>


            <div class="box-content">
                <table class="table table-striped table-bordered">
                  
                    <tbody>
                      
                        <tr>
                            <td>{{$student->name}} </td>
                           <td>
                                <label class="checkbox-inline"><input type="checkbox" disabled=""  {{$student->attended==1?'checked="checked"':''}} >出勤</label>
                                @if($meal_flags->has_lunch==1)
                                <label class="checkbox-inline"><input type="checkbox" disabled=""  {{$student->lunch==1?'checked="checked"':''}} >午餐</label>
                                @endif
                                @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                                <label class="checkbox-inline"><input type="checkbox" disabled="" {{$student->dinner==1?'checked="checked"':''}} >晚餐</label>
                                @endif
                            </td>
                        </tr>
                       
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
