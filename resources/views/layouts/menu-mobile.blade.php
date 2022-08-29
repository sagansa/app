  <nav class="flex-1 px-2 pb-4 space-y-1">
      <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
      <a x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
          :class="{ 'bg-gray-100 text-gray-900': isOn, 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !isOn }"
          href="#"
          class="flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group">
          <!--
                            Heroicon name: outline/home

                            Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                            -->
          <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
              :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
              class="flex-shrink-0 w-6 h-6 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Dashboard
      </a>

      <ul class="space-y-2">
          <li>
              <a href="#"
                  class="flex items-center p-2 text-sm font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                  <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                      :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                      xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                  </svg>
                  <span class="ml-3">Links</span>
              </a>
          </li>

          @role('super-admin')
              <x-sidebars.nav-dropdown-mobile control="analysis" title="Analysis">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                  </x-slot>
                  <x-sidebars.dropdown-link href="{{ route('check-productions') }}">
                      Productions
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('unit-price-purchases') }}">
                      Unit Price Purchase Order
                  </x-sidebars.dropdown-link>
              </x-sidebars.nav-dropdown-mobile>
          @endrole

          @if (Auth::user()->can('view-any', App\Models\Customer::class) ||
              Auth::user()->can('view-any', App\Models\SalesOrderEmployee::class) ||
              Auth::user()->can('view-any', App\Models\SalesOrderOnline::class) ||
              Auth::user()->can('view-any', App\Models\Supplier::class) ||
              Auth::user()->can('view-any', App\Models\PurchaseOrder::class) ||
              Auth::user()->can('view-any', App\Models\PurchaseReceipt::class) ||
              Auth::user()->can('view-any', App\Models\ClosingStore::class) ||
              Auth::user()->can('view-any', App\Models\ClosingCourier::class) ||
              Auth::user()->can('view-any', App\Models\Refund::class) ||
              Auth::user()->can('view-any', App\Models\Receipts::class))
              <x-sidebars.nav-dropdown-mobile control="transactions" title="Transactions">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                  </x-slot>
                  @can('view-any', App\Models\Customer::class)
                      <x-sidebars.dropdown-link href="{{ route('customers.index') }}">
                          Customers
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\SalesOrderEmployee::class)
                      <x-sidebars.dropdown-link href="{{ route('sales-order-employees.index') }}">
                          Sales Order Employees
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\SalesOrderOnline::class)
                      <x-sidebars.dropdown-link href="{{ route('sales-order-onlines.index') }}">
                          Sales Order Onlines
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\Supplier::class)
                      <x-sidebars.dropdown-link href="{{ route('suppliers.index') }}">
                          Suppliers
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\PurchaseOrder::class)
                      <x-sidebars.dropdown-link href="{{ route('purchase-orders.index') }}">
                          Purchase Orders
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\PurchaseReceipt::class)
                      <x-sidebars.dropdown-link href="{{ route('purchase-receipts.index') }}">
                          Purchase Receipts
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\ClosingStore::class)
                      <x-sidebars.dropdown-link href="{{ route('closing-stores.index') }}">
                          Closing Stores
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\ClosingCourier::class)
                      <x-sidebars.dropdown-link href="{{ route('closing-couriers.index') }}">
                          Closing Couriers
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\Refund::class)
                      <x-sidebars.dropdown-link href="{{ route('refunds.index') }}">
                          Refunds
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\AccountCashless::class)
                      <x-sidebars.dropdown-link href="{{ route('account-cashlesses.index') }}">
                          Account Cashlesses
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\UtilityBill::class)
                      <x-sidebars.dropdown-link href="{{ route('utility-bills.index') }}">
                          Utility Bills
                      </x-sidebars.dropdown-link>
                  @endcan
                  {{-- @can('view-any', App\Models\Receipts::class)
                        <x-sidebars.dropdown-link href="{{ route('all-receipts.index') }}">
                            Receipt Loyverse
                        </x-sidebars.dropdown-link>
                        @endcan --}}
              </x-sidebars.nav-dropdown-mobile>
          @endif

          @if (Auth::user()->can('view-any', App\Models\Production::class) ||
              Auth::user()->can('view-any', App\Models\TransferStock::class) ||
              Auth::user()->can('view-any', App\Models\RemainingStock::class) ||
              Auth::user()->can('view-any', App\Models\UtilityUsage::class) ||
              Auth::user()->can('view-any', App\Models\RequestStock::class) ||
              Auth::user()->can('view-any', App\Models\OutInProduct::class) ||
              Auth::user()->can('view-any', App\Models\StockCard::class) ||
              Auth::user()->can('view-any', App\Models\SelfConsumption::class))
              <x-sidebars.nav-dropdown-mobile control="stock-managements" title="Stock Managements">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                      </svg>
                  </x-slot>
                  @can('view-any', App\Models\Production::class)
                      <x-sidebars.dropdown-link href="{{ route('productions.index') }}">
                          Productions
                      </x-sidebars.dropdown-link>
                  @endcan
                  {{-- @can('view-any', App\Models\PurchaseOrderProduct::class)
                      <div class="ml-6">
                          <x-sidebars.dropdown-link href="{{ route('productions`.index') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-2" fill="none"
                                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                              </svg> Check Productions
                          </x-sidebars.dropdown-link>
                      </div>
                  @endcan --}}
                  @can('view-any', App\Models\TransferStock::class)
                      <x-sidebars.dropdown-link href="{{ route('transfer-stocks.index') }}">
                          Transfer Stocks
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\RemainingStock::class)
                      <x-sidebars.dropdown-link href="{{ route('remaining-stocks.index') }}">
                          Remaining Stocks
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\SelfConsumption::class)
                      <x-sidebars.dropdown-link href="{{ route('self-consumptions.index') }}">
                          Self Consumptions
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\RequestStock::class)
                      <x-sidebars.dropdown-link href="{{ route('request-stocks.index') }}">
                          Request Stocks
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\UtilityUsage::class)
                      <x-sidebars.dropdown-link href="{{ route('utility-usages.index') }}">
                          Utility Usages
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\StockCard::class)
                      <x-sidebars.dropdown-link href="{{ route('stock-cards.index') }}">
                          Stock Cards
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\OutInProduct::class)
                      <div class="ml-6">
                          <x-sidebars.dropdown-link href="{{ route('out-in-products.index') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-2" fill="none"
                                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                              </svg> Out In Products
                          </x-sidebars.dropdown-link>
                      </div>
                  @endcan


              </x-sidebars.nav-dropdown-mobile>
          @endif

          @if (Auth::user()->can('view-any', App\Models\Vehicle::class) ||
              Auth::user()->can('view-any', App\Models\VehicleCertificate::class) ||
              Auth::user()->can('view-any', App\Models\VehicleTax::class) ||
              Auth::user()->can('view-any', App\Models\MovementAsset::class) ||
              Auth::user()->can('view-any', App\Models\MovementAssetResult::class))
              <x-sidebars.nav-dropdown-mobile control="asset-managements" title="Asset Managements">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                      </svg>
                  </x-slot>
                  @can('view-any', App\Models\Vehicle::class)
                      <x-sidebars.dropdown-link href="{{ route('vehicles.index') }}">
                          Vehicles
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\VehicleCertificate::class)
                      <x-sidebars.dropdown-link href="{{ route('vehicle-certificates.index') }}">
                          Vehicle Certificates
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\VehicleTax::class)
                      <x-sidebars.dropdown-link href="{{ route('vehicle-taxes.index') }}">
                          Vehicle Taxes
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\StoreAsset::class)
                      <x-sidebars.dropdown-link href="{{ route('store-assets.index') }}">
                          Store Assets
                      </x-sidebars.dropdown-link>
                  @endcan
                  {{-- @can('view-any', App\Models\MovementAssetResult::class)
                      <x-sidebars.dropdown-link href="{{ route('movement-asset-results.index') }}">
                          Movement Asset Results
                      </x-sidebars.dropdown-link>
                  @endcan --}}
              </x-sidebars.nav-dropdown-mobile>
          @endif

          @if (Auth::user()->can('view-any', App\Models\Employee::class) ||
              Auth::user()->can('view-any', App\Models\PermitEmployee::class) ||
              Auth::user()->can('view-any', App\Models\Presence::class) ||
              Auth::user()->can('view-any', App\Models\Sop::class) ||
              Auth::user()->can('view-any', App\Models\MonthlySalary::class))
              <x-sidebars.nav-dropdown-mobile control="hrd" title="HRD">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                  </x-slot>
                  @can('view-any', App\Models\Employee::class)
                      <x-sidebars.dropdown-link href="{{ route('employees.index') }}">
                          Employees
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\PermitEmployee::class)
                      <x-sidebars.dropdown-link href="{{ route('permit-employees.index') }}">
                          Permit Employees
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\Presence::class)
                      <x-sidebars.dropdown-link href="{{ route('presences.index') }}">
                          Presences
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\Sop::class)
                      <x-sidebars.dropdown-link href="{{ route('sops.index') }}">
                          SOP
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\MonthlySalary::class)
                      <x-sidebars.dropdown-link href="{{ route('monthly-salaries.index') }}">
                          Monthly Salaries
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\TransferDailySalary::class)
                      <x-sidebars.dropdown-link href="{{ route('transfer-daily-salaries.index') }}">
                          Transfer Daily Salaries
                      </x-sidebars.dropdown-link>
                  @endcan
              </x-sidebars.nav-dropdown-mobile>
          @endif

          @if (Auth::user()->can('view-any', App\Models\CleanAndNeat::class) ||
              Auth::user()->can('view-any', App\Models\Hygiene::class))
              <x-sidebars.nav-dropdown-mobile control="environments" title="Environments">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                  </x-slot>
                  @can('view-any', App\Models\CleanAndNeat::class)
                      <x-sidebars.dropdown-link href="{{ route('clean-and-neats.index') }}">
                          Cleans And neats
                      </x-sidebars.dropdown-link>
                  @endcan
                  @can('view-any', App\Models\Hygiene::class)
                      <x-sidebars.dropdown-link href="{{ route('hygienes.index') }}">
                          Hygienes
                      </x-sidebars.dropdown-link>
                  @endcan
              </x-sidebars.nav-dropdown-mobile>
          @endif

          @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
              Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
              <x-sidebars.nav-dropdown-mobile control="access-managements" title="Access Managements">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                  </x-slot>
                  @can('view-any', Spatie\Permission\Models\Role::class)
                      <x-sidebars.dropdown-link href="{{ route('roles.index') }}">
                          Roles
                      </x-sidebars.dropdown-link>
                  @endcan

                  @can('view-any', Spatie\Permission\Models\Permission::class)
                      <x-sidebars.dropdown-link href="{{ route('permissions.index') }}">
                          Permissions
                      </x-sidebars.dropdown-link>
                  @endcan

              </x-sidebars.nav-dropdown-mobile>
          @endif

          @role('super-admin')
              <x-sidebars.nav-dropdown-mobile control="data-settings" title="Data Settings">
                  <x-slot name="content">
                      <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
                          :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
                          class="flex-shrink-0 w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                  </x-slot>
                  <x-sidebars.dropdown-link href="{{ route('users.index') }}">
                      Users
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('admin-cashlesses.index') }}">
                      Admin Cashlesses
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('store-cashlesses.index') }}">
                      Store Cashlesses
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('stores.index') }}">
                      Stores
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('products.index') }}">
                      Products
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('utilities.index') }}">
                      Utilities
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('units.index') }}">
                      Units
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('franchise-groups.index') }}">
                      Franchise Groups
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('material-groups.index') }}">
                      Material Groups
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('online-categories.index') }}">
                      Online Categories
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('payment-types.index') }}">
                      Payment Types
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('restaurant-categories.index') }}">
                      Restaurant Categories
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('banks.index') }}">
                      Banks
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('shift-stores.index') }}">
                      Shift Stores
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('cashless-providers.index') }}">
                      Cashless Providers
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('online-shop-providers.index') }}">
                      Online Shop Providers
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('product-groups.index') }}">
                      Product Groups
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('rooms.index') }}">
                      Rooms
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('utility-providers.index') }}">
                      Utility Providers
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('employee-statuses.index') }}">
                      Employee Statuses
                  </x-sidebars.dropdown-link>
                  <x-sidebars.dropdown-link href="{{ route('delivery-services.index') }}">
                      Delivery Services
                  </x-sidebars.dropdown-link>
              </x-sidebars.nav-dropdown-mobile>
          @endrole
      </ul>

      <a href="#"
          class="flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
          <!-- Heroicon name: outline/chart-bar -->
          <svg x-data="{ isOn: false }" @click="isOn = !isOn" :aria-checked="isOn"
              :class="{ 'text-gray-500': isOn, 'text-gray-400 group-hover:text-gray-500': !isOn }"
              class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
              aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          Reports
      </a>
  </nav>
