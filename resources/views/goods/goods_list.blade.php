<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./bootstrap-5.3.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <title>Goods List</title>
    <script>
        //팝업창 위치 조정
        function pop(url) {
            var windowW = 1500;
            var windowH = 900;
            var winHeight = document.body.clientHeight;
            var winWidth = document.body.clientWidth;
            var winX = window.screenX || window.screenLeft || 0;
            var winY = window.screenY || window.screenTop || 0;
            var popX = winX + (winWidth - windowW)/2;
            var popY = winY + (winHeight - windowH)/2;

            window.open(url, "gd_rg", "width=" + windowW + ", height=" + windowH + ", scrollbars=no, menubar=no, top=" + popY + ", left=" + popX);
        }
        
        function setPriceformat(pricenum, id){
            let price = pricenum;
            price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById(id).innerHTML = price;
        }  

        //정렬 왔다갔다
        function orderbynm(){
            let link = document.location.href;
            if(link =="http://127.0.0.1:8002/goodsnm1") {
                location.href="goodsnm2";
            } else {
                location.href="goodsnm1";
            }
        }

        function orderbytm(){
            let link = document.location.href;
            if(link =="http://127.0.0.1:8002/goodsrgt1") {
                location.href="goodsrgt2";
            } else {
                location.href="goodsrgt1";
            } 
        }

        //검색
        function issearch(){
            let input = $('#search').val();
            
            if(!(input=="")){
                console.log(input);
                let word = encodeURI(input);
                location.replace(`/${word}`);
            } else {
                alert('검색어를 입력해주세요');
            }
        }
    </script>
</head>
<body>
    <div class="py-1 px-2">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">상품관리 페이지</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="javascript:" onclick="pop('register');" class="nav-link" aria-current="page">등록</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select">삭제</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php 
                                if($_SERVER["REQUEST_URI"]=='/goodsnm1') {
                                    echo "상품명(오름차순)";
                                } else if($_SERVER["REQUEST_URI"]=='/goodsnm2') {
                                    echo "상품명(내림차순)";
                                } else if($_SERVER["REQUEST_URI"]=='/goodsrgt1') {
                                    echo "등록일(오름차순)";
                                } else if($_SERVER["REQUEST_URI"]=='/goodsrgt2') {
                                    echo "등록일(내림차순)";
                                } else {
                                    echo "정렬";
                                }
                            ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item" onclick="orderbynm();">상품명 순</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="#" class="dropdown-item" onclick="orderbytm();">등록일 순</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            보기
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="goodsby5">5개</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/">10개</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="goodsby15">15개</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="text" placeholder="상품명" aria-label="Search" id="search">
                    <!-- <button class="btn btn-sm btn-outline-success" type="submit" >검색</button> -->
                    <button class="btn btn-sm btn-outline-success" type="button" onclick="issearch();">검색</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="">    
        <div class="">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">상품번호</th>
                        <th scope="col">상품명</th>
                        <th scope="col">카테고리</th>
                        <th scope="col">색상</th>
                        <th scope="col">사이즈</th>
                        <th scope="col">가격</th>
                        <th scope="col">계절</th>
                        <th scope="col">이미지</th>
                        <th scope="col">등록일자</th>
                        <th scope="col">수정일자</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($goodslist as $goods)
                    <tr>
                        <th scope="row">{{$goods->idx}}</th>
                        <td><a href="javascript:" onclick="pop('read/{{$goods->idx}}');" style="text-decoration-line: none; color: black;">{{$goods->goods_nm}}</a></td>
                        <td>{{$goods->category}}</td>
                        <td>{{$goods->color}}</td>
                        <td>{{$goods->size}}</td>
                        <td><span id="{{$goods->idx}}"></span><script>setPriceformat({{$goods->price}}, '{{$goods->idx}}');</script></td>
                        <td>{{$goods->weather}}</td>
                        <td>(이미지)</td>
                        <td>{{$goods->rt}}</td>
                        <td>{{$goods->ut}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row text-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination" style="justify-content: center;">
                    @if ($goodslist->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $goodslist->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                    </li>
                    @endif

                    @for($i = 1; $i <= $goodslist->lastPage(); $i++)
                    @if ($goodslist->currentPage() == $i)
                    <li class="page-item"><a class="page-link active" href="{{$goodslist->url($i)}}#">{{$i}}</a></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{$goodslist->url($i)}}#">{{$i}}</a></li>
                    @endif
                    @endfor
                    <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                    @if ($goodslist->currentPage() < $goodslist->lastPage() )
                    <li class="page-item">
                        <a class="page-link" href="{{$goodslist->nextPageUrl()}}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                    @endif
                    </li>
                </ul>
            </nav>
        </div>

    </div>
    </div>
</body>
</html>