<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SopController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\HygieneController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\ShiftStoreController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\VehicleTaxController;
use App\Http\Controllers\StoreAssetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\UtilityBillController;
use App\Http\Controllers\FuelServiceController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\RequestStockController;
use App\Http\Controllers\CleanAndNeatController;
use App\Http\Controllers\OutInProductController;
use App\Http\Controllers\UtilityUsageController;
use App\Http\Controllers\ClosingStoreController;
use App\Http\Controllers\MaterialGroupController;
use App\Http\Controllers\MonthlySalaryController;
use App\Http\Controllers\TransferStockController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\AdminCashlessController;
use App\Http\Controllers\StoreCashlessController;
use App\Http\Controllers\ClosingCourierController;
use App\Http\Controllers\RemainingStockController;
use App\Http\Controllers\FranchiseGroupController;
use App\Http\Controllers\OnlineCategoryController;
use App\Http\Controllers\PermitEmployeeController;
use App\Http\Controllers\EmployeeStatusController;
use App\Http\Controllers\ReceiptLoyverseController;
use App\Http\Controllers\UtilityProviderController;
use App\Http\Controllers\SelfConsumptionController;
use App\Http\Controllers\PurchaseReceiptController;
use App\Http\Controllers\AccountCashlessController;
use App\Http\Controllers\DeliveryServiceController;
use App\Http\Controllers\CashlessProviderController;
use App\Http\Controllers\SalesOrderOnlineController;
use App\Http\Controllers\OnlineShopProviderController;
use App\Http\Controllers\RestaurantCategoryController;
use App\Http\Controllers\SalesOrderEmployeeController;
use App\Http\Controllers\VehicleCertificateController;
use App\Http\Controllers\MovementAssetResultController;
use App\Http\Controllers\TransferDailySalaryController;
use App\Http\Controllers\TransferFuelServiceController;
use App\Http\Controllers\ReceiptByItemLoyverseController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('customers', CustomerController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('users', UserController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('stores', StoreController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('closing-couriers', ClosingCourierController::class);
        Route::resource('remaining-stocks', RemainingStockController::class);
        Route::resource(
            'cashless-providers',
            CashlessProviderController::class
        );
        Route::resource('franchise-groups', FranchiseGroupController::class);
        Route::resource('material-groups', MaterialGroupController::class);
        Route::resource('monthly-salaries', MonthlySalaryController::class);
        Route::resource('online-categories', OnlineCategoryController::class);
        Route::resource(
            'online-shop-providers',
            OnlineShopProviderController::class
        );
        Route::resource('payment-types', PaymentTypeController::class);
        Route::resource('permit-employees', PermitEmployeeController::class);
        Route::resource('product-groups', ProductGroupController::class);
        Route::resource('transfer-stocks', TransferStockController::class);
        Route::resource(
            'restaurant-categories',
            RestaurantCategoryController::class
        );
        Route::resource(
            'sales-order-employees',
            SalesOrderEmployeeController::class
        );
        Route::resource(
            'sales-order-onlines',
            SalesOrderOnlineController::class
        );
        Route::resource('shift-stores', ShiftStoreController::class);
        Route::resource('sops', SopController::class);
        Route::resource('presences', PresenceController::class);
        Route::resource('products', ProductController::class);
        Route::resource('banks', BankController::class);
        Route::resource('productions', ProductionController::class);
        Route::resource('request-stocks', RequestStockController::class);
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::resource('utilities', UtilityController::class);
        Route::resource('units', UnitController::class);
        Route::resource(
            'receipt-by-item-loyverses',
            ReceiptByItemLoyverseController::class
        );
        Route::resource('receipt-loyverses', ReceiptLoyverseController::class);
        Route::resource('hygienes', HygieneController::class);
        Route::resource('clean-and-neats', CleanAndNeatController::class);
        Route::resource('utility-providers', UtilityProviderController::class);
        Route::resource('self-consumptions', SelfConsumptionController::class);
        Route::resource('out-in-products', OutInProductController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('stock-cards', StockCardController::class);
        Route::resource('employee-statuses', EmployeeStatusController::class);
        Route::resource('refunds', RefundController::class);
        Route::resource('utility-usages', UtilityUsageController::class);
        Route::resource('vehicle-taxes', VehicleTaxController::class);
        Route::resource(
            'vehicle-certificates',
            VehicleCertificateController::class
        );
        Route::resource(
            'movement-asset-results',
            MovementAssetResultController::class
        );
        Route::resource('store-assets', StoreAssetController::class);
        Route::resource('admin-cashlesses', AdminCashlessController::class);
        Route::resource('purchase-receipts', PurchaseReceiptController::class);
        Route::resource('closing-stores', ClosingStoreController::class);
        Route::resource(
            'transfer-daily-salaries',
            TransferDailySalaryController::class
        );
        Route::resource('store-cashlesses', StoreCashlessController::class);
        Route::resource('account-cashlesses', AccountCashlessController::class);
        Route::resource('delivery-services', DeliveryServiceController::class);
        Route::resource('utility-bills', UtilityBillController::class);
        Route::resource('fuel-services', FuelServiceController::class);
        Route::resource(
            'transfer-fuel-services',
            TransferFuelServiceController::class
        );
    });
