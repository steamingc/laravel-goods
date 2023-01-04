<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./bootstrap-5.3.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <title>Goods List</title>
    <script>
        
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">상품관리 페이지</a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="javascript:" onclick="window.open('register', 'gd_rg', 'width=600, height=800, scrollbars=yes');" class="nav-link" aria-current="page">등록</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">삭제</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            정렬
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="">상품명 순</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">등록일 순</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            보기
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="">5개</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">10개</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">15개</a></li>
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
                        <th scope="col">상품번호</th>
                        <th scope="col">상품명</th>
                        <th scope="col">카테고리</th>
                        <th scope="col">색상</th>
                        <th scope="col">사이즈</th>
                        <th scope="col">가격</th>
                        <th scope="col">이미지</th>
                        <th scope="col">등록일자</th>
                        <th scope="col">수정일자</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <!-- blade에서 반복문을 처리하는 방법
                    goodsController에서 index에 넘긴 $goodslist(goods데이터리스트)를 출력해준다 -->
                    @foreach ($goodslist as $key => $goods)
                    <tr>
                        <th scope="row">{{$key+1 + (($goodslist->currentPage()-1) * 10)}}</th>
                        <td>{{$goods->goods_nm}}</td>
                        <td>{{$goods->category}}</td>
                        <td>{{$goods->color}}</td>
                        <td>{{$goods->size}}</td>
                        <td>{{$goods->price}}</td>
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
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>