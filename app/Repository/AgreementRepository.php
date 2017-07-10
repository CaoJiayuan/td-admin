<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/3
 * Time: 14:32
 **/

namespace App\Repository;

use App\Entity\Agreement;
use App\Traits\Uploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AgreementRepository extends Repository
{
    use Uploads;
    public function getAgreement()
    {
        return $this->getSearchAbleData(Agreement::class, [
            'id', 'title', 'created_at'
        ], function ($builder) {
            $builder->where('keyWords','<>', '免责声明')->select('about.*');
        });
    }

    public function addAgreement($data)
    {
        if (Agreement::where('title', $data['title'])->first()) {
            throw new UnprocessableEntityHttpException('协议名称已存在,请勿重复添加');
        } elseif (empty($data['title'])) {
            throw new UnprocessableEntityHttpException('协议名称不能为空');
        } elseif (empty($data['keyWords'])) {
            throw new UnprocessableEntityHttpException('协议类型不能为空');
        } elseif ($data['type'] == "") {
            throw new UnprocessableEntityHttpException('启用/禁用-状态不能为空');
        } elseif (empty($data['content'])) {
            throw new UnprocessableEntityHttpException('协议内容不能为空');
        }
        Agreement::create([
            'title' => $data['title'],
            'keyWords' => $data['keyWords'],
            'type' => $data['type'],
            'content' => $this->decodeBase64Image($data['content'])
        ]);
    }

    public function editAgreement($data, $id)
    {
        if (Agreement::where('title', $data['title'])->where('id', '<>', $id)->first()) {
            throw new UnprocessableEntityHttpException('注意!协议名称已存在!!!');
        } elseif (empty($data['title'])) {
            throw new UnprocessableEntityHttpException('协议名称不能为空');
        } elseif (empty($data['keyWords'])) {
            throw new UnprocessableEntityHttpException('协议类型不能为空');
        } elseif ($data['type'] === false) {
            throw new UnprocessableEntityHttpException('启用/禁用-状态不能为空');
        } elseif (empty($data['content'])) {
            throw new UnprocessableEntityHttpException('协议内容不能为空');
        } else {
            Agreement::where('id', $id)->update([
                'title' => $data['title'],
                'keyWords' => $data['keyWords'],
                'type' => $data['type'],
                'content' => $this->decodeBase64Image($data['content'])
            ]);
        }
    }

    public function delAgreement($id)
    {
        Agreement::where('id', $id)->delete();
    }
}