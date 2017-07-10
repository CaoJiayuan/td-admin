<?php
use App\Entity\AdPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Created by Cao Jiayuan.
 * Date: 17-2-28
 * Time: 下午2:05
 */
class AdPositionSeeder extends Seeder
{
  public function run()
  {
    DB::table('ads')->truncate();
    DB::table('ad_positions')->truncate();
    Model::unguard();
    $position = AdPosition::create([
      'name' => 'banner'
    ]);
    $faker = \Faker\Factory::create('zh_CN');

    \App\Entity\Ad::create([
      'title'          => $faker->text(20),
      'img'            => 'http://id-card-no.oss-cn-shanghai.aliyuncs.com/ads29f96ba24f441f311d4fd064b4d4a0cd',
      'ad_position_id' => $position->id,
      'url'            => 'http://www.baidu.com'
    ]);
    $this->createAds($position, 2);
    $countPos = 3;
    for ($i = 0; $i < $countPos; $i++) {
      $p = AdPosition::create([
        'name' => '广告位置' . ($i + 1)
      ]);
      $this->createAds($p, 2);
    }
    Model::reguard();
  }

  /**
   * @param $position
   * @param int $num
   */
  public function createAds($position,$num = 3)
  {
    $faker = \Faker\Factory::create('zh_CN');
    for ($i = 0; $i < $num; $i++) {
      \App\Entity\Ad::create([
        'title'          => $faker->text(20),
        'img'            => $faker->imageUrl(),
        'ad_position_id' => $position->id,
        'url'            => $faker->url
      ]);
    }
  }
}