<?php
//대성씨가 추가해주신 코드 -> 의미 검색
namespace App\Http\Controllers\goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class goodsController extends Controller
{
    /*----- VIEW -----*/
    //1. 인덱스페이지
    public function index()
    {
        DB::beginTransaction();

        // $goodslist = DB::table('goods') -> orderByDesc('idx')
        //                                 -> limit(10)
        //                                 -> get();
        
        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> paginate(10);

        //index페이지에 $goodslist를 보내주기
        return view('goods/goods_list', ['goodslist' => $goodslist]);
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
    public function search($input)     
    {
        $word = urldecode($input);
        // dd($input);
        DB::beginTransaction();
        $sql = "
            select * from goods where goods_nm like '%$word%';
        ";

        $goodslist = DB::select($sql);
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }

    /*----- Data -----*/
    //1. 상품등록
    public function store(Request $request)
    {
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size');
        $weather = $request->input('weather');
        $price = $request->input('price');
        
        // dd($category);

        try {
            DB::beginTransaction();

            DB::table('goods')->insert([
                'category' => $category,
                'goods_nm' => $goods_nm,
                'color' => $color,
                'size' => $size,
                'weather' => $weather,
                'price' => $price,
                'rt' => now()
            ]);

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
         $category = $request->input('category');
         $goods_nm = $request->input('goods_nm');
         $color = $request->input('color');
         $size = $request->input('size'); 
         $weather = $request->input('weather');
         $price = $request->input('price');
         
         // dd($category);
 
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
                    'price' => $price,
                    'ut' => now()
            ]);

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

     //3. 상품삭제
     public function delete(Request $request)
     {
         try {
            //받은 object를 디코드해서 다시 array로 변경
            $dataArr = json_decode($_POST['dataObject']);

            DB::beginTransaction();

            foreach($dataArr as $idx) {
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
}