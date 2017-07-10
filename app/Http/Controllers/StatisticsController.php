<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\StatisticsRepository;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class StatisticsController extends Controller
{


    public function OnlineStat(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetonlineStat($request->get('begin'),$request->get('end'));
    }
    //注册统计
    public function Register(StatisticsRepository $repository, Request $request)
    {
        return $repository->getRegisterStat($request->get('begin'),$request->get('end'));
    }
    //注册天数统计详情
    public function RegisterDetails(StatisticsRepository $repository, Request $request)
    {
        return $repository->getRegisterStatDetails($request->get('date'));
    }
    //获取开户统计信息
    public function GetOpenStat(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetOpenStat($request->get('begin'),$request->get('end'));
    }
    //开户详细信息
    public function GetOpenStatDetails(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetOpenStatDetails($request->get('date'));
    }
    //获取交易详情【old】
    public function  GetTranscation(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetTranscation($request->get('begin'),$request->get('end'));
    }
    //获取交易详情【old】
    public function GetTranDetails(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetTranDetails($request->get('date'));
    }


    //获取交易详情【new】
    public function  GetTranscationnew(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetTranscationnew($request->get('begin'),$request->get('end'));
    }
    //获取交易详情【new】
    public function GetTranDetailsnew(StatisticsRepository $repository, Request $request)
    {
        return $repository->GetTranDetailsnew($request->get('date'));
    }



    //获取交易统计数据信息
    public function GetTradeData(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $instid=$request->get('instid');
        $insttype=$request->get('insttype');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $date=$request->get('date');
        $parentid=$request->get('parentid');
        return $repository->GetTradeData($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid);
    }



    public function GetHistoryTradeData(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $instid=$request->get('instid');
        $insttype=$request->get('insttype');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');
        $parentid=$request->get('parentid');
        return $repository->GetHistoryTradeData($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid);
    }
    //获取总资产信息
    public function  GetTotalAssets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');
        $parentid=$request->get('parentid');
        return $repository->GetTotalAssets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);

    }
    //获取当日资产数据信息
    public function GetCurrentAssets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $date=$request->get('date');

        $parentid=$request->get('parentid');

        return $repository->GetCurrentAssets($bp,$bc,$phone,$brokercode,$date,$parentid);
    }
    public function GetHistoryAssets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');
        $parentid=$request->get('parentid');


        return $repository->GetHistoryAssets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);
    }
    public function GetAllOnlineData(StatisticsRepository $repository, Request $request)
    {
        $begin=$request->get('begin');
        $end=$request->get('end');
        return $repository->GetAllOnlineData($begin,$end);
    }



    public function Totalcurrenttrade(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $instid=$request->get('instid');
        $insttype=$request->get('insttype');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $date=$request->get('date');
        $parentid=$request->get('parentid');
        return $repository->GetTotalcurrenttrade($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid);
    }
    public function Totalhistorytrade(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $instid=$request->get('instid');
        $insttype=$request->get('insttype');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');

        $parentid=$request->get('parentid');

        return $repository->GetTotalhistorytrade($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid);
    }
    public function Totalnumberassets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');
        $parentid=$request->get('parentid');
        return $repository->GetTotalnumberassets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);
    }
    public function Totalcurrentassets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $date=$request->get('date');
        $parentid=$request->get('parentid');
        return $repository->GetTotalcurrentassets($bp,$bc,$phone,$brokercode,$date,$parentid);
    }
    public function Totalhistoryassets(StatisticsRepository $repository, Request $request)
    {
        $bp=$request->get('bp');
        $bc=$request->get('bc');
        $phone=$request->get('phone');
        $brokercode=$request->get('brokercode');
        $begin=$request->get('begin');
        $end=$request->get('end');
        $parentid=$request->get('parentid');

        return $repository->GetTotalhistoryassets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);
    }
}
