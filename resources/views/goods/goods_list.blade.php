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

    <script src='https://unpkg.com/@ag-grid-enterprise/all-modules@22.1.2/dist/ag-grid-enterprise.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css"/>
    <link rel="stylesheet"
     href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-balham.css"/>
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
        // function orderbynm(){
        //     let link = document.location.href;
        //     if(link =="http://127.0.0.1:8002/goodsnm1") {
        //         location.href="goodsnm2";
        //     } else {
        //         location.href="goodsnm1";
        //     }
        // }

        // function orderbytm(){
        //     let link = document.location.href;
        //     if(link =="http://127.0.0.1:8002/goodsrgt1") {
        //         location.href="goodsrgt2";
        //     } else {
        //         location.href="goodsrgt1";
        //     } 
        // }

        //검색
        function issearch(){
            let input = $('#search').val();
            
            if(!(input=="")){
                console.log(input);
                // let word = encodeURI(input);
                Search();
                // location.replace(`/${word}`);
            } else {
                alert('검색어를 입력해주세요');
            }
        }

        //검색 엔터
        $(document).ready(function(){
            $('#search').focus();
            $("#search").keydown(function(key){
                if(key.keyCode == 13) {
                    issearch();
                }
            })
        })

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
                            <a class="nav-link" href="javascript:" onclick="isdelete()">삭제</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
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
                        </li> -->
                    </ul>
                    <!-- <form id="searchFrm" name="searchFrm"> -->
                        <div class="d-flex" role="search">
                                
                            <input class="form-control me-2" type="text" placeholder="상품명" aria-label="Search" id="search">
                            <button class="btn btn-sm btn-outline-success col-3" type="button" onclick="issearch();" id="btnSrch">검색</button>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </nav>
    
        <div>
            <div class="table-responsive">
                <div id="div-gd" style="height:calc(100vh - 370px); width:100%;" class="ag-theme-balham"></div>
            </div>
        </div>
    </div>

<script>
    let gx;
    const gridOptions = {
        columnDefs: [
            {headerName: [''], headerCheckboxSelection: true, checkboxSelection: true, width: '30px'},
            {headerName: "#", field: "idx", width: 50},
            {headerName: "상품명", field: "goods_nm", width: 150,
                //cell 클릭시
                cellRenderer: function(params) {
                    let index = params.data.idx;
                    return '<a href="javascript:" onclick="pop(`read/'+index+'`);" style="text-decoration-line: none; color: black;">'+params.value+'</a>'
            }
        },
            {headerName: "카테고리", field: "category",  width: 80},
            {headerName: "색상", field: "color",  width: 80},
            {headerName: "사이즈", field: "size", width: 80},
            {headerName: "가격", field: "price", width: 100},
            {headerName: "계절", field: "weather", width: 80},
            {headerName: "등록일시", field: "rt", width: 120},
            {headerName: "수정일시", field: "ut", width: 120},
            // {headerName: "수정", field: "", width: 50},
            // {headerName: "", field: "", width: 'auto'}
        ],

        defaultColDef: {sortable: true, filter: true},
        rowSelection: 'multiple',
        animateRows: true,
        onGridReady: function (params) {
            params.api.sizeColumnsToFit();
        },
        isdelete : isdelete,

    };
   
    //문서 시작시 goodslist 출력
    $(document).ready(function(){
        const eGridDiv = document.getElementById("div-gd");
        gx = new agGrid.Grid(eGridDiv, gridOptions);
        
        Search();
    });

    //검색
    function Search() {
        // let data = $('form[name="searchFrm"]').serialize();
        let data = $('#search').val();
  
        $.ajax({
            url: 'search',
            type: "GET",
            data : 
                { data : data },
            dataType: "json",
            success: function(data){
                gx.gridOptions.api.setRowData(data.result);
                // console.log("hey");
                if(data.result==null){
                    console.log(data.result);
                    alert('검색된 데이터가 없습니다.');
                }
            }
        });
    }


    function isdelete(){
            let rows = gridOptions.api.getSelectedRows();
            let rowCount = gridOptions.api.getSelectedRows().length;
            
            //체크된 것이 있으면
            if(rowCount > 0) {
                let isdel = confirm(rowCount + '개의 상품을 삭제하겠습니까?');
                if(isdel) {
                    let idxarr = [];
                    rows.forEach(function (selectedRow, i) {
                        idxarr.push(selectedRow.idx);
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
    
</script>
</body>
</html>