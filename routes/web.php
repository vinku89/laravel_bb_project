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
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
});
Route::get('/clear-config', function() {
    Artisan::call('config:clear');
});
Auth::routes();
Route::get('/', [ 'as' => '/', 'uses' => 'home\WebsiteController@index']);
Route::any('ImportEpgListToDB', 'home\EpgController@ImportEpgListToDB');
Route::any('updateXMLid', 'home\EpgController@updateXMLid');
Route::get('index', 'home\WebsiteController@index');
Route::get('privacy_policy', 'home\WebsiteController@privacy_policy');
Route::get('terms_of_use', 'home\WebsiteController@terms_of_use');
Route::get('purchasing_terms', 'home\WebsiteController@purchasing_terms');
Route::any('tvapp', 'home\WebsiteController@downloadTvApp');
Route::any('vodrexapp', 'home\WebsiteController@downloadVodrexApp');
Route::any('bestboxios', 'home\WebsiteController@iosApp');
Route::any('bestboxappios', 'home\WebsiteController@downloadVodrexIOSApp');
//Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('checkLogin', 'Auth\LoginController@login');
Route::get('customerLogin', 'Auth\LoginController@customerLoginForm');
Route::post('custLogin', 'Auth\LoginController@customerLogin');
Route::get('Admin', 'Auth\LoginController@adminLoginForm');
Route::post('adminLoginCheck', 'Auth\LoginController@adminLogin');

Route::any('restnewpwd', 'home\AdminController@resetNewPassword');
Route::get('logout', 'Auth\LoginController@logout');
Route::any('verifyEmail/{id1?}/{id2?}', 'home\AdminController@verifyEmail');
Route::any('resetNewPassword', 'Auth\ForgotPasswordController@resetNewPassword');
Route::any('reset-password/{encryptString?}', 'Auth\ForgotPasswordController@resetPassword');
Route::any('forgotPassword/{type?}', 'Auth\ForgotPasswordController@forgotPassword');
Route::any('sendForgotPasswordEmail', 'Auth\ForgotPasswordController@sendForgotPasswordEmail');
Route::get('unileveltree', 'home\CustomerController@unileveltree');

Route::any('customerSignup/{referralId?}', 'home\ReportController@referralProgram');
Route::any('saveReferralUser', 'home\ReportController@saveReferralUser');
Route::any('checkUsername', 'Auth\LoginController@checkUsername');
Route::any('checkCustomerUsername', 'Auth\LoginController@checkCustomerUsername');
Route::any('checkPassword', 'Auth\LoginController@checkPassword');
Route::any('checkEmailExist', 'home\AdminController@checkEmailExist');

Route::post('change_lang', 'home\WebsiteController@change_lang');

