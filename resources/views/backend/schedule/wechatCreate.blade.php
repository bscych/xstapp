@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-book"></i> {{$date}}订餐</h2>
            </div>
            <div class="box-content">

                @if($menu==null)
                <span>菜谱还没准备好</span>
                @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr> <td colspan="2">{{$student->name}} </td></tr>
                        <tr>
                            @if($meal_flags->has_lunch==1)
                            <th style="width: 50%">
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}}, 'lunch',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'lunch'.$student->student_id}}" {{$student->lunch==1?'checked="checked"':''}} >午餐</label>
                            </th>
                            @endif
                            @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                            <th style="width: 50%">
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}}, 'dinner',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'dinner'.$student->student_id}}" {{$student->dinner==1?'checked="checked"':''}} >晚餐</label>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            @if($meal_flags->has_lunch==1)
                            <td>
                                @foreach($menu->lunch as $menu_item)
                                <span>{{$menu_item}} </span><br>
                                @endforeach
                            </td>
                            @endif
                            @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                            <td>
                                @foreach($menu->dinner as $menu_item)
                                <span>{{$menu_item}}</span><br>
                                @endforeach
                            </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>

            @if(false)

            <div class="box-content">
                <table class="table table-striped table-bordered">

                    <tbody>
                        <tr>
                            <td style="align-items: center">{{$student->name}} </td>
                            <td>
                                @if(false)
                                <label class="checkbox-inline"><input type="checkbox"  onChange="submit({{$student->id}}, 'attended',{{$student->student_id}}, '{{ url('/schedule') }}')"  id="{{'attended'.$student->student_id}}" {{$student->attended==1?'checked="checked"':''}} >出勤</label>
                                @endif
                                @if($meal_flags->has_lunch==1)
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}}, 'lunch',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'lunch'.$student->student_id}}" {{$student->lunch==1?'checked="checked"':''}} >午餐</label>
                                @endif
                                @if( $exception->contains('student_id',$student->student_id) or $meal_flags->has_dinner==1)
                                <label class="checkbox-inline"><input type="checkbox" onChange="submit({{$student->id}}, 'dinner',{{$student->student_id}}, '{{ url('/schedule') }}')" id="{{'dinner'.$student->student_id}}" {{$student->dinner==1?'checked="checked"':''}} >晚餐</label>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!--/span-->

</div><!--/row-->

@endsection
