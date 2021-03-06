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
use Illuminate\Contracts\Pagination\Paginator;

Route::get('/','HomeController@index');
Route::get('help','HomeController@help');


 /* SchoolsController*/
Route::get('schools/boite','SchoolsController@boite');
Route::resource('schools','SchoolsController');
Route::post('schools/updatepass','SchoolsController@updatepass');
Route::post('schools/category','SchoolsController@category');
Route::match(['get','post'],'schools/fillcatbills','SchoolsController@show_cat_bills');
Route::match(['get','post'],'schools/schoolbyalph','SchoolsController@schoolbyalph');
Route::post('schools/upimage','SchoolsController@upimage'); // uploader ou changer l'image de compte famille
Route::post('schools/upimageecole','SchoolsController@upimageecole'); // uploader ou changer l'image de compte ecole
Route::any('schools/profile/{id?}','SchoolsController@profile');
Route::get('schools/editer/{id}','SchoolsController@editer');

Route::post('schools/show_price_bills','SchoolsController@show_price_bills');
Route::post('schools/price_bills_store','SchoolsController@price_bills_store');
Route::post('schools/check_gestion_users','SchoolsController@check_gestion_users');
Route::any('schools/gestion_users/{id?}','SchoolsController@gestion_users');
  /*
   * connexion login
   * */




Route::get('auth/login', 'Auth\AuthController@getLogin',['middleware'=>'guest']);
Route::post('auth/login', ['as'=>'auth.login','uses'=>'Auth\AuthController@postLogin']);
Route::get('auth/logout', 'Auth\AuthController@getLogout');


/*   Profiles Controller **/

Route::resource('profiles','ProfilesController');



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
Route::match(['get','post'],'children/checkiffamily','ChildrenController@checkiffamily'); // check if family exists ajax
Route::post('children/checktoreturn','ChildrenController@checktoreturn'); // check multiple fields to redirect if family exists ajax

// excel children/index
Route::get('children/exportEleve/{ids?}','ChildrenController@exportEleve');
// PDF Export PDF children/index
Route::get('children/exportPdf/{ids?}','ChildrenController@exportPdf');
// retourne la branche  dès le recoit de la classe  en ajax
Route::post('children/getBranchWhenClassid','ChildrenController@getBranchWhenClassid');
// retourne le la classe dès le recoit de de niveau  en ajax
Route::post('children/getClassroomWhenLevelId','ChildrenController@getClassroomWhenLevelId');

// retourne le niveau quand on recoit le niveau global
Route::post('children/getLevelWhenGradeIsChosen','ChildrenController@getLevelWhenGradeIsChosen');

// retourne la class de la crèche en ajax
Route::post('children/getclassforcreche','ChildrenController@getclassforcreche');


Route::any('children/changeClasse/{id?}','ChildrenController@changeClasse');


Route::get('eleves/{y1?}/{y2?}','ChildrenController@index');
Route::resource('children','ChildrenController');

/**********************   FamiliesController *********************/

/*   checkboxes ajax families */
Route::match(['get','post'],'families/supprimer','FamiliesController@supprimer');
Route::match(['get','post'],'families/archiver','FamiliesController@archiver');
/*  By clicking on actions   */
Route::get('families/delete/{id}','FamiliesController@delete');
Route::get('families/archive/{id}','FamiliesController@archive');

// excel export families/index
Route::get('families/exportExcel/{ids?}','FamiliesController@exportExcel');
// pdf export families/index
Route::get('families/exportPdf/{ids?}','FamiliesController@exportPdf');

Route::get('familles/{y1?}/{y2?}','FamiliesController@index');

/* add child to family in families/show/id */

Route::any('families/addchild/{id?}','FamiliesController@addchild');

Route::get('search/{q}',['uses'=>'FamiliesController@search']);
Route::match(['get','post'],'fambyalph','FamiliesController@fambyalph');
Route::resource('families','FamiliesController');





Route::get('attendances/indexef','AttendancesController@indexef');
Route::get('attendances/showef/{id}','AttendancesController@showef');
Route::match(['get','post'],'delatt','AttendancesController@delatt');
Route::match(['get','post'],'attbyalph','AttendancesController@attbyalph');
Route::match(['get','post'],'pointage','AttendancesController@pointage');
Route::get('attendances/absenceToday','AttendancesController@absenceToday'); // absence aujourd'hui compte ecole
Route::resource('attendances','AttendancesController');


 /* BillsController  */

 // ajax checkboxes