Route::group(['middleware' => ['web', 'auth', 'pagename']], function () {

	Route::get('/dashboard/{year?}', 'home\AdminController@dashboard');
	Route::any('chartData', 'home\AdminController@chartData');

	/*agents */
	Route::any('agents', 'home\AdminController@agents');
	Route::any('agent-new', 'home\AdminController@agentNew');
	Route::any('createAgent', 'home\AdminController@createAgent');
	Route::any('agent-edit/{agentId}', 'home\AdminController@agentEdit');
	Route::any('updateAgentData', 'home\AdminController@updateAgentData');
	Route::any('agentView/{agentId}', 'home\AdminController@agentView');

	/*reselller*/
	Route::any('resellers', 'home\AdminController@resellers');
	Route::any('reseller-new', 'home\AdminController@resellerNew');
	Route::any('createReseller', 'home\AdminController@createReseller');

	Route::any('getResellerData', 'home\AdminController@getResellerData');
	Route::any('reseller-edit/{resellerId}', 'home\AdminController@resellerEdit');
	Route::any('updateResellerData', 'home\AdminController@updateResellerData');
	Route::any('deleteResellerData', 'home\AdminController@deleteResellerData');
	Route::any('deleteResellerAgentStatus', 'home\AdminController@deleteResellerAgentStatus');
	Route::any('resellerView/{resellerId}', 'home\AdminController@resellerView');

	Route::any('profile', 'home\ProfileController@profile'); //24-05-2019
	Route::any('updateProfile', 'home\ProfileController@updateProfile'); //28-05-2019
	Route::any('updateProfileImage', 'home\ProfileController@updateProfileImage'); //28-05-2019
	Route::any('changePassword', 'home\ProfileController@changePassword');
	Route::any('updateNewPassword', 'home\ProfileController@updateNewPassword');

	/*customers */
	Route::get('customers', 'home\CustomerController@customers');
	Route::any('customer-new/{customerId?}', 'home\CustomerController@customerNew');
	Route::any('createCustomer', 'home\CustomerController@createCustomer');
	Route::any('customer-edit/{customerId}', 'home\CustomerController@customerEdit');
	Route::any('updateCustomerData', 'home\CustomerController@updateCustomerData');
	Route::any('checkReferralUser', 'home\CustomerController@checkReferralUser');
	// Route::any('createCustomer', 'home\AdminController@createCustomer');
	// Route::any('updateCustomerData', 'home\AdminController@updateCustomerData');
	Route::any('customerView/{customerId}', 'home\CustomerController@customerView');

	Route::get('payForMyFriend/{customerId?}', 'home\ReportController@payForMyFriend');
	Route::any('savePayForMyFriend', 'home\ReportController@savePayForMyFriend');
	Route::any('checkPackagePurchase', 'home\ReportController@checkPackagePurchase');

	Route::get('renewalSubscription/{customerId?}', 'home\CustomerController@renewalSubscription');
	Route::any('saveRenewalSubscription', 'home\CustomerController@saveRenewalSubscription');

	Route::any('commissionReport', 'home\CustomerController@commissionReport');
	Route::any('loadCommissionReportsById', 'home\ProfileController@loadCommissionReportsById');
	Route::get('commissionReportDetails/{userId}/{referenceId}', 'home\CustomerController@commissionReportDetails');
	Route::get('directSales', 'home\CustomerController@directSales');

	//Packages or Plans
	Route::get('plans', 'home\PackagesController@plans');
	Route::any('deletePackageStatus', 'home\PackagesController@deletePackageStatus');
	Route::any('addNewPackageInfo', 'home\PackagesController@addNewPackageInfo');
	Route::any('getEditPackageInfo', 'home\PackagesController@getEditPackageInfo');
	Route::any('updatePackageInfo', 'home\PackagesController@updatePackageInfo');
	Route::any('deletePackageImage', 'home\PackagesController@deletePackageImage');

	//customer Bonus
	Route::get('customer_bonus', 'home\SettingsController@customer_bonus');
	Route::any('addCustomerBonus', 'home\SettingsController@addCustomerBonus');

	Route::any('requestedMovies', 'home\SettingsController@requestedMovies');
	Route::any('sendFCMUploadedMovie', 'home\SettingsController@sendFCMUploadedMovie');

	// Route::any('recentMoviesImages', 'home\SettingsController@recentMoviesImages');
	Route::any('addNewMovieImage', 'home\SettingsController@addNewMovieImage');
	Route::any('deleteMovieStatus', 'home\SettingsController@deleteMovieStatus');

	Route::any('iptvStreamingURLs', 'home\SettingsController@iptvStreamingURLs');
	Route::any('updateIPTVStreamingInfo', 'home\SettingsController@updateIPTVStreamingInfo');

	// TV version updates
	Route::any('getMobileVersions', 'home\SettingsController@getMobileVersions');
	Route::any('updateMobileAppVersions', 'home\SettingsController@updateMobileAppVersions');

	// tab/mobile version updates
	Route::any('getTabMobileVersions', 'home\SettingsController@getTabMobileVersions');
	Route::any('updateTabMobileAppVersions', 'home\SettingsController@updateTabMobileAppVersions');

	//Resend Verify E-mail
	Route::any('resendVerifyEmail', 'home\SettingsController@resendVerifyEmail');
	Route::any('resendVerifyEmailToUser', 'home\SettingsController@resendVerifyEmailToUser');
	Route::any('deleteInvalidEmail', 'home\SettingsController@deleteInvalidEmail');

	//referral
	Route::any('getReferralsList', 'home\ReferralController@getReferralsList');
	//Route::any('getCustomerTransactionsList', 'home\ReferralController@getCustomerTransactionsList');

	Route::any('check_time_zone', 'home\AdminController@check_time_zone');

	// Mobile menu settings
	Route::any('mobile_menu_settings', 'home\MobileMenuSettingsController@mobile_menu_settings');
	Route::any('addNewMobileMenu', 'home\MobileMenuSettingsController@addNewMobileMenu');
	Route::any('changeMenuLocation', 'home\MobileMenuSettingsController@changeMenuLocation');
	Route::any('deleteMenuStatus', 'home\MobileMenuSettingsController@deleteMenuStatus');
	Route::any('updateMenuPermissions', 'home\MobileMenuSettingsController@updateMenuPermissions');
	Route::any('updateMenuOrders', 'home\MobileMenuSettingsController@updateMenuOrders');
	Route::any('displayDashboardAt', 'home\MobileMenuSettingsController@displayDashboardAt');

	Route::get('transactions', 'home\ReportController@transactions');
	Route::get('withdrawal', 'home\ReportController@withdrawal');
	Route::get('transferToCryptoWallet', 'home\ReportController@transferToCryptoWallet');
	Route::any('saveWithdrawal', 'home\ReportController@saveWithdrawal');
	Route::any('amountTransferToWallet', 'home\ReportController@amountTransferToWallet');
	Route::any('saveTransferToWallet', 'home\ReportController@saveTransferToWallet');
	Route::any('withdrawRequestedList', 'home\ReportController@withdrawRequestedList');
	Route::any('updateWithdrawPaymentRequest', 'home\ReportController@updateWithdrawPaymentRequest');

	Route::any('customerActivation', 'home\CustomerController@customerActivation');
	Route::any('subscribePackage/{customerId}/{type?}', 'home\CustomerController@subscribePackage');
	Route::any('saveSubscribePackage/{id}', 'home\CustomerController@saveSubscribePackage');
	Route::any('saveRenewPackage/{id}', 'home\CustomerController@saveRenewPackage');
	Route::any('updateOrderFromAdmin/{type?}', 'home\CustomerController@updateOrderFromAdmin');
	Route::any('updateCustomerOrderFromAdmin', 'home\CustomerController@updateCustomerOrderFromAdmin');
	Route::any('checkOrderIdExistsOrNot', 'home\CustomerController@checkOrderIdExistsOrNot');
	Route::any('updateOrderStatus', 'home\CustomerController@updateOrderStatus');
	Route::any('getShippingAddress', 'home\CustomerController@getShippingAddress');

	Route::any('renewal/{id?}', 'home\CustomerController@renewal');
	Route::any('renewalpkg/{id?}', 'home\CustomerController@renewalpkg');
	Route::any('multibox/{id?}', 'home\CustomerController@multibox');
	Route::any('saveRenewal', 'home\CustomerController@saveRenewal');
	Route::any('renewalActivation', 'home\CustomerController@renewalActivation');
	Route::any('freeTrailRequest', 'home\CustomerController@freeTrailRequest');

	Route::any('newbox/{id?}', 'home\CustomerController@newbox');
	Route::any('confirmation', 'home\CustomerController@buyOrSubscribeConfirmation');
	Route::any('addnewAddress', 'home\CustomerController@addnewAddress');
	Route::any('saveBuyOrSubscribe', 'home\CustomerController@saveBuyOrSubscribe');
	Route::any('getShipAddress', 'home\CustomerController@getShipAddress');
	Route::any('updateDefaultAddress', 'home\CustomerController@updateDefaultAddress');

	Route::any('everusPayCallback', 'home\CustomerController@everusPayCallback');
	Route::any('checkPaymentWaitingStatus', 'home\CustomerController@checkPaymentWaitingStatus');
	Route::any('curlCall', 'home\CustomerController@curlCall');

	Route::any('packagePurchasedList', 'home\ReportController@packagePurchasedList');

	Route::any('updateOrderDetails', 'home\AdminController@updateOrderDetailsPage');
	Route::any('updateCustomerOrderDetails', 'home\AdminController@updateCustomerOrderDetails');

Route::any('updatedOrdersList/{type?}','home\AdminController@updatedOrdersList');
	Route::any('tree_view','home\TreeViewController@tree_view');
	Route::any('getunilevelData','home\TreeViewController@getunilevelData');

	Route::any('notifications', 'home\ReportController@notifications');
	Route::any('notificationStatusUpdate', 'home\ReportController@notificationStatusUpdate');

	Route::any('announcements', 'home\ReportController@announcements');

	Route::any('adminUsersList', 'home\AdminUserController@adminUsersList');
	Route::any('addUser', 'home\AdminUserController@addUser');
	Route::any('createAdminUser', 'home\AdminUserController@createAdminUser');
	Route::any('rolesList', 'home\AdminUserController@rolePermissions');
	Route::any('editAdminUser/{uid}', 'home\AdminUserController@editAdminUser');
	Route::any('updateAdminUser', 'home\AdminUserController@updateAdminUser');
	Route::any('addRole', 'home\AdminUserController@addRole');
	Route::any('createRole', 'home\AdminUserController@createRole');
	Route::any('editRole/{rid}', 'home\AdminUserController@editRole');
	Route::any('updateRole', 'home\AdminUserController@updateRole');

	Route::any('createUser', 'home\AdminUserController@createUser');
	Route::any('getUserData', 'home\AdminUserController@getUserData');
	Route::any('updateUserStatus', 'home\AdminUserController@updateUserStatus');
	Route::any('checkEmailForRoleAssign', 'home\AdminUserController@checkEmailForRoleAssign');

	//social media icons
	Route::any('socialmedia', 'home\WebsiteController@socialmedia');

	//Tracking order
	Route::any('trackingOrder', 'home\SettingsController@trackingOrder');
	Route::any('sendTrakingDetailsToCustomer', 'home\ReportController@sendTrakingDetailsToCustomer');
	Route::any('payment_form/{id?}', 'home\PaymentController@payment_form');
	Route::any('confirmPayment', 'home\PaymentController@confirmPayment');

	// Free Trail Requested
	Route::any('freeTrailCmsAccounts', 'home\FreeTrailController@freeTrailCMSAccounts');
	Route::any('addNewCMSAccount', 'home\FreeTrailController@addNewCMSAccount');
	Route::any('checkCMSAccountExist', 'home\FreeTrailController@checkCMSAccountExist');
	Route::any('disableTrailCMSAccount', 'home\FreeTrailController@disableTrailCMSAccount');
	Route::any('deleteTrailCMSAccount', 'home\FreeTrailController@deleteTrailCMSAccount');
	Route::any('editCMSAccount', 'home\FreeTrailController@editCMSAccount');
	Route::any('updateCMSAccount', 'home\FreeTrailController@updateCMSAccount');

	Route::any('getFreeTrailRequestedUsers', 'home\FreeTrailController@getFreeTrailRequestedUsers');

	// Free Trail New
	Route::any('prospectsList', 'home\FreeTrailController@prospectsList');
	Route::any('testAccountStatusList', 'home\FreeTrailController@testAccountStatusList');
	Route::any('requestTrialsList', 'home\FreeTrailController@requestTrialsList');
	Route::any('trialAccountActivated', 'home\FreeTrailController@trialAccountActivated');
    Route::any('testCMSAccounts', 'home\FreeTrailController@testCMSAccounts');
    Route::any('addFreetrail', 'home\FreeTrailController@addFreetrail');
    Route::any('saveFreetrail', 'home\FreeTrailController@saveFreetrail');

	// vod purpose
	Route::any('freeTrailStartRequestInWeb', 'home\FreeTrailController@freeTrailStartRequestInWeb');

	//Announcements
	Route::any('getAnnouncementsList', 'home\AnnouncementsController@getAnnouncementsList');
	Route::any('sendAnnouncmentsToAll', 'home\AnnouncementsController@sendAnnouncmentsToAll');
	Route::any('addNewAnnouncment', 'home\AnnouncementsController@addNewAnnouncment');
	Route::any('saveAnnouncmentData', 'home\AnnouncementsController@saveAnnouncmentData');
	Route::any('editAnnouncment/{id?}', 'home\AnnouncementsController@editAnnouncment');
	Route::any('updateAnnouncmentData', 'home\AnnouncementsController@updateAnnouncmentData');
	Route::any('deleteAnnouncment', 'home\AnnouncementsController@deleteAnnouncment');
	Route::any('resendGeneralAnnouncement', 'home\AnnouncementsController@resendGeneralAnnouncement');
	
	//maintanance / server problem
	
	Route::any('announcementPopup_flag_update', 'home\AnnouncementsController@announcementPopup_flag_update');
	//force logout
	Route::any('getInstalledVersionsList', 'home\AppVersionsController@getInstalledVersionsList');
	Route::any('forceLogout', 'home\AppVersionsController@forceLogout');
	Route::any('sendFCMForceLogout', 'home\AppVersionsController@sendFCMForceLogout');

	Route::any('pendingShipment', 'home\ReportController@pendingShipment');
	Route::any('pendingActivation', 'home\ReportController@pendingActivation');
	Route::any('pendingRenewal', 'home\ReportController@pendingRenewal');
	Route::any('activeLine', 'home\ReportController@activeLine');
	Route::any('sendRenewalRemainder', 'home\ReportController@sendRenewalRemainder');
	Route::any('validatePortalCredentials', 'home\CustomerController@validatePortalCredentials');
	Route::any('validatePortalCredentialsForRenew', 'home\CustomerController@validatePortalCredentialsForRenew');

	Route::any('applicationSettings', 'home\SettingsController@applicationSettings');
	Route::any('save_proxy_settings', 'home\SettingsController@save_proxy_settings');
	Route::any('save_trail_earning', 'home\SettingsController@save_trail_earning');
	Route::any('save_vplayed_data_update', 'home\SettingsController@save_vplayed_data_update');
	Route::any('save_multi_acc_discount', 'home\SettingsController@save_multi_acc_discount');
	Route::any('save_maintanance_update', 'home\SettingsController@save_maintanance_update');

	Route::any('walletBalanceReport/{search?}/{filter?}/{sort?}/{print?}', 'home\ReportController@walletBalanceReport');
	Route::any('userDetailsReport/{search?}/{filter?}/{sort?}/{print?}', 'home\ReportController@userDetailsReport');

	Route::any('salesReport', 'home\ReportController@salesReport');

    Route::any('importEpgList', 'home\SettingsController@importEpgList');
    Route::any('save_epg_list', 'home\SettingsController@saveEpgList');
    Route::any('readUSFile', 'home\SettingsController@readUSFile');

	// VOD
	Route::any('vod/{is_home?}', 'home\VodController@vodDashboard');
	Route::any('vodOnVplayedMore/{page?}', 'home\VodController@vodOnVplayedMore');
	Route::any('vodOnVplayedShowMoreAjax', 'home\VodController@vodOnVplayedShowMoreAjax');
	Route::any('vodDetailView/{slug?}/{is_home?}', 'home\VodController@vodMovieDetailsView');
	Route::any('vodCategory', 'home\VodController@vodCategoryShowmore');
	Route::any('vodCategoryShowmoreAjax', 'home\VodController@vodCategoryShowmoreAjax');
    Route::any('updateDuration', 'home\VodController@updateDuration');
    Route::any('getContinueWatchList', 'home\VodController@getContinueWatchList');
    //Route::any('updateDurationOncache', 'home\VodController@updateDurationOncache');
	// LIVE TV
	//Route::any('livetvlist/{page?}/{country_id?}/{category?}/{searchKey?}', 'home\LivetvController@livetvDashboard');
	Route::any('livetv', 'home\LivetvController@livetvDashboard');
	Route::any('livetvDetails', 'home\LivetvController@livetvDetails');
	//Route::any('livetvDetails/{page?}/{country_id?}/{category?}/{searchKey?}', 'home\LivetvController@livetvDetails');
	Route::any('livetvChannelsLoadmore', 'home\LivetvController@livetvChannelsLoadmore');
	Route::any('livetvChannelView/{slug?}', 'home\LivetvController@livetvChannelView');

	//webseries
	Route::any('webseries/{is_home?}', 'home\WebseriesController@webseriesDashboard');
	Route::any('webseriesList', 'home\WebseriesController@webseriesList');
	Route::any('webserieslistLoadMore/{page?}', 'home\WebseriesController@webserieslistLoadMore');
	Route::any('webseriesDetailsList/{slug?}/{season_id?}', 'home\WebseriesController@webseriesDetailsList');
	Route::any('webseriesEpisodeView/{slug?}/{is_home?}', 'home\WebseriesController@webseriesEpisodeView');

	//catchuplist
	Route::any('catchupList', 'home\CatchUPController@getCatchupList');
	Route::any('getAjaxchannelList', 'home\CatchUPController@getAjaxchannelList');
	
	Route::any('catchupChannelData', 'home\CatchUPController@getCatchupChannelData');
	Route::any('CatchupView/{channel_name}/{p2p_id}', 'home\CatchUPController@CatchupView');
	
	Route::any('check_otp', 'home\VodController@check_otp');

	Route::any('test_player', 'home\VodController@test_player');

	//bitpay payment gateway

	Route::any('bitpay', 'home\BitpayController@bitpay');
	
});
Route::any('bitpaySuccess', 'home\BitpayController@bitpaySuccess');
// Cronjobs routes
Route::any('testCron', 'home\CronJobsController@testCron');

Route::any('packageBeforeSevenDaysAlert', 'home\CronJobsController@packageBeforeSevenDaysAlert');
Route::any('checkFreeTrailExpiryTime', 'home\CronJobsController@checkFreeTrailExpiryTime');
Route::any('packageSubscriptionExpired', 'home\CronJobsController@packageSubscriptionExpired');
Route::any('packageExpiredAlert', 'home\CronJobsController@packageExpiredAlert');
Route::any('check_otp', 'home\VodController@check_otp');
Route::any('runUSEPGlist', 'home\CronJobsController@runUSEPGlist');
Route::any('removeOldUSEPGlist', 'home\CronJobsController@removeOldUSEPGlist');


