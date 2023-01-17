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
    //인덱스페이지
    public function index()
    {
        return view('goods/goods_list');
    }

    //검색 기능
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


    //상품 삭제 기능
    public function delete(Request $request)
    {
        try {
           //받은 object를 디코드해서 다시 array로 변경
           $dataArr = json_decode($_POST['dataObject']);
         
           DB::beginTransaction();

           foreach($dataArr as $idx) {
            //    $imgpath = DB::table('goods')
            //                -> where('idx', $idx)
            //                -> value('img_path');
        
            //    //사진 있으면
            //    if($imgpath != null) {
            //        //사진 다중
            //        if(str_contains($imgpath, ',')){
            //            $imgpath = explode(",", $imgpath);
            //            $num = count($imgpath);
            //            // dd($num);
            //            for($i=0; $i<$num; $i++) {
            //                // dd($imgpath[$i]);
            //                Storage::delete($imgpath[$i]);       
            //            }
            //        //사진 하나
            //        } else {
            //            Storage::delete($imgpath);   
            //        }
            //    }

                //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
                $imgpaths = DB::table('goods_img')
                            -> where('idx', $idx)
                            -> get();
                //사진 있으면
                if($imgpaths != null) {
                    foreach ($imgpaths as $imgpath) {
                        $pathdel = $imgpath->img_path;
                        Storage::delete($pathdel);
                    }
                    DB::table('goods_img')
                        -> where('idx', $idx)
                        -> delete();
                }

               DB::table('goods')
                   -> where('idx', $idx)
                   -> delete();

               DB::commit();
           }
           $sql = "select * from goods order by idx desc";
           $result = DB::select($sql);

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
            'result' => $result
        ]);
    }

    //상품 개별 삭제
    public function deleting(Request $request, $idx)
    {
       try {
            //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
            $imgpaths = DB::table('goods_img')
                    -> where('idx', $idx)
                    -> get();
            //사진 있으면
            if($imgpaths != null) {
                foreach ($imgpaths as $imgpath) {
                    $pathdel = $imgpath->img_path;
                    Storage::delete($pathdel);
                }
                DB::table('goods_img')
                    -> where('idx', $idx)
                    -> delete();
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

    //상품 상세 창
    public function goods_read($idx)  
    {
        DB::beginTransaction();
        $sql = "
            select * from goods where idx=$idx;
        ";
        $goodslist = DB::select($sql);

        $sql2 = "
            select * from goods_img where idx=$idx;
        ";
        
        $goodsimglist = DB::select($sql2);

        return view('goods/goods_read', ['goodslist' => $goodslist], ['goodsimglist' => $goodsimglist]);
    }

    //상품명 list 출력 창
    public function name()
    {
        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> get();
        return view('goods/goods_name_list', ['goodslist' => $goodslist]);
    }

    //상품명 list 출력 창에서 idx 전송
    public function rgstrcall(Request $request)  
    {
        try {
            $idx = $request -> input('idx');

            $goodslist = DB::table('goods')
                        -> where('idx', $idx)
                        -> get();
                        
            foreach ($goodslist as $goods) {
                $category = $goods->category;
                $goods_nm = $goods->goods_nm;
                $color = $goods->color;
                $size = $goods->size;
                $comment = $goods->comment;
                $price = $goods->price;
                $weather = $goods->weather;
            }

            $goodsimglist = DB::table('goods_img')
                            -> where('goods_idx', $idx)
                            -> get();

            $imgArr = array();
            $imgPathArr = array();

            foreach ($goodsimglist as $goodsimg) {
                $img = $goodsimg->img;
                $img_path = $goodsimg->img_path;
                array_push($imgArr, $img);
                array_push($imgPathArr, $img_path);
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
            'code' => $code,
            // 'goodslist' => $goodslist,
            'category' => $category,
            'goods_nm' => $goods_nm,
            'color' => $color,
            'size' => $size,
            'price' => $price,
            'weather' => $weather,
            'comment' => $comment,
            'imgArr' => $imgArr,
            'imgPathArr' => $imgPathArr
        ]);
    }

    //상품 등록 창
    public function goods_register()  
    {
        return view('goods/goods_register');
    }

    //상품 등록 기능 - 사진 db 재설계 중
    public function store(Request $request)
    {
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size');
        $weather = $request->input('weather');
        $price = $request->input('price');
        $comment = $request->input('comment');

        $files = $request->file('image');
        // $filesPath = $request->input('imagePath');
        
        try {
            DB::beginTransaction();
            
            DB::table('goods')->insert([
                'category' => $category,
                'goods_nm' => $goods_nm,
                'color' => $color,
                'size' => $size,
                'weather' => $weather,
                'price' => $price,
                'rt' => now(),
                'comment' => $comment
                ]);
                    
                $lastid = DB::getPdo() -> lastInsertId();
            
                if(!empty($files)) {
                    foreach($files as $file) {
                        $imageName = date("YmdHis").'_'.$file->getClientOriginalName();
                        $path = $file -> storeAs('public/images', $imageName);
                        //summernote용 이미지 처리
                        // $imageName = $files[$i];
                        // $path = $filesPath[$i];
                        DB::table('goods_img')->insert([
                                    'goods_idx' => $lastid,
                                    'img' => $imageName,
                                    'img_path' => $path,
                                    'rt' => now()
                        ]);
                    }
                }

            DB::commit();
            $msg = '성공';
            $code = 200;
        } catch (Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
            $code = 500;

        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code,
            'idx' => $lastid
        ]);
    }

    //db 재설계 - summernote 사진
    public function imgsave(Request $request)
    {
        $files = $request->file('file');
        $image_arr = array();
        $path_arr = array();
        
        try {
            if(!empty($files)) {
                $imageName = date("YmdHis").'_'.$files->getClientOriginalName();
                $path = $files -> storeAs('public/images', $imageName);
                $url = '/storage/images/'.$imageName;
            }

            $msg = '성공';
            $code = 200;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $code = 500;
        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code,
            'url' => $url,
            'imgName' => $imageName,
            'path' => $path
        ]);
    }

    //상품 수정 창
    public function goods_modify($idx)  
    {
        // dd($idx);
        DB::beginTransaction();
        $sql = "
            select * from goods where idx=$idx;
        ";

        $sql2 = "
            select * from goods_img where goods_idx=$idx;
        ";

        $goodslist = DB::select($sql);
        $goodsimglist = DB::select($sql2);

        // dd($goodsimglist);
        // dd($goodslist);
        return view('goods/goods_modify', ['goodslist' => $goodslist], ['goodsimglist' => $goodsimglist]);
    }

    //상품 수정 기능
    public function modify(Request $request, $idx)
    {
        // dd($request->all());
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size'); 
        $weather = $request->input('weather');
        $price = $request->input('price');

        $comment = $request->input('comment');

        $files = $request->file('image');
        // $filesPath = $request->input('imagePath');
        
        try {
            DB::beginTransaction();
            
            DB::table('goods')
                -> where('idx', $idx)
                -> update([
                    'category' => $category,
                    'goods_nm' => $goods_nm,
                    'color' => $color,
                    'size' => $size,
                    'weather' => $weather,
                    'comment' => $comment,
                    'price' => $price,
                    'ut' => now()
            ]);

            // //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
            // //db select
            // $imgpaths = DB::table('goods_img')
            //             -> where('goods_idx', $idx)
            //             -> get();
            // //사진 있으면
            // if($imgpaths != null) {
            //     foreach ($imgpaths as $imgpath) {
            //         $pathdel = $imgpath->img_path;
            //         Storage::delete($pathdel);
            //     }
            //     DB::table('goods_img')
            //         -> where('goods_idx', $idx)
            //         -> delete();
            // }

            if(!empty($files)) {
                //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
                //db select
                $imgpaths = DB::table('goods_img')
                            -> where('goods_idx', $idx)
                            -> get();
                //사진 있으면
                if($imgpaths != null) {
                    foreach ($imgpaths as $imgpath) {
                        $pathdel = $imgpath->img_path;
                        Storage::delete($pathdel);
                    }
                    DB::table('goods_img')
                        -> where('goods_idx', $idx)
                        -> delete();
                }

                foreach($files as $file) {
                    $imageName = date("YmdHis").'_'.$file->getClientOriginalName();
                    $path = $file -> storeAs('public/images', $imageName);
                    DB::table('goods_img')->insert([
                                'goods_idx' => $idx,
                                'img' => $imageName,
                                'img_path' => $path,
                                'rt' => now()
                    ]);
                }
            }

            DB::commit();
            $msg = '성공';
            $code = 200;
          
        } catch (Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
            $code = 500;
        }
        return response() -> json([
            'msg' => $msg,
            'code' => $code,
            'idx' => $idx
        ]);
   }


    public function photodelete ($idx){
        try{
            $goods_idx = DB::table('goods_img')->where('idx', $idx)->value('goods_idx');
            // dd($goods_idx);

            //기존 img가 널값인지 확인 후 기존 이미지 스토리지 삭제
            $imgs = DB::table('goods_img')
                    -> where('idx', $idx)
                    -> get();
            
            //사진 있으면
            if($imgs != null) {
                foreach ($imgs as $img) {
                    $pathdel = $img->img_path;
                    Storage::delete($pathdel);
                }
                DB::table('goods_img')
                    -> where('idx', $idx)
                    -> delete();
            }
     
            // $newgoods = DB::table('goods') -> where('idx', $idx) -> get();
            // dd($newgoods);

            $newimgs = DB::table('goods_img')->where('goods_idx', $goods_idx)->get();
            DB::commit();

    
            $msg = '성공';
            $code = 200;
                
        } catch (Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
            $code = 500;   
       } return response() -> json([
            'msg' => $msg,
            'code' => $code,
            // 'newgoods' => $newgoods,
            'newimgs' => $newimgs
       ]);
    }

   
   
   
       
           

   



    // ----------수정전-----------
    
    //정렬 - 상품명 순1
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

}