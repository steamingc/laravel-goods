<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <script src="./jquery-3.6.3.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>상품 수정</title>
</head>
<body onload="window.resizeTo(600,800)">
    <div class="" style="padding:20px;">
        <div class="text-center">
            <h1>상품수정</h1>
            <hr />
        </div>
        <form id="mfyFrm" name="mfyFrm" method="post">
            @csrf
            @foreach ($goodslist as $goods)
            <div class="mb-3">
                <label for="rgstrNm" class="form-label" name="goods_nm">상품명</label>
                <input class="form-control" id="rgstrNm" name="goods_nm" placeholder="{{$goods->goods_nm}}" >
            </div>
            
            <div class="mb-3">
                <label for="rgstrCategory" class="form-label" name="category">카테고리</label>

                <input type="radio" id="rgstrCategory" name="category" value="상의" 
                {{ ($goods ->category==='상의')? "checked" : "" }}>상의

                <input type="radio" id="rgstrCategory" name="category" value="하의" {{ ($goods ->category==='하의')? "checked" : "" }}>하의

                <input type="radio" id="rgstrCategory" name="category" value="신발" {{ ($goods ->category==='신발')? "checked" : "" }}>신발

                <input type="radio" id="rgstrCategory" name="category" value="모자" {{ ($goods ->category==='모자')? "checked" : "" }}>모자
               
                <input type="radio" id="rgstrCategory" name="category" value="가방"{{ ($goods ->category==='가방')? "checked" : "" }}>가방
                
            </div>
            <div class="mb-3">
                <label for="rgstrColor" class="form-label" name="color">색상</label>
                <select id="rgstrColor" name="color">
                    <!-- <option value="" selected disabled hidden>선택</option> -->
                    <option value="red" name="color" {{ ($goods ->color ==='red')? "selected" : "" }}>red</option>
                    <option value="orange" name="color" {{ ($goods ->color ==='orange')? "selected" : "" }}>orange</option>
                    <option value="yellow" name="color" {{ ($goods ->color ==='yellow')? "selected" : "" }}>yellow</option>
                    <option value="green" name="color" {{ ($goods ->color ==='green')? "selected" : "" }}>green</option>
                    <option value="blue" name="color" {{ ($goods ->color ==='blue')? "selected" : "" }}>blue</option>
                    <option value="navy" name="color" {{ ($goods ->color ==='navy')? "selected" : "" }}>navy</option>
                    <option value="purple" name="color" {{ ($goods ->color ==='purple')? "selected" : "" }}>purple</option>
                    <option value="black" name="color" {{ ($goods ->color ==='black')? "selected" : "" }}>black</option>
                    <option value="white" name="color" {{ ($goods ->color ==='white')? "selected" : "" }}>white</option>
                    <option value="mint" name="color" {{ ($goods ->color ==='mint')? "selected" : "" }}>mint</option>
                    <option value="pink" name="color" {{ ($goods ->color ==='pink')? "selected" : "" }}>pink</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rgstrSize" class="form-label" name="size">사이즈</label>
                <input type="radio" id="rgstrSize" name="size" value="xs" {{ ($goods ->size==='xs')? "checked" : "" }}>XS
                <input type="radio" id="rgstrSize" name="size" value="s" {{ ($goods ->size==='s')? "checked" : "" }}>S
                <input type="radio" id="rgstrSize" name="size" value="m" {{ ($goods ->size==='m')? "checked" : "" }}>M
                <input type="radio" id="rgstrSize" name="size" value="l" {{ ($goods ->size==='l')? "checked" : "" }}>L
                <input type="radio" id="rgstrSize" name="size" value="xl" {{ ($goods ->size==='xl')? "checked" : "" }}>XL
            </div>
            <div class="mb-3"> 
                <label for="rgstrWeather" class="form-label" name="weatherchk">계절</label>
                    <input class="form-check-input" type="checkbox" value="봄" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '봄')? "checked" : ""}}>봄
                    <input class="form-check-input" type="checkbox" value="여름" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '여름')? "checked" : ""}}>여름
                    <input class="form-check-input" type="checkbox" value="가을" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '가을')? "checked" : ""}}>가을
                    <input class="form-check-input" type="checkbox" value="겨울" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '겨울')? "checked" : ""}}>겨울
            </div>
            <div class="mb-3">
                <label for="rgstrPrice" class="form-label" name="price">가격</label>
                <input class="form-control" id="rgstrPrice" name="price" placeholder="{{$goods->price}}">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">이미지</label>
                <input class="form-control" type="file" id="formFile" disabled>
            </div>
            <div>
                <button onclick="self.close();">닫기</button>
                <button type="button" onclick="isSubmit();">수정</button>
            </div>
            @endforeach
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
                let goodsnm = $('#rgstrNm').val();
                let goodscate = $('#rgstrCategory').val();
                let goodscol = $('#rgstrColor').val();
                let goodssize = $('#rgstrSize').val();
                let goodsweather = '';
                $(':checkbox[name="weatherchk"]:checked').each(function(index){
                    let chk = $(this).val();
                    index == 0 ? goodsweather += chk : goodsweather += (", " + chk);
                });
                let goodspri = $('#rgstrPrice').val();
                
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    // url: "{{route('goods.store')}}",
                    url: "/modify/{{$goods->idx}}",
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
                            alert('상품을 수정하였습니다');
                            window.opener.location.reload();
                            self.close();
                        } else if (data.code == 500) {
                            alert('상품 수정에 실패했습니다');
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