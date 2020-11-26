<?php

use Illuminate\Http\Request;

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
Route::any('bitpayCallback', 'API\LoginController@bitpayCallback');

Route::post('login', 'API\LoginController@login');
Route::post('loginOld', 'API\LoginController@loginOld');

Route::post('sendCustomerIDToEmail', 'API\LoginController@sendCustomerIDToEmail');
Route::post('sendForgetPasswordLinkToEmail', 'API\LoginController@sendForgetPasswordLinkToEmail');

Route::any('customerSignup', 'API\RegistrationController@customerSignup');
Route::any('checkEmailExistOrNot', 'API\RegistrationController@checkEmailExistOrNot');
Route::any('sampletest.json', 'API\RegistrationController@sampleTest');
//Route::any('sampletesttwo.json', 'API\RegistrationController@appDownload');
Route::any('apkversion', 'API\RegistrationController@apkVersion');


//for thirdparty sellers starts
Route::any('customerSignupAPI', 'API\BestBoxThirdpartyController@bbCustomerSignupAPI');
Route::any('packagePurchaseAPI', 'API\BestBoxThirdpartyController@bbPackagePurchaseAPI');
Route::any('bbCountryListAPI', 'API\BestBoxThirdpartyController@bbCountryListAPI');
Route::any('packageListAPI', 'API\BestBoxThirdpartyController@bbPackageListAPI');

//for thirdparty sellers ends
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
	Route::post('userDetails', 'API\UserController@userDetails'); //done
	Route::any('maintanance_details', 'API\UserController@maintananceDetails'); //done
	Route::any('announcementPopup_flag_update', 'API\UserController@announcementPopup_flag_update');
	Route::any('updateIptvCountryName', 'API\UserController@updateIptvCountryName');
	Route::any('updateVLSChangeFlag', 'API\UserController@updateVLSChangeFlag');
	Route::any('logout', 'API\UserController@logout');
	// online / offline status request
	Route::any('isOnlineRequest', 'API\UserController@isOnlineRequest'); //done
	Route::any('isOfflineRequest', 'API\UserController@isOfflineRequest'); //done

	Route::post('getCountriesList', 'API\AgentsController@getCountriesList');
	Route::post('disableBadgeCount', 'API\UserController@disableBadgeCount'); //doc
	// agents
	Route::post('getAgentsList', 'API\AgentsController@getAgentsList');
	Route::post('creatNewAgent', 'API\AgentsController@creatNewAgent');
	Route::post('updateAgentInfo', 'API\AgentsController@updateAgentInfo');
	Route::post('deleteAgent', 'API\AgentsController@deleteAgent');

	// Direct Sales
	Route::post('getDirectSalesList', 'API\DirectSalesController@getDirectSalesList');

	//Commission Report
	Route::post('getCommissionReport', 'API\CommissionReportController@getCommissionReport');
	Route::post('getCommissionDetailview', 'API\CommissionReportController@getCommissionDetailview');


	//Packages
	Route::post('packagesList', 'API\PackagesController@getPackagesList');

	// Customers List
	Route::post('getCustomersList', 'API\CustomersController@getCustomersListNew');
	Route::post('getCustomersListNew', 'API\CustomersController@getCustomersListNew');
	Route::post('createNewCustomer', 'API\CustomersController@createNewCustomer');
	Route::post('deleteCustomer', 'API\CustomersController@deleteCustomer');
	Route::post('updateCustomerInfo', 'API\CustomersController@updateCustomerInfo');
	Route::post('payCustomerList', 'API\CustomersController@payCustomerList');
	Route::post('payCustomerListNew', 'API\CustomersController@payCustomerListNew');
	Route::post('payForMyFriendAPI', 'API\CustomersController@payForMyFriendAPI');
	Route::post('saveRenewalAPI', 'API\CustomersController@saveRenewalAPI');


	//referred customers
	Route::post('getCustomerReferralsList', 'API\CustomerReferralController@getCustomerReferralsList');

	// Transactions
	Route::any('transactionsFilters', 'API\TransactionsController@transactionsFilters');
	Route::post('getTransactionsList', 'API\TransactionsController@getTransactionsList');
	//Profile
	Route::post('getProfileDet', 'API\ProfileController@getProfile');
	Route::post('updateProfile', 'API\ProfileController@updateProfile');
	Route::post('updateProfilepic', 'API\ProfileController@updateProfilepic');

	//change password
	Route::post('changeNewPassword', 'API\ProfileController@changeNewPassword');

	// Withdrawal Request
	Route::post('withdrawaloptions', 'API\WithdrawalController@withdrawaloptions');
	Route::post('withdrawalOptionCustomers', 'API\WithdrawalController@withdrawalOptionCustomers');
	Route::post('sendWithdrawalAmt', 'API\WithdrawalController@sendWithdrawalAmt');
	Route::post('withdrawalRequestedList', 'API\WithdrawalController@withdrawalRequestedList');

	// update Orders(customers)
	Route::post('getOrdersList', 'API\OrdersUpdateController@getOrdersList');
	Route::post('updateOrderInfo', 'API\OrdersUpdateController@updateOrderInfo');

	//requested movies
	Route::any('requestedMovies', 'API\RequestedMoviesController@saveRequestedMovies');

	//Free trail requested users
	Route::any('freeTrailRequestedAPI', 'API\RequestedMoviesController@freeTrailRequestedAPI');
	Route::any('freeTrailThankyouRequest', 'API\RequestedMoviesController@freeTrailThankyouRequest');
	Route::any('freeTrailStartRequest', 'API\RequestedMoviesController@freeTrailStartRequest');
	Route::any('freeTrailExtendRequest', 'API\RequestedMoviesController@freeTrailExtendRequest');

	Route::post('subscribeUser', 'API\UserController@subscribeUser');

	Route::post('getEpgList', 'API\EpgController@getEpgList');


	//for web apis

	Route::get('subscribeUser', 'API\UserController@subscribeUser');
});
