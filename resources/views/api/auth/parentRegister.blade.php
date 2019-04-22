@extends('layouts.wechat')

@section('content')
<div class="container">
    <div class="row" style="height: 30px">

    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('注册') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('apiAuthRegister') }}">
                        @csrf
                        <input type="hidden" name ="whichForm" value="parent">
                       
                        <div class="form-group row" >
                            <label for="relationship" class="col-md-4 col-form-label text-md-right">{{ __('与孩子的关系') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="relationship">
                                    <option selected value="妈妈">妈妈</option>
                                    <option value="爸爸">爸爸</option>
                                    <option value="爷爷">爷爷</option>
                                    <option value="奶奶">奶奶</option>
                                    <option value="姥姥">姥姥</option>
                                    <option value="老爷">姥爷</option>
                                </select>
                             
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('验证码（请找前台老师索取）') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('注册') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height: 30px">

    </div>
</div>
@endsection
