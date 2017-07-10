<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */
namespace App\Repository;
use App\Entity\User;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\SQLAnywhere16Platform;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
class StatisticsRepository extends Repository
{
    //获取在线人数统计
    public function GetonlineStat($begin,$end)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        }
        $data = \Request::only([
            'order', 'page_size','page'
        ]);

        list($order, $pageSize, $page) = array_values($data);

        $orderArr = explode('|', $order, 2);

        list($o, $d) = [array_get($orderArr, 0) ?: 'tbl.date', array_get($orderArr, 1) ?: 'desc'];

        $count =  (strtotime($end) - strtotime($begin)) / (3600 *24) + 1;

        $page = $page  ?: 1;
        $offset = ($page-1)*10;
        $sql = <<<SQL
            select tbl.date,sum(ifnull(pum.online_numbers,0)) as num  from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            left join
            (select *from protoss_user_mq_online as pmo where pmo.current_times >='$begin' and pmo.current_times<='$end')  as pum
            on DATE_FORMAT( pum.current_times, '%Y-%m-%d')=tbl.date
            group by  tbl.date
            ORDER BY $o $d
            limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);

        return new LengthAwarePaginator($results, $count, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'begin' => $begin,
                    'end' =>$end
                ]),
            'pageName' => 'page',
        ]);


    }
    //获取注册页面
    public function getRegisterStat($begin,$end)
    {

        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
           // $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());

            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $data = \Request::only([
            'order', 'page_size','page'
        ]);

        list($order, $pageSize, $page) = array_values($data);

        $orderArr = explode('|', $order, 2);

        list($o, $d) = [array_get($orderArr, 0) ?: 'tbl.date', array_get($orderArr, 1) ?: 'desc'];

        $count =  (strtotime($end) - strtotime($begin)) / (3600 *24) + 1;


        $page = $page  ?: 1;
        $offset = ($page-1)*10;
        $sql = <<<SQL
            select
            tbl.date,
	    (select count(*) from protoss_user_auth as pu where  DATE_FORMAT(pu.create_time, '%Y-%m-%d')=tbl.date) as num
            from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            ORDER BY $o $d
            limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $count, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'begin' => $begin,
                    'end' =>$end
                ]),
            'pageName' => 'page',
        ]);
    }
    //获取注册信息详情
    public function getRegisterStatDetails($date)
    {
        $data = \Request::only([
            'order', 'page_size','page'
        ]);

        list($order, $pageSize, $page) = array_values($data);

        $orderArr = explode('|', $order, 2);

        list($o, $d) = [array_get($orderArr, 0) ?: 'pua.create_time', array_get($orderArr, 1) ?: 'desc'];

        $countsql=<<<SQL
        select count(*) as total from protoss_user_auth as pua where DATE_FORMAT(create_time, '%Y-%m-%d')='$date'
SQL;
        $array = DB::connection()->select($countsql);

       $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select
            create_time,
            app_identifier,
            (select nick_name from protoss_user as pu where pu.id=pua.user_id) as real_name
            from protoss_user_auth as pua where DATE_FORMAT(create_time, '%Y-%m-%d')='$date'
            ORDER BY $o $d
            limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);

        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'date' =>$date
                ]),
            'pageName' => 'page',
        ]);

    }
    //获取开户统计列表信息
    public function GetOpenStat($begin,$end)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());

            $begin= date('Y-m-d', Carbon::now()->getTimestamp());

        }

        $data = \Request::only([
            'order', 'page_size','page'
        ]);

        list($order, $pageSize, $page) = array_values($data);
        $orderArr = explode('|', $order, 2);
        list($o, $d) = [array_get($orderArr, 0) ?: 'tbl.date', array_get($orderArr, 1) ?: 'desc'];
        $count =  (strtotime($end) - strtotime($begin)) / (3600 *24) + 1;

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
	    select
               tbl.date,
	    (select count(*) from protoss_gold_account as pga where pga.gold_num!='' and  DATE_FORMAT(pga.create_time, '%Y-%m-%d')=tbl.date) as num
            from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            ORDER BY $o $d
            limit $offset,10
