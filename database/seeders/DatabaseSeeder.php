<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(AccountCashlessSeeder::class);
        $this->call(AdminCashlessSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(CashlessSeeder::class);
        $this->call(CashlessProviderSeeder::class);
        $this->call(CleanAndNeatSeeder::class);
        $this->call(ClosingCourierSeeder::class);
        $this->call(ClosingStoreSeeder::class);
        $this->call(ContractEmployeeSeeder::class);
        $this->call(ContractLocationSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(DeliveryAddressSeeder::class);
        $this->call(DeliveryServiceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(FranchiseGroupSeeder::class);
        $this->call(FuelServiceSeeder::class);
        $this->call(HygieneSeeder::class);
        $this->call(HygieneOfRoomSeeder::class);
        $this->call(MaterialGroupSeeder::class);
        $this->call(MonthlySalarySeeder::class);
        $this->call(MovementAssetSeeder::class);
        $this->call(MovementAssetAuditSeeder::class);
        $this->call(MovementAssetResultSeeder::class);
        $this->call(OnlineCategorySeeder::class);
        $this->call(OnlineShopProviderSeeder::class);
        $this->call(OutInProductSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(PermitEmployeeSeeder::class);
        $this->call(PresenceSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductGroupSeeder::class);
        $this->call(ProductionSeeder::class);
        $this->call(ProductionFromSeeder::class);
        $this->call(ProductionSupportFromSeeder::class);
        $this->call(ProductionToSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(PurchaseOrderSeeder::class);
        $this->call(PurchaseOrderProductSeeder::class);
        $this->call(PurchaseReceiptSeeder::class);
        $this->call(ReceiptByItemLoyverseSeeder::class);
        $this->call(ReceiptLoyverseSeeder::class);
        $this->call(RefundSeeder::class);
        $this->call(RegencySeeder::class);
        $this->call(RemainingStockSeeder::class);
        $this->call(RequestStockSeeder::class);
        $this->call(RestaurantCategorySeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(SalesOrderEmployeeSeeder::class);
        $this->call(SalesOrderOnlineSeeder::class);
        $this->call(SavingSeeder::class);
        $this->call(SelfConsumptionSeeder::class);
        $this->call(ShiftStoreSeeder::class);
        $this->call(SopSeeder::class);
        $this->call(StockCardSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(StoreAssetSeeder::class);
        $this->call(StoreCashlessSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(TransferDailySalarySeeder::class);
        $this->call(TransferFuelServiceSeeder::class);
        $this->call(TransferStockSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UtilitySeeder::class);
        $this->call(UtilityBillSeeder::class);
        $this->call(UtilityProviderSeeder::class);
        $this->call(UtilityUsageSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(VehicleCertificateSeeder::class);
        $this->call(VehicleTaxSeeder::class);
        $this->call(VillageSeeder::class);
        $this->call(WorkingExperienceSeeder::class);
    }
}
