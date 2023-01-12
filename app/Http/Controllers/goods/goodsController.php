<?php
//대성씨가 추가해주신 코드 -> 의미 검색
namespace App\Http\Controllers\goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class goodsController extends Controller
{
    /*----- VIEW -----*/
    //1. 인덱스페이지
    public function index()
    {
        return view('goods/goods_list');
        // DB::beginTransaction();

        // $goodslist = DB::table('goods') -> orderByDesc('idx')
        //                                 -> paginate(10);
        
        //index페이지에 $goodslist를 보내주기
        // $goodslist = DB::table('goods') -> orderByDesc('idx') -> get();
        // return view('goods/goods_list', ['goodslist' => $goodslist]);


        
        // return response() -> json([
        //     'goodslist' => $goodslist
        // ]);
    }

    //여기여기
    public function search(Request $request)     
    {
        $data = $request->input('data');

        if ($data != "") {
            $sql = "select * from goods where goods_nm like '%".$data."%' order by idx desc";
        } else {
            $sql = "select * from goods order by idx desc";
        }

        $result = DB::select($sql);
        // dd($result);
        return response()->json(['result' => $result]);
    }


    //2. 상품등록창
    public function goods_register()  
    {
        return view('goods/goods_register');
    }

    //3. 상품보기창
    public function goods_read($idx)  
    {
        DB::beginTransaction();
        $sql = "
            select * from goods where idx=$idx;
        ";

        $goodslist = DB::select($sql);
        // dd($goods);
        return view('goods/goods_read', ['goodslist' => $goodslist]);
    }

    //4. 상품수정창
    public function goods_modify($idx)  
    {
        // dd($idx);
        DB::beginTransaction();
        $sql = "
            select * from goods where idx=$idx;
        ";

        $goodslist = DB::select($sql);
        // dd($goodslist);
        return view('goods/goods_modify', ['goodslist' => $goodslist]);
    }

    //5. 상품삭제창
    public function goods_select()
    {
        DB::beginTransaction();

        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> paginate(10);
        
        return view('goods/goods_select', ['goodslist' => $goodslist]);
    }

    //6. 정렬 - 상품명 순1
    public function goods_name1()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderBy('goods_nm')
                                        -> paginate(10);

