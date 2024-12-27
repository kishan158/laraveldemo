<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\Admin\VendorController;
use App\Http\Controllers\Back\Admin\HomeCustomizeController;
use App\Http\Controllers\Back\Admin\ServiceController;
use App\Http\Controllers\Back\Admin\AdminOrderController;
use App\Http\Controllers\Back\Admin\PageController;
use App\Http\Controllers\Back\Admin\CategoryController;
use App\Http\Controllers\Back\Admin\ProductController;
use App\Http\Controllers\Back\Admin\RechargeController;

use App\Http\Controllers\Back\Vendor\VendorServiceController;
use App\Http\Controllers\Back\Vendor\WalletController;
use App\Http\Controllers\Back\Vendor\ProfileController;
use App\Http\Controllers\Back\Vendor\FinanceController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\UserDashBoardController;

Route::get('login', [LoginController::class, 'login'])->name('vendor.login');
Route::get('admin', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::post('admin', [LoginController::class, 'adminSubmit'])->name('admin.submit');
Route::post('login', [LoginController::class, 'loginSubmit'])->name('vendor.login.submit');
Route::get('/register', [RegisterController::class, 'register'])->name('vendor.register');
Route::post('/register',[RegisterController::class,'submit'])->name('vender.register.submit');

Route::middleware(['admin','PreventBackHistory'])->group(function () {
    Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/admin/vendor/list',[VendorController::class,'list'])->name('admin.vendor.list');
    Route::get('/admin/vendor/add',[VendorController::class,'add'])->name('admin.vendor.add');
    Route::post('/admin/vendor/add',[VendorController::class,'submit'])->name('admin.vendor.submit');
    Route::post('/admin/vendor/{id}/status',[VendorController::class,'Updatestatus'])->name('admin.vendor.status');
    Route::get('/admin/vendor/{id}/profile',[VendorController::class,'VendorProfile'])->name('admin.vendor.profile');
    Route::get('/admin/vendor/{id}/assign_cat',[VendorController::class,'Vendor_cat'])->name('admin.vendor.cat');
    Route::post('/admin/vendor/{id}/assign_cat',[VendorController::class,'Vendor_cat_submit'])->name('admin.vendor.catSubmit');
    Route::get('/admin/vendor/{id}/order_history',[VendorController::class,'Vendor_order_history'])->name('admin.vendor.order_history');
    Route::get('/admin/vendor/{id}/order_history',[VendorController::class,'Vendor_order_history'])->name('admin.vendor.order_history');
    Route::get('/admin/vendor/order/{order_id}/history/show', [VendorController::class, 'Vendor_orderhistory_show'])->name('admin.vendor.orderhistory_show');

    Route::get('/admin/service/list',[ServiceController::class,'list'])->name('admin.service.list');
    Route::get('/admin/service/add',[ServiceController::class,'add'])->name('admin.service.create');
    Route::post('/admin/service/add',[ServiceController::class,'submit'])->name('admin.service.submit');
    Route::get('/admin/service/edit/{id}',[ServiceController::class,'serviceEdit'])->name('admin.service.edit');
    Route::post('/admin/service/edit/{id}',[ServiceController::class,'serviceUpdate'])->name('admin.service.update');
    Route::delete('/admin/service/delete/{id}', [ServiceController::class, 'serviceDelete'])->name('admin.service.delete');

    Route::get('/admin/service/title/list/{id}',[ServiceController::class,'Titlelist'])->name('admin.service.title.list');
    Route::get('/admin/service/title/add/{id}',[ServiceController::class,'Titleadd'])->name('admin.service.title.add');
    Route::post('/admin/service/title/add/{id}',[ServiceController::class,'TitleSubmit'])->name('admin.service.title.submit');
    Route::get('/admin/service/title/edit/{id}',[ServiceController::class,'TitleEdit'])->name('admin.service.title.Edit');
    Route::post('/admin/service/title/edit/{id}',[ServiceController::class,'TitleUpdate'])->name('admin.service.title.Update');
    Route::delete('/admin/service/title/delete/{id}',[ServiceController::class,'TitleDelete'])->name('admin.service.title.delete');



    Route::get('/admin/issue/list/{id}',[ServiceController::class,'IssueList'])->name('admin.issue.list');
    Route::get('/admin/issue/add/{id}',[ServiceController::class,'issueAdd'])->name('admin.issue.add');
    Route::post('/admin/issue/add/{id}',[ServiceController::class,'issueSubmit'])->name('admin.issue.submit');
    Route::get('/admin/issue/edit/{id}',[ServiceController::class,'issueEdit'])->name('admin.issue.edit');
    Route::post('/admin/issue/edit/{id}',[ServiceController::class,'issueUpdate'])->name('admin.issue.update');
    Route::delete('/admin/issue/delete/{id}', [ServiceController::class, 'issueDelete'])->name('admin.issue.delete');

    Route::get('/admin/product_type/list/{id}',[ProductController::class,'ProductTypeList'])->name('admin.product_type.list');
    Route::get('/admin/product_type/add/{id}',[ProductController::class,'AddProductType'])->name('admin.product_type.add');
    Route::post('/admin/product_type/add/{id}',[ProductController::class,'SubmitProductType'])->name('admin.product_type.submit');
    Route::get('/admin/product_type/edit/{id}',[ProductController::class,'EditProductType'])->name('admin.product_type.edit');
    Route::post('/admin/product_type/edit/{id}',[ProductController::class,'UpdateProductType'])->name('admin.product_type.update');
    Route::delete('/admin/product_type/{id}',[ProductController::class,'DeleteProductType'])->name('admin.product_type.delete');

    Route::get('/admin/part/list/{id}',[ProductController::class,'PartList'])->name('admin.Part.list');
    Route::get('/admin/part/add/{id}',[ProductController::class,'PartAdd'])->name('admin.Part.add');
    Route::post('/admin/part/add/{id}',[ProductController::class,'PartSubmit'])->name('admin.Part.submit');
    Route::get('/admin/part/edit/{id}',[ProductController::class,'PartEdit'])->name('admin.Part.edit');
    Route::post('/admin/part/edit/{id}',[ProductController::class,'PartEditUpdate'])->name('admin.Part.update');
    Route::delete('/admin/part/delete/{id}', [ProductController::class, 'PartDelete'])->name('admin.Part.delete');


    Route::get('/admin/subcategory/list',[CategoryController::class,'SubCategoryList'])->name('admin.Subcategory.list');
    Route::get('/admin/subcategory/add',[CategoryController::class,'AddSubCategory'])->name('admin.subcategory.add');
    Route::post('/admin/subcategory/add',[CategoryController::class,'SubmitSubCategory'])->name('admin.subcategory.submit');
    Route::get('/admin/subcategory/edit/{id}',[CategoryController::class,'EditSubCategory'])->name('admin.subcategory.edit');
    Route::post('/admin/subcategory/edit/{id}',[CategoryController::class,'UpdateSubCategory'])->name('admin.subcategory.update');
    Route::delete('/admin/subcategory/{id}',[CategoryController::class,'DeleteSubCategory'])->name('admin.subcategory.delete');


    Route::get('/admin/category/list',[CategoryController::class,'CategoryList'])->name('admin.category.list');

    Route::get('/admin/category/add',[CategoryController::class,'AddCategory'])->name('admin.category.add');
    Route::post('/admin/category/add',[CategoryController::class,'SubmitCategory'])->name('admin.category.submit');
    Route::get('/admin/category/update/{id}', [CategoryController::class, 'updateStatus'])->name('category.update.status');
    Route::post('/admin/category/update/{id}', [CategoryController::class, 'CategoryupdateStatus'])->name('admin.category.update.status');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'Categorydelete'])->name('admin.category.delete');



    Route::get('/admin/product/list',[ProductController::class,'ProductList'])->name('admin.product.list');
    Route::get('/admin/product/add',[ProductController::class,'ProductAdd'])->name('admin.product.add');
    Route::post('/admin/product/add',[ProductController::class,'ProductSubmit'])->name('admin.product.submit');
    Route::get('/admin/product/edit/{id}',[ProductController::class,'ProductEdit'])->name('admin.product.edit');
    Route::post('/admin/product/edit/{id}',[ProductController::class,'ProductEditUpdate'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'ProductDelete'])->name('admin.product.delete');


    Route::get('/admin/package/list',[ServiceController::class,'package'])->name('admin.package.list');
    Route::get('/admin/package/add',[ServiceController::class,'packageAdd'])->name('admin.package.add');
    Route::post('/admin/package/add',[ServiceController::class,'packageSubmit'])->name('admin.package.submit');
    Route::get('/admin/package/edit/{id}',[ServiceController::class,'packageEdit'])->name('admin.package.edit');
    Route::post('/admin/package/edit/{id}',[ServiceController::class,'packageUpdate'])->name('admin.package.update');
    Route::delete('/admin/package/delete/{id}', [ServiceController::class, 'packageDelete'])->name('admin.package.delete');

    Route::get('/admin/order',[AdminOrderController::class,'Order'])->name('admin.order');
    Route::post('/check-availability', [AdminOrderController::class, 'checkAvailability'])->name('check.availability');

    Route::post('/admin/order/transfer', [AdminOrderController::class, 'TransferVendorOrder'])->name('admin.transfer.admin');
    Route::delete('/admin/order/{id}', [AdminOrderController::class, 'deleteOrder'])->name('admin.order.delete');
    Route::get('/admin/order/history',[AdminOrderController::class,'OrderHistory'])->name('admin.order.history');
    Route::get('admin/home', [HomeCustomizeController::class, 'index'])->name('admin.front.home');
    Route::post('admin/home/title-logo', [HomeCustomizeController::class, 'submit'])->name('admin.front.submit');
    Route::post('admin/home/banners', [HomeCustomizeController::class, 'homesubmit'])->name('admin.front.banners');
    Route::get('admin/page/', [PageController::class, 'page'])->name('admin.back.page');
    Route::get('admin/page/add', [PageController::class, 'pageAdd'])->name('admin.back.page.add');
    Route::post('admin/page/add', [PageController::class, 'pageSubmit'])->name('admin.back.page.submit');
    Route::get('admin/page/edit/{id}', [PageController::class, 'pageEdit'])->name('admin.back.page.edit');
    Route::post('admin/page/edit/{id}', [PageController::class, 'pageUpdate'])->name('admin.back.page.update');
    Route::delete('/admin/page/delete/{id}', [PageController::class, 'pageDelete'])->name('admin.page.delete');

    Route::get('/admin/Qr_code', [RechargeController::class, 'QRCode'])->name('admin.qr_code');
    Route::get('/admin/Qr_code/add', [RechargeController::class, 'QRCodeAdd'])->name('admin.qr_code.add');
    Route::post('/admin/Qr_code/add', [RechargeController::class, 'QRCodeSubmit'])->name('admin.qr_code.submit');
    Route::get('/admin/qr/edit/{id}', [RechargeController::class, 'QRedit'])->name('admin.qr.edit');
    Route::post('/admin/qr/edit/{id}', [RechargeController::class, 'UpdateQRedit'])->name('admin.qr.update');
    Route::delete('/admin/qr/delete/{id}', [RechargeController::class, 'QRDelete'])->name('admin.qr.delete');

    Route::get('/admin/recharge', [RechargeController::class, 'Recharge'])->name('admin.recharge.request');
    Route::get('/admin/recharge/add', [RechargeController::class, 'RechargeAdd'])->name('admin.recharge.add');
    Route::post('/admin/recharge/add', [RechargeController::class, 'RechargeSubmit'])->name('admin.recharge.submit');
    Route::post('admin/recharge/updateStatus/{id}', [RechargeController::class, 'RechargeupdateStatus'])->name('admin.recharge.updateStatus');

    Route::get('admin/widthraw', [RechargeController::class, 'widthraw'])->name('admin.widthraw.request');
    Route::post('admin/widthraw/update/{id}', [RechargeController::class, 'widthrawUpdate'])->name('admin.widthraw.request.update');

    Route::get('/admin/setting', [HomeCustomizeController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/setting', [HomeCustomizeController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/admin/logout', [LoginController::class, 'Adminlogout'])->name('admin.logout');

    // notification
    Route::get('admin/order/mark-as-read', [DashboardController::class, 'markAsRead'])->name('admin.order.markAsRead');
    Route::get('admin/vendor/mark-as-read', [DashboardController::class, 'markAsReadVendor'])->name('admin.vendor.markAsRead');
    Route::get('admin/widthraw/mark-as-read', [DashboardController::class, 'markAsWidthraw'])->name('admin.widthraw.markAsRead');


    Route::get('/admin/notifications', [DashboardController::class, 'adminNotifications'])->name('admin.notifications');

    // Route for marking notifications as read for admin
    Route::get('/admin/notifications/read/{id}', [DashboardController::class, 'markAsRead'])->name('admin.notifications.read');
});

