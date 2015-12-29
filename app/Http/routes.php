<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::group(['middleware'=>'auth'],function(){
    Route::get('index',function(){
        return view('index');
    });
});*/
Route::get('/','HomeController@index');


 /* SchoolsController*/
Route::get('schools/boite','SchoolsController@boite');
Route::resource('schools','SchoolsController');
Route::post('schools/updatepass','SchoolsController@updatepass');
Route::post('schools/category','SchoolsController@category');
Route::match(['get','post'],'schools/fillcatbills','SchoolsController@show_cat_bills');
Route::match(['get','post'],'schools/schoolbyalph','SchoolsController@schoolbyalph');
Route::post('schools/upimage','SchoolsController@upimage');

  /*
   * connexion login
   * */




Route::get('auth/login', 'Auth\AuthController@getLogin',['middleware'=>'guest']);
Route::post('auth/login', ['as'=>'auth.login','uses'=>'Auth\AuthController@postLogin']);
Route::get('auth/logout', 'Auth\AuthController@getLogout');


/********* ChildrenController         *****************/
Route::match(['get','post'],'enfbyalph','ChildrenController@enfbyalph');
Route::match(['get','post'],'ajouter_enfant','ChildrenController@create_enfant');
Route::post('store_enfant','ChildrenController@store_enfant');

 /*   checkboxes ajax children */
Route::match(['get','post'],'children/supprimer','ChildrenController@supprimer');
Route::match(['get','post'],'children/archiver','ChildrenController@archiver');
/*  By clicking on actions   */
Route::match(['get'],'children/delete/{id}','ChildrenController@delete');
Route::match(['get'],'children/archive/{id}','ChildrenController@archive');
 /*  For registred families  */
Route::get('children/indexef','ChildrenController@indexef');
Route::get('children/showef/{id}','ChildrenController@showef');
/* children age show in inscription*/
Route::post('children/getageandprice','ChildrenController@getage');
Route::post('children/total','ChildrenController@total');
Route::post('children/checktransport','ChildrenController@checktransport');

Route::resource('children','ChildrenController');

/**********************   FamiliesController *********************/

/*   checkboxes ajax families */
Route::match(['get','post'],'families/supprimer','FamiliesController@supprimer');
Route::match(['get','post'],'families/archiver','FamiliesController@archiver');
/*  By clicking on actions   */
Route::get('families/delete/{id}','FamiliesController@delete');
Route::get('families/archive/{id}','FamiliesController@archive');

Route::get('search/{q}',['uses'=>'FamiliesController@search']);
Route::match(['get','post'],'fambyalph','FamiliesController@fambyalph');
Route::resource('families','FamiliesController');





Route::get('attendances/indexef','AttendancesController@indexef');
Route::get('attendances/showef/{id}','AttendancesController@showef');
Route::match(['get','post'],'delatt','AttendancesController@delatt');
Route::match(['get','post'],'attbyalph','AttendancesController@attbyalph');
Route::match(['get','post'],'pointage','AttendancesController@pointage');
Route::resource('attendances','AttendancesController');


 /* BillsController  */

 // ajax checkboxes
Route::match(['get','post'],'regler','BillsController@regler');
Route::match(['get','post'],'nonregler','BillsController@nonregler');
//status trier bills/show
Route::match(['get','post'],'status','BillsController@status');
// filter status bills/index
Route::match(['get','post'],'statusindex','BillsController@statusindex');



// filter by month bills/show
Route::match(['get','post'],'month','BillsController@month');
// filter by month bills/index
Route::match(['get','post'],'monthindex','BillsController@monthindex');

// instant search ajax bills/index
Route::match(['get','post'],'instantsearch','BillsController@searchinst');
// showef famille bills (account Family)
Route::get('bills/showef/{id}','BillsController@showef');
Route::get('bills/indexef','BillsController@indexef');
Route::get('schools/editef/{id}','SchoolsController@editef');
Route::post('schools/updatepassef','SchoolsController@updatepassef');






// archive and delete bills
Route::get('bills/archive/{id}','BillsController@archive');
Route::get('bills/delete/{id}','BillsController@delete');

// for bills details and print
Route::get('bills/imprimer/{id}','BillsController@imprimer');
Route::get('bills/details/{id}','BillsController@details');
Route::get('bills/detailsef/{id}','BillsController@detailsef');
Route::resource('bills','BillsController');



/* TeachersController */
Route::resource('teachers','TeachersController');

// alpha search for teachers -- teachers/index
Route::match(['get','post'],'teachers/teacherbyalph','TeachersController@teacherbyalph');

/*   checkboxes ajax teachers */
Route::match(['get','post'],'teachers/supprimer','TeachersController@supprimer');
Route::match(['get','post'],'teachers/archiver','TeachersController@archiver');

/*  By clicking on actions   */
Route::match(['get'],'teachers/delete/{id}','TeachersController@delete');
Route::match(['get'],'teachers/archive/{id}','TeachersController@archive');



/* statistics*/
Route::get('statistics/mb','StatisticsController@monthly_bills');
Route::get('statistics/mabs','StatisticsController@monthly_absence'); // index attendances statistics
Route::post('statistics/absence_raison','StatisticsController@absence_raison'); // trier en ajax normale ou maladie
Route::match(['get','post'],'statistics/supprimer_att','StatisticsController@supprimer_att'); // supprimer att en ajax
Route::match(['get','post'],'statistics/archiver_att','StatisticsController@archiver_att'); //archiver att en ajax
Route::get('statistics/delete_att/{id}','StatisticsController@delete_att');
Route::get('statistics/archive_att/{id}','StatisticsController@archive_att');
Route::get('statistics/newsbsc','StatisticsController@new_subscribers');

Route::resource('statistics','StatisticsController');