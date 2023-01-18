<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- CDN 파일 summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <!-- CDN 한글화 -->
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>

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
                            arr = (data.weather).split(", ");
                            arr.forEach(function(value, index){
                                $('#rgstrWeather[value="'+value+'"]', opener.document).prop("checked", true);
                            });
                        } else {
                            $('#rgstrWeather[value="'+data.weather+'"]', opener.document).prop("checked", true);
                        }
                        $('#rgstrPrice', opener.document).val(data.price);

                        opener.setSummernote(data.comment);
                        opener.setImage(data.imgArr, data.imgPathArr);
                    } else if (data.code == 500) {
                        alert('상품 정보를 불러오지 못했습니다');
                        
                    }
                }
            });
        }
    </script>
</body>
</html>