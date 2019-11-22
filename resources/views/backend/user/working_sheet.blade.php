@extends('layouts.wechat')

@section('content')

<div class="row">
    <div class="box col-md-12">
                <h3><i class="glyphicon glyphicon-th"></i>{{$month.'月'}}考勤</h3>
            
            <div class="box-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><small>姓名</small></th>
                            <th class="text-center"><small>总课时数</small></th>
                            <th class="text-center"><small>总课人次</small></th>
                        </tr>
                    </thead>
                 
                    <tbody>
                       @foreach($datas as $data)
                       <tr>
                           <td class="text-center"><a href="{{route('getTCKListByTeacherId',['year'=>$year,'month'=>$month,'teacher_id'=>$data['teacher']['id']])}}">{{$data['teacher']['name']}}</a></td>
                            <td class="text-center">{{$data['sum_of_class']}}</td>
                            <td class="text-center">{{$data['sum_of_student']}}</td>
                        </tr>
                       @endforeach
                      
                    </tbody>
                </table>
                
            </div>      
       
    </div>
</div>
</div>
@endsection