Route::match(['get','post'],'regler','BillsController@regler');
Route::match(['get','post'],'nonregler','BillsController@nonregler');
//status trier bills/show
Route::match(['get','post'],'status','BillsController@status');
// filter status bills/index
Route::match(['get','post'],'statusindex','BillsController@statusindex');
// for statistics only
Route::any('statistics/statusindex','StatisticsController@statusindex'); // new index



Route::post('history/trierenfantparlettre','StatisticsController@enfbyalph');
Route::get('archives/{year1?}/{year2?}','StatisticsController@archive');
Route::get('statistics/graphs/{year1?}/{year2?}','StatisticsController@graphs');
Route::get('stats','StatisticsController@statistics');


// filter by month bills/show// filter by month bills/index
Route::match(['get','post'],'monthindex','BillsController@monthindex');
Route::match(['get','post'],'month','BillsController@month');

// instant search ajax bills/index
Route::match(['get','post'],'instantsearch','BillsController@searchinst');

Route::any('bills/exportExcel/{ids?}','BillsController@exportExcel');
Route::any('bills/exportPdf/{ids?}','BillsController@exportPdf');
// showef famille bills (account Family)
Route::get('bills/showef/{id}','BillsController@showef');
Route::get('bills/indexef','BillsController@indexef');

Route::get('schools/editef/{id}','SchoolsController@editef');
Route::post('schools/updatepassef','SchoolsController@updatepassef');
Route::post('schools/deleteSchools','SchoolsController@deleteSchools'); // delete schools
Route::post('schools/bloquer','SchoolsController@bloquer');
Route::post('schools/debloquer','SchoolsController@debloquer');
Route::post('schools/offess','SchoolsController@offess'); // status trier officiel or essai
Route::get('schools/delete/{id}','SchoolsController@delete');
route::any('schools/promotion/{id?}','SchoolsController@promotion');


Route::post('bills/checkpassofregler','BillsController@checkpassofregler'); // vérifie le mot de pass avant de régler
Route::get('bills/indexnr','BillsController@indexnr'); // index factures non réglées
Route::post('bills/filterByYear','BillsController@filterByYear'); // filter by year
Route::post('bills/filterByYearef','BillsController@filterByYearef'); // filter by year compte famille
Route::post('bills/filterByMonthef','BillsController@filterByMonthef'); // filter by month compte famille
Route::post('bills/statusindexef','BillsController@statusindexef'); // filter status compte famille


// archive and delete bills
Route::get('bills/archive/{id}','BillsController@archive');
Route::get('bills/delete/{id}','BillsController@delete');

// for bills details and print
Route::get('bills/imprimer/{id}','BillsController@imprimer');
Route::get('bills/details/{id}','BillsController@details');
Route::get('bills/detailsef/{id}','BillsController@detailsef');
Route::resource('bills','BillsController');



/* TeachersController */
// excel export
Route::get('teachers/exportExcel/{ids?}','TeachersController@exportExcel');
// export pdf
Route::get('teachers/exportPdf/{ids?}','TeachersController@exportPdf');


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
Route::get('statistics/mb/{year}/{month}','StatisticsController@monthly_bills');
Route::get('statistics/mabs/{year}/{month}','StatisticsController@monthly_absence'); // index attendances statistics
Route::post('statistics/absence_raison','StatisticsController@absence_raison'); // trier en ajax normale ou maladie
Route::post('attendances/absence_raison_today','AttendancesController@absence_raison_today'); // for today only
Route::match(['get','post'],'statistics/supprimer_att','StatisticsController@supprimer_att'); // supprimer att en ajax
Route::match(['get','post'],'statistics/archiver_att','StatisticsController@archiver_att'); //archiver att en ajax
Route::get('statistics/delete_att/{id}','StatisticsController@delete_att');
Route::get('statistics/archive_att/{id}','StatisticsController@archive_att');
Route::get('statistics/newsbsc/{year}/{month}','StatisticsController@new_subscribers');
Route::post('statistics/trier_sexe','StatisticsController@trier_sexe'); // trier en ajax sexe garcon ou fille
Route::post('forgetpass','StatisticsController@forgetpass'); // forget pass ajax login
Route::get('gestion','StatisticsController@gestion');

