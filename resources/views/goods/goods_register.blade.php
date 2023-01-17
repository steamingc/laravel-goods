<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- ag grid -->
    <script src='https://unpkg.com/@ag-grid-enterprise/all-modules@22.1.2/dist/ag-grid-enterprise.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css"/>
    <link rel="stylesheet"
     href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-balham.css"/>

      <!-- CDN 파일 summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <!-- CDN 한글화 -->
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>상품 등록</title>
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

            window.open(url, "gd_nm", "width=" + windowW + ", height=" + windowH + ", scrollbars=no, menubar=no, top=" + popY + ", left=" + popX);
        }
    </script>
</head>
<body onload="window.resizeTo(600,800)">
    <div class="" style="padding:20px;">
        <div class="text-center">
            <h1>상품등록</h1>
            <hr />
        </div>
        <form id="rgstrFrm" name="rgstrFrm"  method="post" enctype="multipart/form-data">
            <!-- 라라벨은 CSRF로 부터 보호하기 위해 데이터를 등록할 때의 위조를 체크 하기 위해 아래 코드가 필수 -->
            <!-- 라라벨은 크로스-사이트 요청 위조 공격 (CSRF)으로부터 애플리케이션을 손쉽게 보호할 수 있도록 해줍니다. 사이트 간 요청 위조는 인증된 사용자를 대신해서 승인되지 않은 커맨드를 악의적으로 활용하는 것입니다. -->
            @csrf
            <div class="mb-3">
                <div class="row">
                    <div class="col-6 text-start"><label for="rgstrNm" class="form-label" name="goods_nm">상품명</label></div>
                    <div class="col-6 text-end"><button type="button" class="btn btn-sm btn-secondary" onclick="pop('rgstr/name')">불러오기
                </div>
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
                <input class="form-control" type="file" id="formFile" name="formimage" onchange="readMultipleImage(this);" multiple>
                <!-- <div id="multiple-container" style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
                </div> -->
            </div>
            <div class="mb-3" id="multiple-container" style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
            </div>
            <div class="mb-3">
                <!-- <form method="post"> -->
                    <label for="summernote-editor" class="summernote-editor py-2">상품상세</label>
                    <div>
                        <textarea id="summernote" name="editordata"></textarea>
                    </div>
                <!-- </form> -->
            </div>
            
            <div class="mb-3">
                <div class="row">
                    <div class="col-6 text-start">
                        <button class="btn btn-sm btn-dark" onclick="window.close();">취소</button>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-sm btn-primary" type="button" onclick="isSubmit();">등록</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        // let imgNameArr = new Array();
        // let imgPathArr = new Array();

        //썸머노트
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 150,                // 에디터 높이
                // fontSize: '24',
                minHeight: null,            // 최소 높이
                maxHeight: null,            // 최대 높이
                focus: true,                // 에디터 로딩후 포커스를 맞출지 여부
                lang: "ko-KR",				// 한글 설정
                placeholder: '최대 100자까지 쓸 수 있습니다',	//placeholder 설정        
                toolbar: [
                    // [groupName, [list of button]],
                    // ['fontname', ['fontname']],
                    // ['fontsize', ['fontsize']],
                    // ['font', ['fontname','fontsize','fontsizeunit']],
                    ['style', ['bold', 'italic', 'underline','strikethrough', 'clear']],
                    // ['color', ['forecolor','color']],
                    ['para', ['ul', 'ol']],
                    ['insert',['picture']],
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New','맑은 고딕','궁서','굴림체','굴림','돋움체','바탕체'],
                fontSizes: ['8','9','10','11','12','14','16','18','20','22','24','28','30','36','50','72'],
                callbacks: {
                    onImageUpload: function(files, editor, welEditable) {
                        for (var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
                        }
                    }
                } 
            });
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

        //가격 입력 시 , 넣기
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
            //여기 수정 중
            $(".column").remove();
            $(".beforeimg").remove();
            const multipleContainer = document.getElementById("multiple-container")
            
            // 인풋 태그에 파일들이 있는 경우
            if(input.files) {
                // 이미지 파일 검사 (생략)
                // console.log(input.files)

                let fileArr = new Array();
                // 유사배열을 배열로 변환 (forEach문으로 처리하기 위해)
                if(!Array.isArray(input)) {
                    fileArr = Array.from(input.files);
                    console.log(fileArr);
                } else {
                    fileArr = input;
                    console.log(fileArr);
                }
                
                // 유사배열을 배열로 변환 (forEach문으로 처리하기 위해)
                // const fileArr = Array.from(input.files)

                const $colDiv1 = document.createElement("div")
                const $colDiv2 = document.createElement("div")
                $colDiv1.classList.add("column")
                $colDiv2.classList.add("column")
                $colDiv1.style.height = "100%"
                $colDiv2.style.height = "100%"
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
                    
                    console.log(file.name)
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
            }
        }


        function isSubmit() {
            var check_num = /^[0-9]+$/;
            let str = $('#rgstrPrice').val();
            str = str.replace(/,/g, "");
            // value = Number(value.replaceAll(',', ''));

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
                // 변수 선언
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

                //이미지 첨부했을 경우에만 (기존)
                if($('input[name="formimage"]')[0].files.length > 0) {
                    // let imgarr = [];
                    $($('input[name="formimage"]')[0].files).each(function(index, file){
                        formData.append("image[]", file);
                    });
                }

                // //img arr
                // imgNameArr.forEach(function(img){
                //     formData.append("image[]", img);
                // });
                // imgPathArr.forEach(function(img){
                //     formData.append("imagePath[]", img);
                // });

                // //plain text
                // let comment = $($('#summernote').summernote('code')).text();
                // //with tag
                let comment = $('#summernote').summernote('code');
                formData.append("comment", comment);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "store",
                    type: "POST",
                    traditional : true,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data : formData,
                    cache: false,
                    success: function(data){
                        if (data.code == 200) {
                            alert('상품을 등록하였습니다');
                            window.opener.Search();

                            // self.close();
                        } else if (data.code == 500) {
                            alert('상품등록에 실패했습니다');
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