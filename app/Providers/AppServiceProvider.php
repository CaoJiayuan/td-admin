<?php

namespace App\Providers;

use App\Entity\NewsComments;
use App\Entity\ScoopComments;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      \Validator::extend('mobile', function ($attribute, $value, $parameters) {
        if ($value == '') {
          return true;
        }
        return preg_match("/^1[0-9]{2}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $value);
      }, '请输入正确的手机号');
      Relation::morphMap([
        NewsComments::class,ScoopComments::class
      ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