SQL;


        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $count, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'begin' => $begin,
                    'end' =>$end
                ]),
            'pageName' => 'page',
        ]);
    }
    //获取开户每日详情
    public function GetOpenStatDetails($date)
    {
        $data = \Request::only([
            'order', 'page_size','page'
        ]);
        list($order, $pageSize, $page) = array_values($data);
        $orderArr = explode('|', $order, 2);
        list($o, $d) = [array_get($orderArr, 0) ?: 'pga.create_time', array_get($orderArr, 1) ?: 'desc'];
        $countsql=<<<SQL
        select count(*) as total from protoss_gold_account  where DATE_FORMAT(create_time, '%Y-%m-%d')='$date' and gold_num!=''
SQL;
        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select
            pga.user_id,
            create_time,
            (select app_identifier from protoss_user_auth as pua where pua.user_id=pga.user_id) as app_identifier,
            pga.name as real_name,
            (select  broker_name from protoss_brokers as pb where pb.broker_id=pga.broker_list) as broker_name
            from protoss_gold_account as pga where DATE_FORMAT(create_time, '%Y-%m-%d')='$date' and pga.gold_num!=''
            ORDER BY $o $d
            limit $offset,10
SQL;
        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'date' =>$date
                ]),
            'pageName' => 'page',
        ]);

    }
    //获取交易数量统计(old)
    public  function  GetTranscation($begin,$end)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
        }
        $data = \Request::only([
            'order', 'page_size','page'
        ]);
        list($order, $pageSize, $page) = array_values($data);
        $orderArr = explode('|', $order, 2);
        list($o, $d) = [array_get($orderArr, 0) ?: 'tbl.date', array_get($orderArr, 1) ?: 'desc'];
        $count =  (strtotime($end) - strtotime($begin)) / (3600 *24) + 1;
        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
	     select tbl.date as date,
	    (select count(*) from protoss_defer_match as pdm where  DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')=tbl.date ) as num
	     from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            ORDER BY $o $d
            limit $offset,10
SQL;
        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $count, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'begin' => $begin,
                    'end' =>$end
                ]),
            'pageName' => 'page',
        ]);


    }
    //获取交易详情(old)
    public  function  GetTranDetails($date)
    {
        $data = \Request::only([
            'order', 'page_size','page'
        ]);
        list($order, $pageSize, $page) = array_values($data);
        $orderArr = explode('|', $order, 2);
        list($o, $d) = [array_get($orderArr, 0) ?: 'exch_date', array_get($orderArr, 1) ?: 'desc'];
        $countsql=<<<SQL
select count(*) as total from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d') ='$date'
SQL;
        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
select
pdm.user_id,
pdm.exch_date,
(select app_identifier from protoss_user_auth as pua where pua.user_id=pdm.user_id) as app_identifier,
(select name from protoss_gold_account as pga where pga.id=pdm.gold_id) as relyname,
inst_id,exch_type,match_price,match_amount,exch_bal,
(select  broker_name from protoss_brokers as pb where pb.broker_id=
(select broker_list from protoss_gold_account as pga where pga.id=pdm.gold_id)
)as broker_name
from protoss_defer_match as pdm where  DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') ='$date'
ORDER BY $o $d
limit $offset,10
SQL;
        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'date' =>$date
                ]),
            'pageName' => 'page',
        ]);
    }
    //获取交易数量统计(new)
    public function GetTranscationnew($begin,$end)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }


        $data = \Request::only([
            'order', 'page_size','page'
        ]);
        list($order, $pageSize, $page) = array_values($data);
        $orderArr = explode('|', $order, 2);
        list($o, $d) = [array_get($orderArr, 0) ?: 'tbl.date', array_get($orderArr, 1) ?: 'desc'];
        $count =  (strtotime($end) - strtotime($begin)) / (3600 *24) + 1;
        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
	 select tbl.date,
        (select count(distinct user_id)from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date)  as totalperson,
	(select ifnull(sum(match_amount),0) from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date)  as match_amount,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=1) as au1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=2) as au2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=3) as au3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=4) as au4,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=1) as ag1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=2) as ag2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=3) as ag3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=4) as ag4,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=1) as mau1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=2) as mau2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=3) as mau3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=4) as mau4
	from
           (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
           FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            ORDER BY $o $d
            limit $offset,10
SQL;
        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $count, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query([
                    'begin' => $begin,
                    'end' =>$end
                ]),
            'pageName' => 'page',
        ]);

    }
    //获取交易详情(new)
    public function GetTranDetailsnew($date)
    {

    }
    //导出在线excel
    public function GetOnlineExcel($begin,$end)
    {
        $sql=<<<SQL
            select tbl.date,sum(ifnull(pum.online_numbers,0)) as num  from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            left join
            (select *from protoss_user_mq_online as pmo where pmo.current_times >='$begin' and pmo.current_times<='$end')  as pum
            on DATE_FORMAT( pum.current_times, '%Y-%m-%d')=tbl.date
            group by  tbl.date
SQL;
        return DB::connection()->select($sql);

    }
    //导出注册excel
    public function GetRegisterExcel($begin,$end)
    {
        $sql=<<<SQL
            select
               tbl.date,count(pu.id) as num
            from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end')
            as tbl left join  protoss_user as pu on DATE_FORMAT(pu.create_time, '%Y-%m-%d')=tbl.date
            group by tbl.date
SQL;
        return DB::connection()->select($sql);
    }
    //导出开户excel
    public function GetOpenExcel($begin,$end)
    {
        $sql=<<<SQL
            select
               tbl.date,count(pga.id) as num
            from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            left join (select *from protoss_gold_account where gold_num!='' and create_time>='$begin' and create_time <='$end') as pga
	        on DATE_FORMAT(pga.create_time, '%Y-%m-%d')=tbl.date
	        group by tbl.date
SQL;
        return DB::connection()->select($sql);
    }
    //导出交易excel
    public function GetTradeExcel($begin,$end)
    {
        $sql=<<<SQL
            select tbl.date as date,count(*) num from
            (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
            left join
            (select *from protoss_defer_match where exch_date>='$begin' and exch_date<='$end' ) as pdm
            on  tbl.date=DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')
            group by tbl.date
SQL;
        return DB::connection()->select($sql);
    }

    /*新导出excel====*/
    public function  GetTranscationnewExcel($begin,$end)
    {


        $sql=<<<SQL
    select tbl.date,
    (select ifnull(count(distinct user_id),0) from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date)  as totalperson,
	(select ifnull(sum(match_amount),0) from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date)  as match_amount,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=1) as au1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=2) as au2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=3) as au3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=1 and exch_type=4) as au4,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=1) as ag1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=2) as ag2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=3) as ag3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=2 and exch_type=4) as ag4,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=1) as mau1,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=2) as mau2,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=3) as mau3,
	(select  ifnull(sum(match_amount),0)   from protoss_defer_match where DATE_FORMAT(exch_date, '%Y-%m-%d')=tbl.date and inst_id=3 and exch_type=4) as mau4
	from
    (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
    FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
SQL;
        return DB::connection()->select($sql);
    }
    //当日交易查询
    public function GetTradeDataExcel($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid)
    {
        //$date='2017-02-16';
        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';

        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0'){
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($instid!='0' && $instid!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.inst_id='.$instid;
            }
            else{
                $condition=$condition.' and pdm.inst_id='.$instid;
            }
        }
        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
            select pdm.exch_date,pua.app_identifier as phone, pga.name as real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type,pdm.match_price,pdm.match_amount,pdm.exch_bal,pdm.margin,pdm.exch_fare
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')='$date' $condition
            order by pdm.exch_date desc
