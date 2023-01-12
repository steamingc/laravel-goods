<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>상품 목록</title>
</head>
<body onload="window.resizeTo(600,800)">
    <div class="" style="padding:20px;">
        <!-- <div class="text-center">
            <h1>상품목록</h1>
            <hr />
        </div> -->

        <div class="">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">상품번호</th>
                        <th scope="col">상품명</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($goodslist as $goods)
                    <tr>
                        <th scope="row">{{$goods->idx}}</th>
                        <td><a href="javascript:" onclick="issubmit({{$goods->idx}});" style="text-decoration-line: none; color: black;">{{$goods->goods_nm}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function issubmit(index){
            let idx = index;
            // console.log(idx);
            // console.log(window.location.href);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "call",
                type: "post",
                traditional : true,
                data : { 'idx' : idx },
                dataType: "json",
                cache: false,
                success: function(data){
                    if (data.code == 200) {
                        $('#rgstrCategory[value="'+data.category+'"]', opener.document).prop("checked", true);
                        $('#rgstrNm', opener.document).val(data.goods_nm);
                        $('#rgstrColor', opener.document).val(data.color).prop("selected", true);
                        $('#rgstrSize[value="'+data.size+'"]', opener.document).prop("checked", true);
                        if((data.weather).includes(',')) {
                            console.log(data.weather);
                            arr = (data.weather).split(", ");
                            arr.forEach(function(value, index){
                                $('#rgstrWeather[value="'+value+'"]', opener.document).prop("checked", true);
                            });
                        } else {
                            $('#rgstrWeather[value="'+data.weather+'"]', opener.document).prop("checked", true);
                        }
                        $('#rgstrPrice', opener.document).val(data.price);
                        // console.log(data.img);
                        // console.log(data.img_path);
                        $('#formFile', opener.document).val(data.img);
                        // alert('상품 정보를 불러왔습니다');
                        // self.close();
                    } else if (data.code == 500) {
                        alert('상품 정보를 불러오지 못했습니다');
                        // self.close();
                    }
                }
            });
        }
    </script>
</body>
</html>