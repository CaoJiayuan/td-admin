<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\LastQuoRepository;

class DashboardController extends Controller
{
    //注册统计
    public function GetData(LastQuoRepository $repository, Request $request)
    {
        return $repository->Getprotosslastquo();
    }
   //获取各合约统计信息
    public function GetStatisticsInstId(LastQuoRepository $repository, Request $request)
    {
       return $repository->GetExchTypeData();

    }
    //获取当前人数信息
    public function GetStatisticsNum(LastQuoRepository $repository, Request $request)
    {
        $result= $repository->GetStatisticsNum();
        $num=$this->GetCurrentOnlineNumber();
        array_push($result,['currentnum'=>$num]);
         //dd($result);
        return $result;
    }
    public function GetCurrentOnlineNumber()
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, env('API_DOMAIN'));
            // 设置header 响应头是否输出
            curl_setopt($curl, CURLOPT_HEADER, 0);
            // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
            // 1如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // 运行cURL，请求网页
            $data = curl_exec($curl);
            // 关闭URL请求
            curl_close($curl);
            $data = rtrim($data, ']');
            $data = ltrim($data, '[');
            $obj = \GuzzleHttp\json_decode($data, true);
            return $obj['onlineNumbers'];
        }catch(Exception $e)
        {
            return 0;
        }
    }
}
