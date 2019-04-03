@extends('layouts.app_backend')

@section('content')
<form role="form" method="POST" action="{{ url('/menu') }}"> 
    @csrf
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i> 菜谱日期</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="control-group">

                        <label class="control-label">日期 ： </label>
                        <input type="date" id="startDate" class="form-control" name="which_day" value="{{ old('which_day') }}">   

                    </div>

                </div>
            </div>
        </div>
        <!--/span-->

    </div><!--/row-->



    <div class="row">
       
       <!--上午间点 start -->
        <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i> 上午间点</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                  
                    <div class="control-group">
                    <label class="control-label" for="morning_snack">选择菜品</label>

                    <div class="controls">
                        <select id="morning_snack" multiple class="form-control" data-rel="chosen" name="morning_snack[]">
                             @foreach($menuItems as $menuItem)
                                <option value="{{$menuItem->name}}">{{$menuItem->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
     <!--上午间点 end -->
     
      <!--午餐 start -->
        <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i> 午餐</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                  
                    <div class="control-group">
                    <label class="control-label" for="lunch">选择菜品</label>

                    <div class="controls">
                        <select id="lunch" multiple class="form-control" data-rel="chosen" name="lunch[]">
                             @foreach($menuItems as $menuItem)
                                <option value="{{$menuItem->name}}">{{$menuItem->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
     <!--午餐 end -->
  
      <!--下午间点 start -->
        <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i> 下午间点</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                  
                    <div class="control-group">
                    <label class="control-label" for="afternoon_snack">选择菜品</label>

                    <div class="controls">
                        <select id="afternoon_snack" multiple class="form-control" data-rel="chosen" name="afternoon_snack[]">
                             @foreach($menuItems as $menuItem)
                                <option value="{{$menuItem->name}}">{{$menuItem->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
     <!--下午间点 end -->
      <!--晚餐 start -->
        <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i> 晚餐</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                  
                    <div class="control-group">
                    <label class="control-label" for="dinner">选择菜品</label>

                    <div class="controls">
                        <select id="dinner" multiple class="form-control" data-rel="chosen" name="dinner[]">
                             @foreach($menuItems as $menuItem)
                                <option value="{{$menuItem->name}}">{{$menuItem->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
     <!--晚餐 end -->   
        
        
        
    </div><!--/row-->

    <div class="row">
        <div class="form-group  col-md-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-user"></i>提交
            </button>

        </div>
    </div><!--/row-->


</form>
<script>

</script>
@endsection
