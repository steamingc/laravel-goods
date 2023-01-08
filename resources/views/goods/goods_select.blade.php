<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./bootstrap-5.3.0/css/bootstrap.min.css">
    <!-- <script src="./jquery-3.6.3.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
        
        //selectAll 클릭시
        function selectAll(selectAll){
            const checkboxes = document.getElementsByName('deletechk');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            })
        }

        //checkbox 개별 클릭시
        function selectchk(){
            let total = $("input[name='deletechk']").length;
            let checked = $("input[name='deletechk']:checked").length;
            if(total != checked) $("#selectAll").prop("checked", false);
            else $("#selectAll").prop("checked", true); 
        }

        //삭제 
        function isdelete(){
            let num = $('input:checkbox[name=deletechk]:checked').length;

            //체크된 것이 있으면
            if($('input:checkbox[name=deletechk]:checked').length > 0) {
                let isdel = confirm(num + '개의 상품을 삭제하겠습니까?');
                if(isdel) {
                    let idxarr = [];

                    $('input:checkbox[name=deletechk]').each(function (i) {
                        if($(this).is(":checked")==true){
                            idxarr.push($(this).val());
                            console.log($(this).val());
                            console.log(idxarr);
                        }
                    });
                    //ajax를 통해 php로 데이터를 보낼 때 array는 json형태로 보내줘야함
                    dataObject = JSON.stringify(idxarr);

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "delete",
                        type: "post",
                        traditional : true,
                        data: { dataObject : dataObject },
                        dataType: "json",
                        success: function() {
                            alert('글을 삭제하였습니다!');
                            location.href='/'; 
                            }
                    });

                } else {
                }
                //체크 없으면
            } else {
                alert('선택된 것이 없습니다');
            }
        }

        function setPriceformat(pricenum, id){
            let price = pricenum;
            price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById(id).innerHTML = price;
        }  

        //정렬 왔다갔다
        function orderbynm() {
            let link = document.location.href;
            if(link =="http://127.0.0.1:8002/goodsnm1") {
                location.href="goodsnm2";
            } else {
                location.href="goodsnm1";
            }
        }

        function orderbytm() {
            let link = document.location.href;
            if(link =="http://127.0.0.1:8002/goodsrgt1") {
                location.href="goodsrgt2";
            } else {
                location.href="goodsrgt1";
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
                        <a class="nav-link" href="select" style="font-weight: bold;">삭제</a>
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
                    <input class="form-control me-2" type="search" placeholder="상품명" aria-label="Search">
                    <button class="btn btn-sm btn-outline-success" type="submit">검색</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="">    
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="selectAll" onclick="selectAll(this)" id="selectAll" name="deletechkAll">
                            </div></th>
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
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$goods->idx}}" id="deletechk" name="deletechk" onclick="selectchk()">
                            </div>
                        </th>
                        <td>{{$goods->idx}}</td>
                        <td><a href="javascript:"onclick="pop('read/{{$goods->idx}}');" style="text-decoration-line: none; color: black;">{{$goods->goods_nm}}</a></td>
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
