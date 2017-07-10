<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;

use App\Entity\LastQuo;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\SQLAnywhere16Platform;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class LastQuoRepository extends Repository
{
    ///获取当前更新数据信息
    public function Getprotosslastquo()
    {
        $sql=' select inst_id,last,up_down,up_rate  from protoss_last_quo where inst_id in(\'Au(T+D)\',\'Ag(T+D)\',\'mAu(T+D)\') ';
        $results = \DB::connection()->select($sql);
        return $results;
    }
    //统计数据信息
    public  function GetStatisticsNum()
    {
          /*1 当日注册人数*/ /*2 当日开户人数*/ /*3 当日交易人数*/ /*4 AU成交手数*/ /*5 AG成交手数*/ /*6 mAu成交手数*/

        $sql=<<<SQL
 select
 (select count(*) from protoss_user  where DATE_FORMAT(create_time, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d'))as registernum,
 (select count(*)  from protoss_gold_account where  DATE_FORMAT(create_time, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d') and  gold_num!='')  as opennum,
 (select count(*)  from (select distinct user_id from protoss_defer_match where  DATE_FORMAT(exch_date, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d')) as tbl )  as tradenum,
 (select sum(match_amount)  from protoss_defer_match where inst_id=1 and DATE_FORMAT(exch_date, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d')) as  audefernum,
 (select sum(match_amount)  from protoss_defer_match where inst_id=2 and DATE_FORMAT(exch_date, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d')) as  agdefernum ,
 (select sum(match_amount)  from protoss_defer_match where inst_id=3 and DATE_FORMAT(exch_date, '%Y-%m-%d')=DATE_FORMAT(now(), '%Y-%m-%d')) as maudefernum
SQL;



        $results = \DB::connection()->select($sql);
        return $results;
    }


    //获取各合约开多开空平多平空等数据
    public function GetExchTypeData()
    {

        $sql = <<<SQL
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=1 and inst_id=1
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=1 and inst_id=2
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=1 and inst_id=3
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=2 and inst_id=1
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=2 and inst_id=2
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=2 and inst_id=3
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=3 and inst_id=1
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=3 and inst_id=2
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=3 and inst_id=3
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=4 and inst_id=1
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=4 and inst_id=2
union all
select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT(now(), '%Y-%m-%d')
and exch_type=4 and inst_id=3
SQL;

        /*
                $sql = <<<SQL
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=1 and inst_id=1
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=1 and inst_id=2
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=1 and inst_id=3
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=2 and inst_id=1
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=2 and inst_id=2
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=2 and inst_id=3
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=3 and inst_id=1
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=3 and inst_id=2
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=3 and inst_id=3
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=4 and inst_id=1
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=4 and inst_id=2
        union all
        select ifnull(sum(match_amount),0)  as match_amount from protoss_defer_match as pdm where
        DATE_FORMAT(pdm.exch_date, '%Y-%m-%d') =DATE_FORMAT('2017-02-22', '%Y-%m-%d')
        and exch_type=4 and inst_id=3
        SQL;
        */


        $result=DB::connection()->select($sql);
        return $result;
    }

}