SQL;
       return \DB::connection()->select($sql);
    }
    //获取历史交易查询
    public function  GetHistoryTradeDataExcel($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
           // $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }

        $condition='';
        /*
      if($bp!='0' && $bp!=''){
          $condition=$condition."(pbs.branch_id='$bp'";
      }

      if($bc!='0' && $bc!=''){
          if($condition==''){
              $condition=$condition."(pbs.branch_id='$bc'";
          }else{
              $condition=$condition." and pbs.branch_id='$bc'";
          }
      }
      */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($instid!='0' && $instid!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.inst_id='.$instid;
            }
            else{
                $condition=$condition.' and pdm.inst_id='.$instid;
            }
        }
        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
            select DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') as exch_date,pua.app_identifier as phone,pga.name as real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type,sum(pdm.match_price) as match_price,sum(pdm.match_amount) as match_amount,sum(pdm.exch_bal) as exch_bal,sum(pdm.margin) as margin,sum(pdm.exch_fare) as exch_fare
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
	        where  pdm.exch_date>='$begin' and pdm.exch_date<='$end' $condition
            group by  DATE_FORMAT(pdm.exch_date, '%Y-%m-%d'),pu.phone,pu.real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type
            order by DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') desc
SQL;
        return \DB::connection()->select($sql);

    }
    //总资产导出
    public function GetTotalAssetsExcel($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
           // $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */


        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }
        $sql=<<<SQL
            select
            pub.exch_date,pga.name as real_name,pua.app_identifier,pb.broker_name,pbs.branch_name,
            sum(last_bal) as last_bal,sum(last_can_use) as last_can_use,sum(curr_bal) as curr_bal,sum(curr_can_use) as curr_can_use,
            0 as bzj,sum(real_exch_fare) as real_exch_fare,sum(other_fare) as other_fare,sum(mark_surplus) as mark_surplus
            from protoss_user_bal as pub
            left join protoss_user as pu on pub.user_id=pu.id
              left join protoss_gold_account as pga on pga.id=pub.gold_id
            left join protoss_user_auth as pua on pua.user_id=pub.user_id
            left join protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where pub.exch_date>='$begin' and pub.exch_date<='$end'  $condition
            group by pub.exch_date,pu.real_name,pua.app_identifier,pb.broker_name,pbs.branch_name
            order by   pub.exch_date desc
