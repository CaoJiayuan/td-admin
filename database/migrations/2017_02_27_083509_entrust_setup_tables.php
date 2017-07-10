<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return  void
   */
  public function up()
  {
    // Create table for storing roles
    Schema::create('roles', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 50)->unique();
      $table->string('display_name')->nullable();
      $table->string('description')->nullable();
      $table->timestamps();
    });

    // Create table for associating roles to users (Many-to-Many)
    Schema::create('role_admin', function (Blueprint $table) {
      $table->integer('admin_id')->unsigned();
      $table->integer('role_id')->unsigned();

      $table->primary(['admin_id', 'role_id']);
    });

    // Create table for storing permissions
    Schema::create('permissions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 50)->unique();
      $table->string('display_name')->nullable();
      $table->string('description')->nullable();
      $table->string('path', 20)->nullable()->comment('菜单uri');
      $table->string('icon', 20)->nullable();
      $table->integer('parent_id')->default(0)->nullable();
      $table->unsignedTinyInteger('type')->default(0)->comment('类型(0-菜单,1-操作)');
      $table->timestamps();
    });

    // Create table for associating permissions to roles (Many-to-Many)
    Schema::create('permission_role', function (Blueprint $table) {
      $table->integer('permission_id')->unsigned();
      $table->integer('role_id')->unsigned();

      $table->primary(['permission_id', 'role_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return  void
   */
  public function down()
  {
    Schema::drop('permission_role');
    Schema::drop('permissions');
    Schema::drop('role_admin');
    Schema::drop('roles');
  }
}