Route::middleware(['vendor','PreventBackHistory'])->group(function () {
    Route::get('/vendor/dashboard',[DashboardController::class,'vendor'])->name('vendor.dashboard');
    Route::post('/vendor/dashboard',[DashboardController::class,'AvaliblitySubmit'])->name('vendor.dashboard.AvaliblitySubmit');
    Route::post('/vendor/dashboard/status',[DashboardController::class,'StatusSubmit'])->name('vendor.dashboard.status');
    Route::get('/vendor/service/list',[VendorServiceController::class,'vendorService'])->name('vendor.service.list');
    Route::get('/vendor/service/add',[VendorServiceController::class,'vendorServiceAdd'])->name('vendor.service.add');
    Route::post('/vendor/service/add',[VendorServiceController::class,'vendorServiceSubmit'])->name('vendor.service.submit');
    Route::get('/vendor/service/order',[VendorServiceController::class,'vendorOrder'])->name('vendor.service.order');
    Route::get('/vendor/service/order/{id}',[VendorServiceController::class,'vendorOrderShow'])->name('vendor.service.order.show');
    Route::post('/vendor/service/order/payment/{id}',[VendorServiceController::class,'vendorPayment'])->name('vendor.service.order.payment');
    Route::post('/vendor/service/order-Re/payment/{id}',[VendorServiceController::class,'RevendorPayment'])->name('vendor.service.order_re.payment');

    Route::get('/vendor/service/add/{id}',[VendorServiceController::class,'vendorOrderAdd'])->name('vendor.service.order.Add');
    Route::post('/vendor/service/add/{id}',[VendorServiceController::class,'vendorOrderSubmit'])->name('vendor.service.order.submit');
    Route::get('/vendor/order/invoice/{id}', [VendorServiceController::class, 'generateInvoice'])->name('vendor.order.invoice');
    Route::post('/vendor/order/status/{id}', [VendorServiceController::class, 'updateStatus'])->name('vendorOrder.updateStatus');
    Route::post('/vendor-order/update-work-status/{id}', [VendorServiceController::class, 'updateWorkStatus'])
    ->name('vendorOrder.updateWorkStatus');

    Route::post('/vendor/{id}/store-invoice', [VendorServiceController::class, 'storeInvoice'])->name('bills.storeInvoice');

    Route::get('/vendor/order/user_otp/{id}', [VendorServiceController::class, 'user_otp'])->name('vendorOrder.otp.user');
    Route::post('/vendor/order/user_otp/{id}', [VendorServiceController::class, 'user_otp_submit'])->name('vendorOrder.otp.submit');
    Route::get('/vendor/order/inspection/{id}', [VendorServiceController::class, 'inspection'])->name('vendorOrder.order.inspection');
    Route::post('/vendor/order/inspection/{id}', [VendorServiceController::class, 'inspectionSubmit'])->name('vendorOrder.order.inspection.submit');
    Route::get('/vendor/order/bill/{id}', [VendorServiceController::class, 'inspectionBill'])->name('vendorOrder.order.inspection.bill');
    Route::get('/vendor/order/bill/update/{id}', [VendorServiceController::class, 'updateBill'])->name('vendorOrder.order.bill.update');
    Route::get('/vendor/order/bill/revisite/{id}', [VendorServiceController::class, 'updateRevisiteBill'])->name('vendorOrder.order.bill.updateRevisite');

    Route::get('/vendor/wallet/balance', [WalletController::class, 'walletBalance'])->name('vendor.wallet.balance');
    Route::get('/vendor/wallet/recharge/list', [WalletController::class, 'RechargeWalletList'])->name('vendor.wallet.rechargelist');

    Route::get('/vendor/wallet/recharge', [WalletController::class, 'RechargeWallet'])->name('vendor.wallet.recharge');
    Route::post('/vendor/wallet/recharge', [WalletController::class, 'RechargeWalletSubmit'])->name('vendor.wallet.recharge.submit');

    Route::get('/vendor/Order/history', [VendorServiceController::class, 'OrderHistory'])->name('vendor.order.history');

    Route::get('/vendor/finance',[FinanceController::class,'index'])->name('vendor.finance');
    Route::post('/vendor/finance/submit', [FinanceController::class, 'financesaveOrUpdate'])->name('finance.saveOrUpdate');

    Route::get('/vendor/setting', [ProfileController::class, 'profile'])->name('vendor.profile');
    Route::post('/vendor/setting', [ProfileController::class, 'profileUpdate'])->name('vendor.profile.update');

    Route::get('/vendor/order/{order_id}/history/show', [VendorServiceController::class, 'Vendor_orderhistory_show'])->name('vendor.orderhistory_show');

    Route::get('/vendor/logout', [LoginController::class, 'logout'])->name('vendor.logout');

    Route::get('admin/vendor/mark-as-read', [DashboardController::class, 'markAsReadVendorOrder'])->name('vendor.vendor.markAsRead');

    Route::get('/vendor/notifications', [DashboardController::class, 'notifications'])
    ->middleware('auth:vendor')
    ->name('vendor.notifications');
    Route::get('/vendor/notifications/read/{id}', [DashboardController::class, 'markNotificationAsRead'])
    ->middleware('auth:vendor')
    ->name('vendor.notifications.read');
});

