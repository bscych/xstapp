@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">

        <h3><i class="glyphicon glyphicon-th"></i>学生列表</h3>

        <div class="box-content">
            <table class="table table-striped table-bordered">
                <thead>

                    <tr>
                        <th class="text-center"><small>学生名字</small></th>                          
                        <th class="text-center"><small>就读学校</small></th>
                        <th class="text-center"><small>所在班级</small></th>
                        <th class="text-center"><small>打印作业</small></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td class="text-center">{{$student->name}}</td>                           
                        <td class="text-center">
                            {{$student->school}}
                        </td>
                        <td class="text-center">
                            {{$student->grade.'年'.$student->class_room.'班'}}                             
                        </td>
                        <td class="text-center">
                            @php
                            $homework = $homeworks->where('school_name',$student->school)->where('grade',$student->grade)->where('class',$student->class_room)->first();
                            @endphp
                            @if($student->attended==='0')
                            <label class="text-warning">今天不出勤</label> 
                            @else                            
                                @if($homework!=null)
                                <a href="{{route('class.print',['student_id'=>$student->id,'class_id'=>$classmodel_id])}}" target="_blank" class="btn btn-primary btn-sm">打印</a>   
                                @else
                                <label class="text-danger">作业还没上传</label>                            
                                @endif
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div> <a class="btn btn-primary btn-sm" target="_blank" href="{{route('class.print',['class_id'=>$classmodel_id])}}">批量打印</a></div>

        </div>      

    </div>
</div>
</div>
@endsection