Route::any('statistics/getYearAndMonth','StatisticsController@getYearAndMonth');
//Route::get('anniv/annivIndex','StatisticsController@annivIndex');
Route::resource('statistics','StatisticsController');


/* *********************                       *******************/
/***********************       branches and rooms and matters and classrooms  *********/
/* *********************                       *******************/
Route::get('branches/delete/{id}','BranchesController@delete'); // delete a branch by click
Route::post('branches/supprimer','BranchesController@supprimer'); // suppression ajax

//branches excel export branches/index
Route::get('branches/exportExcel/{ids?}','BranchesController@exportExcel');
//branches pdf export branches/index
Route::get('branches/exportPdf/{ids?}','BranchesController@exportPdf');
Route::resource('branches','BranchesController');


Route::post('rooms/supprimer','RoomsController@supprimer'); //suppression ajax
Route::get('rooms/delete/{id}','RoomsController@delete'); // delete a room by click

Route::get('rooms/exportExcel/{ids?}','RoomsController@exportExcel');
Route::get('rooms/exportPdf/{ids?}','RoomsController@exportPdf');
Route::resource('rooms','RoomsController');



Route::post('classrooms/getGrades','ClassroomsController@getGrades');
Route::post('classrooms/detach','ClassroomsController@detach'); // detach from the 3 relations cr-matter-teacher
Route::get('classrooms/indexelc/{id}/{year1?}/{year2?}','ClassroomsController@indexelc'); // afficher les élèves d'une classe
Route::post('classrooms/trierparniveau','ClassroomsController@trierparniveau'); //trier par niveau  ajax
Route::post('classrooms/supprimer','ClassroomsController@supprimer'); //suppression ajax
Route::get('classrooms/delete/{id}','ClassroomsController@delete'); // delete classe by click
Route::get('classrooms/indexef','ClassroomsController@indexef'); // index classrooms compte famille
Route::get('classrooms/{id}/showef','ClassroomsController@showef'); // show  emploi du temps compte famille

Route::any('classrooms/addMatterandProfToCr/{id?}','ClassroomsController@addMatterandProfToCr');
// Excel export classrooms/index
Route::get('classrooms/exportExcel/{ids?}','ClassroomsController@exportExcel');
// export pdf classrooms/index
Route::get('classrooms/exportPdf/{ids?}','ClassroomsController@exportPdf');


Route::post('classrooms/trierparbranche','ClassroomsController@trierparbranche'); // tri level ajax
Route::post('classrooms/getlevel','ClassroomsController@getLevel'); // tri ajax


Route::post('classrooms/getBranchWhenLevelIsChosen','ClassroomsController@getBranchWhenLevelIsChosen');
Route::get('classes/{year1?}/{year2?}','ClassroomsController@index');
Route::resource('classrooms','ClassroomsController');

Route::post('matters/supprimer','MattersController@supprimer'); //suppression ajax
Route::get('matters/delete/{id}','MattersController@delete'); // delete a matter  by click

// export excel matters/index
Route::get('matters/exportExcel/{ids?}','MattersController@exportMatiere');
// export pdf  matters/index
Route::get('matters/exportPdf/{ids?}','MattersController@exportPdf');
Route::resource('matters','MattersController');



/*  timesheets */
Route::post('timesheets/trierparbranche','TimesheetsController@trierparbranche'); //trier par branche  ajax
Route::post('ts/enre','TimesheetsController@enregistrer');
Route::post('ts/del','TimesheetsController@del');
Route::post('timesheets/supprimer','TimesheetsController@supprimer');
Route::get('timesheets/delete/{id}','TimesheetsController@delete'); // supprimer un niveau by click
Route::resource('timesheets','TimesheetsController');


/* levels */
Route::post('levels/supprimer','LevelsController@supprimer');
Route::get('levels/delete/{id}','LevelsController@delete'); // supprimer un niveau by click

//level export excel levels/index
Route::get('levels/exportExcel/{ids?}','LevelsController@exportExcel');
//level pdf excel levels/index
Route::get('levels/exportPdf/{ids?}','LevelsController@exportPdf');

