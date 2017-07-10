<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/6
 * Time: 22:10
 **/
namespace App\Repository;

use App\Entity\SgeCatalogDetail;
use App\Traits\Uploads;

class SgeCataDetailRepository extends Repository
{
    use Uploads;
    public function getDetail($id)
    {//status = 1 禁用
        return $this->getSearchAbleData(SgeCatalogDetail::class, [
            'id', 'sge_catalog_id', 'question', 'answer', 'status'
        ], function ($builder) use($id) {
                    $builder->where('sge_catalog_id', $id);
            $builder->where('status', '<>', 1)->select([
                'sge_catalogs_details.*'
            ]);
        });
    }

    public function addQuestion($data)
    {
        if (empty($data['question'] && $data['answer'])) {
            return response()->json(['code' => 412, 'errors' => [], 'message' => '问题和答案不能为空'], 412);
        } else if (SgeCatalogDetail::where('question', $data['question'])->first()){
            return response()->json(['code' => 422, 'errors' => [], 'message' => '问题已存在,请勿重复添加'], 422);
        } else {
            SgeCatalogDetail::create([
                'sge_catalog_id' => $data['sge_catalog_id'],
                'question' => $data['question'],
                'answer' => $data['answer']
            ]);
        }
    }

    public function editSgeQuestion($data, $id)
    {
        if (empty($data['question'] && $data['answer'])) {
            return response()->json(['code' => 422, 'errors' => [], 'message' => '问题和答案不能为空'], 422);
        } else if (SgeCatalogDetail::where('question', $data['question'])->find($id) && SgeCatalogDetail::where('answer', $data['answer'])->find($id)) {
            return response()->json(['code' => 422, 'errors' => [], 'message' => '如需编辑,问题或答案请勿重复'], 422);
        } else if (SgeCatalogDetail::where('question', $data['question'])->where('id', '<>', $id)->first()){
            return response()->json(['code' => 422, 'errors' => [], 'message' => '问题已存在'], 422);
        } else {
            SgeCatalogDetail::where('id', $id)->update([
                'question' => $data['question'],
                'answer' => $this->decodeBase64Image($data['answer'])
            ]);
        }
    }

    public function delQuestion($id)
    {
        SgeCatalogDetail::where('id', $id)->delete();
    }
}