<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', 'UserController@index')->name('login');
Route::get('/home', 'UserController@dashboard')->name('home');
Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');

Route::post('/authorization/login', 'Auth\LoginController@authorization')->name('authorization.login');

// User online registration
Route::get('/external-user-registration', 'External\ExternalRegistrationController@external_user_registration')->name('external-user-registration');
Route::post('/external-user-registration-save', 'External\ExternalRegistrationController@external_user_registration_save')->name('external-user-registration-save');

Route::get('refreshcaptcha', 'External\ExternalRegistrationController@refreshCaptcha')->name('refreshcaptcha');
Route::get('/email-verify/{id}/{token}', 'External\VerifyController@VerifyEmail')->name('email-verify');


Route::get('/forget-password', 'External\VerifyController@forget_password')
    ->name('forget-password');

Route::post('/forget_password_check', 'External\VerifyController@forget_password_check')
    ->name('forget_password_check');

Route::get('/forget_password_confirmation/{id}/{token}', 'External\VerifyController@forget_password_confirmation')
    ->name('forget_password_confirmation');

Route::post('/forget_password_save', 'External\VerifyController@forget_password_save')
    ->name('forget_password_save');

// Terms & Conditions
Route::get('/terms-and-conditions', 'External\ExternalRegistrationController@terms_and_conditions')->name('terms-and-conditions');


Route::get('/external-user-login', 'External\ExternalLoginController@external_user_login')->name('external-user-login');
Route::post('/external-user-login-check', 'External\ExternalLoginController@external_user_login_check')->name('external-user-login-check');
Route::post('/external-user-forgot-password', 'External\ExternalLoginController@external_user_forgot_password')->name('external-user-forgot-password');