Route::resource('levels','LevelsController');

Route::post('educators/enregistrer','EducatorsController@enregistrer'); // edit classroom teacher / matter

Route::post('educators/getmatters','EducatorsController@getmatters');
Route::post('educators/getmatieres','EducatorsController@getmatieres');
Route::resource('educators','EducatorsController');

//trier par jour en ajax
Route::post('plans/trierparjour','PlansController@trierparjour');
//trier par salle en ajax
Route::post('plans/trierparsalle','PlansController@trierparsalle');
Route::resource('plans','PlansController');

//bus export excel buses/index
Route::get('buses/exportExcel/{ids?}','BusesController@exportExcel');
//bus pdf excel levels/index
Route::get('buses/exportPdf/{ids?}','BusesController@exportPdf');
Route::post('buses/supprimer','BusesController@supprimer');  //ajax supprimer
Route::get('buses/delete/{id}','BusesController@delete'); // supprimer un bus by click
Route::resource('buses','BusesController');


/*      occasions    */
Route::post('occasions/insertOcc','OccasionsController@insertOcc');
Route::post('occasions/delOcc','OccasionsController@delOcc');
Route::resource('occasions','OccasionsController');



/* SchoolYears */
Route::post('schoolsyears/getlevels','SchoolYearsController@getLevels');
Route::post('schoolsyears/verifyRange','SchoolYearsController@verifyRange');
Route::post('schoolyears/getdates','SchoolYearsController@getdates');
Route::resource('schoolyears','SchoolYearsController');

/*  PriceBills */
//check if a price exists for a level
Route::post('pricebills/checkPriceOfLevel','PriceBillsController@checkPriceOfLevel');
Route::resource('pricebills','PriceBillsController');


Route::post('promotionstatuses/resetallblocks','PromotionStatusesController@resetallblocks');
Route::post('promotionstatuses/setbloc1','PromotionStatusesController@setbloc1');
Route::post('promotionstatuses/setbloc2','PromotionStatusesController@setbloc2');
Route::post('promotionstatuses/setGlobal','PromotionStatusesController@setGlobal');
Route::post('promotionstatuses/checkglobal','PromotionStatusesController@checkglobal');
Route::post('promotionstatuses/checkbloc1','PromotionStatusesController@checkbloc1');
Route::post('promotionstatuses/checkbloc2','PromotionStatusesController@checkbloc2');

Route::resource('promotionstatuses','PromotionStatusesController');



Route::post('promotionadvances/showPriceOfPromotion','PromotionAdvancesController@showPriceOfPromotion');
Route::resource('promotionadvances','PromotionAdvancesController');
Route::post('promotionexceptionals/getData','PromotionExceptionalsController@getData');
Route::resource('promotionexceptionals','PromotionExceptionalsController');


Route::post('earlysubscriptions/getClassWhenLevelid','EarlySubscriptionsController@getClassWhenLevelid');
Route::resource('earlysubscriptions','EarlySubscriptionsController');


/* Gallery room */

Route::get('gallery',function(){
    return view('gallery3d.index');
})->middleware(['auth','admin']);
/* Gallery Room*/

Route::get('pdf',function() {

    $page = substr(URL::previous(), -1);
    if (is_null($page)) {
        $page = 1;
    } else {
      $model = App\Matter::where('user_id', \Auth::user()->id)->forPage($page, 5)->get(['nom_matiere','code_matiere']);
      Excel::create('Sheetname', function ($excel) use ($model) {
        $excel->sheet('Sheetname', function ($sheet) use ($model) {
            $sheet->fromModel($model);
            $sheet->setStyle(array(
                'font' => array(
                    'name'      =>  'Calibri',
                    'size'      =>  13,

                )
            ));
            $sheet->setAllBorders('thin');
            $sheet->cells('A1:B1',function($cells){
                $cells->setBackground('#97efee');
                // header only
                $cells->setFont(array(
                    'family'     => 'Calibri',
                    'size'       => '14',
                    'bold'       =>  true
                ));
            });

            $sheet->row(1, array(
                'Nom Matière', 'Code Matière'
            ));

        });
    })->export('pdf');
}
});