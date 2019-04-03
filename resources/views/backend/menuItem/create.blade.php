@extends('layouts.app_backend')

@section('content')

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i>创建菜品信息</h2>
            </div>
            <div class="box-content">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#info">菜品基本信息</a></li>
                </ul>
                <form role="form" method="POST" action="{{ url('/menuItem') }}">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="box-content">

                                @csrf
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">菜品名称 ： </label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">   

                                    </div>
                                    <div class="form-group{{ $errors->has('ingredients') ? ' has-error' : '' }} col-md-6">
                                        <label class="control-label">菜品材料 ： </label>
                                        <input type="text" class="form-control" name="ingredients" value="{{ old('ingredients') }}">   

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('recipe') ? ' has-error' : '' }}  col-md-6">
                                        <label class="control-label">菜品做法 ： </label>
                                        <input id="duration" type="" class="form-control" name="recipe" value="{{ old('recipe') }}" >   

                                    </div>
                                    <div class="form-group{{ $errors->has('is_vegetarian') ? ' has-error' : '' }}  col-md-6">
                                        <label class="control-label"> 荤素</label>
                                        <select class="form-control" name="is_vegetarian">
                                            <option value="0">荤菜</option>
                                            <option value="1">素菜</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group  col-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i>提交
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--/span-->

</div><!--/row-->

@endsection
