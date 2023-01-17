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

    <!-- CDN 파일 summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <!-- CDN 한글화 -->
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>

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
                <input class="form-control" id="rgstrNm" name="goods_nm" value="{{$goods->goods_nm}}" >
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
                <input class="form-control" id="rgstrPrice" name="price" value="{{$goods->price}}">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">이미지</label>
                <input class="form-control" type="file" id="formFile" name="formimage" onchange="readMultipleImage(this);" multiple>
                <div id="multiple-container" style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
                </div>
            </div>
            
            
            <div class="beforeimg" id="beforeimg">
                    @foreach ($goodsimglist as $goodsimg)
                    <div><img src="/storage/images/{{$goodsimg->img}}" alt="제품사진" style="width:20%;" class="beforeimg"></div>
                    <label class="beforeimg" style="font-size:0.5rem;">{{$goodsimg->img_path}}<a href="javascript:photodelete({{$goodsimg->idx}});">[삭제]</a></label>
                    @endforeach
            </div>
            
            
            <div class="mb-3">
                <!-- <script>
                    let beforecomment = "<?= $goods->comment ?>";
                </script> -->
                <label for="summernote-editor" class="summernote-editor py-2">상품상세</label>
                <div>
                <textarea id="summernote" name="editordata">{{$goods->comment}}</textarea>
                </div>
            </div>

            @endforeach
            <div class="row" style="padding:10px; position: relative">
                <div class="col-6 text-start">
                    <!-- <button class="btn btn-sm btn-dark" onclick="self.close();">닫기</button> -->
                    <button class="btn btn-sm btn-danger" onclick="isdelete();">삭제</button>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-sm btn-primary" type="button" onclick="isSubmit();">수정</button>
                    
                </div>
            </div>
        </form>
    </div>
    <script>
        //사진 개별 삭제
        function photodelete(idx) {
            $.ajax({
            // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            // data: form_data,
            type: "get",
            url: `photodelete/${idx}`,
            // cache: false,
            // contentType: false,
            // enctype: 'multipart/form-data',
            // processData: false,
            success: function(data) {
                // $('#beforeimg').remove();
                $('#beforeimg').load(location.href+' #beforeimg');

            }, 
            error: function(e){
                console.log(e);
            }
        });
        }

        // let imgNameArr = new Array();
        // let imgPathArr = new Array();

        //썸머노트
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 150,                // 에디터 높이
                minHeight: null,            // 최소 높이
                maxHeight: null,            // 최대 높이
                focus: true,                // 에디터 로딩후 포커스를 맞출지 여부
                lang: "ko-KR",				// 한글 설정        
                toolbar: [
                    ['style', ['bold', 'italic', 'underline','strikethrough', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert',['picture']],
                ],
                callbacks: {
                    onImageUpload: function(files, editor, welEditable) {
                        for (var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
                        }
                    }
                } 
            });

            // $('#summernote').summernote('editor.insertText', beforecomment);
            // for (let i=0; i<imgArr.length; i++) {
            //     $('#summernote').summernote('editor.insertImage', `/storage/images/${imgArr[i]}`);
            // }

        });

        function sendFile(file, el) {
        var form_data = new FormData();
        form_data.append('file', file);
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: form_data,
            type: "POST",
            url: 'imgsave',
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(data) {
                $(el).summernote('insertImage', data.url);
                // imgNameArr.push(data.imgName);
                // imgPathArr.push(data.path);
            }, 
            error: function(e){
                console.log(e);
            }
        });
        }


        //placeholder 가격 천 단위 콤마
        $(function(){
            let price = document.querySelector('#rgstrPrice');
            price = price.placeholder;
            price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#rgstrPrice').attr("placeholder", price);
        });

        //가격 입력 시 콤마 찍기
        const input = document.querySelector('#rgstrPrice');
        input.addEventListener('keyup', function(e) {   //키입력이 있을 때마다 포매팅하므로 keyup이벤트 사용
        let value = e.target.value;         //e.target.value를 이용해 input에 입력된 값 가져옴
        value = Number(value.replaceAll(',', ''));  //,값을 받으면 무조건 콤마없는 숫자로 반환
        if(isNaN(value)) {      //NaN인지 판별
            input.value = 0;
        }else {
            const formatValue = value.toLocaleString('ko-KR');
            input.value = formatValue;
        }
        })

        //썸네일
        function readMultipleImage(input) {
            $(".beforeimg").remove();
            $(".column").remove();
            const multipleContainer = document.getElementById("multiple-container")
            
            // 인풋 태그에 파일들이 있는 경우
            if(input.files) {
                // 이미지 파일 검사 (생략)
                console.log(input.files)
                // 유사배열을 배열로 변환 (forEach문으로 처리하기 위해)
                const fileArr = Array.from(input.files)
                const $colDiv1 = document.createElement("div")
                const $colDiv2 = document.createElement("div")
                $colDiv1.classList.add("column")
                $colDiv2.classList.add("colunm")
                $colDiv1.style.height = "100%";
                $colDiv2.style.height = "100%";
                fileArr.forEach((file, index) => {
                    const reader = new FileReader()
                    const $imgDiv = document.createElement("div")   
                    $imgDiv.style.height = "150px"
                    $imgDiv.style.padding = "10px"  
                    const $img = document.createElement("img")
                    // $img.classList.add("image")
                    $img.style.display = "block"
                    $img.style.width = "100%"
                    $img.style.height = "100%"
                    const $label = document.createElement("label")
                    // $label.classList.add("image-label")
                    $label.textContent = file.name
                    $imgDiv.appendChild($img)
                    $imgDiv.appendChild($label)
                    reader.onload = e => {
                        $img.src = e.target.result
                        
                        $imgDiv.style.width = ($img.width) * 0.5 + "px"
                        $imgDiv.style.height = ($img.height) * 0.5 + "px"
                        // $imgDiv.style.width = ($img.naturalWidth) * 0.2 + "px"
                        // $imgDiv.style.height = ($img.naturalHeight) * 0.2 + "px"
                    }
                    
                    // console.log(file.name)
                    
                    if(index % 2 == 0) {
                        $colDiv1.appendChild($imgDiv)
                    } else {
                        $colDiv2.appendChild($imgDiv)
                    }
                    
                    reader.readAsDataURL(file)
                })
                multipleContainer.appendChild($colDiv1)
                multipleContainer.appendChild($colDiv2)

                // const inputMultipleImage = document.getElementById("formFile")
                // inputMultipleImage.addEventListener("change", e => {
                //     readMultipleImage(e.target)
                // })
                // $("#beforeimg").empty();
                
            }
        }

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
                            window.opener.Search();
                            self.close();
                        } else if (data.code == 500) {
                            alert('상품을 삭제하지 못했습니다');
                            window.opener.Search();
                            // self.close();
                        }
                    }
                });
            } else {
            }
        }

        function isSubmit() {
            var check_num = /^[0-9]+$/;
            let str = $('#rgstrPrice').val();
            str = str.replace(/,/g, "");

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
                let goodscate = $(':radio[name="category"]:checked').val();
                let goodscol = $('#rgstrColor').val();
                let goodssize = $(':radio[name="size"]:checked').val();
                let goodsweather = '';
                $(':checkbox[name="weatherchk"]:checked').each(function(index){
                    let chk = $(this).val();
                    index == 0 ? goodsweather += chk : goodsweather += (", " + chk);
                });
                let goodspri = $('#rgstrPrice').val().replace(/,/g, "");
                

                let formData = new FormData();

                formData.append("category", goodscate);
                formData.append("goods_nm", goodsnm);
                formData.append("color", goodscol);
                formData.append("size", goodssize,);
                formData.append("weather", goodsweather);
                formData.append("price", goodspri);

                // //img arr
                // imgNameArr.forEach(function(img){
                //     formData.append("image[]", img);
                // });
                // imgPathArr.forEach(function(img){
                //     formData.append("imagePath[]", img);
                // });

                //이미지 첨부했을 경우에만 (기존)
                if($('input[name="formimage"]')[0].files.length > 0) {
                    // let imgarr = [];
                    $($('input[name="formimage"]')[0].files).each(function(index, file){
                        formData.append("image[]", file);
                    });
                }

                //plain text
                let comment = $('#summernote').summernote('code');
                formData.append("comment", comment);


        
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/modify/{{$goods->idx}}",
                    type: "POST",
                    traditional : true,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data : formData,
                    cache: false,
                    success: function(data){
                        if (data.code == 200) {
                            alert('상품을 수정하였습니다');
                            window.opener.Search();
                            // self.close();
                        } else if (data.code == 500) {
                            alert('상품 수정에 실패했습니다');
                            // window.opener.location.reload();
                            // self.close();
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>