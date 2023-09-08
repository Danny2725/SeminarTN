<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('frontend/css/app.css')}}">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!--test filter-->





    <!--mũi tên xuống cho dropdown menu header-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    cho thanh menuBar -->
    <!-- Link Swiper's CSS -->
    <!-- Scrips cho slide -->
    <link rel="stylesheet" href="{{asset('frontend/css/swiper-bundle.min.css')}}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>
    <title>Quản Lí CLB</title>
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


    <!-- slide hình ảnh -->
    <section class="main swiper mySwiper">
        <div class="wrapper swiper-wrapper">
            @foreach ($data1 as $inf1)
            <div class="slide swiper-slide">
                <img src="{{$inf1 -> HinhAnh}}" alt="" class="image" />
                <div class="image-data">
                    <h2>
                        <!--  CÂU LẠC BỘ -->
                        {{$inf1 -> Ten}}
                    </h2>
                    <a href="gioithieu/{{$inf1->id}}" class="button">Tìm hiểu thêm</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="nav-btn swiper-button-next "></div>
        <div class="nav-btn swiper-button-prev "></div>
        <div class="swiper-pagination"></div>
    </section>

    <!-- Swiper JS cho slide -->
    <script src="{{asset('frontend/JS/swiper-bundle.min.js')}}"></script>

    <!-- Initialize Swiper cho slide -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>


    <!--Filter-->

    <div class="styleSearchBar">
        <form action="{{route('home')}}/search" id="search-box" method="get">
            <select class="form-select" name="club_filter" id="club-filter">
                <option value="">Tất cả câu lạc bộ</option>
                <?php
                    // Kết nối tới cơ sở dữ liệu MySQL
                    $connection = mysqli_connect("localhost", "root", "", "datafb");
    
                    // Kiểm tra kết nối
                    if (mysqli_connect_errno()) {
                        echo "Lỗi kết nối đến cơ sở dữ liệu: " . mysqli_connect_error();
                        exit();
                    }
    
                    // Truy vấn dữ liệu từ bảng "fanpages" để lấy trường "name"
                    $query = "SELECT name FROM fanpages";
                    $result = mysqli_query($connection, $query);
    
                    // Kiểm tra và tạo các tùy chọn cho trường select từ dữ liệu câu lạc bộ
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['name'];
                            $selected = ($selectedClub == $name) ? 'selected' : '';
                            echo "<option value=\"$name\" $selected>$name</option>";
                        }
                    }
    
                    // Đóng kết nối cơ sở dữ liệu
                    mysqli_close($connection);
                ?>
            </select>
            <select class="form-select" name="date_filter">
                <option value="">Thời gian</option>
                <option value="day" {{ $dateFilter == 'day' ? 'selected' : '' }}>Today</option>
                <option value="week" {{ $dateFilter == 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ $dateFilter == 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year" {{ $dateFilter == 'year' ? 'selected' : '' }}>This Year</option>
            </select>
            <div class="search">
                <input type="text" placeholder="Tìm kiếm" id="search-text" name="search">
                <button id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    



<!-- Tin tức cập nhật-->
<div class="width-65">
    <!--   tạo độ rộng 65% từ trái -->
    <h2 class="heading-text mt-20">TIN MỚI CẬP NHẬT</h2>
    <!--  tạo tiêu đề căn lề trên 20-->
</div>

<div class="Rong-65">
    <!--Bài posts-->
    @foreach ($data as $post)
        <!-- Kiểm tra xem cột image có giá trị hay không -->
        @if (!empty($post->image))
            <div class="list">
                <!--thẻ thông tin-->
                <div class="items">
                    <div class="vi_left">
                        <img src="{{$post->image}}">
                    </div>
                    <div class="vi_right">
                        <p class="title">{{$post->fanpage_name}}</p>
                        <p class="date">{{$post->created_time}}</p>
                        <p class="content">{{$post->post_content}}</p>
                        <div class="btn">
                            <a href="post/{{$post->id}}">Xem thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <!--chuyển trang-->
    <div class="pagination">
    </div>
</div>
    <!-- script chuyển trang-->
    <script type="text/javascript">
        function getPageList(totalPages, page, maxLength) {
            function range(start, end) {
                return Array.from(Array(end - start + 1), (_, i) => i + start);
            }

            var sideWidth = maxLength < 9 ? 1 : 2;
            var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
            var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

            if (totalPages <= maxLength) {
                return range(1, totalPages);
            }

            if (page <= maxLength - sideWidth - 1 - rightWidth) {
                return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
            }

            if (page >= totalPages - sideWidth - 1 - rightWidth) {
                return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }

            return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
        }

        $(function() {
            var numberOfItems = $(".list .items").length;
            var limitPerPage = 5; //How many items items visible per a page
            var totalPages = Math.ceil(numberOfItems / limitPerPage);
            var paginationSize = 7; //How many page elements visible in the pagination
            var currentPage;

            function showPage(whichPage) {
                if (whichPage < 1 || whichPage > totalPages) return false;

                currentPage = whichPage;

                $(".list .items").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

                $(".pagination li").slice(1, -1).remove();

                getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                    $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
                        .toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
                            .attr({
                                href: "javascript:void(0)"
                            }).text(item || "...")).insertBefore(".next-page");
                });

                $(".previous-page").toggleClass("disable", currentPage === 1);
                $(".next-page").toggleClass("disable", currentPage === totalPages);
                return true;
            }

            $(".pagination").append(
                $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({
                    href: "javascript:void(0)"
                }).text("Prev")),
                $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({
                    href: "javascript:void(0)"
                }).text("Next"))
            );

            $(".list").show();
            showPage(1);

            $(document).on("click", ".pagination li.current-page:not(.active)", function() {
                return showPage(+$(this).text());
            });

            $(".next-page").on("click", function() {
                return showPage(currentPage + 1);
            });

            $(".previous-page").on("click", function() {
                return showPage(currentPage - 1);
            });
        });
    </script>


    <!-- Tạo bảng đường dẫn đến group CLB-->

    <div class="width-25">
        <div class="su-kien-dac-sac">
            <div class="heading-sect">
                <!--tạo tiêu đề -->
                <h3 class="head-title">CÁC CÂU LẠC BỘ</h3>
            </div>
            <!--tạo hình ảnh và đường dẫn -->
            @foreach ($data1 as $inf1)
            <div class="banner">
                <a class="link" href="{{$inf1 -> url}}"><img src="{{$inf1 -> HinhAnh}}" /></a>
            </div>
            @endforeach
        </div>
    </div>




    <!-- footer-->
    <div class="width-100 footer">
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
                <li><i class="fa fa-envelope-o" aria-hidden="true"></i> E-MAIL:<a href="#" class="footer-e-mail"> tranquan.ttdt.@gmai.com</a></li>
                <li><i class="fa fa-headphones" aria-hidden="true"></i> WHATS-APP: +91 -123 456 789</li>
                <li><i class="fa fa-fax" aria-hidden="true"></i> SỐ ĐIỆN THOẠI: +91 -(123)-4567890</li>
            </ul>

        </div>
    </div>
    </div>


</body>

</html>