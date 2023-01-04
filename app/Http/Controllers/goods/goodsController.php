<?php
//대성씨가 추가해주신 코드 -> 의미 검색
namespace App\Http\Controllers\goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\goods;
// use Illuminate\Support\Facades\DB;

class goodsController extends Controller
{

    private $goods;
    
    public function __construct(goods $goods) 
    // Laravel 의 IOC(Inversion of Control) 입니다
    // 이렇게 모델을 가져오는 것이 추천 코드
    {
        $this->goods = $goods;
    }

    //인덱스라는 이름의 함수 : goods_list를 보여주는 기능
    public function index()
    {
        //goodslist의 데이터를 최신순(idx기준)으로 페이징해서 가져오기
        $goodslist = $this->goods->latest('idx')->paginate(10);

        //index페이지에 $goodslist를 보내주기
        return view('goods/goods_list', compact('goodslist'));
        // return view('goods/goods_list');
    }

    //상품등록창 보기 메소드
    public function goods_register()  
    {
        return view('goods/goods_register');
    }

    public function store(Request $request)
    {
        //Request에 대한 유효성 검사
        //유효성에 걸린 에러는 errors에 담긴다
        // $request = $request -> validate([
        //     'category' => 'required',
        //     'goods_nm' => 'required',
        //     'color' => 'required',
        //     'size' => 'required',
        //     'price' => 'required'
        // ]);

        // $this->goods->create($request);

        // return view('goods/goods_register', ['response' => true]);
        // return true;
        // return view();
        // return redirect()->route('goods.index');

        /*ajax 처리 */
        // $sCategory = $request -> input('regstrCategory');
        // $sGoodsNm = $request -> input('goods_nm');
        // $sColor = $request -> input('color');
        // $sSize = $request -> input('size');
        // $sPrice = $request -> input('price');

        // $result = DB::table('goods')->insert(
        //     [ 'category' => $sCategory, 'goods_nm' => $sGoodsNm, 'color' => $sColor, 'size' => $sSize, 'price' => $sPrice]
        // );
        // return response() -> json(array('msg'=>$result), 200);

        return json_encode(array("statusCode"=>200));
    }


}