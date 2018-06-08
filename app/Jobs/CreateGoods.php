<?php

namespace App\Jobs;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Api\GoodsService;
use MeiTuanOpenApi\Config\Config;
use Redis;

class CreateGoods implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shop;
    protected $data;
//    protected $result;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, $data)
    {
        $this->shop = $shop;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->data['upc'])
        {
            $this->data['result'] = '条码不存在';
            Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
            return true;
        }
        if (!$this->data['price'])
        {
            $this->data['result'] = '价格不存在';
            Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
            return true;
        }
        if (!$this->data['stock'])
        {
            $this->data['result'] = '库存不存在';
            Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
            return true;
        }
        $deopt = \DB::table('deopts')->where(['upc' => $this->data['upc']])->first();
        if (!$deopt)
        {
            $this->data['result'] = '品库中暂无此药品';
            Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
            return true;
        }
        $goods = \DB::table('goods')->where(['shop_id' => $this->shop->id, 'deopt_id' => $deopt->id])->first();
        if ($goods && $goods->meituan_id)
        {
//            return '药品已存在';
            $goods_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
            if ($goods_server->syncPriceStock($goods, $this->data['stock'], $this->data['price']) )
            {
                $goods->stock = $this->data['stock'];
                $goods->price = $this->data['price'];
                $goods->save();
                $this->data['result'] = '药品已存在，同步成功';
                Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
                return true;
            }else{
                $this->data['result'] = '药品已存在，同步库存失败';
                Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
                return true;
            }
        }else{
            $category = \DB::table('categories')->where(['name' => $deopt->category, 'shop_id' => $this->shop->id])->first();
            if (!$category || !$category->meituan_id)
            {
                $category_id = \DB::table('categories')->insertGetId(['name' => $deopt->category, 'shop_id' => $this->shop->id, 'sort' => 100]);
                $category = \DB::table('categories')->where(['id' => $category_id])->first();
                dd($category);
                $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $category_create_status = $server->create($category);
                if (!$category_create_status)
                {
                    \DB::table('categories')->delete($category);
                    $this->data['result'] = '该药品分类创建失败';
                    Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
                    return true;
                }
            }
            if ($category->meituan_id)
            {
                $goods_data = [
                    'deopt_id' => $deopt->id,
                    'third_id' => $this->data['id'],
                    'price' => $this->data['price'],
                    'shop_id' => $this->shop->id,
                    'category_id' => $category->id,
                    'sort' => 1000,
                    'stock' => $this->data['stock'],
                    'online' => 1,
                ];
//                $good = Good::create($goods_data);
                $good_id = \DB::table('goods')->insertGetId($goods_data);
                $server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $good_create_status = $server->create($good_id);
                if (!$good_create_status)
                {
                    \DB::table('goods')->delete($good_id);
                    $this->data['result'] = '该药品创建失败';
                    Redis::rpush('goods'.$this->shop->id, json_encode($this->data));
                    return true;
                }
            }
        }
    }
}
