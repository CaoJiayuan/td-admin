<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test', function () {
  return env('TD_API_ADDRESS');
});
Route::group(['middleware' => 'api.auth'], function () {
  Route::get('user', 'HomeController@user');

  //广告位管理
  Route::get('adsPosition', 'AdsPositionController@index'); //广告位列表

  //广告管理
  Route::get('at', 'AdsController@index'); //广告列表
  Route::get('at/add', 'AdsController@add'); //添加广告
  Route::post('at/add', 'AdsController@postAds');
  Route::get('at/edit/{id}', 'AdsController@edit'); //编辑广告
  Route::post('at/edit', 'AdsController@postEdit');
  Route::get('at/delete/{id}', 'AdsController@delete');
  Route::get('at/modifyStatus/{id}', 'AdsController@modifyStatus');

  //素材管理
  Route::get('resource', 'ResourceController@index');
  Route::post('resource/add', 'ResourceController@add');
  Route::get('resource/edit/{id}', 'ResourceController@edit');
  Route::post('resource/edit', 'ResourceController@postEdit');
  Route::get('resource/delete/{id}', 'ResourceController@delete');
  Route::get('resource/modifyStatus/{id}', 'ResourceController@modifyStatus');

  //推送管理
  Route::get('notice', 'NoticeController@index');
  Route::get('notice/add', 'NoticeController@add');
  Route::post('notice/add', 'NoticeController@postAdd');
  Route::get('notice/edit/{id}', 'NoticeController@edit');
  Route::post('notice/edit', 'NoticeController@postEdit');
  Route::get('notice/delete/{id}', 'NoticeController@delete');
  Route::get('notice/publish/{id}', 'NoticeController@publish');

  //管理团队
  Route::get('leaders', 'LeadersController@index');
  Route::post('leaders/add', 'LeadersController@add');
  Route::get('leaders/edit/{id}', 'LeadersController@edit');
  Route::post('leaders/edit', 'LeadersController@postEdit');
  Route::get('leaders/modifyStatus/{id}', 'LeadersController@modifyStatus');
  Route::get('leaders/delete/{id}', 'LeadersController@delete');

  //联系我们
  Route::get('contacts', 'ContactsController@index');
  Route::post('contacts/add', 'ContactsController@add');
  Route::get('contacts/edit/{id}', 'ContactsController@edit');
  Route::post('contacts/edit', 'ContactsController@postEdit');
  Route::get('contacts/delete/{id}', 'ContactsController@delete');
  Route::get('contacts/modifyStatus/{id}', 'ContactsController@modifyStatus');

  //加入我们
  Route::get('recruits', 'RecruitsController@index');
  Route::post('recruits/add', 'RecruitsController@add');
  Route::get('recruits/edit/{id}', 'RecruitsController@edit');
  Route::post('recruits/edit', 'RecruitsController@postEdit');
  Route::get('recruits/delete/{id}', 'RecruitsController@delete');
  Route::get('recruits/modifyStatus/{id}', 'RecruitsController@modifyStatus');


  //新闻管理
  Route::get('news/info', 'NewsController@index');//新闻资讯列表
  Route::get('news/newsComments/{id}', 'NewsController@newsComments');//新闻资讯评论
  Route::get('news/flash', 'FlashController@index');//新闻快讯列表
  Route::get('news/scoops', 'ScoopController@index');//独家专栏列表
  Route::get('news/getCategories', 'ScoopController@getCategories');//获取专栏类型
  Route::get('news/comments/{id}', 'ScoopCateController@scoopComments');//专栏评论
  Route::get('news/modifyStatus/{id}', 'NewsController@modifyStatus');
  Route::post('news/createScoop', 'ScoopController@createScoop');//添加专栏
  Route::put('news/updateScoop/{id}', 'ScoopController@editScoop');//修改专栏
  Route::get('news/getScoop/{id}', 'ScoopController@getScoop');//获取专栏评论
  Route::get('news/scoopComments/modifyStatus/{id}', 'ScoopController@modifyStatus');
  Route::get('news/getScoopCate/{id}', 'ScoopController@getScoopCate');//获取专栏类型
  Route::get('news/categories', 'ScoopCateController@index');//专栏类型列表
  Route::delete('news/delScoop/{id}', 'ScoopController@delScoop');//修改专栏类型
  Route::Post('news/addScoopCate', 'ScoopCateController@scoopAdd');//添加专栏类型
  Route::put('news/editScoopCate/{id}', 'ScoopCateController@scoopEdit');//修改专栏类型
  Route::delete('news/delScoopCate/{id}', 'ScoopCateController@scoopDel');//修改专栏类型


  //上金所
  Route::get('sge', 'SgeController@index');//上金所目录
  Route::post('sge/addSgeCate', 'SgeController@addSgeCate');//添加上金所目录
  Route::put('sge/editSgeCate/{id}', 'SgeController@editSgeCate');//添加上金所目录
  Route::delete('sge/delSgeCate/{id}', 'SgeController@delSgeCate');//删除目录
  Route::get('sge/sgeCataDetail/{id}', 'SgeQuestionController@index');// sgeCataDetail
  Route::post('sge/addQuestion', 'SgeQuestionController@questionAdd');//添加问题
  Route::put('sge/editSgeQuestion/{id}', 'SgeQuestionController@questionEdit');
  Route::delete('sge/delQuestion/{id}', 'SgeQuestionController@questionDel'); //删除问题

  //产品管理
  Route::get('products', 'Products\ProductsController@index');
  Route::post('products/addProduct', 'Products\ProductsController@productAdd');
  Route::get('products/edit/{id}', 'Products\ProductsController@editSummary');//获取数据
  Route::put('products/editProduct/{id}', 'Products\ProductsController@productEdit');//产品更新
  Route::delete('products/delProduct/{id}', 'Products\ProductsController@productDel');
  Route::get('products/complaint', 'Products\ProductsController@getComplaint');//获取评论投诉
  Route::post('product/getComments', 'Products\ProductsController@getComments');//获取评论内容
  //免责声明
  Route::get('disclaimer/index', 'DisclaimerController@index');
  Route::put('disclaimer/edit/{id}', 'DisclaimerController@disclaimerEdit');//保存

  //协议
  Route::get('agreement/index', 'AgreementController@index');//协议列表
  Route::post('agreement/addAgreement', 'AgreementController@agreementAdd');//添加协议
  Route::get('agreement/edit/{id}', 'AgreementController@edit');
  Route::put('agreement/editAgreement/{id}', 'AgreementController@agreementEdit');
  Route::delete('agreement/delAgreement/{id}', 'AgreementController@agreementDel');

  //客户管理
  Route::get('account', 'AccountController@index');
  Route::get('account/getBroker/{branch_id}', 'AccountController@getBroker');
  Route::post('account/setBroker', 'AccountController@setBroker');
  Route::get('account/debits/{id}', 'AccountController@debits');
  Route::get('account/capital/{id}', 'AccountController@capital');
  Route::get('account/transfers/{id}', 'AccountController@transfers');
  Route::get('account/getBranches', 'AccountController@getBranches');

  //客服
  Route::get('service/getServices', 'ServiceController@services');//客服列表获取数据
  Route::get('service/getBranches', 'ServiceController@branches');
  Route::post('service/addService', 'ServiceController@serviceAdd');
  Route::any('service/getService/{id}', 'ServiceController@getService');//更新获取数据
  Route::put('service/updateService/{id}', 'ServiceController@postEdit');
  Route::delete('service/serviceDel/{id}', 'ServiceController@delService');
  Route::get('service/showBranch/{id}', 'ServiceController@branchShow');
  Route::get('service/updateBranch', 'ServiceController@brancheUpdate');

  //单位管理
  Route::get('branch', 'BranchController@index');
  Route::get('branch/getParentBranches/{id?}', 'BranchController@getParentBranches');
  Route::post('branch/add', 'BranchController@postAdd');
  Route::get('branch/edit/{id}', 'BranchController@edit');
  Route::post('branch/edit', 'BranchController@postEdit');
  Route::get('branch/delete/{id}', 'BranchController@delete');
  Route::get('branch/modifyStatus/{id}', 'BranchController@modifyStatus');

  //客户经理管理
  Route::get('broker', 'BrokerController@index');
  Route::get('broker/getBranches', 'BrokerController@getBranches');
  Route::post('broker/add', 'BrokerController@postAdd');
  Route::get('broker/edit/{id}', 'BrokerController@edit');
  Route::post('broker/edit', 'BrokerController@postEdit');
  Route::get('broker/delete/{id}', 'BrokerController@delete');
  Route::get('broker/modifyStatus/{id}', 'BrokerController@modifyStatus');

  //反馈管理
  Route::get('feedback', 'FeedbackController@index');


  Route::group(['prefix' => 'permission'], function () {
    Route::get('/navigation', 'PermissionController@navigation');
    Route::get('/permissions', 'PermissionController@permissions');
    Route::get('/tree', 'PermissionController@tree');
    Route::get('/roles', 'PermissionController@roles');
    Route::post('/role', 'PermissionController@postRole');
    Route::delete('/roles/{id}', 'PermissionController@deleteRole');
    Route::get('/roles/{id}', 'PermissionController@role');
    Route::get('/admins', 'PermissionController@admins');
    Route::get('/admins/{id}', 'PermissionController@getAdmin');
    Route::delete('/admins/{id}', 'PermissionController@deleteAdmin');
    Route::post('/admins', 'PermissionController@postAdmin');
    Route::post('/admin', 'PermissionController@editAdmin');
    Route::post('/admin/password', 'PermissionController@setPassword');
  });

  Route::group(['prefix' => 'versions'], function () {
    Route::get('/', 'VersionController@versions');
    Route::get('/types', 'VersionController@getTypes');
    Route::post('/', 'VersionController@postVersion');
    Route::get('/{id}', 'VersionController@getVersion');
    Route::delete('/{id}', 'VersionController@delVersion');
  });

  Route::group(['prefix' => 'Statistics'], function () {
    Route::get('/Dashboard', 'DashboardController@GetData');
    Route::get('/StatisticsNum', 'DashboardController@GetStatisticsNum');
    Route::get('/StatisticsInstId', 'DashboardController@GetStatisticsInstId');


    Route::get('/Register', 'StatisticsController@Register');
    Route::get('/RegisterDetails', 'StatisticsController@RegisterDetails');

    Route::get('/Open', 'StatisticsController@GetOpenStat');
    Route::get('/OpenDetails', 'StatisticsController@GetOpenStatDetails');

    Route::get('/Transcation', 'StatisticsController@GetTranscationnew');
    Route::get('/TranDetails', 'StatisticsController@GetTranDetails');

    Route::get('/TranscationOLD', 'StatisticsController@GetTranscation');
    Route::get('/TranDetailsOLD', 'StatisticsController@GetTranDetails');

    Route::get('/OnlineStat', 'StatisticsController@OnlineStat');

    Route::get('/OnlineStatChart', 'StatisticsController@GetAllOnlineData');

  });

  Route::group(['prefix' => 'Trade'], function () {
    Route::get('/GetTradeData', 'StatisticsController@GetTradeData');
    Route::get('/GetParentBranches', 'BranchController@getParentselectBranches');
    Route::get('/GetChildBranches/{id}', 'BranchController@getChildBranches');
    Route::get('/GetHistoryTradeData', 'StatisticsController@GetHistoryTradeData');
  });

  Route::group(['prefix' => 'Assets'], function () {
    Route::get('/GetTotalAssets', 'StatisticsController@GetTotalAssets');
    Route::get('/GetCurrentAssets', 'StatisticsController@GetCurrentAssets');
    Route::get('/GetHistoryAssets', 'StatisticsController@GetHistoryAssets');
  });


  Route::group(['prefix' => 'Total'], function () {
    Route::get('/totalcurrenttrade', 'StatisticsController@Totalcurrenttrade');
    Route::get('/totalhistorytrade', 'StatisticsController@Totalhistorytrade');
    Route::get('/totalnumberassets', 'StatisticsController@Totalnumberassets');
    Route::get('/totalcurrentassets', 'StatisticsController@Totalcurrentassets');
    Route::get('/totalhistoryassets', 'StatisticsController@Totalhistoryassets');
  });


});
//图片上传
Route::post('uploads', 'UploadController@index'); //图片上传