SQL;
        return \DB::connection()->select($sql);

    }
    //获取当前日期资产
    public function GetCurrentAssetsExcel($bp,$bc,$phone,$brokercode,$date,$parentid)
    {
        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }

        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pb.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pb.branch_id='$bc'";
            }else{
                $condition=$condition." and pb.branch_id='$bc'";
            }
        }
        */
        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pu.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pu.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
                select
                pu.phone,pga.bank_num,pb.broker_name,pbs.branch_name,pmr.o_date,pga.name,pmr.access_way,pmr.exch_bal,pmr.in_account_flag
                from protoss_money_record as pmr
                left join protoss_user as pu on pmr.user_id=pu.id
                left join protoss_gold_account as pga on pmr.gold_id=pga.id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where DATE_FORMAT(pmr.o_date, '%Y-%m-%d')='$date' $condition
                order by pmr.o_date desc
SQL;
        return \DB::connection()->select($sql);
    }
    //获取历史资产Excel导出
    public function GetHistoryAssetsExcel($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }*/
        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
            select
            pu.phone,pga.bank_num,pb.broker_name,pbs.branch_name,o_date,pga.name,pmr.access_way,pmr.exch_bal,pmr.in_account_flag
            from protoss_money_record as pmr
            left join protoss_user as pu on pmr.user_id=pu.id
            left join protoss_gold_account as pga on pmr.gold_id=pga.id
            left join protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where pmr.o_date>='$begin' and pmr.o_date<='$end' $condition
            order by pmr.o_date desc
