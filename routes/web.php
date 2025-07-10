<?php

use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AutoreplyController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\AibotController;
use App\Http\Controllers\BlastController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MessagesHistoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RestapiController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShowMessageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PickindexController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Payments\PaymobController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\Payments;
use App\Http\Controllers\Admin\PaymentGatewayController;

use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\User\NotificationController as UserNotificationController;



require_once 'custom-route.php';

Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
	if(env("ENABLE_INDEX") == 'no'){
		Route::get('/', function()
		{
			return Redirect::to( '/login');
		});
	}else{
		Route::get('/',[IndexController::class,'index'])->name('index');
	}
	
	Route::middleware('2fa')->group(function (){
		Route::get('/2fa', [TwoFactorController::class, 'showVerify'])->name('2fa.verify');
		Route::post('/2fa', [TwoFactorController::class, 'verifyLogin'])->name('2fa.verify');
	});
	Route::middleware('auth', '2fa')->group(function (){
		Route::group(['prefix' => 'laravel-filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
		Route::get('/home',[HomeController::class,'index'])->name('home');
		Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file-manager');
		Route::get('/filemanager', function () { return redirect('/'.LaravelLocalization::getCurrentLocale().'/laravel-filemanager'); })->name('filemanager');
		Route::post('/home/setSessionSelectedDevice',[HomeController::class,'setSelectedDeviceSession'])->name('home.setSessionSelectedDevice');
		Route::post('/home/sethook',[HomeController::class,'setHook'])->name('setHook');
		Route::post('/home/setavailable',[HomeController::class,'setAvailable'])->name('setAvailable');
		Route::post('/home/setdelay',[HomeController::class,'setDelay'])->name('setDelay');
		Route::post('/home/sethookread',[HomeController::class,'setHookRead'])->name('setHookRead');
		Route::post('/home/sethookreject',[HomeController::class,'setHookReject'])->name('setHookReject');
		Route::post('/home/sethooktyping',[HomeController::class,'setHookTyping'])->name('setHookTyping');
		Route::post('/home/setGPT',[HomeController::class,'setGPT'])->name('setGPT');
		Route::post('/home',[HomeController::class,'store'])->name('addDevice');
		Route::delete('/home',[HomeController::class,'destroy'])->name('deleteDevice');

		Route::get('/scan/{number:body}',[ScanController::class,'scan'])->name('scan');
		Route::get('/code/{number:body}',[ScanController::class,'code'])->name('connect-via-code');

		Route::get('/autoreply',[AutoreplyController::class,'index'])->name('autoreply')->middleware('permissions');
		Route::post('/autoreply',[AutoreplyController::class,'store'])->name('autoreply')->middleware('permissions');
		Route::get('/autoreply-edit/{id}', [AutoreplyController::class, 'edit'])->name('autoreply.edit')->middleware('permissions');
		Route::post('/autoreply-edit', [AutoreplyController::class, 'editUpdate'])->name('autoreply.edit.update')->middleware('permissions');
		Route::delete('/autoreply',[AutoreplyController::class,'destroy'])->name('autoreply.delete')->middleware('permissions');
		Route::post('auto-reply/update/{autoreply:id}',[AutoreplyController::class,'update'])->name('autoreply.update')->middleware('permissions');

		Route::get('/aibot',[AibotController::class,'index'])->name('aibot')->middleware('permissions');
		Route::post('/aibot',[AibotController::class,'store'])->name('aibot')->middleware('permissions');
		
		Route::get('/phonebook',[TagController::class,'index'])->name('phonebook');
		Route::get('/get-phonebook',[TagController::class,'getPhonebook'])->name('getPhonebook');
		Route::delete('/clear-phonebook',[TagController::class,'clearPhonebook'])->name('clearPhonebook');
		Route::get('get-contact/{id}',[ContactController::class,'getContactByTagId']);
		Route::post('/contact/store',[ContactController::class,'store'])->name('contact.store');
		Route::delete('/contact/delete/{contact:id}',[ContactController::class,'destroy'])->name('contact.delete');
		Route::delete('/contact/delete-all/{id}',[ContactController::class,'DestroyAll'])->name('deleteAll');
		Route::post('/contact/import',[ContactController::class,'import'])->name('import');
		Route::get('/contact/export/{id}',[ContactController::class,'export'])->name('exportContact');

	  Route::post('/tags',[TagController::class,'store'])->name('tag.store');
	  Route::delete('/tags',[TagController::class,'destroy'])->name('tag.delete');
	  Route::post('fetch-groups',[TagController::class ,'fetchGroups'])->name('fetch.groups');

	  Route::get('/campaigns',[CampaignController::class,'index'])->name('campaigns')->middleware('permissions');
	  Route::get('/campaign/create',[CampaignController::class,'create'])->name('campaign.create')->middleware('permissions');
	  Route::post('/campaign/store',[CampaignController::class,'store'])->name('campaign.store')->middleware('permissions');
	  Route::post('/campaign/pause/{id}',[CampaignController::class,'pause'])->name('campaign.pause')->middleware('permissions');
	  Route::post('/campaign/resume/{id}',[CampaignController::class,'resume'])->name('campaign.resume')->middleware('permissions');
	  Route::delete('/campaign/delete/{id}',[CampaignController::class,'destroy'])->name('campaign.delete')->middleware('permissions');
	  Route::get('/campaign/show/{id}',[CampaignController::class,'show'])->name('campaign.show')->middleware('permissions');
	  Route::delete('/campaign/clear',[CampaignController::class,'destroyAll'])->name('campaigns.delete.all')->middleware('permissions');
	  Route::get('/campaign/blast/{campaign:id}',[BlastController::class,'index'])->name('campaign.blasts')->middleware('permissions');

	  Route::post('/preview-message',[ShowMessageController::class,'index'])->name('previewMessage');
	  Route::get('/form-message/{type}',[ShowMessageController::class,'getFormByType'])->name('formMessage');
	  Route::get('/form-message-edit/{type}',[ShowMessageController::class,'showEdit'])->name('formMessageEdit');

	  Route::get('/message/test',[MessagesController::class,'index'])->name('messagetest');
	  Route::post('/message/test',[MessagesController::class,'store'])->name('messagetest')->middleware('permissions');

	  Route::get('/api-docs',RestapiController::class)->name('rest-api')->middleware('permissions');

	  Route::get('/user/settings',[UserController::class,'settings'])->name('user.settings');
	  Route::post('/user/change-password',[UserController::class,'changePasswordPost'])->name('changePassword');
	  Route::post('/user/setting/apikey',[UserController::class,'generateNewApiKey'])->name('generateNewApiKey');
	  Route::post('/user/setting/deletehistory',[UserController::class,'deleteHistory'])->name('deleteHistory');
	  
	  Route::post('/settings/timezone', [UserController::class, 'updateTimezone'])->name('user.settings.timezone');
	  
	  Route::post('/user/settings/2fa', [UserController::class, 'toggleTwoFactor'])->name('user.settings.2fa');
	  Route::get('/user/2fa_setup', [TwoFactorController::class, 'showSetup'])->name('user.2fa_setup');
	  Route::post('/user/2fa/verify', [TwoFactorController::class, 'verify'])->name('user.2fa.verify');
	  
	  Route::post('/user/notification-seen', [UserNotificationController::class, 'markAsSeen'])->name('user.notification.seen');
	  
	  Route::get('/admin/settings',[SettingController::class,'index'])->name('admin.settings')->middleware('admin');
	  Route::post('/settings/server',[SettingController::class,'setServer'])->name('setServer')->middleware('admin');
	  Route::post('/settings/generate-ssl', [SettingController::class, 'generateSslCertificate'])->name('generateSsl')->middleware('admin');
	  Route::post('/settings/setenvall', [SettingController::class, 'setEnvAll'])->name('setEnvAll')->middleware('admin');
	  
	  Route::get('/admin/cronjob',[SettingController::class,'cronJob'])->name('cronjob')->middleware('admin');

	  Route::get('tickets', [UserTicketController::class, 'index'])->name('user.tickets.index');
	  Route::post('tickets/{ticket}/reply', [UserTicketController::class, 'reply'])->name('user.tickets.reply');
	  Route::post('tickets/store', [UserTicketController::class, 'store'])->name('user.tickets.store');
	  Route::get('tickets/create', [UserTicketController::class, 'create'])->name('user.tickets.create');
	  Route::get('tickets/{ticket}', [UserTicketController::class, 'show'])->name('user.tickets.show');

	  Route::get('/admin/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index')->middleware('admin');
	  Route::get('/admin/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show')->middleware('admin');
	  Route::post('/admin/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('admin.tickets.reply')->middleware('admin');
	  Route::post('/admin/tickets/{ticket}/close', [AdminTicketController::class, 'close'])->name('admin.tickets.close')->middleware('admin');
	  Route::post('/admin/tickets/{ticket}/reopen', [AdminTicketController::class, 'reopen'])->name('admin.tickets.reopen')->middleware('admin');

	  Route::get('/admin/plans', [PlansController::class, 'index'])->name('admin.plans.index')->middleware('admin');
	  Route::get('/admin/plans/create', [PlansController::class, 'create'])->name('admin.plans.create')->middleware('admin');
	  Route::post('/admin/plans', [PlansController::class, 'store'])->name('admin.plans.store')->middleware('admin');
	  Route::get('/admin/plans/{plan}/edit', [PlansController::class, 'edit'])->name('admin.plans.edit')->middleware('admin');
	  Route::put('/admin/plans/{plan}', [PlansController::class, 'update'])->name('admin.plans.update')->middleware('admin');
	  Route::delete('/admin/plans/{plan}', [PlansController::class, 'destroy'])->name('admin.plans.destroy')->middleware('admin');
	  
	  Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index')->middleware('admin');
	  Route::post('/admin/notifications', [NotificationController::class, 'send'])->name('admin.notifications.send')->middleware('admin');
	  
	  Route::get('/admin/pickindex', [PickindexController::class, 'editSettings'])->name('admin.index.edit')->middleware('admin');
	  Route::post('/admin/pickindex', [PickindexController::class, 'updateSettings'])->name('admin.index.update')->middleware('admin');
	  Route::post('/admin/pickindexcolor', [PickindexController::class, 'updateColor'])->name('admin.index.color')->middleware('admin');
	  Route::post('/admin/pickindexenable', [PickindexController::class, 'enableIndex'])->name('admin.index.enable')->middleware('admin');
	  
	  Route::get('/admin/languages', [LanguageController::class, 'index'])->name('languages.index')->middleware('admin');
	  Route::get('/admin/languages/{lang}/edit', [LanguageController::class, 'edit'])->name('languages.edit')->middleware('admin');
	  Route::post('/admin/languages/{lang}', [LanguageController::class, 'update'])->name('languages.update')->middleware('admin');
	  Route::post('/admin/languages/add/new', [LanguageController::class, 'add'])->name('languages.add')->middleware('admin');
	  Route::delete('/admin/languages/{lang}', [LanguageController::class, 'destroy'])->name('languages.destroy')->middleware('admin');
	  
	  Route::get('/admin/update',[UpdateController::class,'checkUpdate'])->name('update')->middleware('admin');
	  Route::post('/admin/update/install',[UpdateController::class,'installUpdate'])->name('update.install')->middleware('admin');
	  
	  Route::get('/admin/manage-themes',[ThemesController::class,'index'])->name('admin.manage-themes')->middleware('admin');
	  Route::get('/admin/active-themes/{name}',[ThemesController::class,'activeTheme'])->name('themes.active')->middleware('admin');
	  Route::post('/admin/download-themes',[ThemesController::class,'downloadTheme'])->name('themes.download')->middleware('admin');
	  Route::post('/admin/delete-themes',[ThemesController::class,'deleteTheme'])->name('themes.delete')->middleware('admin');

	  Route::get('/admin/manage-users',[ManageUsersController::class,'index'])->name('admin.manage-users')->middleware('admin');
	  Route::post('/admin/user/store',[ManageUsersController::class,'store'])->name('user.store')->middleware('admin');
	  Route::post('/admin/user/updatePlan/{id}',[ManageUsersController::class,'updatePlan'])->name('admin.users.updatePlan')->middleware('admin');
	  Route::delete('/admin/user/delete/{id}',[ManageUsersController::class,'delete'])->name('user.delete')->middleware('admin');
	  Route::get('admin/user/edit',[ManageUsersController::class,'edit'])->name('user.edit')->middleware('admin');
	  Route::post('admin/user/update',[ManageUsersController::class,'update'])->name('user.update')->middleware('admin');
	  
	  Route::get('/login-as-user/{id}', [ManageUsersController::class, 'loginAsUser'])->name('admin.loginAsUser')->middleware('admin');
	  Route::get('/back-to-admin', [ManageUsersController::class, 'backToAdmin'])->name('admin.backToAdmin')->middleware('admin');
	  
	  Route::get('/checkout/{planId}', [PaymentController::class, 'checkout'])->name('payments.checkout');
	  Route::post('/checkout/{planId}', [PaymentController::class, 'process'])->name('payments.process');
	  Route::get('/trial/{planId}', [PaymentController::class, 'trial'])->name('payments.trial');
	  Route::post('/trial/{planId}', [PaymentController::class, 'trialProcess'])->name('payments.process.trial');
	  Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payments.callback');
	  Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payments.callback');
	  Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');
	  Route::post('/paypal/ipn', [PayPalController::class, 'handleIpn'])->name('paypal.ipn');
	  Route::post('/payments/paymob/process', [PaymobController::class, 'process'])->name('payments.paymob.process');
	  Route::post('/payments/paymob/callback', [PaymobController::class, 'callback'])->name('payments.paymob.callback');
	  
	  Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index')->middleware('admin');
	  Route::post('/admin/orders', [OrderController::class, 'changeStatus'])->name('admin.orders.status')->middleware('admin');

	  Route::get('/messages-history',[MessagesHistoryController::class,'index'])->name('messages.history');
	  Route::post('/resend-message',[MessagesHistoryController::class,'resend'])->name('resend.message');
	  Route::post('/delete-messages',[MessagesHistoryController::class,'deleteAll'])->name('delete.messages');
	  
	  Route::get('/admin/payments', [PaymentGatewayController::class, 'index'])->name('admin.payments.index')->middleware('admin');
	  Route::post('/admin/payments/update', [PaymentGatewayController::class, 'update'])->name('admin.payments.update')->middleware('admin');
	  
	  Route::get('/permission-denied', function () { return view('theme::pages.permission'); })->name('permission.denied');

	});

	Route::middleware('guest')->group(function(){

		Route::get('/login',[LoginController::class,'index'])->name('login');
		Route::get('/register',[RegisterController::class,'index'])->name('register');
		Route::post('/register',[RegisterController::class,'store'])->name('register');
		Route::post('/login',[LoginController::class,'store'])->name('login')->middleware('throttle:5,1');
		Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
		Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
		Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
		Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
	});
	Route::match(['get', 'post'], '/logout', LogoutController::class)->name('logout');
	Route::get('/install', [SettingController::class,'install'])->name('setting.install_app');
	Route::post('/install', [SettingController::class,'install'])->name('settings.install_app');

	Route::post('/settings/check_database_connection',[SettingController::class,'test_database_connection'])->name('connectDB');
	Route::post('/settings/activate_license',[SettingController::class,'activate_license'])->name('activateLicense');
});

?>