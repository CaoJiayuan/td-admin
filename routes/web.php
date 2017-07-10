<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Repository\StatisticsRepository;
use App\Repository\LastQuoRepository;
use Carbon\Carbon;
use App\Entity\Branch;
use App\Repository\AgreementRepository;
Route::get('/', 'HomeController@index');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/OnlineExcel',function(StatisticsRepository $repository){

    $begin= $_GET['begin'];
    $end=   $_GET['end'];
    if (!$begin || !$end) {
        $end= date('Y-m-d', Carbon::now()->getTimestamp());
        //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->getTimestamp());
    }

    $begin=str_replace('/','-',$begin);
    $end=str_replace('/','-',$end);

    $result= $repository->GetOnlineExcel($begin,$end);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,['日期'=>$result[$i]->date,'在线人数'=>($result[$i]->num==0?"0人":((string)$result[$i]->num).'人')]);
    }
    Excel::create('在线人数', function($excel) use($array){
        $excel->sheet('在线人数', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
Route::get('/RegisterExcel',function(StatisticsRepository $repository){

    $begin= $_GET['begin'];
    $end=   $_GET['end'];
    if (!$begin || !$end) {
        $end= date('Y-m-d', Carbon::now()->getTimestamp());
        //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->getTimestamp());
    }
    $begin=str_replace('/','-',$begin);
    $end=str_replace('/','-',$end);

    $result= $repository->GetRegisterExcel($begin,$end);

    //return $result;

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,['日期'=>$result[$i]->date,'注册人数'=>($result[$i]->num==0?"0人":((string)$result[$i]->num).'人')]);
    }
    Excel::create('注册人数', function($excel) use($array){
        $excel->sheet('注册人数', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
Route::get('/OpenExcel',function(StatisticsRepository $repository){
    $begin= $_GET['begin'];
    $end=   $_GET['end'];
    if (!$begin || !$end) {
        $end= date('Y-m-d', Carbon::now()->getTimestamp());
        //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->getTimestamp());
    }
    $begin=str_replace('/','-',$begin);
    $end=str_replace('/','-',$end);

    $result= $repository->GetOpenExcel($begin,$end);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,['日期'=>$result[$i]->date,'开户人数'=>($result[$i]->num==0?"0人":((string)$result[$i]->num).'人')]);
    }
    Excel::create('开户人数', function($excel) use($array){
        $excel->sheet('开户人数', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
Route::get('/TradeExcel',function(StatisticsRepository $repository){
    $begin= $_GET['begin'];
    $end=   $_GET['end'];
    if (!$begin || !$end) {
        $end= date('Y-m-d', Carbon::now()->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
    }
    $begin=str_replace('/','-',$begin);
    $end=str_replace('/','-',$end);

    $result= $repository->GetTradeExcel($begin,$end);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,['日期'=>$result[$i]->date,'交易手数'=>($result[$i]->num==0?"0手":((string)$result[$i]->num).'手')]);
    }
    Excel::create('交易手数', function($excel) use($array){
        $excel->sheet('交易手数', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
/*统计新加*/
//交易手数
Route::get('/TradeDetailsExcel',function(StatisticsRepository $repository){
    $begin= $_GET['begin'];
    $end=   $_GET['end'];

    if (!$begin || !$end) {
        $end= date('Y-m-d', Carbon::now()->getTimestamp());
       // $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->getTimestamp());
    }
    $begin=str_replace('/','-',$begin);
    $end=str_replace('/','-',$end);

    $result= $repository->GetTranscationnewExcel($begin,$end);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '日期'=>$result[$i]->date,
            '交易人数'=>($result[$i]->totalperson==null)?"0":$result[$i]->totalperson.'',
            '成交总量'=>$result[$i]->match_amount,

            '黄金延期开多'=>$result[$i]->au1,
            '黄金延期开空'=>$result[$i]->au2,
            '黄金延期平多'=>$result[$i]->au3,
            '黄金延期平空'=>$result[$i]->au4,

            '白银延期开多'=>$result[$i]->ag1,
            '白银延期开空'=>$result[$i]->ag2,
            '白银延期平多'=>$result[$i]->ag3,
            '白银延期平空'=>$result[$i]->ag4,

            'MiNi黄金延期延期开多'=>$result[$i]->mau1,
            'MiNi黄金延期延期开空'=>$result[$i]->mau2,
            'MiNi黄金延期延期平多'=>$result[$i]->mau3,
            'MiNi黄金延期延期平空'=>$result[$i]->mau4
        ]);
    }
    Excel::create('交易人数', function($excel) use($array){
        $excel->sheet('交易人数', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
//当日交易查询
Route::get('/CurrenttradeExcel',function(StatisticsRepository $repository){

    $bp=$_GET['bp'];
    $bc=$_GET['bc'];
    $instid=$_GET['instid'];
    $insttype=$_GET['insttype'];
    $phone=$_GET['phone'];
    $brokercode=$_GET['brokercode'];
    $date=$_GET['date'];
    $parentid=$_GET['parentid'];

    $result=  $repository->GetTradeDataExcel($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid);
    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '交易日期'=>$result[$i]->exch_date,
            '客户手机'=>$result[$i]->phone==null?"暂无":$result[$i]->phone,
            '客户姓名'=>$result[$i]->real_name==null?"暂无":$result[$i]->real_name,
            '客户经理'=>$result[$i]->broker_name==null?"暂无":$result[$i]->broker_name,
            '单位名称'=>$result[$i]->branch_name==null?"暂无":$result[$i]->branch_name,
            '合约代码'=>ConvertContractName($result[$i]->inst_id),
            '交易类型'=>ConvertExchType($result[$i]->exch_type),
            '成交价格'=>$result[$i]->match_price,
            '成交数量'=>$result[$i]->match_amount,
            '成交金额'=>$result[$i]->exch_bal,
            '保证金'=>$result[$i]->margin,
            '交易费'=>$result[$i]->exch_fare
        ]);
    }
    Excel::create('当日交易', function($excel) use($array){
        $excel->sheet('当日交易', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
//历史交易查询
Route::get('/HistorytradeExcel',function(StatisticsRepository $repository){
    $bp=$_GET['bp'];
    $bc=$_GET['bc'];
    $instid=$_GET['instid'];
    $insttype=$_GET['insttype'];
    $phone=$_GET['phone'];
    $brokercode=$_GET['brokercode'];
    $begin=$_GET['begin'];
    $end=$_GET['end'];
    $parentid=$_GET['parentid'];

    $result=  $repository->GetHistoryTradeDataExcel($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid);
    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '交易日期'=>$result[$i]->exch_date,
            '客户手机'=>$result[$i]->phone==null?"暂无":$result[$i]->phone,
            '客户姓名'=>$result[$i]->real_name==null?"暂无":$result[$i]->real_name,
            '客户经理'=>$result[$i]->broker_name==null?"暂无":$result[$i]->broker_name,
            '单位名称'=>$result[$i]->branch_name==null?"暂无":$result[$i]->branch_name,
            '合约代码'=>ConvertContractName($result[$i]->inst_id),
            '交易类型'=>ConvertExchType($result[$i]->exch_type),
            '成交价格'=>$result[$i]->match_price,
            '成交数量'=>$result[$i]->match_amount,
            '成交金额'=>$result[$i]->exch_bal,
            '保证金'=>$result[$i]->margin,
            '交易费'=>$result[$i]->exch_fare
        ]);
    }
    Excel::create('历史交易', function($excel) use($array){
        $excel->sheet('历史交易', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');

});
//历史交易查询
Route::get('/TotalAssetsExcel',function(StatisticsRepository $repository){
    $bp=$_GET['bp'];
    $bc=$_GET['bc'];
    $phone=$_GET['phone'];
    $brokercode=$_GET['brokercode'];
    $begin=$_GET['begin'];
    $end=$_GET['end'];
    $parentid=$_GET['parentid'];

    $result=  $repository->GetTotalAssetsExcel($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);
    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '交易日期'=>$result[$i]->exch_date,
            '客户手机'=>$result[$i]->app_identifier==null?"暂无":$result[$i]->app_identifier,
            '客户姓名'=>$result[$i]->real_name==null?"暂无":$result[$i]->real_name,
            '客户经理'=>$result[$i]->broker_name==null?"暂无":$result[$i]->broker_name,
            '单位名称'=>$result[$i]->branch_name==null?"暂无":$result[$i]->branch_name,
            '上日余额'=>$result[$i]->last_bal,
            '上日可用'=>$result[$i]->last_can_use,
            '当日余额'=>$result[$i]->curr_bal,
            '当日可用'=>$result[$i]->curr_can_use,
            '占用保证'=>$result[$i]->bzj==null?"0.00".'':$result[$i]->bzj,
            '交易费用'=>$result[$i]-> real_exch_fare==null?'0.00'.'':$result[$i]->real_exch_fare,
            '其他费用'=>$result[$i]->other_fare==null?'0.00'.'':$result[$i]->other_fare,
            '盯市盈亏'=>$result[$i]->mark_surplus==null?'0.00'.'':$result[$i]->mark_surplus
        ]);
    }
    Excel::create('总资产查询', function($excel) use($array){
        $excel->sheet('总资产查询', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');

});
//当日出入金
Route::get('/CurrentAssetsExcel',function(StatisticsRepository $repository){
    $bp=$_GET['bp'];
    $bc=$_GET['bc'];
    $phone=$_GET['phone'];
    $brokercode=$_GET['brokercode'];
    $date=$_GET['date'];
    $parentid=$_GET['parentid'];
    $result= $repository->GetCurrentAssetsExcel($bp,$bc,$phone,$brokercode,$date,$parentid);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '出入金时间'=>$result[$i]->o_date,
            '客户手机'=>$result[$i]->phone==null?"暂无":$result[$i]->phone,
            '银行账号'=>$result[$i]->bank_num==null?"暂无":$result[$i]->bank_num,
            '客户经理'=>$result[$i]->broker_name==null?"暂无":$result[$i]->broker_name,
            '单位名称'=>$result[$i]->branch_name==null?"暂无":$result[$i]->branch_name,
            '客户姓名'=>$result[$i]->name==null?"暂无":$result[$i]->name ,
            '出入金方向'=>$result[$i]->access_way==1?"存入":"取出",
            '金额'=>$result[$i]->exch_bal,
            '是否到账'=>$result[$i]->in_account_flag==1?"是":"否"
        ]);
    }
    Excel::create('当日出入金', function($excel) use($array){
        $excel->sheet('当日出入金', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
//当日出入金
Route::get('/HistoryAssetsExcel',function(StatisticsRepository $repository){
    $bp=$_GET['bp'];
    $bc=$_GET['bc'];
    $phone=$_GET['phone'];
    $brokercode=$_GET['brokercode'];
    $begin=$_GET['begin'];
    $end=$_GET['end'];

    $parentid=$_GET['parentid'];

    $result= $repository->GetHistoryAssetsExcel($bp,$bc,$phone,$brokercode,$begin,$end,$parentid);

    $array=array();
    for($i=0;$i<count($result);$i++) {
        array_push($array,[
            '出入金时间'=>$result[$i]->o_date,
            '客户手机'=>$result[$i]->phone==null?"暂无":$result[$i]->phone,
            '银行账号'=>$result[$i]->bank_num==null?"暂无":$result[$i]->bank_num,
            '客户经理'=>$result[$i]->broker_name==null?"暂无":$result[$i]->broker_name,
            '单位名称'=>$result[$i]->branch_name==null?"暂无":$result[$i]->branch_name,
            '客户姓名'=>$result[$i]->name==null?"暂无":$result[$i]->name ,
            '出入金方向'=>$result[$i]->access_way==1?"存入":"取出",
            '金额'=>$result[$i]->exch_bal,
            '是否到账'=>$result[$i]->in_account_flag==1?"是":"否"
        ]);
    }
    Excel::create('历史出入金', function($excel) use($array){
        $excel->sheet('历史出入金', function($sheet) use($array) {
            $sheet->fromArray($array);
            $sheet->setOrientation('landscape');
        });
    })->export('xls');
});
//*交易类型*/
function ConvertExchType($exch_type)
{
    switch($exch_type) {
        case 1:return '开多仓';
        case 2:return '开空仓';
        case 3:return '平多仓';
        case 4:return '平空仓';
        default:return '未知交易类型';
    }
}
///*合约代码*/
function ConvertContractName($instid)
{
    switch($instid) {
        case 1:return 'Au(T+D)';
        case 2:return 'Ag(T+D)';
        case 3:return 'mAu(T+D)';
        default:return '未知合约';
    }
}
/*测试*/
Route::get('/test',function(StatisticsRepository $repository){
    //return $repository->GetHistoryTradeData('','','','','','','2017-02-01','2017-02-22');

    //return $repository->GetHistoryTradeData('','','','','','','2017-03-01','2017-03-30');

  //  $result= $repository->GetAllOnlineData('2017-03-01','2017-03-31');
   // $key= array_keys($result);
  // return $key;

    //return $repository->GetHistoryAssets('','','','','2017-04-01','2017-04-05');

    return $repository->GetTotalcurrentassets('','','','','2017-03-01');
});
