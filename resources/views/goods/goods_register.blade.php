<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="./jquery-3.6.3.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>상품 등록</title>
</head>
<body onload="window.resizeTo(600,800)">
    <div class="" style="padding:20px;">
        <div class="text-center">
            <h1>상품등록</h1>
            <hr />
        </div>
        <form id="rgstrFrm" name="rgstrFrm"  method="post">
            <!-- 라라벨은 CSRF로 부터 보호하기 위해 데이터를 등록할 때의 위조를 체크 하기 위해 아래 코드가 필수 -->
            <!-- 라라벨은 크로스-사이트 요청 위조 공격 (CSRF)으로부터 애플리케이션을 손쉽게 보호할 수 있도록 해줍니다. 사이트 간 요청 위조는 인증된 사용자를 대신해서 승인되지 않은 커맨드를 악의적으로 활용하는 것입니다. -->
            @csrf
            <div class="mb-3">
                <label for="rgstrNm" class="form-label" name="goods_nm">상품명</label>
                <input class="form-control" id="rgstrNm" placeholder="상품명" name="goods_nm">
            </div>
            <div class="mb-3">
                <label for="rgstrCategory" class="form-label" name="category">카테고리</label>
                <input type="radio" id="rgstrCategory" name="category" value="상의">상의
                <input type="radio" id="rgstrCategory" name="category" value="하의">하의
                <input type="radio" id="rgstrCategory" name="category" value="신발">신발
                <input type="radio" id="rgstrCategory" name="category" value="모자">모자
                <input type="radio" id="rgstrCategory" name="category" value="가방">가방
            </div>
            <div class="mb-3">
                <label for="rgstrColor" class="form-label" name="color">색상</label>
                <select id="rgstrColor" name="color">
                    <option value="" selected disabled hidden>선택</option>
                    <option value="red" name="color">red</option>
                    <option value="orange" name="color">orange</option>
                    <option value="yellow" name="color">yellow</option>
                    <option value="green" name="color">green</option>
                    <option value="blue" name="color">blue</option>
                    <option value="navy" name="color">navy</option>
                    <option value="purple" name="color">purple</option>
                    <option value="black" name="color">black</option>
                    <option value="white" name="color">white</option>
                    <option value="mint" name="color">mint</option>
                    <option value="pink" name="color">pink</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rgstrSize" class="form-label" name="size">사이즈</label>
                <input type="radio" id="rgstrSize" name="size" value="xs">XS
                <input type="radio" id="rgstrSize" name="size" value="s">S
                <input type="radio" id="rgstrSize" name="size" value="m">M
                <input type="radio" id="rgstrSize" name="size" value="l">L
                <input type="radio" id="rgstrSize" name="size" value="xl">XL
            </div>
            <div class="mb-3">
                <label for="rgstrWeather" class="form-label" name="weatherchk">계절</label>
                    <input class="form-check-input" type="checkbox" value="봄" id="rgstrWeather" name="weatherchk">봄
                    <input class="form-check-input" type="checkbox" value="여름" id="rgstrWeather" name="weatherchk">여름
                    <input class="form-check-input" type="checkbox" value="가을" id="rgstrWeather" name="weatherchk">가을
                    <input class="form-check-input" type="checkbox" value="겨울" id="rgstrWeather" name="weatherchk">겨울
            </div>
            <div class="mb-3">
                <label for="rgstrPrice" class="form-label" name="price">가격</label>
                <input class="form-control" id="rgstrPrice" placeholder="가격" name="price">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">이미지</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="">
                <button type="button" onclick="isSubmit();">등록</button>
                <button onclick="window.close();">취소</button>
            </div>
        </form>
    </div>
    <script>
        function isSubmit() {
            var check_num = /^[0-9]+$/;
            let str = $('#rgstrPrice').val();

            /* 유효성 검사 */
            if($('#rgstrNm').val() == '') {
                alert('상품명을 입력하세요');
                return false;
            } else if($(':radio[name="category"]:checked').length < 1) {
                alert('카테고리를 선택하세요');
                return false;
            } else if( !$('#rgstrColor > option:selected').val() ) {
                alert('색상을 선택하세요');
                return false;
            } else if($(':radio[name="size"]:checked').length < 1) {
                alert('사이즈를 선택하세요');
                return false;
            } else if($('input:checkbox[name="weatherchk"]:checked').length < 1) {
                alert('계절을 선택하세요');
                return false;
            } else if($('#rgstrPrice').val() == '') {
                alert('가격을 입력하세요');
                return false;
            } else if(!check_num.test(str)) {
                alert('가격은 숫자만 입력가능합니다');
                return false;
            } else {
                //변수 선언
                let goodsnm = $('#rgstrNm').val();
                let goodscate = $(':radio[name="category"]:checked').val();
                let goodscol = $('#rgstrColor').val();
                let goodssize = $(':radio[name="size"]:checked').val();

                let goodsweather = '';
                $(':checkbox[name="weatherchk"]:checked').each(function(index){
                    let chk = $(this).val();
                    index == 0 ? goodsweather += chk : goodsweather += (", " + chk);
                });

                let goodspri = $('#rgstrPrice').val();
                
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/store",
                    type: "POST",
                    traditional : true,
                    data: {
                        category : goodscate,
                        goods_nm : goodsnm,
                        color : goodscol,
                        size : goodssize,
                        weather : goodsweather,
                        price : goodspri
                    },
                    cache: false,
                    success: function(data){
                        if (data.code == 200) {
                            alert('상품을 등록하였습니다');
                            window.opener.location.reload();
                            self.close();
                        } else if (data.code == 500) {
                            alert('상품등록에 실패했습니다');
                            window.opener.location.reload();
                            self.close();
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>