SQL;
        return \DB::connection()->select($sql);
    }
    /*新导出excel====*/


    //获取交易统计数据信息
    public function GetTradeData($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid)
    {
        $data = \Request::only([
            'order', 'page_size','page'
        ]);
        list($order, $pageSize, $page) = array_values($data);
        //$date='2017-02-16';
        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';


        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */


        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($instid!='0' && $instid!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.inst_id='.$instid;
            }
            else{
                $condition=$condition.' and pdm.inst_id='.$instid;
            }
        }

        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                 $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                 $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }


        //统计
        $countsql=<<<SQL
            select count(*) as total
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')='$date' $condition
SQL;


            //dd($countsql);

        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select pdm.user_id,pdm.exch_date,pua.app_identifier as phone, pga.name as real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type,pdm.match_price,pdm.match_amount,pdm.exch_bal,pdm.margin,pdm.exch_fare
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')='$date' $condition
            order by pdm.exch_date desc
            limit $offset,10
SQL;
            //dd($sql);

        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query(\Request::all()),
            'pageName' => 'page',
        ]);

    }
    //获取你是交易数据统计
    public function GetHistoryTradeData($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid)
    {

        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $begin=$begin.' 00:00';
        $end=$end.' 23:59';

        $data = \Request::only([
            'page_size','page'
        ]);

        list( $pageSize, $page) = array_values($data);

        $condition='';

        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($instid!='0' && $instid!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.inst_id='.$instid;
            }
            else{
                $condition=$condition.' and pdm.inst_id='.$instid;
            }
        }
        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
          select count(*) as total from(
                select DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') as exch_date,pua.app_identifier as phone, pga.name as real_name,pb.broker_name,pbs.branch_name,
                pdm.inst_id,pdm.exch_type,sum(pdm.match_price) as match_price,sum(pdm.match_amount) as match_amount,sum(pdm.exch_bal) as exch_bal,sum(pdm.margin) as margin,sum(pdm.exch_fare) as exch_fare
                from protoss_defer_match as pdm
                left join   protoss_user as pu on pdm.user_id=pu.id
                left join   protoss_gold_account as pga on pdm.gold_id=pga.id
                left join   protoss_user_auth as pua on pdm.user_id=pua.user_id
                left join  protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where  pdm.exch_date>='$begin' and pdm.exch_date<='$end' $condition
                group by  DATE_FORMAT(pdm.exch_date, '%Y-%m-%d'),pu.phone,pu.real_name,pb.broker_name,pbs.branch_name,
                pdm.inst_id,pdm.exch_type
        ) as tbl
SQL;
        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select pdm.user_id,DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') as exch_date,pua.app_identifier as phone,pga.name as real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type,sum(pdm.match_price) as match_price,sum(pdm.match_amount) as match_amount,sum(pdm.exch_bal) as exch_bal,sum(pdm.margin) as margin,sum(pdm.exch_fare) as exch_fare
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
	        where  pdm.exch_date>='$begin' and pdm.exch_date<='$end' $condition
            group by  DATE_FORMAT(pdm.exch_date, '%Y-%m-%d'),pu.phone,pu.real_name,pb.broker_name,pbs.branch_name,
            pdm.inst_id,pdm.exch_type
            order by DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') desc
            limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query(\Request::all()),
            'pageName' => 'page',
        ]);


    }
    //获取总资产
    public function GetTotalAssets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $data = \Request::only([
            'page_size','page'
        ]);
        list( $pageSize, $page) = array_values($data);

        $condition='';
        /*
       if($bp!='0' && $bp!=''){
           $condition=$condition."(pbs.branch_id='$bp'";
       }
       if($bc!='0' && $bc!=''){
           if($condition==''){
               $condition=$condition."(pbs.branch_id='$bc'";
           }else{
               $condition=$condition." and pbs.branch_id='$bc'";
           }
       }
       */


        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
            select count(*) as total from (
                select
                pub.exch_date,pga.name as real_name,pua.app_identifier,pb.broker_name,pbs.branch_name
                from protoss_user_bal as pub
                left join protoss_user as pu on pub.user_id=pu.id
                left join protoss_gold_account as pga on pga.id=pub.gold_id
                left join protoss_user_auth as pua on pua.user_id=pub.user_id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where pub.exch_date>='$begin' and pub.exch_date<='$end' $condition
                group by pub.exch_date,pu.real_name,pua.app_identifier,pb.broker_name,pbs.branch_name
            ) as tbl
