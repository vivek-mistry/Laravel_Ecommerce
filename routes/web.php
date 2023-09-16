<?php

use App\Http\Controllers\Backend\AuthenticateController;
use App\Http\Controllers\Backend\CouponController as BackendCouponController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\DataTablePaginate;
use App\Http\Middleware\FimaAdminAuth;
use Illuminate\Support\Facades\Route;

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

/**
 * FrontEnd ROUTES
 */
Route::get('sign-in', [UserController::class, 'signIn'])->name('sign-in');
Route::post('authenticate', [UserController::class, 'authenticate']);
Route::get('check-auth', [UserController::class, 'checkAuthUser']);
Route::get('sign-out', [UserController::class, 'signOut']);

// Forget Password
Route::get('forget-password', [UserController::class, 'forgetPasswordView']);

Route::get('download-pdf', [UserController::class, 'demoPdf']);


/**
 * Otp Verification Routes
 */
Route::prefix('otp-verification')->group(function () {
    Route::post('generate', [OtpVerificationController::class, 'genreateOtpForgetPassword']);
    Route::post('verify', [OtpVerificationController::class, 'otpVerification']);
});
Route::post('reset-password', [OtpVerificationController::class, 'resetPassword']);

Route::get('register', [UserController::class, 'registerView']);
Route::post('user-store', [UserController::class, 'store']);

Route::get('', [HomeController::class, 'index']);
Route::get('home', [HomeController::class, 'index']);


Route::get('product', [ProductController::class, 'index']);
Route::get('product-json', [ProductController::class, 'productJsonCall']);
Route::get('product/detail/{product_id}', [ProductController::class, 'detail']);
Route::get('product-search', [ProductController::class, 'search']);

Route::post('cart', [CartController::class, 'store']);
Route::get('cart', [CartController::class, 'getUserCart']);
Route::get('cart/{cart_id}', [CartController::class, 'removecart']);
Route::put('cart', [CartController::class, 'updateCartQuantity']);

Route::get('cart-list', [CartController::class, 'cartList']);
Route::get('cart-json', [CartController::class, 'cartJson']);
Route::get('checkout', [CheckoutController::class, 'index']);


Route::group(['middleware' => 'auth'], function () {

    Route::get('my-account', [UserController::class, 'myAccount']);
    Route::get('change-password', [UserController::class, 'changePassword']);
    Route::post('change-password', [UserController::class, 'updatePassword']);
    Route::get('my-orders', [OrderController::class, 'myOrders']);
    Route::get('order/detail/{order_id}', [OrderController::class, 'getOrderById']);
    Route::get('address-book', [UserAddressController::class, 'addressBook']);
    Route::get('user-address/{id}', [UserAddressController::class, 'edit']);
    Route::post('user-address', [UserAddressController::class, 'store']);
    Route::put('user-address/{id}', [UserAddressController::class, 'update']);
    Route::get('account-info', [UserController::class, 'accountInfo']);
    Route::post('update-account-info/{user_id}', [UserController::class, 'updateAccountInfo']);

    Route::get('payment-success', [StripeController::class, 'success']);
    Route::get('payment-failure', [StripeController::class, 'failure']);
    Route::get('stripe-checkout', [StripeController::class, 'stripeCheckout']);

    Route::post('stripe-payment/create-intent', [StripeController::class, 'generatePaymentIntent']);

    Route::get('paypal-checkout', [PaypalController::class, 'index']);

    Route::get('make-checkout', [CheckoutController::class, 'makeCheckout']);
    /**
     * Coupon ROUTES
     */
    Route::prefix('coupon')->group(function () {
        Route::post('apply/{coupon_id}', [CouponController::class, 'applyCoupon']);
    });
    Route::get('order/{order_id}', [OrderController::class, 'orderInvoice']);
});
Route::get('mail-test', [UserController::class, 'mailTest']);

/**
 * TODO: Move to backend.php file
 * BackEnd ROUTES
 */
Route::prefix('backend')->group(function () {
    Route::get('', [AuthenticateController::class, 'loadSignin'])->name('admin_signin');
    Route::get('sign-in', [AuthenticateController::class, 'loadSignin'])->name('admin_signin');
    Route::post('authenticate', [AuthenticateController::class, 'checkAuthenticate']);
    Route::get('sign-out', [AuthenticateController::class, 'signOut']);

    Route::get('change-profile', [AuthenticateController::class, 'changeProfile'])->middleware([FimaAdminAuth::class]);
    Route::put('update-profile/{user_id}', [AuthenticateController::class, 'updateProfile'])->middleware([FimaAdminAuth::class]);

    Route::get('dashboard', [DashboardController::class, 'index'])->middleware([FimaAdminAuth::class]);

    /**
     * User Route
     */
    Route::middleware([FimaAdminAuth::class])->prefix('user')->group(function () {
        Route::get('list', [BackendUserController::class, 'index']);
        Route::get('create', [BackendUserController::class, 'createLoadView']);
        Route::post('store', [BackendUserController::class, 'store']);
        Route::post('paginate', [BackendUserController::class, 'getAllUsers'])->middleware([DataTablePaginate::class]);
        Route::get('edit/{user_id}', [BackendUserController::class, 'edit']);
        Route::put('update/{user_id}', [BackendUserController::class, 'update']);
        Route::get('remove/{user_id}', [BackendUserController::class, 'remove']);
    });

    /**
     * Order Route
     */
    Route::middleware([FimaAdminAuth::class])->prefix('order')->group(function () {
        Route::get('list', [BackendOrderController::class, 'index']);
        Route::post('paginate', [BackendOrderController::class, 'getAllOrders'])->middleware([DataTablePaginate::class]);
    });

    /**
     * Coupon Module route
     */
    Route::middleware([FimaAdminAuth::class])->prefix('coupon')->group(function () {
        Route::get('list', [BackendCouponController::class, 'index']);
        Route::get('create', [BackendCouponController::class, 'createLoadView']);
        Route::post('store', [BackendCouponController::class, 'store']);
        Route::post('paginate', [BackendCouponController::class, 'getAll'])->middleware([DataTablePaginate::class]);
        Route::get('edit/{coupon_id}', [BackendCouponController::class, 'edit']);
        Route::put('update/{coupon_id}', [BackendCouponController::class, 'update']);
        Route::get('remove/{coupon_id}', [BackendCouponController::class, 'remove']);
    });

    Route::middleware([FimaAdminAuth::class])->prefix('category')->group(function () {
        Route::get('list', [CategoryController::class, 'index']);
    });
    Route::middleware([FimaAdminAuth::class])->prefix('product')->group(function () {
        Route::get('list', [BackendProductController::class, 'index']);
    });
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