Route::group(['middleware' => ['externalUserAuth'], 'as' => 'external-user.', 'prefix' => 'external-user'], function () {

    Route::get('/dashboard', 'External\DashboardController@index')->name('dashboard');
    Route::post('/dashboard-search', 'External\DashboardController@dashboard_search')->name('dashboard-search');
    Route::post('/seen-notification', 'Api\V1\Pmis\Employee\BasicInfoController@seen_notification')->name('seen_notification');

    Route::get('/product-detail/{id}', 'External\ProductDetailController@index')->name('product-detail');
    Route::post('/product_detail_by_id', 'External\ProductDetailController@product_detail_by_id')->name('product_detail_by_id');

    Route::get('/checkout', 'External\CartController@checkout')->name('checkout');
    Route::get('/cart', 'External\CartController@cart')->name('cart');
    Route::post('/cart-add', 'External\CartController@add')->name('cart-add');
    Route::post('/cart-update', 'External\CartController@update')->name('cart-update');
    Route::post('/cart-remove', 'External\CartController@remove')->name('cart-remove');
    Route::post('/cart-clear', 'External\CartController@clear')->name('cart-clear');


    Route::get('/product-request-index', 'External\ProductRequestController@index')->name('product-request-index');
    Route::post('/product-request-datatable-list', 'External\ProductRequestController@dataTableList')->name('product-request-datatable-list');

    Route::post('/selling-product-by-id', 'External\SellingRequestController@selling_product_by_id')->name('selling-product-by-id');
    Route::get('/selling-request-edit/{id}', 'External\SellingRequestController@edit')->name('selling-request-edit');

    Route::post('/selling-request-post', 'External\SellingRequestController@post')->name('selling-request-post');
    Route::post('/selling-request-update/{id}', 'External\SellingRequestController@update')->name('selling-request-update');


    //
    Route::get('/approved-request-index', 'External\ApprovedRequestController@index')->name('approved-request-index');
    Route::post('/goto-payment-gateway/{id}', 'External\ApprovedRequestController@goto_payment_gateway')->name('goto-payment-gateway');


    Route::get('/confirmed-order-index', 'External\ConfirmedOrderController@index')->name('confirmed-order-index');

    //Payment
    Route::get('/payment-index', 'Payment\PaymentController@index')->name('payment-index');
    Route::get('/payment-success/{id}', 'Payment\PaymentController@payment_success')->name('payment-success');
    Route::get('/payment-reject', 'Payment\PaymentController@payment_reject')->name('payment-reject');
    Route::get('/sonali-payment', 'Payment\PaymentController@paymentUrl')->name('sonali-payment-index');
    Route::post('/payment-response-url/{ap_mbl}/{ap_id}', 'Payment\PaymentController@paymentResponseUrl')->name('payment-response-url');

    //Bkash
    Route::post('/bkash-create', 'Payment\BkashController@create')->name('bkash-create');
    Route::post('/bkash-execute', 'Payment\BkashController@execute')->name('bkash-execute');
    Route::get('/bkash-success', 'Payment\BkashController@success')->name('bkash-success');
    //City (not yet done)

    //product-upload
    Route::get('/product-download-index', 'External\ProductDownloadController@index')->name('product-download-index');
    //product-download-order-detail
    Route::get('/product-download-order-detail/{id}', 'External\ProductDownloadController@detail')->name('product-download-order-detail');
    Route::get('/product-download-order-detail-download/{id}', 'External\ProductDownloadController@download')->name('product-download-order-detail-download');
    Route::get('/product-download-file/{id}', 'External\ProductDownloadController@download')->name('product-download-file');


    Route::get('/order-tracking-index', 'External\OrderTrackingController@index')->name('order-tracking-index');


});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
    Route::post('/dashboard-notification-update', 'UserController@notification_seen')->name('dashboard-notification-update');
    Route::get('/seen-notification', 'UserController@updateNotification')->name('seen-notification');


    Route::group([ 'as' => 'others.' , 'prefix' => 'others'], function () {

        Route::get('/fuel-oil-requisition-index', 'Others\FuelOilRequisitionController@index')->name('fuel-oil-requisition-index');
        Route::post('/fuel-oil-requisition-post', 'Others\FuelOilRequisitionController@post')->name('fuel-oil-requisition-post');

        Route::get('/craft-profile-index', 'Others\CraftProfileController@index')->name('craft-profile-index');
        Route::get('/spare-part-requisition-index', 'Others\SparePartRequisitionController@index')->name('spare-part-requisition-index');

        Route::get('/contact-management-index', 'Others\ContactManagementController@index')->name('contact-management-index');


        Route::get('/fuel-oil-requisition-usage-index', 'Others\FuelOilRequisitionUsageController@index')->name('fuel-oil-requisition-usage-index');
        Route::get('/fuel-oil-requisition-approval-index', 'Others\FuelOilRequisitionApprovalController@index')->name('fuel-oil-requisition-approval-index');

    });

    Route::post('/customer-detail-with-order', 'Product\ProductOrderDetailController@customer_detail_with_order')->name('customer_detail-with-order');

    Route::group([ 'as' => 'setup.' , 'prefix' => 'setup'], function () {
        //Zone area setup
        Route::get('/zone-area-index', 'Setup\ZoneAreaController@index')->name('zone-area-index');
        Route::post('/zone-area-datatable-list', 'Setup\ZoneAreaController@dataTableList')->name('zone-area-datatable-list');
        Route::get('/zone-area-edit/{id}', 'Setup\ZoneAreaController@edit')->name('zone-area-edit');
        Route::post('/zone-area-post', 'Setup\ZoneAreaController@post')->name('zone-area-post');
        Route::put('/zone-area-update/{id}', 'Setup\ZoneAreaController@update')->name('zone-area-update');

        // File
        Route::get('/file-category-index', 'Setup\FileCategoryController@index')->name('file-category-index');
        Route::post('/file-category-datatable-list', 'Setup\FileCategoryController@dataTableList')->name('file-category-datatable-list');
        Route::get('/file-category-edit/{id}', 'Setup\FileCategoryController@edit')->name('file-category-edit');
        Route::post('/file-category-post', 'Setup\FileCategoryController@post')->name('file-category-post');
        Route::put('/file-category-update/{id}', 'Setup\FileCategoryController@update')->name('file-category-update');


        //product
        Route::get('/product-index', 'Setup\ProductController@index')->name('product-index');
        Route::post('/product-datatable-list', 'Setup\ProductController@dataTableList')->name('product-datatable-list');
        Route::get('/product-edit/{id}', 'Setup\ProductController@edit')->name('product-edit');
        Route::post('/product-post', 'Setup\ProductController@post')->name('product-post');
        Route::put('/product-update/{id}', 'Setup\ProductController@update')->name('product-update');

        //Product Details

        Route::get('/product-format-index', 'Setup\ProductFormatController@index')->name('product-format-index');
        Route::post('/product-format-datatable-list', 'Setup\ProductFormatController@dataTableList')->name('product-format-datatable-list');
        Route::get('/product-format-edit/{id}', 'Setup\ProductFormatController@edit')->name('product-format-edit');
        Route::post('/product-format-post', 'Setup\ProductFormatController@post')->name('product-format-post');
        Route::put('/product-format-update/{id}', 'Setup\ProductFormatController@update')->name('product-format-update');



        //Team type
        Route::get('/team-type-index', 'Setup\TeamTypeController@index')->name('team-type-index');
        Route::post('/team-type-datatable-list', 'Setup\TeamTypeController@dataTableList')->name('team-type-datatable-list');
        Route::get('/team-type-edit/{id}', 'Setup\TeamTypeController@edit')->name('team-type-edit');
        Route::post('/team-type-post', 'Setup\TeamTypeController@post')->name('team-type-post');
        Route::put('/team-type-update/{id}', 'Setup\TeamTypeController@update')->name('team-type-update');

        //Team
        Route::get('/team-index/{id?}', 'Setup\TeamController@index')->name('team-index');
        Route::post('/team-datatable-list', 'Setup\TeamController@dataTableList')->name('team-datatable-list');
        Route::get('/team-edit/{id}', 'Setup\TeamController@edit')->name('team-edit');
        Route::post('/team-post', 'Setup\TeamController@post')->name('team-post');
        Route::put('/team-update/{id}', 'Setup\TeamController@update')->name('team-update');



        //Team Employee
        Route::get('/team-employee-index', 'Setup\TeamEmployeeController@index')->name('team-employee-index');
        Route::post('/team-employee-datatable-list', 'Setup\TeamEmployeeController@dataTableList')->name('team-employee-datatable-list');
        Route::get('/team-employee-edit/{id}', 'Setup\TeamEmployeeController@edit')->name('team-employee-edit');
        Route::post('/team-employee-post', 'Setup\TeamEmployeeController@post')->name('team-employee-post');
        Route::post('/team-employee-update', 'Setup\TeamEmployeeController@update')->name('team-employee-update');
        //team_employee_get
        Route::get('/team-employee-get', 'Setup\TeamEmployeeController@team_employee_get')->name('team-employee-get');

        Route::get('/designations', 'Setup\TeamEmployeeController@designations')->name('designations');
        Route::post('/employee-by-designation', 'Setup\TeamEmployeeController@employee_by_designation')->name('employee-by-designation');
        Route::post('/employee-detail-from-pims', 'Setup\TeamEmployeeController@employee_detail_from_pims')->name('employee-detail-from-pims');



        // Schedule type
        Route::get('/schedule-type-index', 'Setup\ScheduleTypeController@index')->name('schedule-type-index');
        Route::post('/schedule-type-datatable-list', 'Setup\ScheduleTypeController@dataTableList')->name('schedule-type-datatable-list');
        Route::get('/schedule-type-edit/{id}', 'Setup\ScheduleTypeController@edit')->name('schedule-type-edit');
        Route::post('/schedule-type-post', 'Setup\ScheduleTypeController@post')->name('schedule-type-post');
        Route::put('/schedule-type-update/{id}', 'Setup\ScheduleTypeController@update')->name('schedule-type-update');



    });

    Route::group([ 'as' => 'product.' , 'prefix' => 'product'], function () {

        Route::get('/customer-pending-approval', 'Product\CustomerApprovalController@pending_approval')->name('customer-pending-approval');
        Route::post('/customer-approval-confirmation/{id}', 'Product\CustomerApprovalController@customer_approval_confirmation')->name
        ('customer-approval-confirmation');


        //CompletedPaymentController
        Route::get('/completed-payment-index', 'Product\CompletedPaymentController@index')->name('completed-payment-index');



        Route::get('/product-approval-index', 'Product\ProductApprovalController@index')->name('product-approval-index');
        Route::post('/product-approval-update', 'Product\ProductApprovalController@update')->name('product-approval-update');

        Route::post('/product-approval-confirmation', 'Product\ProductApprovalController@product_approval_confirmation')->name('product-approval-confirmation');
        Route::post('/product-approval-rejection', 'Product\ProductApprovalController@product_approval_rejection')->name('product-approval-rejection');


        //product-upload
        Route::get('/product-upload-index', 'Product\ProductUploadController@index')->name('product-upload-index');
        Route::get('/product-upload-file/{id}', 'Product\ProductUploadController@upload_file')->name('product-upload-file');
        Route::post('/product-upload-post', 'Product\ProductUploadController@post')->name('product-upload-post');
        Route::post('/product-upload-datatable-list/{id}', 'Product\ProductUploadController@dataTableList')->name('product-upload-datatable-list');


        Route::post('/product-confirm-notify', 'Product\CompletedPaymentController@product_confirm_notify')->name('product-confirm-notify');

        Route::post('/file-upload-confirmation', 'Product\ProductUploadController@file_upload_confirmation')->name('file-upload-confirmation');


        Route::get('/product-order-detail/{id}', 'Product\ProductOrderDetailController@detail')->name('product-order-detail');
        Route::post('/product-order-detail-post/{id}', 'Product\ProductOrderDetailController@post')->name('product-order-detail-post');
        Route::post('/product-order-detail-datatable-list', 'Product\ProductOrderDetailController@uploaded_file_list')->name('product-order-detail-datatable-list');
        Route::get('/delete_product_order_detail/{id}', 'Product\ProductOrderDetailController@delete_product_order_detail')->name('delete_product_order_detail');

        Route::post('/file-upload-post', 'Product\ProductOrderDetailController@post_file')->name('file-upload-post');


        Route::post('/file-upload-datatable-list', 'Product\ProductOrderDetailController@dataTableList')->name('file-upload-datatable-list');

        //Not yet done
        Route::get('/product-upload-update/{id}', 'Product\ProductUploadController@update')->name('product-upload-update');

        //Product Detail File Search
        Route::get('/archive-search-index', 'Product\ProductOrderDetailController@archive_index')->name('archive-search-index');
        Route::post('/archive-search-post', 'Product\ProductOrderDetailController@archive_post')->name('archive-search-post');

        Route::post('/multi-product-order-detail-post', 'Product\ProductOrderDetailController@multi_post')->name('multi-product-order-detail-post');


    });

    Route::group([ 'as' => 'file.' , 'prefix' => 'file'], function () {

        Route::get('/file-upload-index', 'File\FileUploadController@index')->name('file-upload-index');
        Route::post('/file-upload-post', 'File\FileUploadController@post')->name('file-upload-post');


        Route::post('/file-upload-datatable-list', 'File\FileUploadController@dataTableList')->name('file-upload-datatable-list');


        Route::put('/file-upload-update/{id}', 'File\FileUploadController@update')->name('file-upload-update');
        Route::get('/zone-area-edit/{id}', 'Setup\ZoneAreaController@edit')->name('zone-area-edit');

        Route::get('/file-upload-download/{id}', 'File\FileUploadController@download')->name('file-upload-download');

         // Archive Serarch
         Route::get('/archive-search-index', 'File\ArchiveSerachController@index')->name('archive-search-index');
         Route::post('/archive-search-post', 'File\ArchiveSerachController@post')->name('archive-search-post');

    });

    Route::group([ 'as' => 'schedule.' , 'prefix' => 'schedule'], function () {


        Route::get('/boat-employee-index', 'Schedule\BoatEmployeeController@index')->name('boat-employee-index');
        Route::post('/boat-employee-datatable-list', 'Schedule\BoatEmployeeController@dataTableList')->name('boat-employee-datatable-list');
      //  Route::get('/boat-employee-edit/{id}', 'Setup\BoatEmployeeController@edit')->name('boat-employee-edit');
        Route::post('/boat-employee-post', 'Schedule\BoatEmployeeController@post')->name('boat-employee-post');

        Route::post('/boat-employee-update', 'Schedule\BoatEmployeeController@update')->name('boat-employee-update');
        Route::get('/get-employee', 'Schedule\BoatEmployeeController@getEmp')->name('get-employee');

        //boat_employee_get
        Route::get('/boat-employee-get', 'Schedule\BoatEmployeeController@boat_employee_get')->name('boat-employee-get');

        Route::post('/boat-employee-setup-update', 'Schedule\BoatEmployeeController@updateEmp')->name('boat-employee-setup-update');



        Route::get('/duty-roster-index', 'Schedule\DutyRosterController@index')->name('duty-roster-index');
        Route::post('/duty-roster-employee', 'Schedule\DutyRosterController@duty_roster_employee')->name('duty-roster-employee');

        //Route::get('/duty-roster-calender/{id}/{month_id}/{year_id}', 'Schedule\DutyRosterCalenderController@index')->name('duty-roster-calender');
        Route::get('/duty-roster-calender/{id}', 'Schedule\DutyRosterCalenderController@index')->name('duty-roster-calender');
        //Route::get('/duty-roster-calender-boat/{id}/{month_id}/{year_id}', 'Schedule\DutyRosterCalenderController@boat_index')->name('duty-roster-calender-boat');
        Route::get('/duty-roster-calender-boat/{id}', 'Schedule\DutyRosterCalenderController@boat_index')->name('duty-roster-calender-boat');
        Route::post('/schedule-post-for-approval', 'Schedule\DutyRosterCalenderController@schedule_post')->name('schedule-post-for-approval');

        Route::post('/duty-roster-calender-save', 'Schedule\DutyRosterCalenderController@save')->name('duty-roster-calender-save');
        Route::post('/delete-employee-roster', 'Schedule\DutyRosterCalenderController@delete_employee_roster')->name('delete-employee-roster');

        Route::post('/employee_roaster', 'Schedule\DutyRosterCalenderController@employee_roaster')->name('employee_roaster');

        // Roaster index
        Route::get('/duty-roster-approval-index', 'Schedule\DutyRosterApprovalController@index')->name('duty-roster-approval-index');
        //Route::get('/duty-roster-approval-index', 'Schedule\DutyRosterApprovalController@index')->name('duty-roster-approval-index');
        Route::get('/duty-roster-approval-save', 'Schedule\DutyRosterApprovalController@save')->name('duty-roster-approval-save');
        Route::post('/duty-roster-approval-approve', 'Schedule\DutyRosterApprovalController@approve')->name('duty-roster-approval-approve');

        Route::post('/pending-approval-datatable-list', 'Schedule\DutyRosterCalenderController@dataTableList')->name('pending-approval-datatable-list');
        Route::post('/pending-approval-remove', 'Schedule\DutyRosterCalenderController@pendingApprovalRemove')->name('pending-approval-remove');
        Route::post('/individual-approval', 'Schedule\DutyRosterCalenderController@approveIndividualData')->name('individual-approval');
        Route::post('/batch-approval', 'Schedule\DutyRosterCalenderController@batchApprove')->name('batch-approval');
        Route::post('/individual-approval-request', 'Schedule\DutyRosterCalenderController@indvApprvRequest')->name('individual-approval-request');

        Route::get('/downloadPDF/{vehicle_id}/{month_id}/{year_id}', 'Schedule\DutyRosterApprovalController@downloadPDF')->name('downloadPDF');



        //schedule
        Route::get('/schedule-index', 'Schedule\ScheduleController@index')->name('schedule-index');
        Route::post('/schedule-datatable-list', 'Schedule\ScheduleController@dataTableList')->name('schedule-datatable-list');
        Route::get('/schedule-edit/{id}', 'Schedule\ScheduleController@edit')->name('schedule-edit');
        Route::post('/schedule-post', 'Schedule\ScheduleController@post')->name('schedule-post');
        Route::post('/schedule-assignment-delete', 'Schedule\ScheduleController@schedule_assignment_delete')->name('schedule-assignment-delete');
        Route::put('/schedule-update/{id}', 'Schedule\ScheduleController@update')->name('schedule-update');

        //Schedule detail
        Route::post('/schedule-detail-post', 'Schedule\ScheduleController@schedule_detail_post')->name('schedule-detail-post');


        //schedule
        Route::get('/schedule-approval-index', 'Schedule\ScheduleApprovalController@index')->name('schedule-approval-index');
        Route::post('/schedule-approval-datatable-list', 'Schedule\ScheduleApprovalController@dataTableList')->name('schedule-approval-datatable-list');
        Route::get('/schedule-approval-edit/{id}/{team_id}', 'Schedule\ScheduleApprovalController@edit')->name('schedule-approval-edit');
        Route::post('/schedule-approval-post', 'Schedule\ScheduleApprovalController@post')->name('schedule-approval-post');
        Route::put('/schedule-approval-update/{id}', 'Schedule\ScheduleApprovalController@update')->name('schedule-approval-update');
        Route::get('/approval', 'Schedule\WorkflowController@status')->name('approval');
        Route::post('/approval-post', 'Schedule\WorkflowController@store')->name('approval-post');


        //schedule notification
        Route::get('/schedule-notification-index', 'Schedule\ScheduleNotificationController@index')->name('schedule-notification-index');
        Route::post('/schedule-notification-post', 'Schedule\ScheduleNotificationController@post')->name('schedule-notification-post');
        Route::post('/schedule-notification-datatable-list', 'Schedule\ScheduleNotificationController@dataTableList')->name('schedule-notification-datatable-list');

        Route::get('/schedule-edit/{id}', 'Schedule\ScheduleController@edit')->name('schedule-edit');

        Route::put('/survey-update/{id}', 'Schedule\SurveyController@update')->name('survey-update');

        /*//Schedule detail
        Route::post('/schedule-detail-post', 'Schedule\ScheduleController@schedule_detail_post')->name('schedule-detail-post');*/

        //Shift Setup
        Route::get('/shift-setup', 'Setup\ShiftSetupController@index')->name('shift-setup-index');
        Route::get('/shift-setup/{id}', 'Setup\ShiftSetupController@edit')->name('shift-setup-edit');
        Route::put('/shift-setup/{id}', 'Setup\ShiftSetupController@update')->name('shift-setup-update');
        Route::post('/shift-setup-post', 'Setup\ShiftSetupController@post')->name('shift-setup-post');
        Route::post('/shift-setup-datatable-list', 'Setup\ShiftSetupController@dataTableList')->name('shift-setup-datatable-list');
        Route::get('/shift-remove', 'Setup\ShiftSetupController@removeData')->name('shift-remove');

        //Gadge Roster
        Route::get('/gadge-reader-roster-index', 'Schedule\GadgeReaderRosterController@index')->name('gadge-reader-roster-index');
        Route::get('/gadge-reader-roster/{id}', 'Schedule\GadgeReaderRosterController@edit')->name('gadge-reader-roster-edit');
        Route::put('/gadge-reader-roster/{id}', 'Schedule\GadgeReaderRosterController@update')->name('gadge-reader-roster-update');
        Route::post('/gadge-reader-roster-post', 'Schedule\GadgeReaderRosterController@post')->name('gadge-reader-roster-post');
        Route::post('/gadge-reader-roster-datatable-list', 'Schedule\GadgeReaderRosterController@dataTableList')->name('gadge-reader-roster-datatable-list');
        Route::post('/employee-by-designation', 'Schedule\GadgeReaderRosterController@employee_by_designation')->name('employee-by-designation');
        Route::get('/remove-dtl-data', 'Schedule\GadgeReaderRosterController@removeDtlData')->name('remove-dtl-data');
        Route::get('/get-dtl-data/{schedule_mst_id}','Schedule\GadgeReaderRosterController@getDtlData')->name("get-dtl-data");

        //Gadge Roster Approval
        Route::get('/reader-approval-index', 'Schedule\ReaderRosterApprovalController@index')->name('reader-approval-index');
        Route::post('/reader-approval-datatable-list', 'Schedule\ReaderRosterApprovalController@dataTableList')->name('reader-approval-datatable-list');
        Route::get('/reader-roaster-remove', 'Schedule\ReaderRosterApprovalController@removeData')->name('reader-roaster-remove');


        //Boat Setup
        Route::get('/boat-setup', 'Schedule\BoatSetupController@index')->name('boat-setup-index');
        Route::get('/boat-setup/{id}', 'Schedule\BoatSetupController@edit')->name('boat-setup-edit');
        Route::put('/boat-setup/{id}', 'Schedule\BoatSetupController@update')->name('boat-setup-update');
        Route::post('/boat-setup-post', 'Schedule\BoatSetupController@post')->name('boat-setup-post');
        Route::post('/boat-setup-datatable', 'Schedule\BoatSetupController@dataTableList')->name('boat-setup-datatable');


        //Gadge Roster
        Route::get('/dredging-inspection-index', 'Schedule\DredgingInspectionController@index')->name('dredging-inspection-index');
        Route::post('/dredging-inspection-post', 'Schedule\DredgingInspectionController@post')->name('dredging-inspection-post');
        Route::post('/dreadging-inspection-datatable-list', 'Schedule\DredgingInspectionController@dataTableList')->name('dreadging-inspection-datatable-list');
        Route::get('/dreadging_inspection_delete/{id}', 'Schedule\DredgingInspectionController@destroy')->name('dreadging_inspection_delete');




    });

    Route::get('/user/change-password', function () {
        return view('resetPassword');
    })->name('change-password');


    //Route::post('/user/change-password', 'Auth\ResetPasswordController@resetPassword')->name('user.reset-password');
    Route::post('/report/render/{title?}', 'Report\OraclePublisherController@render')->name('report');
    Route::get('/report/render/{title?}', 'Report\OraclePublisherController@render')->name('report-get');
    Route::get('/report-generator', 'Report\ReportGeneratorController@index')->name('report-generator');
    Route::get('/report-generator-params', 'Report\ReportGeneratorController@reportParams')->name('report-generator-params');



});

// For News
Route::get('/get-top-news', 'NewsController@getNews')->name('get-top-news');
Route::get('/news-download/{id}', 'NewsController@downloadAttachment')->name('news-download');

Route::post('/authorization/logout', 'Auth\LoginController@logout')->name('logout');