Route::get('/',[HomeController::class,'index'])->name('front.home');
Route::get('/user/login',[AuthController::class,'user_Login'])->name('user.login');
Route::get('/package/{id}',[HomeController::class,'package'])->name('front.package');
Route::post('/add-to-cart',[HomeController::class,'AddToCart'])->name('front.addtocart');

Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/checkout',[HomeController::class,'checkout'])->name('front.checkout');
Route::get('/user/register',[AuthController::class,'Register'])->name('front.user_register');
Route::get('/user/register/{invite_code?}', [AuthController::class, 'Register'])->name('front.user_register');
Route::post('/user/register',[AuthController::class,'UserRegister'])->name('front.user.register');
Route::post('/user/login',[AuthController::class,'UserLogin'])->name('front.user.login');
Route::post('/verify/otp', [AuthController::class, 'verifyOtp'])->name('front.verify.otp');
Route::get('/user/dashboard', [UserController::class, 'Dashboard'])->name('front.user.dashboard');
Route::post('/user/Order', [UserController::class, 'Order'])->name('front.user.order');
Route::get('/user/logout', [AuthController::class, 'logout'])->name('front.user.logout');
Route::get('/user/dashboard',[UserDashBoardController::class,'index'])->name('user.front.dashboard');
Route::get('/user/dashboard/booking',[UserDashBoardController::class,'booking'])->name('user.front.booking');
Route::get('/user/dashboard/bill/{id}',[UserDashBoardController::class,'bill'])->name('user.front.bill');
Route::post('/user/dashboard/revisite/{id}',[UserDashBoardController::class,'Revisite'])->name('user.front.revisite');
Route::get('/user/bill/update/{id}', [UserDashBoardController::class, 'updateBillStatus'])->name('user.front.bill_update');
Route::get('/user/bill/update/revisit/{id}/{status}', [UserDashBoardController::class, 'updateBillStatusRevisite'])->name('user.front.bill_update.revisite');
Route::get('/user/order/history', [UserDashBoardController::class, 'orderHistory'])->name('user.front.order.history');
Route::get('/user/dashboard/wallet', [UserDashBoardController::class, 'UserWallet'])->name('user.front.wallet');
Route::get('/user/dashboard/widthraw', [UserDashBoardController::class, 'WalletWidthdraw'])->name('user.front.widthdraw');
Route::post('/user/dashboard/widthraw', [UserDashBoardController::class, 'KYC_Submit'])->name('user.front.kyc');
Route::post('/user/dashboard/widthraw-request', [UserDashBoardController::class, 'widthrawRequestSubmit'])->name('user.front.widthdraw.request');
Route::get('/user/dashboard/widthraw-history', [UserDashBoardController::class, 'WidthrawHistory'])->name('user.front.widthrawHistory');

Route::get('/user/profile/update', [UserDashBoardController::class, 'UserProfile'])->name('user.front.profile');
Route::post('/user/profile/update', [UserDashBoardController::class, 'UserProfileUpdate'])->name('user.front.profile.update');
Route::get('/user/profile/setting', [UserDashBoardController::class, 'UserSetting'])->name('user.front.setting');
Route::post('/user/profile/setting', [UserDashBoardController::class, 'UserSettingPassword'])->name('user.front.settingPassword');

Route::get('/page/{slug}', [HomeController::class, 'page'])->name('front.page');


