<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $guarded = [];

    public function collect($goods_id)
    {
        $res = $this->create([
            'goods_id' => $goods_id,
            'user_id' => \Auth::user()->id
        ]);
        return $res;
    }

    public function cancelCollect($goods_id)
    {
        $res = $this->where('goods_id', $goods_id)->where('user_id', \Auth::user()->id)->delete();
        return $res;
    }
}
