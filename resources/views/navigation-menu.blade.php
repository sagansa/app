<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                </div>

                <x-nav-dropdown title="Apps" align="right" width="48">
                        @can('view-any', App\Models\Customer::class)
                        <x-dropdown-link href="{{ route('customers.index') }}">
                        Customers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Employee::class)
                        <x-dropdown-link href="{{ route('employees.index') }}">
                        Employees
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\User::class)
                        <x-dropdown-link href="{{ route('users.index') }}">
                        Users
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Vehicle::class)
                        <x-dropdown-link href="{{ route('vehicles.index') }}">
                        Vehicles
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Store::class)
                        <x-dropdown-link href="{{ route('stores.index') }}">
                        Stores
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Supplier::class)
                        <x-dropdown-link href="{{ route('suppliers.index') }}">
                        Suppliers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ClosingCourier::class)
                        <x-dropdown-link href="{{ route('closing-couriers.index') }}">
                        Closing Couriers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\RemainingStock::class)
                        <x-dropdown-link href="{{ route('remaining-stocks.index') }}">
                        Remaining Stocks
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\CashlessProvider::class)
                        <x-dropdown-link href="{{ route('cashless-providers.index') }}">
                        Cashless Providers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\FranchiseGroup::class)
                        <x-dropdown-link href="{{ route('franchise-groups.index') }}">
                        Franchise Groups
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\MaterialGroup::class)
                        <x-dropdown-link href="{{ route('material-groups.index') }}">
                        Material Groups
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\MonthlySalary::class)
                        <x-dropdown-link href="{{ route('monthly-salaries.index') }}">
                        Monthly Salaries
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\OnlineCategory::class)
                        <x-dropdown-link href="{{ route('online-categories.index') }}">
                        Online Categories
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\OnlineShopProvider::class)
                        <x-dropdown-link href="{{ route('online-shop-providers.index') }}">
                        Online Shop Providers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\PaymentType::class)
                        <x-dropdown-link href="{{ route('payment-types.index') }}">
                        Payment Types
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\PermitEmployee::class)
                        <x-dropdown-link href="{{ route('permit-employees.index') }}">
                        Permit Employees
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ProductGroup::class)
                        <x-dropdown-link href="{{ route('product-groups.index') }}">
                        Product Groups
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\TransferStock::class)
                        <x-dropdown-link href="{{ route('transfer-stocks.index') }}">
                        Transfer Stocks
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\RestaurantCategory::class)
                        <x-dropdown-link href="{{ route('restaurant-categories.index') }}">
                        Restaurant Categories
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\SalesOrderEmployee::class)
                        <x-dropdown-link href="{{ route('sales-order-employees.index') }}">
                        Sales Order Employees
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\SalesOrderOnline::class)
                        <x-dropdown-link href="{{ route('sales-order-onlines.index') }}">
                        Sales Order Onlines
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ShiftStore::class)
                        <x-dropdown-link href="{{ route('shift-stores.index') }}">
                        Shift Stores
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Sop::class)
                        <x-dropdown-link href="{{ route('sops.index') }}">
                        Standard Operation Procedures
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Presence::class)
                        <x-dropdown-link href="{{ route('presences.index') }}">
                        Presences
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Product::class)
                        <x-dropdown-link href="{{ route('products.index') }}">
                        Products
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Bank::class)
                        <x-dropdown-link href="{{ route('banks.index') }}">
                        Banks
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Production::class)
                        <x-dropdown-link href="{{ route('productions.index') }}">
                        Productions
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\RequestStock::class)
                        <x-dropdown-link href="{{ route('request-stocks.index') }}">
                        Request Stocks
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\PurchaseOrder::class)
                        <x-dropdown-link href="{{ route('purchase-orders.index') }}">
                        Purchase Orders
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Utility::class)
                        <x-dropdown-link href="{{ route('utilities.index') }}">
                        Utilities
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Unit::class)
                        <x-dropdown-link href="{{ route('units.index') }}">
                        Units
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ReceiptByItemLoyverse::class)
                        <x-dropdown-link href="{{ route('receipt-by-item-loyverses.index') }}">
                        Receipt By Item Loyverses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ReceiptLoyverse::class)
                        <x-dropdown-link href="{{ route('receipt-loyverses.index') }}">
                        Receipt Loyverses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Hygiene::class)
                        <x-dropdown-link href="{{ route('hygienes.index') }}">
                        Hygienes
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\CleanAndNeat::class)
                        <x-dropdown-link href="{{ route('clean-and-neats.index') }}">
                        Cleans And Neats
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\UtilityProvider::class)
                        <x-dropdown-link href="{{ route('utility-providers.index') }}">
                        Utility Providers
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\SelfConsumption::class)
                        <x-dropdown-link href="{{ route('self-consumptions.index') }}">
                        Self Consumptions
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\OutInProduct::class)
                        <x-dropdown-link href="{{ route('out-in-products.index') }}">
                        Out In Products
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Room::class)
                        <x-dropdown-link href="{{ route('rooms.index') }}">
                        Rooms
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\StockCard::class)
                        <x-dropdown-link href="{{ route('stock-cards.index') }}">
                        Stock Cards
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\EmployeeStatus::class)
                        <x-dropdown-link href="{{ route('employee-statuses.index') }}">
                        Employee Statuses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Refund::class)
                        <x-dropdown-link href="{{ route('refunds.index') }}">
                        Refunds
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\UtilityUsage::class)
                        <x-dropdown-link href="{{ route('utility-usages.index') }}">
                        Utility Usages
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\VehicleTax::class)
                        <x-dropdown-link href="{{ route('vehicle-taxes.index') }}">
                        Vehicle Taxes
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\VehicleCertificate::class)
                        <x-dropdown-link href="{{ route('vehicle-certificates.index') }}">
                        Vehicle Certificates
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\MovementAssetResult::class)
                        <x-dropdown-link href="{{ route('movement-asset-results.index') }}">
                        Movement Asset Results
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\StoreAsset::class)
                        <x-dropdown-link href="{{ route('store-assets.index') }}">
                        Store Assets
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\AdminCashless::class)
                        <x-dropdown-link href="{{ route('admin-cashlesses.index') }}">
                        Admin Cashlesses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\PurchaseReceipt::class)
                        <x-dropdown-link href="{{ route('purchase-receipts.index') }}">
                        Purchase Receipts
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ClosingStore::class)
                        <x-dropdown-link href="{{ route('closing-stores.index') }}">
                        Closing Stores
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\TransferDailySalary::class)
                        <x-dropdown-link href="{{ route('transfer-daily-salaries.index') }}">
                        Transfer Daily Salaries
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\StoreCashless::class)
                        <x-dropdown-link href="{{ route('store-cashlesses.index') }}">
                        Store Cashlesses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\AccountCashless::class)
                        <x-dropdown-link href="{{ route('account-cashlesses.index') }}">
                        Account Cashlesses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\DeliveryService::class)
                        <x-dropdown-link href="{{ route('delivery-services.index') }}">
                        Delivery Services
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\UtilityBill::class)
                        <x-dropdown-link href="{{ route('utility-bills.index') }}">
                        Utility Bills
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\FuelService::class)
                        <x-dropdown-link href="{{ route('fuel-services.index') }}">
                        Fuel Services
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\TransferFuelService::class)
                        <x-dropdown-link href="{{ route('transfer-fuel-services.index') }}">
                        Transfer Fuel Services
                        </x-dropdown-link>
                        @endcan
                </x-nav-dropdown>

                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) || 
                        Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                    <x-nav-dropdown title="Access Management" align="right" width="48">
                        
                        @can('view-any', Spatie\Permission\Models\Role::class)
                        <x-dropdown-link href="{{ route('roles.index') }}">Roles</x-dropdown-link>
                        @endcan
                    
                        @can('view-any', Spatie\Permission\Models\Permission::class)
                        <x-dropdown-link href="{{ route('permissions.index') }}">Permissions</x-dropdown-link>
                        @endcan
                        
                    </x-nav-dropdown>
                    @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
            
                @can('view-any', App\Models\Customer::class)
                <x-jet-responsive-nav-link href="{{ route('customers.index') }}">
                Customers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Employee::class)
                <x-jet-responsive-nav-link href="{{ route('employees.index') }}">
                Employees
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\User::class)
                <x-jet-responsive-nav-link href="{{ route('users.index') }}">
                Users
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Vehicle::class)
                <x-jet-responsive-nav-link href="{{ route('vehicles.index') }}">
                Vehicles
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Store::class)
                <x-jet-responsive-nav-link href="{{ route('stores.index') }}">
                Stores
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Supplier::class)
                <x-jet-responsive-nav-link href="{{ route('suppliers.index') }}">
                Suppliers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ClosingCourier::class)
                <x-jet-responsive-nav-link href="{{ route('closing-couriers.index') }}">
                Closing Couriers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\RemainingStock::class)
                <x-jet-responsive-nav-link href="{{ route('remaining-stocks.index') }}">
                Remaining Stocks
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\CashlessProvider::class)
                <x-jet-responsive-nav-link href="{{ route('cashless-providers.index') }}">
                Cashless Providers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\FranchiseGroup::class)
                <x-jet-responsive-nav-link href="{{ route('franchise-groups.index') }}">
                Franchise Groups
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\MaterialGroup::class)
                <x-jet-responsive-nav-link href="{{ route('material-groups.index') }}">
                Material Groups
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\MonthlySalary::class)
                <x-jet-responsive-nav-link href="{{ route('monthly-salaries.index') }}">
                Monthly Salaries
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\OnlineCategory::class)
                <x-jet-responsive-nav-link href="{{ route('online-categories.index') }}">
                Online Categories
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\OnlineShopProvider::class)
                <x-jet-responsive-nav-link href="{{ route('online-shop-providers.index') }}">
                Online Shop Providers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\PaymentType::class)
                <x-jet-responsive-nav-link href="{{ route('payment-types.index') }}">
                Payment Types
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\PermitEmployee::class)
                <x-jet-responsive-nav-link href="{{ route('permit-employees.index') }}">
                Permit Employees
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ProductGroup::class)
                <x-jet-responsive-nav-link href="{{ route('product-groups.index') }}">
                Product Groups
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\TransferStock::class)
                <x-jet-responsive-nav-link href="{{ route('transfer-stocks.index') }}">
                Transfer Stocks
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\RestaurantCategory::class)
                <x-jet-responsive-nav-link href="{{ route('restaurant-categories.index') }}">
                Restaurant Categories
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\SalesOrderEmployee::class)
                <x-jet-responsive-nav-link href="{{ route('sales-order-employees.index') }}">
                Sales Order Employees
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\SalesOrderOnline::class)
                <x-jet-responsive-nav-link href="{{ route('sales-order-onlines.index') }}">
                Sales Order Onlines
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ShiftStore::class)
                <x-jet-responsive-nav-link href="{{ route('shift-stores.index') }}">
                Shift Stores
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Sop::class)
                <x-jet-responsive-nav-link href="{{ route('sops.index') }}">
                Standard Operation Procedures
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Presence::class)
                <x-jet-responsive-nav-link href="{{ route('presences.index') }}">
                Presences
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Product::class)
                <x-jet-responsive-nav-link href="{{ route('products.index') }}">
                Products
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Bank::class)
                <x-jet-responsive-nav-link href="{{ route('banks.index') }}">
                Banks
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Production::class)
                <x-jet-responsive-nav-link href="{{ route('productions.index') }}">
                Productions
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\RequestStock::class)
                <x-jet-responsive-nav-link href="{{ route('request-stocks.index') }}">
                Request Stocks
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\PurchaseOrder::class)
                <x-jet-responsive-nav-link href="{{ route('purchase-orders.index') }}">
                Purchase Orders
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Utility::class)
                <x-jet-responsive-nav-link href="{{ route('utilities.index') }}">
                Utilities
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Unit::class)
                <x-jet-responsive-nav-link href="{{ route('units.index') }}">
                Units
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ReceiptByItemLoyverse::class)
                <x-jet-responsive-nav-link href="{{ route('receipt-by-item-loyverses.index') }}">
                Receipt By Item Loyverses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ReceiptLoyverse::class)
                <x-jet-responsive-nav-link href="{{ route('receipt-loyverses.index') }}">
                Receipt Loyverses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Hygiene::class)
                <x-jet-responsive-nav-link href="{{ route('hygienes.index') }}">
                Hygienes
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\CleanAndNeat::class)
                <x-jet-responsive-nav-link href="{{ route('clean-and-neats.index') }}">
                Cleans And Neats
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\UtilityProvider::class)
                <x-jet-responsive-nav-link href="{{ route('utility-providers.index') }}">
                Utility Providers
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\SelfConsumption::class)
                <x-jet-responsive-nav-link href="{{ route('self-consumptions.index') }}">
                Self Consumptions
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\OutInProduct::class)
                <x-jet-responsive-nav-link href="{{ route('out-in-products.index') }}">
                Out In Products
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Room::class)
                <x-jet-responsive-nav-link href="{{ route('rooms.index') }}">
                Rooms
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\StockCard::class)
                <x-jet-responsive-nav-link href="{{ route('stock-cards.index') }}">
                Stock Cards
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\EmployeeStatus::class)
                <x-jet-responsive-nav-link href="{{ route('employee-statuses.index') }}">
                Employee Statuses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Refund::class)
                <x-jet-responsive-nav-link href="{{ route('refunds.index') }}">
                Refunds
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\UtilityUsage::class)
                <x-jet-responsive-nav-link href="{{ route('utility-usages.index') }}">
                Utility Usages
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\VehicleTax::class)
                <x-jet-responsive-nav-link href="{{ route('vehicle-taxes.index') }}">
                Vehicle Taxes
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\VehicleCertificate::class)
                <x-jet-responsive-nav-link href="{{ route('vehicle-certificates.index') }}">
                Vehicle Certificates
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\MovementAssetResult::class)
                <x-jet-responsive-nav-link href="{{ route('movement-asset-results.index') }}">
                Movement Asset Results
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\StoreAsset::class)
                <x-jet-responsive-nav-link href="{{ route('store-assets.index') }}">
                Store Assets
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\AdminCashless::class)
                <x-jet-responsive-nav-link href="{{ route('admin-cashlesses.index') }}">
                Admin Cashlesses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\PurchaseReceipt::class)
                <x-jet-responsive-nav-link href="{{ route('purchase-receipts.index') }}">
                Purchase Receipts
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ClosingStore::class)
                <x-jet-responsive-nav-link href="{{ route('closing-stores.index') }}">
                Closing Stores
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\TransferDailySalary::class)
                <x-jet-responsive-nav-link href="{{ route('transfer-daily-salaries.index') }}">
                Transfer Daily Salaries
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\StoreCashless::class)
                <x-jet-responsive-nav-link href="{{ route('store-cashlesses.index') }}">
                Store Cashlesses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\AccountCashless::class)
                <x-jet-responsive-nav-link href="{{ route('account-cashlesses.index') }}">
                Account Cashlesses
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\DeliveryService::class)
                <x-jet-responsive-nav-link href="{{ route('delivery-services.index') }}">
                Delivery Services
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\UtilityBill::class)
                <x-jet-responsive-nav-link href="{{ route('utility-bills.index') }}">
                Utility Bills
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\FuelService::class)
                <x-jet-responsive-nav-link href="{{ route('fuel-services.index') }}">
                Fuel Services
                </x-jet-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\TransferFuelService::class)
                <x-jet-responsive-nav-link href="{{ route('transfer-fuel-services.index') }}">
                Transfer Fuel Services
                </x-jet-responsive-nav-link>
                @endcan

                @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) || 
                    Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                    
                    @can('view-any', Spatie\Permission\Models\Role::class)
                    <x-jet-responsive-nav-link href="{{ route('roles.index') }}">Roles</x-jet-responsive-nav-link>
                    @endcan
                
                    @can('view-any', Spatie\Permission\Models\Permission::class)
                    <x-jet-responsive-nav-link href="{{ route('permissions.index') }}">Permissions</x-jet-responsive-nav-link>
                    @endcan
                    
                @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>