SQL;

        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);

        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select
            pub.user_id,pub.exch_date,pga.name as real_name,pua.app_identifier,pb.broker_name,pbs.branch_name,
            sum(last_bal) as last_bal,sum(last_can_use) as last_can_use,sum(curr_bal) as curr_bal,sum(curr_can_use) as curr_can_use,
            0 as bzj,sum(real_exch_fare) as real_exch_fare,sum(other_fare) as other_fare,sum(mark_surplus) as mark_surplus
            from protoss_user_bal as pub
            left join protoss_user as pu on pub.user_id=pu.id
            left join protoss_gold_account as pga on pga.id=pub.gold_id
            left join protoss_user_auth as pua on pua.user_id=pub.user_id
            left join protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where pub.exch_date>='$begin' and pub.exch_date<='$end'  $condition
            group by pub.user_id,pub.exch_date,pu.real_name,pua.app_identifier,pb.broker_name,pbs.branch_name
            order by   pub.exch_date desc
            limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query(\Request::all()),
            'pageName' => 'page',
        ]);
    }
    //获取当日出入金数据
    public function GetCurrentAssets($bp,$bc,$phone,$brokercode,$date,$parentid)
    {
        $data = \Request::only([
            'page_size','page'
        ]);
        list($pageSize, $page) = array_values($data);

        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pb.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pb.branch_id='$bc'";
            }else{
                $condition=$condition." and pb.branch_id='$bc'";
            }
        }*/

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
                select
                count(*) as total
                from protoss_money_record as pmr
                left join protoss_user as pu on pmr.user_id=pu.id
                left join protoss_gold_account as pga on pmr.gold_id=pga.id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where DATE_FORMAT(pmr.o_date, '%Y-%m-%d')='$date' $condition
SQL;
        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);
        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
                select
                pmr.user_id,pu.phone,pga.bank_num,pb.broker_name,pbs.branch_name,pmr.o_date,pga.name,pmr.access_way,pmr.exch_bal,pmr.in_account_flag
                from protoss_money_record as pmr
                left join protoss_user as pu on pmr.user_id=pu.id
                left join protoss_gold_account as pga on pmr.gold_id=pga.id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where DATE_FORMAT(pmr.o_date, '%Y-%m-%d')='$date' $condition
                order by pmr.o_date desc
                limit $offset,10
SQL;

        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query(\Request::all()),
            'pageName' => 'page',
        ]);

    }
    //获取历史出入金数据
    public function  GetHistoryAssets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $begin=$begin.' 00:00';
        $end=$end.' 23:59';

        $data = \Request::only([
            'page_size','page'
        ]);
        list( $pageSize, $page) = array_values($data);

        $condition='';

        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
            select
            count(*) as total
            from protoss_money_record as pmr
            left join protoss_user as pu on pmr.user_id=pu.id
            left join protoss_gold_account as pga on pmr.gold_id=pga.id
            left join protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where pmr.o_date>='$begin' and pmr.o_date<='$end' $condition
SQL;
        $array = DB::connection()->select($countsql);
        $alltotal= intval($array[0]->total);
        $page = $page  ?: 1;
        $offset = ($page-1)*10;

        $sql=<<<SQL
            select
            pmr.user_id,pu.phone,pga.bank_num,pb.broker_name,pbs.branch_name,o_date,pga.name,pmr.access_way,pmr.exch_bal,pmr.in_account_flag
            from protoss_money_record as pmr
            left join protoss_user as pu on pmr.user_id=pu.id
            left join protoss_gold_account as pga on pmr.gold_id=pga.id
            left join protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where pmr.o_date>='$begin' and pmr.o_date<='$end' $condition
            order by pmr.o_date desc
            limit $offset,10
