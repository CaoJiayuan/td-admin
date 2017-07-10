<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->comment('推送标题');
            $table->text('content')->comment('推送内容');
            $table->dateTime('publish_at')->comment('推送时间');
            $table->string('url',100)->comment('推送链接');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态(0-已删除,1-已创建,2-已推送)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifiations');
    }
}
