<?php

namespace App\Models;

use EasyWeChat\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['paid_at'];


    public function orderGoods(){
        return $this->hasMany(OrderGoods::class);
    }

    /*public function goods()
    {
        return $this->belongsToMany(Goods::class, 'order_goods', 'order_id', 'goods_id');
    }*/

    /**
     * 被赋过值的订单模型才能调用该方法  特别注意,该模型中包含连表之后的数据
     * 用于后台
     * @return string
     */
    public function orderContent()
    {
         //得到一个分行数据即可
            //得到商品名称
            $res = $goods_name = str_limit($this->goods_name,15);
            //得到shop_number
            $res .= '&nbsp; x'.$this->shop_number;
            $res .= '<br>';
            //得到商品可选属性搭配 格式 -> "厂商:小米,操作系统:安卓"
            if($this->goods_attribute_ids){
                $res .= $this->getAttrNameValues($this->goods_attribute_ids);
                $res .= '<br>';
            }
            $res .= '单价:'.$this->shop_price;
            return $res;
    }

    /**
     * 根据商品属性id得到商品的属性数据,主要用于聚合展示,不适用于购买时的选择
     * @param array or string $goods_attr_ids
     * @param string $connector
     * @return string
     */
    public function getAttrNameValues($goods_attr_ids, $connector = '；'){
        if(!is_array($goods_attr_ids)){
            $goods_attr_ids = explode(',', $goods_attr_ids);
        }
        $goods_attributes = DB::table('goods_attributes')
            ->select('goods_attributes.id', 'attributes.name', 'goods_attributes.attribute_value')
            ->join('attributes', 'goods_attributes.attribute_id', '=', 'attributes.id')
            ->whereIn('goods_attributes.id', $goods_attr_ids)->get(); //集合

        $attr_name_values = $goods_attributes->map(function ($item){
            //拼接出一条
            return $item->name.'：'.$item->attribute_value;
        })->implode($connector);
        return $attr_name_values;
    }

    /**
     * 蓝色,ios,2G
     * @param $goods_attr_ids
     * @param string $connector
     * @return string
     */
    public function getAttrValues($goods_attr_ids, $connector = '，')
    {
        if(!is_array($goods_attr_ids)){
            $goods_attr_ids = explode(',', $goods_attr_ids);
        }
        $goods_attributes = DB::table('goods_attributes')
            ->select('attribute_value')
            ->whereIn('goods_attributes.id', $goods_attr_ids)->get(); //集合

        $attr_name_values = $goods_attributes->map(function ($item){
            //拼接出一条
            return $item->attribute_value;
        })->implode($connector);
        return $attr_name_values;
    }

    /**
     *从session中取出确认订单页需要的商品信息
     */
    public function getSessionOrderGoods()
    {
        $order_goods = json_decode(session('order_goods'));
        if($order_goods){
            //封装商品属性信息
            foreach ($order_goods as &$order_good){
                $order_good->attr_name_values = $this->getAttrNameValues($order_good->goods_attribute_ids);
                $order_good->shop_price = $this->getShopPrice($order_good->goods_id, $order_good->goods_attribute_ids);
            }
        }
        return $order_goods;
    }

    /**
     * 得到该商品的实际购买价格
     * @param int $goods_id
     * @param string $goods_attribute_ids 已经排序过的数组  '20,30' or ''
     * @return int mixed
     */
    public function getShopPrice($goods_id, $goods_attribute_ids)
    {
        //商品原价格查询
        $goods = Goods::find($goods_id);
        //商品库存价格查询
        $number = Number::where([
            ['goods_id', $goods_id],
            ['goods_attribute_ids', $goods_attribute_ids]
        ])->first();
        if($number->price){
            return $number->price;
        }
        return $goods->price;
        //todo  促销期价格判断
    }

    /**
     * 对用户操作的一件商品进行全面检测
     * @param int $goods_id
     * @param string $goods_attribute_ids
     * @param int $shop_number
     * @param bool $is_lock
     * @param bool $is_check_number
     * @return string 错误信息 或者 '';
     */
    public function checkOneGoods($goods_id, $goods_attribute_ids='', $shop_number=1, $is_lock = false, $is_check_number = true){
        //检验商品id是否存在 (用户伪造表单时造成的情况)
        $goods = Goods::find($goods_id); // model or null
        if(!$goods){
            return  '系统错误，商品不存在！';
        }
        //软删除和下架检测
        if($goods->is_on_sale == 0 || $goods->is_deleted == 1){
            return str_limit($goods->name, 15, '').' 已下架！';
        }
        //存在商品属性id时进行的判断
        if($goods_attribute_ids){ //字符串形式,并且已经排过序的,既在 sortOrImplode() 方法中运行过的
            //对商品属性id的真实性进行判断
            $res = $this->checkGoodsAttrIds($goods_attribute_ids, $goods_id); //得到一个true or false 如果返回false则return
            if(!$res){
                return str_limit($goods->name, 15, '').'    '.$this->getAttrValues($goods_attribute_ids).'  已售馨';
            }
        }

        if($is_check_number){
            //库存量检测 无论有商品属性还是没有商品属性都需要进行库存量的检测
            if($is_lock){
                //如果第4个参数为true时则加入排它锁, todo 这里 goods_id都等于8时, goods_attribute_ids 不同,会出现死锁情况吗? 如果两者联合使用一个唯一索引的话,则不会出现死锁情况
                $number = Number::where('goods_id', $goods_id)->where('goods_attribute_ids', $goods_attribute_ids)->lockForUpdate()->first();
            }else{
                $number = Number::where('goods_id', $goods_id)->where('goods_attribute_ids', $goods_attribute_ids)->first();
            }
            if(!$number || $number->number == 0){
                return str_limit($goods->name, 15, '').'    '.$this->getAttrValues($goods_attribute_ids).'  已售馨';
            }
            //库存量再次检测
            if($shop_number > $number->number){
                return str_limit($goods->name, 15, '').' '.$this->getAttrValues($goods_attribute_ids).'  仅剩'.$number->number.'件';
            }
        }
        return '';
    }

    /**
     * 对商品属性的真实性进行一个验证, 服务于checkOneGoods()
     *  既根据一个 goods_attr_id 和一个goods_id能够查到一条记录,
     * 最后将查到的记录的attribute_id(颜色)进行重复性的匹配,如果出现重复则会出现  蓝色,紫色,ios,2g的情况,这种情况是不被允许的
     * @param $goods_attribute_ids
     * @param $goods_id
     * @return bool
     */
    private function checkGoodsAttrIds($goods_attribute_ids, $goods_id)
    {
        //转化为数组
        $goods_attribute_ids = explode(',', $goods_attribute_ids);
        $attribute_ids = [];
        foreach ($goods_attribute_ids as $goods_attribute_id){
            //进行查表
            $res = DB::table('goods_attributes')->where('id', $goods_attribute_id)->where('goods_id', $goods_id)->first();
            if(!$res){
                return false;
            }
            $attribute_ids[] = $res->attribute_id;
        }
        //可能情况  2344   234
        if(count($attribute_ids) > count(array_unique($attribute_ids))){
            return false;
        }
        return true;
    }

    /**
     * todo 防止该方法被重复调用
     * todo 开启事务
     * @param $order_goods session中的商品, 包含的信息有  'goods.name', 'goods.sm_image', 'shop_carts.shop_number', 'shop_carts.id',
     * 'shop_carts.goods_id', 'shop_carts.goods_attribute_ids'
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function ConfirmToOrders($order_goods, $addr)
    {
        $total_price = 0;
        foreach ($order_goods as $key => $item){
            $order_goods[$key]->shop_price = $this->getShopPrice($item->goods_id, $item->goods_attribute_ids);
            //计算出该用户的购买价格
            $total_price += $item->shop_number * $item->shop_price;
        }
        //生成订单表数据
        $order = $this->create([
            'order_id' => date('ymdhi').sprintf('%04d', mt_rand(1,9999)), //todo 关键点订单id生成地  思路一,对前后一分钟时间内所有的订单进行一个检测,如果有重复则再生成一个 思路2,使用 cache实现一个订单池
            'remarks' => (string)request('remarks'),
            'user_id' => \Auth::user()->id,
            'name' => $addr->name,
            'phone' => $addr->phone,
            'floor_name' => $addr->floor_name,
            'number' => $addr->number,
            'total_price' => $total_price
        ]);

        //订单商品数据转移 //todo 分成两个方法来处理
        foreach ($order_goods as $item){
            //订单商品表创建数据, tips 必须使用模型创建才能 生成 created_at和updated_at时间, 通过改时间在后台进行订单的统计
            OrderGoods::create([
                'goods_name' => $item->name,
                'sm_image' => $item->sm_image,
                'goods_attributes' => $this->getAttrNameValues($item->goods_attribute_ids),
                'order_id' => $order->id,
                'goods_id' => $item->goods_id,
                'goods_attribute_ids' => $item->goods_attribute_ids,
                'shop_number' => $item->shop_number,
                'shop_price' => $item->shop_price,
            ]);
            //库存递减  购买量递增
            Number::where('goods_id', $item->goods_id)->where('goods_attribute_ids', $item->goods_attribute_ids)->decrement('number', $item->shop_number);
            Goods::where('id', $item->goods_id)->increment('buy_count', $item->shop_number);
            //删除购物车表中的这条记录
            ShopCart::where('goods_id', $item->goods_id)
                ->where('goods_attribute_ids', $item->goods_attribute_ids)
                ->where('user_id', \Auth::user()->id)
                ->delete();
        }
        //删除session中的数据
        session()->forget('order_goods');
        session()->forget('order_addr_id');
        //像微信客户端发起预付款id申请
        return $order;
    }

    public function getPrepayId()
    {
        $wechat = app('wechat'); //容器实例化
        $payment = $wechat->payment;
        //创建订单
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI(公众号支付)，NATIVE，APP...
            'body'             => '一公里科技有限公司-校园外卖',
            'detail'           => '天哪来啦-校园商城',
            'out_trade_no'     => $this->order_id,
            'total_fee'        => $this->total_price * 100, // 单位：分
            'notify_url'       => env('APP_URL').'/orders/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => \Auth::user()->open_id, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            return $prepayId = $result->prepay_id;
        }
        return false;
    }

    /**
     * 将商品和用户地址存储到确认订单的session中
     * @param $goods_id
     * @param $goods_attribute_ids
     * @param $shop_number
     */
    public function goodsToSession($goods_id, $goods_attribute_ids, $shop_number)
    {
        //确定订单中session的格式  [{},{},{}],需要存储的字段 商品名称,商品小图,商品的购买数量,商品id,商品属性ids
        $goods = Goods::select('name', 'sm_image', 'id as goods_id')->where('id', $goods_id)->first();
        //完善数据
        $goods->goods_attribute_ids = $goods_attribute_ids;
        $goods->shop_number = $shop_number;
        //判断当前用户是否存在默认的地址
        $addr = Addr::where([
            'user_id' => \Auth::user()->id,
            'is_default' => 1,
        ])->first();
        $order_addr_id = '';
        if($addr){
            $order_addr_id = $addr->id;
        }
        //格式转换
        $order_goods = json_encode([$goods]);
        //sesssion存储
        session(['order_addr_id' => $order_addr_id]);
        session(['order_goods' => $order_goods]);
    }

}
