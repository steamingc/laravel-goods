<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./bootstrap-5.3.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <title>Goods List</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">상품관리 페이지</a>
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
                    @foreach ($goodslist as $goods)
                    <tr>
                        <th scope="row">{{$goods->idx}}</th>
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