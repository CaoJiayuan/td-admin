<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBrokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('brokers', function (Blueprint $table) {
        $table->unsignedTinyInteger('sex')->default(1)->comment('性别（0-男，1-女）');
        $table->string('cred_num', 20)->comment('身份证号');
        $table->string('address')->nullable()->comment('联系地址');
        $table->string('zip_code',10)->nullable()->comment('邮编');
        $table->string('phone',20)->comment('手机号码');
        $table->string('mobile',20)->nullable()->comment('联系电话');
        $table->string('fax')->nullable()->comment('传真号码');
        $table->string('email')->nullable()->comment('电子邮箱');
        $table->string('operator_code',20)->comment('运营商编号');
        $table->string('original_broker_id',20)->comment('用户输入的原始客户经理id');
        $table->text('remark')->nullable()->comment('备注');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('brokers', function (Blueprint $table) {
        $table->dropColumn([
          'sex',
          'cred_num',
          'address',
          'zip_code',
          'phone',
          'mobile',
          'fax',
          'email',
          'operator_code',
          'original_broker_id',
          'remark'
        ]);
      });
    }
}
