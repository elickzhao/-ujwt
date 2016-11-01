<?php

namespace App\Http\Controllers\Api\V1;


use ApiDemo\Models\Category;
use ApiDemo\Models\Goods;
use ApiDemo\Transformers\CategoryTransformer;
use ApiDemo\Transformers\GoodsTransformer;
use ApiDemo\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CategoryController extends BaseController
{
//    public function __construct(UserRepositoryContract $userRepository)
//    {
//        $this->userRepository = $userRepository;
//    }


    /**
     * @api {get} /categories 分类列表(category list)
     * @apiDescription 分类列表(category list)
     * @apiGroup category
     * @apiPermission none
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *  {
     *       "data": {
     *       "cat_id": 1,
     *       "cat_name": "个护化妆",
     *       "keywords": "",
     *       "cat_desc": "",
     *       "parent_id": 0,
     *       "sort_order": 19,
     *       "template_file": "",
     *       "measure_unit": "",
     *       "show_in_nav": 0,
     *       "style": "data/category/1468260511391245432.png",
     *       "is_show": 1,
     *       "grade": 0,
     *       "filter_attr": "",
     *       "is_top_style": 0,
     *       "is_top_show": 0,
     *       "category_links": "",
     *       "pinyin_keyword": ""
     *       }
     *   }
     */
    public function index($cid = 0)
    {
        $cat = Cache::remember('cat' . $cid, Carbon::now()->addMinutes(60), function () use ($cid) {
            return Category::where([['parent_id', $cid], ['is_show', 1]])->select('cat_id', 'cat_name', 'parent_id', 'style')->orderBy('sort_order')->get();
        });
        // 因为第一个元素返回的是对象,所以无法用集合的方法,所以还得转换一次
//        $f = collect($cat->first())->get('cat_id');
//        $subCat = Cache::remember('subCat',Carbon::now()->addMinutes(60),function(){
//            return Category::where([['parent_id', $f], ['is_show', 1]])->orderBy('sort_order')->get();
//        });
        //用dingo的response就是省了加json头这个步骤了
        //看来不仅如此啊 加上返回的是一个数组 data[{取出的数据}] 如果不用就返回{取出的数据}
        return $this->response->collection($cat, new CategoryTransformer());
        //return response()->json($a);
    }

    public function goods($cid = 0,$pageSize=8)
    {
        $allCat = Cache::remember('allCat', Carbon::now()->addHour(2), function () {
            return Category::where('is_show', 1)->select('cat_id', 'cat_name', 'parent_id')->orderBy('sort_order')->get()->toArray();
        });

        $subCat = Cache::remember('subCat'.$cid, Carbon::now()->addHour(1), function () use($allCat,$cid) {
            return $this->getSubCat($allCat,$cid);
        });

        $goods = Goods::whereIn('cat_id',$subCat)->select('goods_id','goods_name','market_price','shop_price','goods_thumb')->paginate($pageSize);
        return $this->response->paginator($goods, new GoodsTransformer());

    }

    /**
     * 获取所有子栏目
     * @param $allCat
     * @param $cid
     * @return array
     */
    public function getSubCat($allCat,$cid){
        return $cat_ids = collect($this->createMenuTree($allCat,$cid))->pluck('cat_id')->all();
    }

    /**
     * 生成菜单
     *
     * @param array $data 原始数据
     * @param integer $pid 当前分类的父id
     * @return array 处理后数据
     */
    public  function createMenuTree($data = array(), $pid = 0)
    {
        if (empty($data)) {
            return array();
        }

        static $level = 0;

        $returnArray = array();

        foreach ($data as $node) {
            if ($node['parent_id'] == $pid) {
                $returnArray[] = array(
                    'cat_id' => $node['cat_id'],
                    'cat_name' => $node['cat_name'],
                    'level' => $level
                );

                if ($this->hasChild($node['cat_id'], $data)) {
                    $level++;

                    $returnArray = array_merge($returnArray, $this->createMenuTree($data, $node['cat_id']));

                    $level--;
                }
            }
        }

        return $returnArray;
    }

    /**
     * 检查是否有子分类
     *
     * @param integer $cid 当前分类的id
     * @param array $data 原始数据
     * @return boolean 是否有子分类
     */
    public function hasChild($cid, $data)
    {
        $hasChild = false;

        foreach ($data as $node) {
            if ($node['parent_id'] == $cid) {
                $hasChild = true;
                break;
            }
        }

        return $hasChild;
    }


}
