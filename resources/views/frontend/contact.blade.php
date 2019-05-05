
@extends('layouts.new')


@section('content')
 <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">联系我们
    </h1>

    <!-- Content Row -->
    <div class="row">
      <!-- Map Column -->
      <div class="col-lg-8 mb-4">
        <!-- Embedded Google Map -->
        <iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://map.baidu.com/poi/%E5%B0%8F%E4%B9%A6%E7%AB%A5%E6%95%99%E8%82%B2%E4%B8%AD%E5%BF%83(%E6%A1%83%E8%A3%95%E5%9B%AD%E8%A1%97%E5%BA%97)/@13524125.996089023,4674175.297406953,18.06z?uid=5217cea6f9ded022d0ff236f&primaryUid=4698720776078909662&ugc_type=3&ugc_ver=1&device_ratio=1&compat=1&querytype=detailConInfo&da_src=embedded"></iframe>
      </div>
      <!-- Contact Details Column -->
      <div class="col-lg-4 mb-4">
        <h3>我们在</h3>
        <p>
          辽宁省 大连市 高新园区
          <br>桃裕园街 1号
          <br>
        </p>
        <p>
          <abbr title="电话">电话</abbr>: 0411-39654232,0411-82287080
        </p>
        
        <p>
          <abbr title="微信">公众号</abbr>:
          <img src="{{asset('img/wc.jpg')}}">
          </a>
        </p>
      
      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
@endsection

