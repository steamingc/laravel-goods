<?php
//대성씨가 추가해주신 코드 -> 의미 검색
namespace App\Http\Controllers\goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class goodsController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        $goodslist = DB::table('goods') -> orderByDesc('idx')
                                        -> limit(10)
                                        -> get();
        
        //index페이지에 $goodslist를 보내주기
        return view('goods/goods_list', ['goodslist' => $goodslist]);
    }

    //상품등록창 보기 메소드
    public function goods_register()  
    {
        return view('goods/goods_register');
    }

    public function store(Request $request)
    {
        $category = $request->input('category');
        $goods_nm = $request->input('goods_nm');
        $color = $request->input('color');
        $size = $request->input('size');
        $price = $request->input('price');
        
        // dd($category);
        // dd($goods_nm);
        // dd($color);
        // dd($size);
        // dd($price);

        try {
            DB::beginTransaction();

            DB::table('goods')->insert([
                'category' => $category,
                'goods_nm' => $goods_nm,
                'color' => $color,
                'size' => $size,
                'price' => $price,
                'rt' => now(),
                
            ]);

                /* 두번째 방법
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
}