        // if($_SERVER['HTTP_REFERER']=="http://127.0.0.1:8002/select"){
        //     return view('goods/goods_select', ['goodslist' => $goodslist]);
        // } else {
            return view('goods/goods_list', ['goodslist' => $goodslist]);
        // }
    }

    //7. 정렬 - 상품명 순2
    public function goods_name2()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderByDesc('goods_nm')
                                        -> paginate(10);

        if($_SERVER['HTTP_REFERER']=="http://127.0.0.1:8002/select"){
            return view('goods/goods_select', ['goodslist' => $goodslist]);
        } else {
            return view('goods/goods_list', ['goodslist' => $goodslist]);
        }
    }

    //8. 정렬 - 등록일 순1
    public function goods_rgt1()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderBy('rt')
                                        -> paginate(10);
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }

    //9. 정렬 - 등록일 순2
    public function goods_rgt2()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderByDesc('rt')
                                        -> paginate(10);
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }

    //10. 인덱스페이지 - 5개
    public function goods_by5()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> paginate(5);
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }

    //11. 인덱스페이지 - 15개
    public function goods_by15()
    {
        DB::beginTransaction();
        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> paginate(15);
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }



    //12. 상품검색(get)
    // public function search($input)     
    // {
    //     $word = urldecode($input);
    //     // dd($input);
    //     DB::beginTransaction();
    //     // $sql = "
    //     //     select * from goods where goods_nm like '%$word%';
    //     // ";
    //     // $goodslist = DB::select($sql);

    //     $goodslist = DB::table('goods') -> where('goods_nm', 'like', '%'.$word.'%')
    //                                     -> paginate(10);

    //     return view('goods/goods_list', ['goodslist' => $goodslist]);
    // }
    
    

    //14. 불러오기 상품명list
    public function name()
    {
        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> get();
        return view('goods/goods_name_list', ['goodslist' => $goodslist]);
    }

    //15. 불러오기 - 상품명
    public function rgstrcall(Request $request)  
    {
        try {
            $idx = $request -> input('idx');
            
            // DB::beginTransaction();
            // $sql = "
            //     select * from goods where idx=$idx;
            // ";
            // $goodslist = DB::select($sql);

            $category = DB::table('goods') -> where('idx', $idx) -> value('category');
            $goods_nm = DB::table('goods') -> where('idx', $idx) -> value('goods_nm');
            $color = DB::table('goods') -> where('idx', $idx) -> value('color');
            $size = DB::table('goods') -> where('idx', $idx) -> value('size');
            $price = DB::table('goods') -> where('idx', $idx) -> value('price');
            $weather = DB::table('goods') -> where('idx', $idx) -> value('weather');
            $img = DB::table('goods') -> where('idx', $idx) -> value('img');
            $img_path = DB::table('goods') -> where('idx', $idx) -> value('img_path');


            $msg = '성공';
            $code = 200;
        } catch (\Throwable $th) {
            DB::rollback();
            $msg = '실패';
            $code = 500;
        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code,
            // 'goodslist' => $goodslist,
            'category' => $category,
            'goods_nm' => $goods_nm,
            'color' => $color,
            'size' => $size,
            'price' => $price,
            'weather' => $weather,
            'img' => $img,
            'img_path' => $img_path

        ]);
    }

    // //2. 상품등록창
    // public function goods_register_view($idx)  
    // {
    //     return view('goods/goods_register');
    // }


    // //4. 상품수정창
    // public function goods_modify($idx)  
    // {
    //     // dd($idx);
    //     DB::beginTransaction();
    //     $sql = "
    //         select * from goods where idx=$idx;
    //     ";

    //     $goodslist = DB::select($sql);
    //     // dd($goodslist);
    //     return view('goods/goods_modify', ['goodslist' => $goodslist]);
    // }




    /*----- Data -----*/
    //1. 상품등록
    public function store(Request $request)
    {
        // dd($request->all());
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size');
        $weather = $request->input('weather');
        $price = $request->input('price');

        $files = $request->file('image');
        $image_arr = array();
        $path_arr = array();
        foreach($files as $file) {
            $imageName = date("YmdHis").'_'.$file->getClientOriginalName();
            $path = $file -> storeAs('public/images', $imageName);
            array_push($image_arr, $imageName);
            array_push($path_arr, $path);
        }
        $image_arr = implode(",", $image_arr);
        $path_arr = implode(",", $path_arr);

        try {
            DB::beginTransaction();

            if(isset($path_arr)) {
                DB::table('goods')->insert([
                    'category' => $category,
                    'goods_nm' => $goods_nm,
                    'color' => $color,
                    'size' => $size,
                    'weather' => $weather,
                    'price' => $price,
                    'img' => $image_arr,
                    'img_path' => $path_arr,
                    'rt' => now()
                ]);
            } else {
                DB::table('goods')->insert([
                    'category' => $category,
                    'goods_nm' => $goods_nm,
                    'color' => $color,
                    'size' => $size,
                    'weather' => $weather,
                    'price' => $price,
                    'rt' => now()
                ]);
            }

                /* 다른 방법
                sql문 작성해서 쿼리빌더 넣기
                $sql = "
                    insert into goods values();
                ";
                DB::select($sql);
                */

            DB::commit();
            $msg = '성공';
            $code = 200;
        } catch (\Throwable $th) {
            DB::rollback();
            $msg = '실패';
            $code = 500;

        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code
        ]);
    }

     //2. 상품수정
     public function modify(Request $request, $idx)
     {
        // dd($request->all());
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size'); 
        $weather = $request->input('weather');
        $price = $request->input('price');
        
        //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
        $imgpath = DB::table('goods')
            -> where('idx', $idx)
            -> value('img_path');

        // DB::beginTransaction();

        //사진 있으면
        if($imgpath != null) {
            //사진 다중
            if(str_contains($imgpath, ',')){
                $imgpath = explode(",", $imgpath);
                $num = count($imgpath);
                for($i=0; $i<$num; $i++) {
                    Storage::delete($imgpath[$i]);       
                }
            //사진 하나
            } else {
                Storage::delete($imgpath);   
            }
        }


        $files = $request->file('image');
        $image_arr = array();
        $path_arr = array();
        foreach($files as $file) {
            $imageName = date("YmdHis").'_'.$file->getClientOriginalName();
            $path = $file -> storeAs('public/images', $imageName);
            array_push($image_arr, $imageName);
            array_push($path_arr, $path);
        }
        $image_arr = implode(",", $image_arr);
        $path_arr = implode(",", $path_arr);
 
        try {
            DB::beginTransaction();

            if(isset($path_arr)) {
                DB::table('goods')
                -> where('idx', $idx)
                -> update([
                    'category' => $category,
                    'goods_nm' => $goods_nm,
                    'color' => $color,
                    'size' => $size,
                    'weather' => $weather,
                    'price' => $price,
                    'img' => $image_arr,
                    'img_path' => $path_arr,
                    'ut' => now()
                ]);
            }else {
                DB::table('goods')
                -> where('idx', $idx)
                -> update([
                    'category' => $category,
                    'goods_nm' => $goods_nm,
                    'color' => $color,
                    'size' => $size,
                    'weather' => $weather,
                    'price' => $price,
                    'ut' => now()
                ]);
            }

            DB::commit();
            $msg = '성공';
            $code = 200;

        } catch (\Throwable $th) {
            DB::rollback();
            $msg = '실패';
            $code = 500;

        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code,
            'idx' => $idx
        ]);
    }

     //3. 상품삭제
     public function delete(Request $request)
     {
         try {
            //받은 object를 디코드해서 다시 array로 변경
            $dataArr = json_decode($_POST['dataObject']);

            DB::beginTransaction();

            foreach($dataArr as $idx) {
                $imgpath = DB::table('goods')
                            -> where('idx', $idx)
                            -> value('img_path');
                //사진 있으면
                if($imgpath != null) {
                    //사진 다중
                    if(str_contains($imgpath, ',')){
                        $imgpath = explode(",", $imgpath);
                        $num = count($imgpath);
                        // dd($num);
                        for($i=0; $i<$num; $i++) {
                            // dd($imgpath[$i]);
                            Storage::delete($imgpath[$i]);       
                        }
                    //사진 하나
                    } else {
                        Storage::delete($imgpath);   
                    }
                }

                DB::table('goods')
                    -> where('idx', $idx)
                    -> delete();

                DB::commit();
            }

            $msg = '성공';
            $code = 200;

         } catch (\Throwable $th) {
             DB::rollback();
             $msg = '실패';
             $code = 500;

         }
         return response() -> json([
             'msg' => $msg,
             'code' => $code
         ]);
     }

     //4. 개별 삭제
     public function deleting(Request $request, $idx)
     {
        try {
            //img가 널값인지 확인
            $isnull = DB::table('goods')
                        -> where('idx', $idx)
                        -> value('img');
            $imgpath = DB::table('goods')
                    -> where('idx', $idx)
                    -> value('img_path');
            // dd($isnull);

            DB::beginTransaction();

            //사진 있으면
            if($isnull != null) {
                //사진 다중
                if(str_contains($imgpath, ',')){
                    $imgpath = explode(",", $imgpath);
                    $num = count($imgpath);
                    for($i=0; $i<$num; $i++) {
                        // dd($imgpath[$i]);
                        Storage::delete($imgpath[$i]);       
                    }
                //사진 하나
                } else {
                    Storage::delete($imgpath);   
                }
            }

            DB::table('goods')
                -> where('idx', $idx)
                -> delete();
            DB::commit();

            $msg = '성공';
            $code = 200;
            
        } catch (\Throwable $th) {
            DB::rollback();
            $msg = '실패';
            $code = 500;
            
        } return response() -> json([
            'msg' => $msg,
            'code' => $code
        ]);
     }
}