SQL;
        $results = \DB::connection()->select($sql);
        return new LengthAwarePaginator($results, $alltotal, 10, $page, [
            'path' => Paginator::resolveCurrentPath() .'?' . http_build_query(\Request::all()),
            'pageName' => 'page',
        ]);
    }
    //获取所有在线人数
    public function GetAllOnlineData($begin,$end)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
           // $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());

            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
       // $begin=$begin.' 00:00';
       // $end=$end.' 23:59';


        $sql = <<<SQL
	   select tbl.date,
	   (select ifnull(sum(online_numbers),0) from protoss_user_mq_online as pum where DATE_FORMAT(pum.current_times, '%Y-%m-%d')=tbl.date) as num
	   from
       (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
       FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
SQL;
        $result=DB::connection()->select($sql);
        return $result;
    }


    public function GetTotalcurrenttrade($bp,$bc,$instid,$insttype,$phone,$brokercode,$date,$parentid){

        //$date='2017-03-01';
        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';

        /*
          if($bp!='0' && $bp!=''){
              $condition=$condition."(pbs.branch_id='$bp'";
          }

          if($bc!='0' && $bc!=''){
              if($condition==''){
                  $condition=$condition."(pbs.branch_id='$bc'";
              }else{
                  $condition=$condition." and pbs.branch_id='$bc'";
              }
          }
      */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($instid!='0' && $instid!=''){
          if($condition=='') {
              $condition=$condition.' (pdm.inst_id='.$instid;
          }
          else{
              $condition=$condition.' and pdm.inst_id='.$instid;
          }
      }
        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        //统计
        $countsql=<<<SQL
            select ifnull(sum(exch_bal),0) as totalexch_bal,ifnull(sum(exch_fare),0) as totalfare,ifnull(sum(margin),0) as totalmargin
            from protoss_defer_match as pdm
            left join   protoss_user as pu on pdm.user_id=pu.id
            left join   protoss_gold_account as pga on pdm.gold_id=pga.id
            left join   protoss_user_auth as pua on pu.id=pua.user_id
            left join  protoss_brokers as pb on pu.broker_id=pb.id
            left join protoss_branchs as pbs on pb.branch_id=pbs.id
            where DATE_FORMAT(pdm.exch_date, '%Y-%m-%d')='$date'  $condition
SQL;
        return DB::connection()->select($countsql);
    }
    public function GetTotalhistorytrade($bp,$bc,$instid,$insttype,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $begin=$begin.' 00:00';
        $end=$end.' 23:59';

        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }*/

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($instid!='0' && $instid!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.inst_id='.$instid;
            }
            else{
                $condition=$condition.' and pdm.inst_id='.$instid;
            }
        }
        if($insttype!='0' && $insttype!=''){
            if($condition=='') {
                $condition=$condition.' (pdm.exch_type='.$insttype;
            }
            else{
                $condition=$condition.' and pdm.exch_type='.$insttype;
            }
        }
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
                select ifnull(sum(exch_bal),0) as totalexch_bal,ifnull(sum(pdm.exch_fare),0) as totalfare,ifnull(sum(pdm.margin),0) as totalmargin
                from protoss_defer_match as pdm
                left join   protoss_user as pu on pdm.user_id=pu.id
                left join   protoss_gold_account as pga on pdm.gold_id=pga.id
                left join   protoss_user_auth as pua on pdm.user_id=pua.user_id
                left join  protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where pdm.exch_date>='$begin' and pdm.exch_date<='$end' $condition
