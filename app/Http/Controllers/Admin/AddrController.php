<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Addr;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class AddrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.addr.list');
    }

    /**
     * @return mixed
     */
    public function dtData()
    {
        return Datatables::of(Addr::query())->make(true);
    }


    public function destroy($id)
    {
        $addr = Addr::find($id);
        if (!$addr)
            return response('删除失败',403);
        $res = $addr->delete(); //成功返回1?失败返回0?
        return (string) $res;
    }
}
