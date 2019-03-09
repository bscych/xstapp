@extends('layouts.app')

@section('content')
   <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
              <img class="first-slide" src="{{ asset('img/frontend/paper-big.jpg') }}" alt="First slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>做影响孩子一生的教育</h1>
                <p>托辅教育为体, 文化素质为翼, 养成教育为魂, 人工智能为器</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">了解更多</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
              <img class="second-slide" src="{{ asset('img/frontend/classroom.jpg') }}" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>教育的核心就是提升孩子的综合社会能力“ICPS”</h1>
                <p>社会能力就是孩子解决冲突和与人相处的能力，人是社会动物，没有社会能力的孩子很难取得成功</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">了解更多</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="{{ asset('img/frontend/about_us_1.jpg') }}" alt="Third slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>养成教育，给孩子一个比爱更好的礼物</h1>
                <p>“养成教育”就是培养学生良好的行为习惯、语言习惯和思维习惯的教育</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">了解更多</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('img/frontend/20180109151610166.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>个性化托管</h2>
            <p>专注学生放学后课业辅导、习惯养成教育、营养膳食等服务</p>
            <p><a class="btn btn-secondary" href="#" role="button">详细 &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('img/frontend/youxiao.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>幼小衔接</h2>
            <p>帮助孩子完成幼儿园与小学两个教育阶段平稳过渡</p>
            <p><a class="btn btn-secondary" href="#" role="button">详细 &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="{{ asset('img/frontend/tese.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h2>特色课程</h2>
            <p>从各个学科和方面最大满足孩子和家长的学习需求</p>
            <p><a class="btn btn-secondary" href="#" role="button">详细 &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">帮助城市孩子找回缺失的自然 <span class="text-muted">--免费的自然课堂</span></h2>
            <p class="lead"> 最初，只是因为与孩子们共读书籍到“自然”话题时，儿时的自然体验便浮现在我们的脑海，同时惋惜现代生活在钢筋、水泥中的孩子们缺失了这份感受。后来，发现在各种育儿理念中都提到了“自然教育”的重要性。从而，我们需要给我们的孩子们制造这样一种幸福的记忆，哪怕是一点相似的记忆</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('img/frontend/ziranketang.jpg') }}" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">全国性的知名品牌 <span class="text-muted">--秉承12载的积累与沉淀</span></h2>
            <p class="lead">目前，小书童教育已经在全国200多个城市开设了900多家学习中心，得到了广大家长的高度认可。</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('img/frontend/cz.jpg') }}" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">更好的服务意识<span class="text-muted">--陪伴孩子们更好地成长</span></h2>
            <p class="lead">我们采用国际先进的创新教育理念，以“开发潜质、全面发展”为己任，打造中小学文化素质教育生态圈，坚持做遵循孩子健康成长规律的生态教育。</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('img/frontend/774091798.jpg') }}" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->
@endsection