SQL;
        return DB::connection()->select($countsql);
    }
    public function GetTotalnumberassets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            //$begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';
        /*
       if($bp!='0' && $bp!=''){
           $condition=$condition."(pbs.branch_id='$bp'";
       }
       if($bc!='0' && $bc!=''){
           if($condition==''){
               $condition=$condition."(pbs.branch_id='$bc'";
           }else{
               $condition=$condition." and pbs.branch_id='$bc'";
           }
       }
       */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }

        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pua.app_identifier='$phone'";
            }
            else{
                $condition=$condition." and pua.app_identifier='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $countsql=<<<SQL
   		        select
   		              ifnull(sum(pub.last_bal),0) as totallastbal,
   		              ifnull(sum(pub.last_can_use),0) as totallastcanuse,
   		              ifnull(sum(pub.curr_bal),0) as totalcurrbal,
   		              ifnull(sum(pub.curr_can_use),0) as totalcurrcanuse,
   		              ifnull(sum(pub.real_exch_fare),0) as totalexchfare,
   		              ifnull(sum(pub.other_fare),0) as totalotherfare,
   		              ifnull(sum(pub.mark_surplus),0) as totalmarksurplus
                from protoss_user_bal as pub
                left join protoss_user as pu on pub.user_id=pu.id
                left join protoss_gold_account as pga on pga.id=pub.gold_id
                left join protoss_user_auth as pua on pua.user_id=pub.user_id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where pub.exch_date>='$begin' and pub.exch_date<='$end'  $condition
SQL;
        return DB::connection()->select($countsql);

    }
    public function GetTotalcurrentassets($bp,$bc,$phone,$brokercode,$date,$parentid)
    {

        if(!$date) {
            $date=  date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pb.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pb.branch_id='$bc'";
            }else{
                $condition=$condition." and pb.branch_id='$bc'";
            }
        }
        */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }


        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
                select
                pmr.access_way,ifnull(sum(pmr.exch_bal),0) as totalexchbal
                from protoss_money_record as pmr
                left join protoss_user as pu on pmr.user_id=pu.id
                left join protoss_gold_account as pga on pmr.gold_id=pga.id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where pmr.in_account_flag=1 and DATE_FORMAT(pmr.o_date, '%Y-%m-%d')='$date'  $condition
		        group by  pmr.access_way
SQL;
       return DB::connection()->select($sql);

    }
    public function GetTotalhistoryassets($bp,$bc,$phone,$brokercode,$begin,$end,$parentid)
    {
        $begin=str_replace('/','-',$begin);
        $end=str_replace('/','-',$end);
        if (!$begin || !$end) {
            $end= date('Y-m-d', Carbon::now()->getTimestamp());
            $begin= date('Y-m-d', Carbon::now()->getTimestamp());
        }
        $begin=$begin.' 00:00';
        $end=$end.' 23:59';
        $condition='';
        /*
        if($bp!='0' && $bp!=''){
            $condition=$condition."(pbs.branch_id='$bp'";
        }
        if($bc!='0' && $bc!=''){
            if($condition==''){
                $condition=$condition."(pbs.branch_id='$bc'";
            }else{
                $condition=$condition." and pbs.branch_id='$bc'";
            }
        }
        */

        //选择了一级和二级,直接查询出二级的
        if($bp!='0' && $bc!='0') {
            $condition=$condition."(pbs.branch_id='$bc'";
        }//选择了一级,没选二级
        else if($bp!='0' && $bc=='0') {
            $condition=$condition."((pbs.id=$parentid or pbs.branch_internal_code like '%./$parentid%') ";
        }
        //电话
        if($phone!='' && $phone!=''){
            if($condition=='') {
                $condition=$condition." (pu.phone='$phone'";
            }
            else{
                $condition=$condition." and pu.phone='$phone'";
            }
        }
        if($brokercode!=''&& $brokercode!=''){
            if($condition=='') {
                $condition=$condition." (pb.broker_id='$brokercode'";
            }
            else{
                $condition=$condition." and pb.broker_id='$brokercode'";
            }
        }
        if($condition!='') {
            $condition=$condition.')';
        }
        if($condition!='') {
            $condition=' and '.$condition;
        }

        $sql=<<<SQL
                select
                pmr.access_way,ifnull(sum(pmr.exch_bal),0) as totalexchbal
                from protoss_money_record as pmr
                left join protoss_user as pu on pmr.user_id=pu.id
                left join protoss_gold_account as pga on pmr.gold_id=pga.id
                left join protoss_brokers as pb on pu.broker_id=pb.id
                left join protoss_branchs as pbs on pb.branch_id=pbs.id
                where pmr.in_account_flag=1 and pmr.o_date>='$begin' and pmr.o_date<='$end'  $condition
		        group by  pmr.access_way
SQL;
        return DB::connection()->select($sql);
    }
}