<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/5
 * Time: 23:16
 **/

namespace App\Repository;

use App\Entity\Disclaimer;
use App\Traits\Uploads;

class DisclaimerRepository extends Repository
{
    use Uploads;
    public function getDisclaimer()
    {
        if (!Disclaimer::where('keyWords', '免责声明')->first()) {
            Disclaimer::create([
                'title' => '免责声明',
                'keyWords' => '免责声明',
                'content' => '金生金是一款超级无敌炒股软件!'
            ]);
        } else {
            return Disclaimer::where('keyWords', '免责声明')->first();
            }
    }

    public function editDisclaimer($data, $id)
    {
        Disclaimer::where('id', $id)->update([
        'content' => $this-> decodeBase64Image($data['content'])
        ]);
    }
}