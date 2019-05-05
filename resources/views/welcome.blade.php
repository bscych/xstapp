@extends('layouts.new')

@section('header')
  <header>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item active" style="background-image: url('imgs/bg1.jpg')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>做影响孩子一生的教育</h3>
                            <p>托辅教育为体, 文化素质为翼, 养成教育为魂, 人工智能为器</p>
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('imgs/bg2.jpg')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>教育的核心就是提升孩子的综合社会能力“ICPS”</h3>
                            <p>社会能力就是孩子解决冲突和与人相处的能力，人是社会动物，没有社会能力的孩子很难取得成功</p>
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('imgs/bg3.jpg')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>养成教育，给孩子一个比爱更好的礼物</h3>
                            <p>“养成教育”就是培养学生良好的行为习惯、语言习惯和思维习惯的教育</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </header>
@endsection

@section('content')
   <h1 class="my-4">欢迎来到大连小书童主页！</h1>

            <!-- Marketing Icons Section -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">个性化托管</h4>
                        <div class="card-body">
                            <p class="card-text">专注学生放学后课业辅导、习惯养成教育、营养膳食等服务</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('trust')}}" class="btn btn-primary">详细</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">幼小衔接</h4>
                        <div class="card-body">
                            <p class="card-text">帮助孩子完成幼儿园与小学两个教育阶段平稳过渡</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('connect')}}" class="btn btn-primary">详细</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">特色课程</h4>
                        <div class="card-body">
                            <p class="card-text">从各个学科和方面最大满足孩子和家长的学习需求</p>
                        </div>
                        <div class="card-footer">
                           <a href="{{route('training')}}" class="btn btn-primary">详细</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Portfolio Section -->
            <h2></h2>

            <div class="row">
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('img/frontend/natural.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">免费的自然课堂</a>
                            </h4>
                            <p class="card-text">最初，只是因为与孩子们共读书籍到“自然”话题时，儿时的自然体验便浮现在我们的脑海，同时惋惜现代生活在钢筋、水泥中的孩子们缺失了这份感受。后来，发现在各种育儿理念中都提到了“自然教育”的重要性。从而，我们需要给我们的孩子们制造这样一种幸福的记忆，哪怕是一点相似的记忆</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('img/frontend/honor.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">秉承12载的积累与沉淀</a>
                            </h4>
                            <p class="card-text">目前，小书童教育已经在全国200多个城市开设了900多家学习中心，得到了广大家长的高度认可。</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('img/frontend/together.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">陪伴孩子们更好地成长</a>
                            </h4>
                            <p class="card-text">我们采用国际先进的创新教育理念，以“开发潜质、全面发展”为己任，打造中小学文化素质教育生态圈，坚持做遵循孩子健康成长规律的生态教育。</p>
                        </div>
                    </div>
                </div>
              
            </div>
            <!-- /.row -->
            <hr>

            <!-- Call to Action Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <p>更多详细信息请进校或者电话咨询0411-39654232，0411-82287080</p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-primary btn-block" href="#">电话</a>
                </div>
            </div>

@endsection

