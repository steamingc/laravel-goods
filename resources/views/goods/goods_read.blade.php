<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title>상품 상세</title>
    
</head>
<body onload="window.resizeTo(600,800)">
    <div class="container-fluid" style="padding:20px;">
        <div class="text-center">
            <h1>상품 상세</h1>
            <hr />
        </div>
        <!-- <form id="rgstrFrm" name="rgstrFrm" method="post"> -->
            @csrf
            @foreach ($goodslist as $goods)
            <div class="mb-3">
                <label for="rgstrNm" class="form-label" name="goods_nm">상품명</label>
                <input class="form-control" id="rgstrNm" name="goods_nm" value="{{$goods->goods_nm}}" disabled >
            </div>
            
            <div class="mb-3">
                <label for="rgstrCategory" class="form-label" name="category">카테고리</label>
                
                <input type="radio" id="rgstrCategory" name="category" value="상의" 
                {{ ($goods ->category==='상의')? "checked" : "" }} disabled>상의

                <input type="radio" id="rgstrCategory" name="category" value="하의" {{ ($goods ->category==='하의')? "checked" : "" }} disabled>하의

                <input type="radio" id="rgstrCategory" name="category" value="신발" {{ ($goods ->category==='신발')? "checked" : "" }} disabled>신발

                <input type="radio" id="rgstrCategory" name="category" value="모자" {{ ($goods ->category==='모자')? "checked" : "" }} disabled>모자
               
                <input type="radio" id="rgstrCategory" name="category" value="가방"{{ ($goods ->category==='가방')? "checked" : "" }} disabled>가방
                
            </div>
            <div class="mb-3">
                <label for="rgstrColor" class="form-label" name="color">색상</label>
                <select id="rgstrColor" name="color" disabled>
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
                <input type="radio" id="rgstrSize" name="size" value="xs" {{ ($goods ->size==='xs')? "checked" : "" }} disabled>XS
                <input type="radio" id="rgstrSize" name="size" value="s" {{ ($goods ->size==='s')? "checked" : "" }} disabled>S
                <input type="radio" id="rgstrSize" name="size" value="m" {{ ($goods ->size==='m')? "checked" : "" }} disabled>M
                <input type="radio" id="rgstrSize" name="size" value="l" {{ ($goods ->size==='l')? "checked" : "" }} disabled>L
                <input type="radio" id="rgstrSize" name="size" value="xl" {{ ($goods ->size==='xl')? "checked" : "" }} disabled>XL
            </div>
            <div class="mb-3"> 
                <label for="rgstrWeather" class="form-label" name="weatherchk">계절</label>
                    <input class="form-check-input" type="checkbox" value="봄" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '봄')? "checked" : ""}} disabled>봄
                    <input class="form-check-input" type="checkbox" value="여름" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '여름')? "checked" : ""}} disabled>여름
                    <input class="form-check-input" type="checkbox" value="가을" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '가을')? "checked" : ""}} disabled>가을
                    <input class="form-check-input" type="checkbox" value="겨울" id="rgstrWeather" name="weatherchk" {{str_contains( $goods->weather, '겨울')? "checked" : ""}} disabled>겨울
            </div>
            <div class="mb-3">
                <label for="rgstrPrice" class="form-label" name="price">가격</label>
                <input class="form-control" id="rgstrPrice" name="price" value="{{$goods->price}}" disabled>
            </div>
            <div class="mb-3">
                <label for="rgstrComment" class="form-label" name="goods_comment">상품 설명</label>
                <textarea class="form-control" id="rgstrComment" name="goods_comment" value="{{$goods->comment}}" disabled >{{$goods->comment}}</textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">이미지</label>
                <!-- <input class="form-control" type="file" id="formFile" disabled> -->
                @foreach ($goodsimglist as $goodsimg)
                <div> 
                    <img src="/storage/images/{{$goodsimg->img}}" alt="제품사진" style="width:100%;">
                </div>{{$goodsimg->img_path}}
                @endforeach
            </div>

            <div class="row">
                <div class="col-12 text-end">
                    <button class="btn btn-sm btn-primary" onclick="location.href='modifying/{{$goods->idx}}'">수정</button>
                    <button class="btn btn-sm btn-danger" onclick="isdelete();">삭제</button>
                </div>
            </div>
            @endforeach
        <!-- </form> -->
    </div>
    <script>
        //가격 콤마 형식으로 출력
        $(function(){
            let price = $('#rgstrPrice').val()
            price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#rgstrPrice').attr("value", price);
        });

        //삭제
        function isdelete() {
            if(confirm("상품을 삭제하시겠습니까?")){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/deleting/{{$goods->idx}}",
                    type: "POST",
                    traditional : true,
                    cache: false,
                    success: function(data){
                        if (data.code == 200) {
                            alert('상품을 삭제하였습니다');
                            window.opener.location.reload();
                            self.close();
                        } else if (data.code == 500) {
                            alert('상품을 삭제하지 못했습니다');
                            window.opener.location.reload();
                            self.close();
                        }
                    }
                });
            } else {
            }
        }
    </script>
</body>
</html>