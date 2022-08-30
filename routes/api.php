<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SopController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UtilityController;
use App\Http\Controllers\Api\HygieneController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\CashlessController;
use App\Http\Controllers\Api\StockCardController;
use App\Http\Controllers\Api\UserStoresController;
use App\Http\Controllers\Api\ShiftStoreController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\VehicleTaxController;
use App\Http\Controllers\Api\StoreAssetController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserRefundsController;
use App\Http\Controllers\Api\PaymentTypeController;
use App\Http\Controllers\Api\FuelServiceController;
use App\Http\Controllers\Api\UtilityBillController;
use App\Http\Controllers\Api\UserVehiclesController;
use App\Http\Controllers\Api\UserProductsController;
use App\Http\Controllers\Api\UserHygienesController;
use App\Http\Controllers\Api\ProductGroupController;
use App\Http\Controllers\Api\RequestStockController;
use App\Http\Controllers\Api\UnitProductsController;
use App\Http\Controllers\Api\CleanAndNeatController;
use App\Http\Controllers\Api\OutInProductController;
use App\Http\Controllers\Api\UtilityUsageController;
use App\Http\Controllers\Api\ProductionToController;
use App\Http\Controllers\Api\ClosingStoreController;
use App\Http\Controllers\Api\UserEmployeesController;
use App\Http\Controllers\Api\UserCustomersController;
use App\Http\Controllers\Api\UserSuppliersController;
use App\Http\Controllers\Api\UserPresencesController;
use App\Http\Controllers\Api\StoreVehiclesController;
use App\Http\Controllers\Api\StoreHygienesController;
use App\Http\Controllers\Api\MaterialGroupController;
use App\Http\Controllers\Api\MonthlySalaryController;
use App\Http\Controllers\Api\TransferStockController;
use App\Http\Controllers\Api\BankEmployeesController;
use App\Http\Controllers\Api\BankSuppliersController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\UnitUtilitiesController;
use App\Http\Controllers\Api\MovementAssetController;
use App\Http\Controllers\Api\HygieneOfRoomController;
use App\Http\Controllers\Api\AdminCashlessController;
use App\Http\Controllers\Api\StoreCashlessController;
use App\Http\Controllers\Api\UserStockCardsController;
use App\Http\Controllers\Api\StoreUtilitiesController;
use App\Http\Controllers\Api\ClosingCourierController;
use App\Http\Controllers\Api\RemainingStockController;
use App\Http\Controllers\Api\FranchiseGroupController;
use App\Http\Controllers\Api\OnlineCategoryController;
use App\Http\Controllers\Api\PermitEmployeeController;
use App\Http\Controllers\Api\EmployeeStatusController;
use App\Http\Controllers\Api\ProductionFromController;
use App\Http\Controllers\Api\EmployeeSavingsController;
use App\Http\Controllers\Api\UserProductionsController;
use App\Http\Controllers\Api\StoreStockCardsController;
use App\Http\Controllers\Api\DeliveryAddressController;
use App\Http\Controllers\Api\ReceiptLoyverseController;
use App\Http\Controllers\Api\UtilityProviderController;
use App\Http\Controllers\Api\SelfConsumptionController;
use App\Http\Controllers\Api\PurchaseReceiptController;
use App\Http\Controllers\Api\AccountCashlessController;
use App\Http\Controllers\Api\DeliveryServiceController;
use App\Http\Controllers\Api\UserVehicleTaxesController;
use App\Http\Controllers\Api\UserFuelServicesController;
use App\Http\Controllers\Api\StoreProductionsController;
use App\Http\Controllers\Api\StoreStoreAssetsController;
use App\Http\Controllers\Api\CashlessProviderController;
use App\Http\Controllers\Api\SalesOrderOnlineController;
use App\Http\Controllers\Api\ContractEmployeeController;
use App\Http\Controllers\Api\ContractLocationController;
use App\Http\Controllers\Api\UserClosingStoresController;
use App\Http\Controllers\Api\UserRequestStocksController;
use App\Http\Controllers\Api\UserCleanAndNeatsController;
use App\Http\Controllers\Api\UserUtilityUsagesController;
use App\Http\Controllers\Api\UserOutInProductsController;
use App\Http\Controllers\Api\WorkingExperienceController;
use App\Http\Controllers\Api\UserMaterialGroupsController;
use App\Http\Controllers\Api\UserPurchaseOrdersController;
use App\Http\Controllers\Api\UserTransferStocksController;
use App\Http\Controllers\Api\StoreClosingStoresController;
use App\Http\Controllers\Api\StoreRequestStocksController;
use App\Http\Controllers\Api\OnlineShopProviderController;
use App\Http\Controllers\Api\RestaurantCategoryController;
use App\Http\Controllers\Api\SalesOrderEmployeeController;
use App\Http\Controllers\Api\RoomHygieneOfRoomsController;
use App\Http\Controllers\Api\VehicleCertificateController;
use App\Http\Controllers\Api\MovementAssetAuditController;
use App\Http\Controllers\Api\UserFranchiseGroupsController;
use App\Http\Controllers\Api\UserRemainingStocksController;
use App\Http\Controllers\Api\UserClosingCouriersController;
use App\Http\Controllers\Api\UserPermitEmployeesController;
use App\Http\Controllers\Api\VehicleVehicleTaxesController;
use App\Http\Controllers\Api\VehicleFuelServicesController;
use App\Http\Controllers\Api\StorePurchaseOrdersController;
use App\Http\Controllers\Api\StoreTransferStocksController;
use App\Http\Controllers\Api\PaymentTypeProductsController;
use App\Http\Controllers\Api\BankClosingCouriersController;
use App\Http\Controllers\Api\UtilityUtilityBillsController;
use App\Http\Controllers\Api\MovementAssetResultController;
use App\Http\Controllers\Api\TransferDailySalaryController;
use App\Http\Controllers\Api\TransferFuelServiceController;
use App\Http\Controllers\Api\UserPurchaseReceiptsController;
use App\Http\Controllers\Api\UserSelfConsumptionsController;
use App\Http\Controllers\Api\StoreRemainingStocksController;
use App\Http\Controllers\Api\PaymentTypePresencesController;
use App\Http\Controllers\Api\ProductGroupProductsController;
use App\Http\Controllers\Api\ProductProductionTosController;
use App\Http\Controllers\Api\ProductRequestStocksController;
use App\Http\Controllers\Api\ProductOutInProductsController;
use App\Http\Controllers\Api\PurchaseOrderProductController;
use App\Http\Controllers\Api\RequestStockProductsController;
use App\Http\Controllers\Api\UtilityUtilityUsagesController;
use App\Http\Controllers\Api\OutInProductProductsController;
use App\Http\Controllers\Api\UserSalesOrderOnlinesController;
use App\Http\Controllers\Api\StoreSelfConsumptionsController;
use App\Http\Controllers\Api\MaterialGroupProductsController;
use App\Http\Controllers\Api\TransferStockProductsController;
use App\Http\Controllers\Api\ProductMovementAssetsController;
use App\Http\Controllers\Api\ProductTransferStocksController;
use App\Http\Controllers\Api\ReceiptByItemLoyverseController;
use App\Http\Controllers\Api\HygieneHygieneOfRoomsController;
use App\Http\Controllers\Api\ProductionSupportFromController;
use App\Http\Controllers\Api\ClosingStorePresencesController;
use App\Http\Controllers\Api\StoreContractLocationsController;
use App\Http\Controllers\Api\StoreSalesOrderOnlinesController;
use App\Http\Controllers\Api\StoreAccountCashlessesController;
use App\Http\Controllers\Api\SupplierPurchaseOrdersController;
use App\Http\Controllers\Api\RemainingStockProductsController;
use App\Http\Controllers\Api\FranchiseGroupProductsController;
use App\Http\Controllers\Api\OnlineCategoryProductsController;
use App\Http\Controllers\Api\ProductRemainingStocksController;
use App\Http\Controllers\Api\product_transfer_stockController;
use App\Http\Controllers\Api\out_in_product_productController;
use App\Http\Controllers\Api\StockCardOutInProductsController;
use App\Http\Controllers\Api\ClosingStoreCashlessesController;
use App\Http\Controllers\Api\UserSalesOrderEmployeesController;
use App\Http\Controllers\Api\PaymentTypeFuelServicesController;
use App\Http\Controllers\Api\ShiftStoreClosingStoresController;
use App\Http\Controllers\Api\ProductSelfConsumptionsController;
use App\Http\Controllers\Api\ProductionProductionTosController;
use App\Http\Controllers\Api\product_remaining_stockController;
use App\Http\Controllers\Api\SelfConsumptionProductsController;
use App\Http\Controllers\Api\EmployeeStatusEmployeesController;
use App\Http\Controllers\Api\UserRestaurantCategoriesController;
use App\Http\Controllers\Api\UserMovementAssetResultsController;
use App\Http\Controllers\Api\StoreSalesOrderEmployeesController;
use App\Http\Controllers\Api\SalesOrderOnlineProductsController;
use App\Http\Controllers\Api\ProductSalesOrderOnlinesController;
use App\Http\Controllers\Api\UtilityProviderUtilitiesController;
use App\Http\Controllers\Api\StoreAssetMovementAssetsController;
use App\Http\Controllers\Api\ClosingStoreFuelServicesController;
use App\Http\Controllers\Api\CustomerSalesOrderOnlinesController;
use App\Http\Controllers\Api\CustomerDeliveryAddressesController;
use App\Http\Controllers\Api\EmployeeContractEmployeesController;
use App\Http\Controllers\Api\StoreMovementAssetResultsController;
use App\Http\Controllers\Api\PaymentTypePurchaseOrdersController;
use App\Http\Controllers\Api\ProductionProductionFromsController;
use App\Http\Controllers\Api\UnitPurchaseOrderProductsController;
use App\Http\Controllers\Api\AccountCashlessCashlessesController;
use App\Http\Controllers\Api\EmployeeWorkingExperiencesController;
use App\Http\Controllers\Api\RestaurantCategoryProductsController;
use App\Http\Controllers\Api\SalesOrderEmployeeProductsController;
use App\Http\Controllers\Api\ProductSalesOrderEmployeesController;
use App\Http\Controllers\Api\product_sales_order_onlineController;
use App\Http\Controllers\Api\PurchaseOrderClosingStoresController;
use App\Http\Controllers\Api\ClosingStorePurchaseOrdersController;
use App\Http\Controllers\Api\CustomerSalesOrderEmployeesController;
use App\Http\Controllers\Api\ClosingCourierClosingStoresController;
use App\Http\Controllers\Api\ClosingStoreClosingCouriersController;
use App\Http\Controllers\Api\ProductPurchaseOrderProductsController;
use App\Http\Controllers\Api\product_sales_order_employeeController;
use App\Http\Controllers\Api\closing_store_purchase_orderController;
use App\Http\Controllers\Api\TransferDailySalaryPresencesController;
use App\Http\Controllers\Api\DeliveryServiceOutInProductsController;
use App\Http\Controllers\Api\PresenceTransferDailySalariesController;
use App\Http\Controllers\Api\ProductProductionSupportFromsController;
use App\Http\Controllers\Api\PurchaseOrderPurchaseReceiptsController;
use App\Http\Controllers\Api\closing_courier_closing_storeController;
use App\Http\Controllers\Api\PurchaseReceiptPurchaseOrdersController;
use App\Http\Controllers\Api\AdminCashlessAccountCashlessesController;
use App\Http\Controllers\Api\presence_transfer_daily_salaryController;
use App\Http\Controllers\Api\StoreCashlessAccountCashlessesController;
use App\Http\Controllers\Api\AccountCashlessAdminCashlessesController;
use App\Http\Controllers\Api\CashlessProviderAdminCashlessesController;
use App\Http\Controllers\Api\purchase_order_purchase_receiptController;
use App\Http\Controllers\Api\FuelServiceTransferFuelServicesController;
use App\Http\Controllers\Api\account_cashless_admin_cashlessController;
use App\Http\Controllers\Api\TransferFuelServiceFuelServicesController;
use App\Http\Controllers\Api\ProductionProductionSupportFromsController;
use App\Http\Controllers\Api\DeliveryAddressSalesOrderOnlinesController;
use App\Http\Controllers\Api\MovementAssetMovementAssetAuditsController;
use App\Http\Controllers\Api\DeliveryServiceSalesOrderOnlinesController;
use App\Http\Controllers\Api\CashlessProviderAccountCashlessesController;
use App\Http\Controllers\Api\PurchaseOrderPurchaseOrderProductsController;
use App\Http\Controllers\Api\fuel_service_transfer_fuel_serviceController;
use App\Http\Controllers\Api\OnlineShopProviderSalesOrderOnlinesController;
use App\Http\Controllers\Api\PurchaseOrderProductProductionFromsController;
use App\Http\Controllers\Api\MovementAssetResultMovementAssetAuditsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('customers', CustomerController::class);

        // Customer Sales Order Employees
        Route::get('/customers/{customer}/sales-order-employees', [
            CustomerSalesOrderEmployeesController::class,
            'index',
        ])->name('customers.sales-order-employees.index');
        Route::post('/customers/{customer}/sales-order-employees', [
            CustomerSalesOrderEmployeesController::class,
            'store',
        ])->name('customers.sales-order-employees.store');

        // Customer Sales Order Onlines
        Route::get('/customers/{customer}/sales-order-onlines', [
            CustomerSalesOrderOnlinesController::class,
            'index',
        ])->name('customers.sales-order-onlines.index');
        Route::post('/customers/{customer}/sales-order-onlines', [
            CustomerSalesOrderOnlinesController::class,
            'store',
        ])->name('customers.sales-order-onlines.store');

        // Customer Delivery Addresses
        Route::get('/customers/{customer}/delivery-addresses', [
            CustomerDeliveryAddressesController::class,
            'index',
        ])->name('customers.delivery-addresses.index');
        Route::post('/customers/{customer}/delivery-addresses', [
            CustomerDeliveryAddressesController::class,
            'store',
        ])->name('customers.delivery-addresses.store');

        Route::apiResource('employees', EmployeeController::class);

        // Employee Savings
        Route::get('/employees/{employee}/savings', [
            EmployeeSavingsController::class,
            'index',
        ])->name('employees.savings.index');
        Route::post('/employees/{employee}/savings', [
            EmployeeSavingsController::class,
            'store',
        ])->name('employees.savings.store');

        // Employee Contract Employees
        Route::get('/employees/{employee}/contract-employees', [
            EmployeeContractEmployeesController::class,
            'index',
        ])->name('employees.contract-employees.index');
        Route::post('/employees/{employee}/contract-employees', [
            EmployeeContractEmployeesController::class,
            'store',
        ])->name('employees.contract-employees.store');

        // Employee Working Experiences
        Route::get('/employees/{employee}/working-experiences', [
            EmployeeWorkingExperiencesController::class,
            'index',
        ])->name('employees.working-experiences.index');
        Route::post('/employees/{employee}/working-experiences', [
            EmployeeWorkingExperiencesController::class,
            'store',
        ])->name('employees.working-experiences.store');

        Route::apiResource('users', UserController::class);

        // User Employees
        Route::get('/users/{user}/employees', [
            UserEmployeesController::class,
            'index',
        ])->name('users.employees.index');
        Route::post('/users/{user}/employees', [
            UserEmployeesController::class,
            'store',
        ])->name('users.employees.store');

        // User Stores
        Route::get('/users/{user}/stores', [
            UserStoresController::class,
            'index',
        ])->name('users.stores.index');
        Route::post('/users/{user}/stores', [
            UserStoresController::class,
            'store',
        ])->name('users.stores.store');

        // User Customers
        Route::get('/users/{user}/customers', [
            UserCustomersController::class,
            'index',
        ])->name('users.customers.index');
        Route::post('/users/{user}/customers', [
            UserCustomersController::class,
            'store',
        ])->name('users.customers.store');

        // User Franchise Groups
        Route::get('/users/{user}/franchise-groups', [
            UserFranchiseGroupsController::class,
            'index',
        ])->name('users.franchise-groups.index');
        Route::post('/users/{user}/franchise-groups', [
            UserFranchiseGroupsController::class,
            'store',
        ])->name('users.franchise-groups.store');

        // User Material Groups
        Route::get('/users/{user}/material-groups', [
            UserMaterialGroupsController::class,
            'index',
        ])->name('users.material-groups.index');
        Route::post('/users/{user}/material-groups', [
            UserMaterialGroupsController::class,
            'store',
        ])->name('users.material-groups.store');

        // User Vehicles
        Route::get('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'index',
        ])->name('users.vehicles.index');
        Route::post('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'store',
        ])->name('users.vehicles.store');

        // User Closing Stores
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Products
        Route::get('/users/{user}/products', [
            UserProductsController::class,
            'index',
        ])->name('users.products.index');
        Route::post('/users/{user}/products', [
            UserProductsController::class,
            'store',
        ])->name('users.products.store');

        // User Restaurant Categories
        Route::get('/users/{user}/restaurant-categories', [
            UserRestaurantCategoriesController::class,
            'index',
        ])->name('users.restaurant-categories.index');
        Route::post('/users/{user}/restaurant-categories', [
            UserRestaurantCategoriesController::class,
            'store',
        ])->name('users.restaurant-categories.store');

        // User Purchase Receipts
        Route::get('/users/{user}/purchase-receipts', [
            UserPurchaseReceiptsController::class,
            'index',
        ])->name('users.purchase-receipts.index');
        Route::post('/users/{user}/purchase-receipts', [
            UserPurchaseReceiptsController::class,
            'store',
        ])->name('users.purchase-receipts.store');

        // User Movement Asset Results
        Route::get('/users/{user}/movement-asset-results', [
            UserMovementAssetResultsController::class,
            'index',
        ])->name('users.movement-asset-results.index');
        Route::post('/users/{user}/movement-asset-results', [
            UserMovementAssetResultsController::class,
            'store',
        ])->name('users.movement-asset-results.store');

        // User Suppliers
        Route::get('/users/{user}/suppliers', [
            UserSuppliersController::class,
            'index',
        ])->name('users.suppliers.index');
        Route::post('/users/{user}/suppliers', [
            UserSuppliersController::class,
            'store',
        ])->name('users.suppliers.store');

        // User Sales Order Onlines Created
        Route::get('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'index',
        ])->name('users.sales-order-onlines.index');
        Route::post('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'store',
        ])->name('users.sales-order-onlines.store');

        // User Sales Order Employees Created
        Route::get('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'index',
        ])->name('users.sales-order-employees.index');
        Route::post('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'store',
        ])->name('users.sales-order-employees.store');

        // User Productions Created
        Route::get('/users/{user}/productions', [
            UserProductionsController::class,
            'index',
        ])->name('users.productions.index');
        Route::post('/users/{user}/productions', [
            UserProductionsController::class,
            'store',
        ])->name('users.productions.store');

        // User Request Stocks Created
        Route::get('/users/{user}/request-stocks', [
            UserRequestStocksController::class,
            'index',
        ])->name('users.request-stocks.index');
        Route::post('/users/{user}/request-stocks', [
            UserRequestStocksController::class,
            'store',
        ])->name('users.request-stocks.store');

        // User Remaining Stocks Created
        Route::get('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'index',
        ])->name('users.remaining-stocks.index');
        Route::post('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'store',
        ])->name('users.remaining-stocks.store');

        // User Purchase Orders Created
        Route::get('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'index',
        ])->name('users.purchase-orders.index');
        Route::post('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'store',
        ])->name('users.purchase-orders.store');

        // User Presences Created
        Route::get('/users/{user}/presences', [
            UserPresencesController::class,
            'index',
        ])->name('users.presences.index');
        Route::post('/users/{user}/presences', [
            UserPresencesController::class,
            'store',
        ])->name('users.presences.store');

        // User Closing Couriers Created
        Route::get('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'index',
        ])->name('users.closing-couriers.index');
        Route::post('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'store',
        ])->name('users.closing-couriers.store');

        // User Permit Employees Created
        Route::get('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'index',
        ])->name('users.permit-employees.index');
        Route::post('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'store',
        ])->name('users.permit-employees.store');

        // User Clean And Neats Created
        Route::get('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'index',
        ])->name('users.clean-and-neats.index');
        Route::post('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'store',
        ])->name('users.clean-and-neats.store');

        // User Closing Stores Created
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Hygienes Created
        Route::get('/users/{user}/hygienes', [
            UserHygienesController::class,
            'index',
        ])->name('users.hygienes.index');
        Route::post('/users/{user}/hygienes', [
            UserHygienesController::class,
            'store',
        ])->name('users.hygienes.store');

        // User Clean And Neats Approved
        Route::get('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'index',
        ])->name('users.clean-and-neats.index');
        Route::post('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'store',
        ])->name('users.clean-and-neats.store');

        // User Sales Order Onlines Approved
        Route::get('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'index',
        ])->name('users.sales-order-onlines.index');
        Route::post('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'store',
        ])->name('users.sales-order-onlines.store');

        // User Sales Order Employees Approved
        Route::get('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'index',
        ])->name('users.sales-order-employees.index');
        Route::post('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'store',
        ])->name('users.sales-order-employees.store');

        // User Transfer Stocks Approved
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Productions Approved
        Route::get('/users/{user}/productions', [
            UserProductionsController::class,
            'index',
        ])->name('users.productions.index');
        Route::post('/users/{user}/productions', [
            UserProductionsController::class,
            'store',
        ])->name('users.productions.store');

        // User Request Stocks Approved
        Route::get('/users/{user}/request-stocks', [
            UserRequestStocksController::class,
            'index',
        ])->name('users.request-stocks.index');
        Route::post('/users/{user}/request-stocks', [
            UserRequestStocksController::class,
            'store',
        ])->name('users.request-stocks.store');

        // User Remaining Stocks Approved
        Route::get('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'index',
        ])->name('users.remaining-stocks.index');
        Route::post('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'store',
        ])->name('users.remaining-stocks.store');

        // User Purchase Orders Approved
        Route::get('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'index',
        ])->name('users.purchase-orders.index');
        Route::post('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'store',
        ])->name('users.purchase-orders.store');

        // User Presences Approved
        Route::get('/users/{user}/presences', [
            UserPresencesController::class,
            'index',
        ])->name('users.presences.index');
        Route::post('/users/{user}/presences', [
            UserPresencesController::class,
            'store',
        ])->name('users.presences.store');

        // User Closing Stores Approved
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Closing Couriers Approved
        Route::get('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'index',
        ])->name('users.closing-couriers.index');
        Route::post('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'store',
        ])->name('users.closing-couriers.store');

        // User Permit Employees Approved
        Route::get('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'index',
        ])->name('users.permit-employees.index');
        Route::post('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'store',
        ])->name('users.permit-employees.store');

        // User Hygienes Approved
        Route::get('/users/{user}/hygienes', [
            UserHygienesController::class,
            'index',
        ])->name('users.hygienes.index');
        Route::post('/users/{user}/hygienes', [
            UserHygienesController::class,
            'store',
        ])->name('users.hygienes.store');

        // User Self Consumptions Created
        Route::get('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'index',
        ])->name('users.self-consumptions.index');
        Route::post('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'store',
        ])->name('users.self-consumptions.store');

        // User Utiliy Usages Created
        Route::get('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'index',
        ])->name('users.utility-usages.index');
        Route::post('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'store',
        ])->name('users.utility-usages.store');

        // User Utiliy Usages Approved
        Route::get('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'index',
        ])->name('users.utility-usages.index');
        Route::post('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'store',
        ])->name('users.utility-usages.store');

        // User Self Consumptions Approved
        Route::get('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'index',
        ])->name('users.self-consumptions.index');
        Route::post('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'store',
        ])->name('users.self-consumptions.store');

        // User Stock Cards
        Route::get('/users/{user}/stock-cards', [
            UserStockCardsController::class,
            'index',
        ])->name('users.stock-cards.index');
        Route::post('/users/{user}/stock-cards', [
            UserStockCardsController::class,
            'store',
        ])->name('users.stock-cards.store');

        // User Vehicle Taxes
        Route::get('/users/{user}/vehicle-taxes', [
            UserVehicleTaxesController::class,
            'index',
        ])->name('users.vehicle-taxes.index');
        Route::post('/users/{user}/vehicle-taxes', [
            UserVehicleTaxesController::class,
            'store',
        ])->name('users.vehicle-taxes.store');

        // User Refunds
        Route::get('/users/{user}/refunds', [
            UserRefundsController::class,
            'index',
        ])->name('users.refunds.index');
        Route::post('/users/{user}/refunds', [
            UserRefundsController::class,
            'store',
        ])->name('users.refunds.store');

        // User Out In Products Created
        Route::get('/users/{user}/out-in-products', [
            UserOutInProductsController::class,
            'index',
        ])->name('users.out-in-products.index');
        Route::post('/users/{user}/out-in-products', [
            UserOutInProductsController::class,
            'store',
        ])->name('users.out-in-products.store');

        // User Out In Products Approved
        Route::get('/users/{user}/out-in-products', [
            UserOutInProductsController::class,
            'index',
        ])->name('users.out-in-products.index');
        Route::post('/users/{user}/out-in-products', [
            UserOutInProductsController::class,
            'store',
        ])->name('users.out-in-products.store');

        // User Transfer Stocks2
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Transfer Stocks3
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Fuel Services
        Route::get('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'index',
        ])->name('users.fuel-services.index');
        Route::post('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'store',
        ])->name('users.fuel-services.store');

        // User Fuel Services2
        Route::get('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'index',
        ])->name('users.fuel-services.index');
        Route::post('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'store',
        ])->name('users.fuel-services.store');

        Route::apiResource('vehicles', VehicleController::class);

        // Vehicle Vehicle Taxes
        Route::get('/vehicles/{vehicle}/vehicle-taxes', [
            VehicleVehicleTaxesController::class,
            'index',
        ])->name('vehicles.vehicle-taxes.index');
        Route::post('/vehicles/{vehicle}/vehicle-taxes', [
            VehicleVehicleTaxesController::class,
            'store',
        ])->name('vehicles.vehicle-taxes.store');

        // Vehicle Fuel Services
        Route::get('/vehicles/{vehicle}/fuel-services', [
            VehicleFuelServicesController::class,
            'index',
        ])->name('vehicles.fuel-services.index');
        Route::post('/vehicles/{vehicle}/fuel-services', [
            VehicleFuelServicesController::class,
            'store',
        ])->name('vehicles.fuel-services.store');

        Route::apiResource('stores', StoreController::class);

        // Store Contract Locations
        Route::get('/stores/{store}/contract-locations', [
            StoreContractLocationsController::class,
            'index',
        ])->name('stores.contract-locations.index');
        Route::post('/stores/{store}/contract-locations', [
            StoreContractLocationsController::class,
            'store',
        ])->name('stores.contract-locations.store');

        // Store Vehicles
        Route::get('/stores/{store}/vehicles', [
            StoreVehiclesController::class,
            'index',
        ])->name('stores.vehicles.index');
        Route::post('/stores/{store}/vehicles', [
            StoreVehiclesController::class,
            'store',
        ])->name('stores.vehicles.store');

        // Store Movement Asset Results
        Route::get('/stores/{store}/movement-asset-results', [
            StoreMovementAssetResultsController::class,
            'index',
        ])->name('stores.movement-asset-results.index');
        Route::post('/stores/{store}/movement-asset-results', [
            StoreMovementAssetResultsController::class,
            'store',
        ])->name('stores.movement-asset-results.store');

        // Store Closing Stores
        Route::get('/stores/{store}/closing-stores', [
            StoreClosingStoresController::class,
            'index',
        ])->name('stores.closing-stores.index');
        Route::post('/stores/{store}/closing-stores', [
            StoreClosingStoresController::class,
            'store',
        ])->name('stores.closing-stores.store');

        // Store Purchase Orders
        Route::get('/stores/{store}/purchase-orders', [
            StorePurchaseOrdersController::class,
            'index',
        ])->name('stores.purchase-orders.index');
        Route::post('/stores/{store}/purchase-orders', [
            StorePurchaseOrdersController::class,
            'store',
        ])->name('stores.purchase-orders.store');

        // Store Remaining Stocks
        Route::get('/stores/{store}/remaining-stocks', [
            StoreRemainingStocksController::class,
            'index',
        ])->name('stores.remaining-stocks.index');
        Route::post('/stores/{store}/remaining-stocks', [
            StoreRemainingStocksController::class,
            'store',
        ])->name('stores.remaining-stocks.store');

        // Store Request Stocks
        Route::get('/stores/{store}/request-stocks', [
            StoreRequestStocksController::class,
            'index',
        ])->name('stores.request-stocks.index');
        Route::post('/stores/{store}/request-stocks', [
            StoreRequestStocksController::class,
            'store',
        ])->name('stores.request-stocks.store');

        // Store Productions
        Route::get('/stores/{store}/productions', [
            StoreProductionsController::class,
            'index',
        ])->name('stores.productions.index');
        Route::post('/stores/{store}/productions', [
            StoreProductionsController::class,
            'store',
        ])->name('stores.productions.store');

        // Store Sales Order Employees
        Route::get('/stores/{store}/sales-order-employees', [
            StoreSalesOrderEmployeesController::class,
            'index',
        ])->name('stores.sales-order-employees.index');
        Route::post('/stores/{store}/sales-order-employees', [
            StoreSalesOrderEmployeesController::class,
            'store',
        ])->name('stores.sales-order-employees.store');

        // Store Sales Order Onlines
        Route::get('/stores/{store}/sales-order-onlines', [
            StoreSalesOrderOnlinesController::class,
            'index',
        ])->name('stores.sales-order-onlines.index');
        Route::post('/stores/{store}/sales-order-onlines', [
            StoreSalesOrderOnlinesController::class,
            'store',
        ])->name('stores.sales-order-onlines.store');

        // Store From Transfer Stocks
        Route::get('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'index',
        ])->name('stores.transfer-stocks.index');
        Route::post('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'store',
        ])->name('stores.transfer-stocks.store');

        // Store To Transfer Stocks
        Route::get('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'index',
        ])->name('stores.transfer-stocks.index');
        Route::post('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'store',
        ])->name('stores.transfer-stocks.store');

        // Store Hygienes
        Route::get('/stores/{store}/hygienes', [
            StoreHygienesController::class,
            'index',
        ])->name('stores.hygienes.index');
        Route::post('/stores/{store}/hygienes', [
            StoreHygienesController::class,
            'store',
        ])->name('stores.hygienes.store');

        // Store Self Consumptions
        Route::get('/stores/{store}/self-consumptions', [
            StoreSelfConsumptionsController::class,
            'index',
        ])->name('stores.self-consumptions.index');
        Route::post('/stores/{store}/self-consumptions', [
            StoreSelfConsumptionsController::class,
            'store',
        ])->name('stores.self-consumptions.store');

        // Store Stock Cards
        Route::get('/stores/{store}/stock-cards', [
            StoreStockCardsController::class,
            'index',
        ])->name('stores.stock-cards.index');
        Route::post('/stores/{store}/stock-cards', [
            StoreStockCardsController::class,
            'store',
        ])->name('stores.stock-cards.store');

        // Store Utilities
        Route::get('/stores/{store}/utilities', [
            StoreUtilitiesController::class,
            'index',
        ])->name('stores.utilities.index');
        Route::post('/stores/{store}/utilities', [
            StoreUtilitiesController::class,
            'store',
        ])->name('stores.utilities.store');

        // Store Store Assets
        Route::get('/stores/{store}/store-assets', [
            StoreStoreAssetsController::class,
            'index',
        ])->name('stores.store-assets.index');
        Route::post('/stores/{store}/store-assets', [
            StoreStoreAssetsController::class,
            'store',
        ])->name('stores.store-assets.store');

        // Store Account Cashlesses
        Route::get('/stores/{store}/account-cashlesses', [
            StoreAccountCashlessesController::class,
            'index',
        ])->name('stores.account-cashlesses.index');
        Route::post('/stores/{store}/account-cashlesses', [
            StoreAccountCashlessesController::class,
            'store',
        ])->name('stores.account-cashlesses.store');

        Route::apiResource('suppliers', SupplierController::class);

        // Supplier Purchase Orders
        Route::get('/suppliers/{supplier}/purchase-orders', [
            SupplierPurchaseOrdersController::class,
            'index',
        ])->name('suppliers.purchase-orders.index');
        Route::post('/suppliers/{supplier}/purchase-orders', [
            SupplierPurchaseOrdersController::class,
            'store',
        ])->name('suppliers.purchase-orders.store');

        Route::apiResource('closing-couriers', ClosingCourierController::class);

        // ClosingCourier Closing Stores
        Route::get('/closing-couriers/{closingCourier}/closing-stores', [
            ClosingCourierClosingStoresController::class,
            'index',
        ])->name('closing-couriers.closing-stores.index');
        Route::post(
            '/closing-couriers/{closingCourier}/closing-stores/{closingStore}',
            [ClosingCourierClosingStoresController::class, 'store']
        )->name('closing-couriers.closing-stores.store');
        Route::delete(
            '/closing-couriers/{closingCourier}/closing-stores/{closingStore}',
            [ClosingCourierClosingStoresController::class, 'destroy']
        )->name('closing-couriers.closing-stores.destroy');

        Route::apiResource('remaining-stocks', RemainingStockController::class);

        // RemainingStock Products
        Route::get('/remaining-stocks/{remainingStock}/products', [
            RemainingStockProductsController::class,
            'index',
        ])->name('remaining-stocks.products.index');
        Route::post('/remaining-stocks/{remainingStock}/products/{product}', [
            RemainingStockProductsController::class,
            'store',
        ])->name('remaining-stocks.products.store');
        Route::delete('/remaining-stocks/{remainingStock}/products/{product}', [
            RemainingStockProductsController::class,
            'destroy',
        ])->name('remaining-stocks.products.destroy');

        Route::apiResource(
            'cashless-providers',
            CashlessProviderController::class
        );

        // CashlessProvider Admin Cashlesses
        Route::get('/cashless-providers/{cashlessProvider}/admin-cashlesses', [
            CashlessProviderAdminCashlessesController::class,
            'index',
        ])->name('cashless-providers.admin-cashlesses.index');
        Route::post('/cashless-providers/{cashlessProvider}/admin-cashlesses', [
            CashlessProviderAdminCashlessesController::class,
            'store',
        ])->name('cashless-providers.admin-cashlesses.store');

        // CashlessProvider Account Cashlesses
        Route::get(
            '/cashless-providers/{cashlessProvider}/account-cashlesses',
            [CashlessProviderAccountCashlessesController::class, 'index']
        )->name('cashless-providers.account-cashlesses.index');
        Route::post(
            '/cashless-providers/{cashlessProvider}/account-cashlesses',
            [CashlessProviderAccountCashlessesController::class, 'store']
        )->name('cashless-providers.account-cashlesses.store');

        Route::apiResource('franchise-groups', FranchiseGroupController::class);

        // FranchiseGroup Products
        Route::get('/franchise-groups/{franchiseGroup}/products', [
            FranchiseGroupProductsController::class,
            'index',
        ])->name('franchise-groups.products.index');
        Route::post('/franchise-groups/{franchiseGroup}/products', [
            FranchiseGroupProductsController::class,
            'store',
        ])->name('franchise-groups.products.store');

        Route::apiResource('material-groups', MaterialGroupController::class);

        // MaterialGroup Products
        Route::get('/material-groups/{materialGroup}/products', [
            MaterialGroupProductsController::class,
            'index',
        ])->name('material-groups.products.index');
        Route::post('/material-groups/{materialGroup}/products', [
            MaterialGroupProductsController::class,
            'store',
        ])->name('material-groups.products.store');

        Route::apiResource('monthly-salaries', MonthlySalaryController::class);

        Route::apiResource(
            'online-categories',
            OnlineCategoryController::class
        );

        // OnlineCategory Products
        Route::get('/online-categories/{onlineCategory}/products', [
            OnlineCategoryProductsController::class,
            'index',
        ])->name('online-categories.products.index');
        Route::post('/online-categories/{onlineCategory}/products', [
            OnlineCategoryProductsController::class,
            'store',
        ])->name('online-categories.products.store');

        Route::apiResource(
            'online-shop-providers',
            OnlineShopProviderController::class
        );

        // OnlineShopProvider Sales Order Onlines
        Route::get(
            '/online-shop-providers/{onlineShopProvider}/sales-order-onlines',
            [OnlineShopProviderSalesOrderOnlinesController::class, 'index']
        )->name('online-shop-providers.sales-order-onlines.index');
        Route::post(
            '/online-shop-providers/{onlineShopProvider}/sales-order-onlines',
            [OnlineShopProviderSalesOrderOnlinesController::class, 'store']
        )->name('online-shop-providers.sales-order-onlines.store');

        Route::apiResource('payment-types', PaymentTypeController::class);

        // PaymentType Purchase Orders
        Route::get('/payment-types/{paymentType}/purchase-orders', [
            PaymentTypePurchaseOrdersController::class,
            'index',
        ])->name('payment-types.purchase-orders.index');
        Route::post('/payment-types/{paymentType}/purchase-orders', [
            PaymentTypePurchaseOrdersController::class,
            'store',
        ])->name('payment-types.purchase-orders.store');

        // PaymentType Products
        Route::get('/payment-types/{paymentType}/products', [
            PaymentTypeProductsController::class,
            'index',
        ])->name('payment-types.products.index');
        Route::post('/payment-types/{paymentType}/products', [
            PaymentTypeProductsController::class,
            'store',
        ])->name('payment-types.products.store');

        // PaymentType Presences
        Route::get('/payment-types/{paymentType}/presences', [
            PaymentTypePresencesController::class,
            'index',
        ])->name('payment-types.presences.index');
        Route::post('/payment-types/{paymentType}/presences', [
            PaymentTypePresencesController::class,
            'store',
        ])->name('payment-types.presences.store');

        // PaymentType Fuel Services
        Route::get('/payment-types/{paymentType}/fuel-services', [
            PaymentTypeFuelServicesController::class,
            'index',
        ])->name('payment-types.fuel-services.index');
        Route::post('/payment-types/{paymentType}/fuel-services', [
            PaymentTypeFuelServicesController::class,
            'store',
        ])->name('payment-types.fuel-services.store');

        Route::apiResource('permit-employees', PermitEmployeeController::class);

        Route::apiResource('product-groups', ProductGroupController::class);

        // ProductGroup Products
        Route::get('/product-groups/{productGroup}/products', [
            ProductGroupProductsController::class,
            'index',
        ])->name('product-groups.products.index');
        Route::post('/product-groups/{productGroup}/products', [
            ProductGroupProductsController::class,
            'store',
        ])->name('product-groups.products.store');

        Route::apiResource('transfer-stocks', TransferStockController::class);

        // TransferStock Products
        Route::get('/transfer-stocks/{transferStock}/products', [
            TransferStockProductsController::class,
            'index',
        ])->name('transfer-stocks.products.index');
        Route::post('/transfer-stocks/{transferStock}/products/{product}', [
            TransferStockProductsController::class,
            'store',
        ])->name('transfer-stocks.products.store');
        Route::delete('/transfer-stocks/{transferStock}/products/{product}', [
            TransferStockProductsController::class,
            'destroy',
        ])->name('transfer-stocks.products.destroy');

        Route::apiResource(
            'restaurant-categories',
            RestaurantCategoryController::class
        );

        // RestaurantCategory Products
        Route::get('/restaurant-categories/{restaurantCategory}/products', [
            RestaurantCategoryProductsController::class,
            'index',
        ])->name('restaurant-categories.products.index');
        Route::post('/restaurant-categories/{restaurantCategory}/products', [
            RestaurantCategoryProductsController::class,
            'store',
        ])->name('restaurant-categories.products.store');

        Route::apiResource(
            'sales-order-employees',
            SalesOrderEmployeeController::class
        );

        // SalesOrderEmployee Products
        Route::get('/sales-order-employees/{salesOrderEmployee}/products', [
            SalesOrderEmployeeProductsController::class,
            'index',
        ])->name('sales-order-employees.products.index');
        Route::post(
            '/sales-order-employees/{salesOrderEmployee}/products/{product}',
            [SalesOrderEmployeeProductsController::class, 'store']
        )->name('sales-order-employees.products.store');
        Route::delete(
            '/sales-order-employees/{salesOrderEmployee}/products/{product}',
            [SalesOrderEmployeeProductsController::class, 'destroy']
        )->name('sales-order-employees.products.destroy');

        Route::apiResource(
            'sales-order-onlines',
            SalesOrderOnlineController::class
        );

        // SalesOrderOnline Products
        Route::get('/sales-order-onlines/{salesOrderOnline}/products', [
            SalesOrderOnlineProductsController::class,
            'index',
        ])->name('sales-order-onlines.products.index');
        Route::post(
            '/sales-order-onlines/{salesOrderOnline}/products/{product}',
            [SalesOrderOnlineProductsController::class, 'store']
        )->name('sales-order-onlines.products.store');
        Route::delete(
            '/sales-order-onlines/{salesOrderOnline}/products/{product}',
            [SalesOrderOnlineProductsController::class, 'destroy']
        )->name('sales-order-onlines.products.destroy');

        Route::apiResource('shift-stores', ShiftStoreController::class);

        // ShiftStore Closing Stores
        Route::get('/shift-stores/{shiftStore}/closing-stores', [
            ShiftStoreClosingStoresController::class,
            'index',
        ])->name('shift-stores.closing-stores.index');
        Route::post('/shift-stores/{shiftStore}/closing-stores', [
            ShiftStoreClosingStoresController::class,
            'store',
        ])->name('shift-stores.closing-stores.store');

        Route::apiResource('sops', SopController::class);

        Route::apiResource('presences', PresenceController::class);

        // Presence Transfer Daily Salaries
        Route::get('/presences/{presence}/transfer-daily-salaries', [
            PresenceTransferDailySalariesController::class,
            'index',
        ])->name('presences.transfer-daily-salaries.index');
        Route::post(
            '/presences/{presence}/transfer-daily-salaries/{transferDailySalary}',
            [PresenceTransferDailySalariesController::class, 'store']
        )->name('presences.transfer-daily-salaries.store');
        Route::delete(
            '/presences/{presence}/transfer-daily-salaries/{transferDailySalary}',
            [PresenceTransferDailySalariesController::class, 'destroy']
        )->name('presences.transfer-daily-salaries.destroy');

        Route::apiResource('products', ProductController::class);

        // Product Movement Assets
        Route::get('/products/{product}/movement-assets', [
            ProductMovementAssetsController::class,
            'index',
        ])->name('products.movement-assets.index');
        Route::post('/products/{product}/movement-assets', [
            ProductMovementAssetsController::class,
            'store',
        ])->name('products.movement-assets.store');

        // Product Purchase Order Products
        Route::get('/products/{product}/purchase-order-products', [
            ProductPurchaseOrderProductsController::class,
            'index',
        ])->name('products.purchase-order-products.index');
        Route::post('/products/{product}/purchase-order-products', [
            ProductPurchaseOrderProductsController::class,
            'store',
        ])->name('products.purchase-order-products.store');

        // Product Production Tos
        Route::get('/products/{product}/production-tos', [
            ProductProductionTosController::class,
            'index',
        ])->name('products.production-tos.index');
        Route::post('/products/{product}/production-tos', [
            ProductProductionTosController::class,
            'store',
        ])->name('products.production-tos.store');

        // Product Production Support Froms
        Route::get('/products/{product}/production-support-froms', [
            ProductProductionSupportFromsController::class,
            'index',
        ])->name('products.production-support-froms.index');
        Route::post('/products/{product}/production-support-froms', [
            ProductProductionSupportFromsController::class,
            'store',
        ])->name('products.production-support-froms.store');

        // Product Remaining Stocks
        Route::get('/products/{product}/remaining-stocks', [
            ProductRemainingStocksController::class,
            'index',
        ])->name('products.remaining-stocks.index');
        Route::post('/products/{product}/remaining-stocks/{remainingStock}', [
            ProductRemainingStocksController::class,
            'store',
        ])->name('products.remaining-stocks.store');
        Route::delete('/products/{product}/remaining-stocks/{remainingStock}', [
            ProductRemainingStocksController::class,
            'destroy',
        ])->name('products.remaining-stocks.destroy');

        // Product Transfer Stocks
        Route::get('/products/{product}/transfer-stocks', [
            ProductTransferStocksController::class,
            'index',
        ])->name('products.transfer-stocks.index');
        Route::post('/products/{product}/transfer-stocks/{transferStock}', [
            ProductTransferStocksController::class,
            'store',
        ])->name('products.transfer-stocks.store');
        Route::delete('/products/{product}/transfer-stocks/{transferStock}', [
            ProductTransferStocksController::class,
            'destroy',
        ])->name('products.transfer-stocks.destroy');

        // Product Sales Order Employees
        Route::get('/products/{product}/sales-order-employees', [
            ProductSalesOrderEmployeesController::class,
            'index',
        ])->name('products.sales-order-employees.index');
        Route::post(
            '/products/{product}/sales-order-employees/{salesOrderEmployee}',
            [ProductSalesOrderEmployeesController::class, 'store']
        )->name('products.sales-order-employees.store');
        Route::delete(
            '/products/{product}/sales-order-employees/{salesOrderEmployee}',
            [ProductSalesOrderEmployeesController::class, 'destroy']
        )->name('products.sales-order-employees.destroy');

        // Product Sales Order Onlines
        Route::get('/products/{product}/sales-order-onlines', [
            ProductSalesOrderOnlinesController::class,
            'index',
        ])->name('products.sales-order-onlines.index');
        Route::post(
            '/products/{product}/sales-order-onlines/{salesOrderOnline}',
            [ProductSalesOrderOnlinesController::class, 'store']
        )->name('products.sales-order-onlines.store');
        Route::delete(
            '/products/{product}/sales-order-onlines/{salesOrderOnline}',
            [ProductSalesOrderOnlinesController::class, 'destroy']
        )->name('products.sales-order-onlines.destroy');

        // Product Request Stocks
        Route::get('/products/{product}/request-stocks', [
            ProductRequestStocksController::class,
            'index',
        ])->name('products.request-stocks.index');
        Route::post('/products/{product}/request-stocks/{requestStock}', [
            ProductRequestStocksController::class,
            'store',
        ])->name('products.request-stocks.store');
        Route::delete('/products/{product}/request-stocks/{requestStock}', [
            ProductRequestStocksController::class,
            'destroy',
        ])->name('products.request-stocks.destroy');

        // Product Self Consumptions
        Route::get('/products/{product}/self-consumptions', [
            ProductSelfConsumptionsController::class,
            'index',
        ])->name('products.self-consumptions.index');
        Route::post('/products/{product}/self-consumptions/{selfConsumption}', [
            ProductSelfConsumptionsController::class,
            'store',
        ])->name('products.self-consumptions.store');
        Route::delete(
            '/products/{product}/self-consumptions/{selfConsumption}',
            [ProductSelfConsumptionsController::class, 'destroy']
        )->name('products.self-consumptions.destroy');

        // Product Out In Products
        Route::get('/products/{product}/out-in-products', [
            ProductOutInProductsController::class,
            'index',
        ])->name('products.out-in-products.index');
        Route::post('/products/{product}/out-in-products/{outInProduct}', [
            ProductOutInProductsController::class,
            'store',
        ])->name('products.out-in-products.store');
        Route::delete('/products/{product}/out-in-products/{outInProduct}', [
            ProductOutInProductsController::class,
            'destroy',
        ])->name('products.out-in-products.destroy');

        Route::apiResource('banks', BankController::class);

        // Bank Employees
        Route::get('/banks/{bank}/employees', [
            BankEmployeesController::class,
            'index',
        ])->name('banks.employees.index');
        Route::post('/banks/{bank}/employees', [
            BankEmployeesController::class,
            'store',
        ])->name('banks.employees.store');

        // Bank Suppliers
        Route::get('/banks/{bank}/suppliers', [
            BankSuppliersController::class,
            'index',
        ])->name('banks.suppliers.index');
        Route::post('/banks/{bank}/suppliers', [
            BankSuppliersController::class,
            'store',
        ])->name('banks.suppliers.store');

        // Bank Closing Couriers
        Route::get('/banks/{bank}/closing-couriers', [
            BankClosingCouriersController::class,
            'index',
        ])->name('banks.closing-couriers.index');
        Route::post('/banks/{bank}/closing-couriers', [
            BankClosingCouriersController::class,
            'store',
        ])->name('banks.closing-couriers.store');

        Route::apiResource('productions', ProductionController::class);

        // Production Production Froms
        Route::get('/productions/{production}/production-froms', [
            ProductionProductionFromsController::class,
            'index',
        ])->name('productions.production-froms.index');
        Route::post('/productions/{production}/production-froms', [
            ProductionProductionFromsController::class,
            'store',
        ])->name('productions.production-froms.store');

        // Production Production Tos
        Route::get('/productions/{production}/production-tos', [
            ProductionProductionTosController::class,
            'index',
        ])->name('productions.production-tos.index');
        Route::post('/productions/{production}/production-tos', [
            ProductionProductionTosController::class,
            'store',
        ])->name('productions.production-tos.store');

        // Production Production Support Froms
        Route::get('/productions/{production}/production-support-froms', [
            ProductionProductionSupportFromsController::class,
            'index',
        ])->name('productions.production-support-froms.index');
        Route::post('/productions/{production}/production-support-froms', [
            ProductionProductionSupportFromsController::class,
            'store',
        ])->name('productions.production-support-froms.store');

        Route::apiResource('request-stocks', RequestStockController::class);

        // RequestStock Products
        Route::get('/request-stocks/{requestStock}/products', [
            RequestStockProductsController::class,
            'index',
        ])->name('request-stocks.products.index');
        Route::post('/request-stocks/{requestStock}/products/{product}', [
            RequestStockProductsController::class,
            'store',
        ])->name('request-stocks.products.store');
        Route::delete('/request-stocks/{requestStock}/products/{product}', [
            RequestStockProductsController::class,
            'destroy',
        ])->name('request-stocks.products.destroy');

        Route::apiResource('purchase-orders', PurchaseOrderController::class);

        // PurchaseOrder Purchase Order Products
        Route::get('/purchase-orders/{purchaseOrder}/purchase-order-products', [
            PurchaseOrderPurchaseOrderProductsController::class,
            'index',
        ])->name('purchase-orders.purchase-order-products.index');
        Route::post(
            '/purchase-orders/{purchaseOrder}/purchase-order-products',
            [PurchaseOrderPurchaseOrderProductsController::class, 'store']
        )->name('purchase-orders.purchase-order-products.store');

        // PurchaseOrder Closing Stores
        Route::get('/purchase-orders/{purchaseOrder}/closing-stores', [
            PurchaseOrderClosingStoresController::class,
            'index',
        ])->name('purchase-orders.closing-stores.index');
        Route::post(
            '/purchase-orders/{purchaseOrder}/closing-stores/{closingStore}',
            [PurchaseOrderClosingStoresController::class, 'store']
        )->name('purchase-orders.closing-stores.store');
        Route::delete(
            '/purchase-orders/{purchaseOrder}/closing-stores/{closingStore}',
            [PurchaseOrderClosingStoresController::class, 'destroy']
        )->name('purchase-orders.closing-stores.destroy');

        // PurchaseOrder Purchase Receipts
        Route::get('/purchase-orders/{purchaseOrder}/purchase-receipts', [
            PurchaseOrderPurchaseReceiptsController::class,
            'index',
        ])->name('purchase-orders.purchase-receipts.index');
        Route::post(
            '/purchase-orders/{purchaseOrder}/purchase-receipts/{purchaseReceipt}',
            [PurchaseOrderPurchaseReceiptsController::class, 'store']
        )->name('purchase-orders.purchase-receipts.store');
        Route::delete(
            '/purchase-orders/{purchaseOrder}/purchase-receipts/{purchaseReceipt}',
            [PurchaseOrderPurchaseReceiptsController::class, 'destroy']
        )->name('purchase-orders.purchase-receipts.destroy');

        Route::apiResource('utilities', UtilityController::class);

        // Utility Utility Usages
        Route::get('/utilities/{utility}/utility-usages', [
            UtilityUtilityUsagesController::class,
            'index',
        ])->name('utilities.utility-usages.index');
        Route::post('/utilities/{utility}/utility-usages', [
            UtilityUtilityUsagesController::class,
            'store',
        ])->name('utilities.utility-usages.store');

        // Utility Utility Bills
        Route::get('/utilities/{utility}/utility-bills', [
            UtilityUtilityBillsController::class,
            'index',
        ])->name('utilities.utility-bills.index');
        Route::post('/utilities/{utility}/utility-bills', [
            UtilityUtilityBillsController::class,
            'store',
        ])->name('utilities.utility-bills.store');

        Route::apiResource('units', UnitController::class);

        // Unit Products
        Route::get('/units/{unit}/products', [
            UnitProductsController::class,
            'index',
        ])->name('units.products.index');
        Route::post('/units/{unit}/products', [
            UnitProductsController::class,
            'store',
        ])->name('units.products.store');

        // Unit Utilities
        Route::get('/units/{unit}/utilities', [
            UnitUtilitiesController::class,
            'index',
        ])->name('units.utilities.index');
        Route::post('/units/{unit}/utilities', [
            UnitUtilitiesController::class,
            'store',
        ])->name('units.utilities.store');

        // Unit Purchase Order Products
        Route::get('/units/{unit}/purchase-order-products', [
            UnitPurchaseOrderProductsController::class,
            'index',
        ])->name('units.purchase-order-products.index');
        Route::post('/units/{unit}/purchase-order-products', [
            UnitPurchaseOrderProductsController::class,
            'store',
        ])->name('units.purchase-order-products.store');

        Route::apiResource(
            'receipt-by-item-loyverses',
            ReceiptByItemLoyverseController::class
        );

        Route::apiResource(
            'receipt-loyverses',
            ReceiptLoyverseController::class
        );

        Route::apiResource('hygienes', HygieneController::class);

        // Hygiene Hygiene Of Rooms
        Route::get('/hygienes/{hygiene}/hygiene-of-rooms', [
            HygieneHygieneOfRoomsController::class,
            'index',
        ])->name('hygienes.hygiene-of-rooms.index');
        Route::post('/hygienes/{hygiene}/hygiene-of-rooms', [
            HygieneHygieneOfRoomsController::class,
            'store',
        ])->name('hygienes.hygiene-of-rooms.store');

        Route::apiResource('clean-and-neats', CleanAndNeatController::class);

        Route::apiResource(
            'utility-providers',
            UtilityProviderController::class
        );

        // UtilityProvider Utilities
        Route::get('/utility-providers/{utilityProvider}/utilities', [
            UtilityProviderUtilitiesController::class,
            'index',
        ])->name('utility-providers.utilities.index');
        Route::post('/utility-providers/{utilityProvider}/utilities', [
            UtilityProviderUtilitiesController::class,
            'store',
        ])->name('utility-providers.utilities.store');

        Route::apiResource(
            'self-consumptions',
            SelfConsumptionController::class
        );

        // SelfConsumption Products
        Route::get('/self-consumptions/{selfConsumption}/products', [
            SelfConsumptionProductsController::class,
            'index',
        ])->name('self-consumptions.products.index');
        Route::post('/self-consumptions/{selfConsumption}/products/{product}', [
            SelfConsumptionProductsController::class,
            'store',
        ])->name('self-consumptions.products.store');
        Route::delete(
            '/self-consumptions/{selfConsumption}/products/{product}',
            [SelfConsumptionProductsController::class, 'destroy']
        )->name('self-consumptions.products.destroy');

        Route::apiResource('out-in-products', OutInProductController::class);

        // OutInProduct Products
        Route::get('/out-in-products/{outInProduct}/products', [
            OutInProductProductsController::class,
            'index',
        ])->name('out-in-products.products.index');
        Route::post('/out-in-products/{outInProduct}/products/{product}', [
            OutInProductProductsController::class,
            'store',
        ])->name('out-in-products.products.store');
        Route::delete('/out-in-products/{outInProduct}/products/{product}', [
            OutInProductProductsController::class,
            'destroy',
        ])->name('out-in-products.products.destroy');

        Route::apiResource('rooms', RoomController::class);

        // Room Hygiene Of Rooms
        Route::get('/rooms/{room}/hygiene-of-rooms', [
            RoomHygieneOfRoomsController::class,
            'index',
        ])->name('rooms.hygiene-of-rooms.index');
        Route::post('/rooms/{room}/hygiene-of-rooms', [
            RoomHygieneOfRoomsController::class,
            'store',
        ])->name('rooms.hygiene-of-rooms.store');

        Route::apiResource('stock-cards', StockCardController::class);

        // StockCard Out In Products
        Route::get('/stock-cards/{stockCard}/out-in-products', [
            StockCardOutInProductsController::class,
            'index',
        ])->name('stock-cards.out-in-products.index');
        Route::post('/stock-cards/{stockCard}/out-in-products', [
            StockCardOutInProductsController::class,
            'store',
        ])->name('stock-cards.out-in-products.store');

        Route::apiResource(
            'employee-statuses',
            EmployeeStatusController::class
        );

        // EmployeeStatus Employees
        Route::get('/employee-statuses/{employeeStatus}/employees', [
            EmployeeStatusEmployeesController::class,
            'index',
        ])->name('employee-statuses.employees.index');
        Route::post('/employee-statuses/{employeeStatus}/employees', [
            EmployeeStatusEmployeesController::class,
            'store',
        ])->name('employee-statuses.employees.store');

        Route::apiResource('refunds', RefundController::class);

        Route::apiResource('utility-usages', UtilityUsageController::class);

        Route::apiResource('vehicle-taxes', VehicleTaxController::class);

        Route::apiResource(
            'vehicle-certificates',
            VehicleCertificateController::class
        );

        Route::apiResource(
            'movement-asset-results',
            MovementAssetResultController::class
        );

        // MovementAssetResult Movement Asset Audits
        Route::get(
            '/movement-asset-results/{movementAssetResult}/movement-asset-audits',
            [MovementAssetResultMovementAssetAuditsController::class, 'index']
        )->name('movement-asset-results.movement-asset-audits.index');
        Route::post(
            '/movement-asset-results/{movementAssetResult}/movement-asset-audits',
            [MovementAssetResultMovementAssetAuditsController::class, 'store']
        )->name('movement-asset-results.movement-asset-audits.store');

        Route::apiResource('store-assets', StoreAssetController::class);

        // StoreAsset Movement Assets
        Route::get('/store-assets/{storeAsset}/movement-assets', [
            StoreAssetMovementAssetsController::class,
            'index',
        ])->name('store-assets.movement-assets.index');
        Route::post('/store-assets/{storeAsset}/movement-assets', [
            StoreAssetMovementAssetsController::class,
            'store',
        ])->name('store-assets.movement-assets.store');

        Route::apiResource('admin-cashlesses', AdminCashlessController::class);

        // AdminCashless Account Cashlesses
        Route::get('/admin-cashlesses/{adminCashless}/account-cashlesses', [
            AdminCashlessAccountCashlessesController::class,
            'index',
        ])->name('admin-cashlesses.account-cashlesses.index');
        Route::post(
            '/admin-cashlesses/{adminCashless}/account-cashlesses/{accountCashless}',
            [AdminCashlessAccountCashlessesController::class, 'store']
        )->name('admin-cashlesses.account-cashlesses.store');
        Route::delete(
            '/admin-cashlesses/{adminCashless}/account-cashlesses/{accountCashless}',
            [AdminCashlessAccountCashlessesController::class, 'destroy']
        )->name('admin-cashlesses.account-cashlesses.destroy');

        Route::apiResource(
            'purchase-receipts',
            PurchaseReceiptController::class
        );

        // PurchaseReceipt Purchase Orders
        Route::get('/purchase-receipts/{purchaseReceipt}/purchase-orders', [
            PurchaseReceiptPurchaseOrdersController::class,
            'index',
        ])->name('purchase-receipts.purchase-orders.index');
        Route::post(
            '/purchase-receipts/{purchaseReceipt}/purchase-orders/{purchaseOrder}',
            [PurchaseReceiptPurchaseOrdersController::class, 'store']
        )->name('purchase-receipts.purchase-orders.store');
        Route::delete(
            '/purchase-receipts/{purchaseReceipt}/purchase-orders/{purchaseOrder}',
            [PurchaseReceiptPurchaseOrdersController::class, 'destroy']
        )->name('purchase-receipts.purchase-orders.destroy');

        Route::apiResource('closing-stores', ClosingStoreController::class);

        // ClosingStore Presences
        Route::get('/closing-stores/{closingStore}/presences', [
            ClosingStorePresencesController::class,
            'index',
        ])->name('closing-stores.presences.index');
        Route::post('/closing-stores/{closingStore}/presences', [
            ClosingStorePresencesController::class,
            'store',
        ])->name('closing-stores.presences.store');

        // ClosingStore Fuel Services
        Route::get('/closing-stores/{closingStore}/fuel-services', [
            ClosingStoreFuelServicesController::class,
            'index',
        ])->name('closing-stores.fuel-services.index');
        Route::post('/closing-stores/{closingStore}/fuel-services', [
            ClosingStoreFuelServicesController::class,
            'store',
        ])->name('closing-stores.fuel-services.store');

        // ClosingStore Cashlesses
        Route::get('/closing-stores/{closingStore}/cashlesses', [
            ClosingStoreCashlessesController::class,
            'index',
        ])->name('closing-stores.cashlesses.index');
        Route::post('/closing-stores/{closingStore}/cashlesses', [
            ClosingStoreCashlessesController::class,
            'store',
        ])->name('closing-stores.cashlesses.store');

        // ClosingStore Closing Couriers
        Route::get('/closing-stores/{closingStore}/closing-couriers', [
            ClosingStoreClosingCouriersController::class,
            'index',
        ])->name('closing-stores.closing-couriers.index');
        Route::post(
            '/closing-stores/{closingStore}/closing-couriers/{closingCourier}',
            [ClosingStoreClosingCouriersController::class, 'store']
        )->name('closing-stores.closing-couriers.store');
        Route::delete(
            '/closing-stores/{closingStore}/closing-couriers/{closingCourier}',
            [ClosingStoreClosingCouriersController::class, 'destroy']
        )->name('closing-stores.closing-couriers.destroy');

        // ClosingStore Purchase Orders
        Route::get('/closing-stores/{closingStore}/purchase-orders', [
            ClosingStorePurchaseOrdersController::class,
            'index',
        ])->name('closing-stores.purchase-orders.index');
        Route::post(
            '/closing-stores/{closingStore}/purchase-orders/{purchaseOrder}',
            [ClosingStorePurchaseOrdersController::class, 'store']
        )->name('closing-stores.purchase-orders.store');
        Route::delete(
            '/closing-stores/{closingStore}/purchase-orders/{purchaseOrder}',
            [ClosingStorePurchaseOrdersController::class, 'destroy']
        )->name('closing-stores.purchase-orders.destroy');

        Route::apiResource(
            'transfer-daily-salaries',
            TransferDailySalaryController::class
        );

        // TransferDailySalary Presences
        Route::get('/transfer-daily-salaries/{transferDailySalary}/presences', [
            TransferDailySalaryPresencesController::class,
            'index',
        ])->name('transfer-daily-salaries.presences.index');
        Route::post(
            '/transfer-daily-salaries/{transferDailySalary}/presences/{presence}',
            [TransferDailySalaryPresencesController::class, 'store']
        )->name('transfer-daily-salaries.presences.store');
        Route::delete(
            '/transfer-daily-salaries/{transferDailySalary}/presences/{presence}',
            [TransferDailySalaryPresencesController::class, 'destroy']
        )->name('transfer-daily-salaries.presences.destroy');

        Route::apiResource('store-cashlesses', StoreCashlessController::class);

        // StoreCashless Account Cashlesses
        Route::get('/store-cashlesses/{storeCashless}/account-cashlesses', [
            StoreCashlessAccountCashlessesController::class,
            'index',
        ])->name('store-cashlesses.account-cashlesses.index');
        Route::post('/store-cashlesses/{storeCashless}/account-cashlesses', [
            StoreCashlessAccountCashlessesController::class,
            'store',
        ])->name('store-cashlesses.account-cashlesses.store');

        Route::apiResource(
            'account-cashlesses',
            AccountCashlessController::class
        );

        // AccountCashless Cashlesses
        Route::get('/account-cashlesses/{accountCashless}/cashlesses', [
            AccountCashlessCashlessesController::class,
            'index',
        ])->name('account-cashlesses.cashlesses.index');
        Route::post('/account-cashlesses/{accountCashless}/cashlesses', [
            AccountCashlessCashlessesController::class,
            'store',
        ])->name('account-cashlesses.cashlesses.store');

        // AccountCashless Admin Cashlesses
        Route::get('/account-cashlesses/{accountCashless}/admin-cashlesses', [
            AccountCashlessAdminCashlessesController::class,
            'index',
        ])->name('account-cashlesses.admin-cashlesses.index');
        Route::post(
            '/account-cashlesses/{accountCashless}/admin-cashlesses/{adminCashless}',
            [AccountCashlessAdminCashlessesController::class, 'store']
        )->name('account-cashlesses.admin-cashlesses.store');
        Route::delete(
            '/account-cashlesses/{accountCashless}/admin-cashlesses/{adminCashless}',
            [AccountCashlessAdminCashlessesController::class, 'destroy']
        )->name('account-cashlesses.admin-cashlesses.destroy');

        Route::apiResource(
            'delivery-services',
            DeliveryServiceController::class
        );

        // DeliveryService Out In Products
        Route::get('/delivery-services/{deliveryService}/out-in-products', [
            DeliveryServiceOutInProductsController::class,
            'index',
        ])->name('delivery-services.out-in-products.index');
        Route::post('/delivery-services/{deliveryService}/out-in-products', [
            DeliveryServiceOutInProductsController::class,
            'store',
        ])->name('delivery-services.out-in-products.store');

        // DeliveryService Sales Order Onlines
        Route::get('/delivery-services/{deliveryService}/sales-order-onlines', [
            DeliveryServiceSalesOrderOnlinesController::class,
            'index',
        ])->name('delivery-services.sales-order-onlines.index');
        Route::post(
            '/delivery-services/{deliveryService}/sales-order-onlines',
            [DeliveryServiceSalesOrderOnlinesController::class, 'store']
        )->name('delivery-services.sales-order-onlines.store');

        Route::apiResource('utility-bills', UtilityBillController::class);

        Route::apiResource('fuel-services', FuelServiceController::class);

        // FuelService Transfer Fuel Services
        Route::get('/fuel-services/{fuelService}/transfer-fuel-services', [
            FuelServiceTransferFuelServicesController::class,
            'index',
        ])->name('fuel-services.transfer-fuel-services.index');
        Route::post(
            '/fuel-services/{fuelService}/transfer-fuel-services/{transferFuelService}',
            [FuelServiceTransferFuelServicesController::class, 'store']
        )->name('fuel-services.transfer-fuel-services.store');
        Route::delete(
            '/fuel-services/{fuelService}/transfer-fuel-services/{transferFuelService}',
            [FuelServiceTransferFuelServicesController::class, 'destroy']
        )->name('fuel-services.transfer-fuel-services.destroy');

        Route::apiResource(
            'transfer-fuel-services',
            TransferFuelServiceController::class
        );

        // TransferFuelService Fuel Services
        Route::get(
            '/transfer-fuel-services/{transferFuelService}/fuel-services',
            [TransferFuelServiceFuelServicesController::class, 'index']
        )->name('transfer-fuel-services.fuel-services.index');
        Route::post(
            '/transfer-fuel-services/{transferFuelService}/fuel-services/{fuelService}',
            [TransferFuelServiceFuelServicesController::class, 'store']
        )->name('transfer-fuel-services.fuel-services.store');
        Route::delete(
            '/transfer-fuel-services/{transferFuelService}/fuel-services/{fuelService}',
            [TransferFuelServiceFuelServicesController::class, 'destroy']
        )->name('transfer-fuel-services.fuel-services.destroy');
    });
