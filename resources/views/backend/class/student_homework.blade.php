<!doctype html>
<html lang="zh">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>打印作业</title>  
    </head>
    <body>
        <div class="container-fluid">
           
            @foreach($students as $student)   
           <img src="{{asset('/img/logo20.png')}}" height="50px" class="float-left"> <h2 class="text-center"> {{$student->name}}{{now()->format('Y-m-d')}}的分享</h2>
            <table class="table table-bordered d-print-table">
                <thead>
                    <tr>                
                        <td class="align-middle text-center" width="33.3%">用餐：{{$student->lunch==='1'?' 午餐 ':' '}}  {{$student->dinner==='1'?' 晚餐 ':' '}}</td>
                        <td class="align-middle text-center" width="33.3%">{{$student->school}}</td>
                        <td class="align-middle text-center" width="33.3%">{{$student->grade.'年'.$student->class_room.'班'}}</td>          
                    </tr>
                </thead>                             
                <tbody>                    
                    <tr>                           
                        <td class="align-middle text-center" width="20%">家长嘱托</td>  
                        @php $notes_from_parent = collect($notes->where('student_id',$student->id)->all()); 
                        $note = '';    
                        if($notes_from_parent->count()===1){
                            $note = $notes_from_parent->first()->note;
                        }
                        if($notes_from_parent->count()>1){                      
                        foreach($notes_from_parent as $not){
                            $note = $note.$not->note.'。';
                            }
                        }
                        @endphp
                        <td colspan="4">{{$note}}</td>
                    </tr>  
                    <!-- 每日总结-->
                    <tr>
                        <td width='20%' class="align-middle text-center">每日总结 </td>
                        <td colspan="4"></td>
                    </tr>                         
                </tbody>
            </table>
            <!-- -->
            <table class="table table-bordered border-dark">  
                <thead>                             
                <th width='35%' colspan="2" class="align-middle text-center">作业是否完成&作业内容</th>
                <th width='65%' class="align-middle text-center">备注</th>
                <!--th width='20%' class="align-middle text-center">错误原因</th>
                <th width='10%' class="align-middle text-center">如何纠正</th-->
                </thead>                           
                <tbody>
                    @php $homework = $homeworks->where('date',now()->format('Y-m-d'))
                    ->where('school_name',$student->school)
                    ->where('grade',$student->grade)
                    ->where('class',$student->class_room)->first()
                    @endphp
                    <!-- 语文作业-->
                    @foreach(collect(json_decode($homework->chinese,JSON_UNESCAPED_UNICODE)) as $chinese_task)
                    <tr>
                        @if($loop->index===0)
                        <th rowspan="{{$loop->count}}" width='5%' class="align-middle text-center">语<br>文<br></th>
                        @endif                            
                        <td scope="row" width='30%'><input type="checkbox"> {{$loop->index+1 . '. '.$chinese_task}}</td>
                        <td width='65%'> </td>
                        <!--td width='20%'> </td>
                        <td width='10%'> </td-->
                    </tr>
                    @endforeach  
                    <!-- 数学作业-->
                    @foreach(collect(json_decode($homework->math,JSON_UNESCAPED_UNICODE)) as $math_task)
                    <tr>
                        @if($loop->index===0)
                        <th rowspan="{{$loop->count}}" width='5%' class="align-middle text-center">数<br>学<br></th>     
                        @endif
                        <td scope="row" width='30%'><input type="checkbox"> {{$loop->index+1 . '. '.$math_task}}</td>
                        <td width='65%'> </td>
                        <!--td width='20%'> </td>
                        <td width='10%'> </td-->
                    </tr>
                    @endforeach  
                    <!-- 英语作业-->
                    @foreach(collect(json_decode($homework->english,JSON_UNESCAPED_UNICODE)) as $english_task)
                    <tr>
                        @if($loop->index===0)
                        <th rowspan="{{$loop->count}}" width='5%' class="align-middle text-center">英<br>语<br></th>                          
                        @endif        
                        <td scope="row" width='30%'><input type="checkbox"> {{$loop->index+1 . '. '.$english_task}}</td>
                        <td width='65%'> </td>
                        <!--td width='20%'> </td>
                        <td width='10%'> </td-->
                    </tr>
                    @endforeach 
                    <!-- 托管附加作业-->  
                    @foreach(collect(json_decode($homework->other,JSON_UNESCAPED_UNICODE)) as $other_task)
                    <tr>
                        @if($loop->index===0)
                        <th rowspan="{{$loop->count}}" width='5%' class="align-middle text-center">托<br>管<br>付<br>加</th>                          
                        @endif        
                        <td scope="row" width='30%'><input type="checkbox"> {{$loop->index+1 . '. '.$other_task}}</td>
                       <td width='65%'> </td>
                        <!--td width='20%'> </td>
                        <td width='10%'> </td-->
                    </tr>
                    @endforeach  
                </tbody>
            </table>

            @endforeach

        </div>



        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>