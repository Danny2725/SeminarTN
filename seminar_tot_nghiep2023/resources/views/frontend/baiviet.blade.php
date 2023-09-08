<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('frontend/css/bai-viet.css')}}">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--cho thanh menuBar -->
    <!-- Link Swiper's CSS -->



    <title>BÀI VIẾT</title>
</head>


<body>
    <!--Header-->
    <header>
        <div class="container">
            <input type="checkbox" name="" id="check">

            <a href="{{route('HOME1')}}" id="logo"><img src="{{asset('frontend/images/logo.png')}}" alt="HCMUS"> </a>

            <div class="thanh-menu">
                <div class="nav-links">
                    <ul>
                        <li>
                        </li>
                        <li class="nav-link" style="--i: .6s">
                            <a href="{{route('HOME1')}}">Trang chủ</a>
                        </li>
                        <li class="nav-link" style="--i: .85s">
                            <a>Giới thiệu<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                @foreach ($data1 as $inf1)
                                    <li class="dropdown-link">
                                        <a href="{{route('home')}}/gioithieu/{{$inf1->id}}"> {{$inf1 -> Ten}}</a>
                                    </li>
                                    @endforeach
                                    <div class="arrow"></div>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="hamburger-menu-container">
                <div class="hamburger-menu">
                    <div></div>
                </div>
            </div>
        </div>
    </header>

    <!-- chi tiết bài posts-->
    <div class="Rong-100">
        <div class=" list" style="display: grid;">

            <div class="item">
                <div class="tieu-de">
                    <p>

                    </p>
                </div>
                <div class="noi-dung">
                    <div class="hinh-anh">
                        @if (empty($post['image']))
                        <img src="{{$post_2 -> HinhAnh}}">
                        @else
                        <img src="{{$post -> image}}">
                        @endif

                                      
                        @foreach ($post_1 as $post_1)
                        <img src="{{$post_1 -> image_items}}">
                        @endforeach

                        <!--<img src="images/1-2.jpg">-->
                        <p class="date">{{$post -> created_time}}</p>
                    </div>
                    <div class="bai-viet">
                        <h1>
                            {!! nl2br(htmlspecialchars($post->post_content)) !!}
                        </h1>
                        <br>
                        <br>
                        <h1>
                            {!!$post -> user_name!!}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>






    <!-- footer-->
    <div class="width-100 margin-top-50 footer">
        <div class="Do-rong-trang">
        </div>
        <div class="width-50">
            <h2 class="quicklink-heading">CÁC CÂU LẠC BỘ</h2>
            <ul class="quicklink-menu">
                @foreach ($data1 as $inf1)
                <li><a>{{$inf1 -> Ten}}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="width-50">
            <h2 class="quicklink-heading">LIÊN HỆ</h2>
            <ul class="get-in-touch">
                <li><i class="fa fa-envelope-o" aria-hidden="true"></i> E-MAIL:<a href="#" class="footer-e-mail"> UHFISHUF@gmai.com</a></li>
                <li><i class="fa fa-headphones" aria-hidden="true"></i> WHATS-APP: +91 -123 456 789</li>
                <li><i class="fa fa-fax" aria-hidden="true"></i> SỐ ĐIỆN THOẠI: +91 -(123)-4567890</li>
            </ul>

        </div>
    </div>
    </div>
</body>

</html>