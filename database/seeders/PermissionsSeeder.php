<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list accountcashlesses']);
        Permission::create(['name' => 'view accountcashlesses']);
        Permission::create(['name' => 'create accountcashlesses']);
        Permission::create(['name' => 'update accountcashlesses']);
        Permission::create(['name' => 'delete accountcashlesses']);

        Permission::create(['name' => 'list admincashlesses']);
        Permission::create(['name' => 'view admincashlesses']);
        Permission::create(['name' => 'create admincashlesses']);
        Permission::create(['name' => 'update admincashlesses']);
        Permission::create(['name' => 'delete admincashlesses']);

        Permission::create(['name' => 'list banks']);
        Permission::create(['name' => 'view banks']);
        Permission::create(['name' => 'create banks']);
        Permission::create(['name' => 'update banks']);
        Permission::create(['name' => 'delete banks']);

        Permission::create(['name' => 'list cashlesses']);
        Permission::create(['name' => 'view cashlesses']);
        Permission::create(['name' => 'create cashlesses']);
        Permission::create(['name' => 'update cashlesses']);
        Permission::create(['name' => 'delete cashlesses']);

        Permission::create(['name' => 'list cashlessproviders']);
        Permission::create(['name' => 'view cashlessproviders']);
        Permission::create(['name' => 'create cashlessproviders']);
        Permission::create(['name' => 'update cashlessproviders']);
        Permission::create(['name' => 'delete cashlessproviders']);

        Permission::create(['name' => 'list cleanandneats']);
        Permission::create(['name' => 'view cleanandneats']);
        Permission::create(['name' => 'create cleanandneats']);
        Permission::create(['name' => 'update cleanandneats']);
        Permission::create(['name' => 'delete cleanandneats']);

        Permission::create(['name' => 'list closingcouriers']);
        Permission::create(['name' => 'view closingcouriers']);
        Permission::create(['name' => 'create closingcouriers']);
        Permission::create(['name' => 'update closingcouriers']);
        Permission::create(['name' => 'delete closingcouriers']);

        Permission::create(['name' => 'list closingstores']);
        Permission::create(['name' => 'view closingstores']);
        Permission::create(['name' => 'create closingstores']);
        Permission::create(['name' => 'update closingstores']);
        Permission::create(['name' => 'delete closingstores']);

        Permission::create(['name' => 'list contractemployees']);
        Permission::create(['name' => 'view contractemployees']);
        Permission::create(['name' => 'create contractemployees']);
        Permission::create(['name' => 'update contractemployees']);
        Permission::create(['name' => 'delete contractemployees']);

        Permission::create(['name' => 'list contractlocations']);
        Permission::create(['name' => 'view contractlocations']);
        Permission::create(['name' => 'create contractlocations']);
        Permission::create(['name' => 'update contractlocations']);
        Permission::create(['name' => 'delete contractlocations']);

        Permission::create(['name' => 'list customers']);
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        Permission::create(['name' => 'list deliveryaddresses']);
        Permission::create(['name' => 'view deliveryaddresses']);
        Permission::create(['name' => 'create deliveryaddresses']);
        Permission::create(['name' => 'update deliveryaddresses']);
        Permission::create(['name' => 'delete deliveryaddresses']);

        Permission::create(['name' => 'list deliveryservices']);
        Permission::create(['name' => 'view deliveryservices']);
        Permission::create(['name' => 'create deliveryservices']);
        Permission::create(['name' => 'update deliveryservices']);
        Permission::create(['name' => 'delete deliveryservices']);

        Permission::create(['name' => 'list districts']);
        Permission::create(['name' => 'view districts']);
        Permission::create(['name' => 'create districts']);
        Permission::create(['name' => 'update districts']);
        Permission::create(['name' => 'delete districts']);

        Permission::create(['name' => 'list employees']);
        Permission::create(['name' => 'view employees']);
        Permission::create(['name' => 'create employees']);
        Permission::create(['name' => 'update employees']);
        Permission::create(['name' => 'delete employees']);

        Permission::create(['name' => 'list employeestatuses']);
        Permission::create(['name' => 'view employeestatuses']);
        Permission::create(['name' => 'create employeestatuses']);
        Permission::create(['name' => 'update employeestatuses']);
        Permission::create(['name' => 'delete employeestatuses']);

        Permission::create(['name' => 'list franchisegroups']);
        Permission::create(['name' => 'view franchisegroups']);
        Permission::create(['name' => 'create franchisegroups']);
        Permission::create(['name' => 'update franchisegroups']);
        Permission::create(['name' => 'delete franchisegroups']);

        Permission::create(['name' => 'list fuelservices']);
        Permission::create(['name' => 'view fuelservices']);
        Permission::create(['name' => 'create fuelservices']);
        Permission::create(['name' => 'update fuelservices']);
        Permission::create(['name' => 'delete fuelservices']);

        Permission::create(['name' => 'list hygienes']);
        Permission::create(['name' => 'view hygienes']);
        Permission::create(['name' => 'create hygienes']);
        Permission::create(['name' => 'update hygienes']);
        Permission::create(['name' => 'delete hygienes']);

        Permission::create(['name' => 'list hygieneofrooms']);
        Permission::create(['name' => 'view hygieneofrooms']);
        Permission::create(['name' => 'create hygieneofrooms']);
        Permission::create(['name' => 'update hygieneofrooms']);
        Permission::create(['name' => 'delete hygieneofrooms']);

        Permission::create(['name' => 'list materialgroups']);
        Permission::create(['name' => 'view materialgroups']);
        Permission::create(['name' => 'create materialgroups']);
        Permission::create(['name' => 'update materialgroups']);
        Permission::create(['name' => 'delete materialgroups']);

        Permission::create(['name' => 'list monthlysalaries']);
        Permission::create(['name' => 'view monthlysalaries']);
        Permission::create(['name' => 'create monthlysalaries']);
        Permission::create(['name' => 'update monthlysalaries']);
        Permission::create(['name' => 'delete monthlysalaries']);

        Permission::create(['name' => 'list movementassets']);
        Permission::create(['name' => 'view movementassets']);
        Permission::create(['name' => 'create movementassets']);
        Permission::create(['name' => 'update movementassets']);
        Permission::create(['name' => 'delete movementassets']);

        Permission::create(['name' => 'list movementassetaudits']);
        Permission::create(['name' => 'view movementassetaudits']);
        Permission::create(['name' => 'create movementassetaudits']);
        Permission::create(['name' => 'update movementassetaudits']);
        Permission::create(['name' => 'delete movementassetaudits']);

        Permission::create(['name' => 'list movementassetresults']);
        Permission::create(['name' => 'view movementassetresults']);
        Permission::create(['name' => 'create movementassetresults']);
        Permission::create(['name' => 'update movementassetresults']);
        Permission::create(['name' => 'delete movementassetresults']);

        Permission::create(['name' => 'list onlinecategories']);
        Permission::create(['name' => 'view onlinecategories']);
        Permission::create(['name' => 'create onlinecategories']);
        Permission::create(['name' => 'update onlinecategories']);
        Permission::create(['name' => 'delete onlinecategories']);

        Permission::create(['name' => 'list onlineshopproviders']);
        Permission::create(['name' => 'view onlineshopproviders']);
        Permission::create(['name' => 'create onlineshopproviders']);
        Permission::create(['name' => 'update onlineshopproviders']);
        Permission::create(['name' => 'delete onlineshopproviders']);

        Permission::create(['name' => 'list outinproducts']);
        Permission::create(['name' => 'view outinproducts']);
        Permission::create(['name' => 'create outinproducts']);
        Permission::create(['name' => 'update outinproducts']);
        Permission::create(['name' => 'delete outinproducts']);

        Permission::create(['name' => 'list paymenttypes']);
        Permission::create(['name' => 'view paymenttypes']);
        Permission::create(['name' => 'create paymenttypes']);
        Permission::create(['name' => 'update paymenttypes']);
        Permission::create(['name' => 'delete paymenttypes']);

        Permission::create(['name' => 'list permitemployees']);
        Permission::create(['name' => 'view permitemployees']);
        Permission::create(['name' => 'create permitemployees']);
        Permission::create(['name' => 'update permitemployees']);
        Permission::create(['name' => 'delete permitemployees']);

        Permission::create(['name' => 'list presences']);
        Permission::create(['name' => 'view presences']);
        Permission::create(['name' => 'create presences']);
        Permission::create(['name' => 'update presences']);
        Permission::create(['name' => 'delete presences']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list productgroups']);
        Permission::create(['name' => 'view productgroups']);
        Permission::create(['name' => 'create productgroups']);
        Permission::create(['name' => 'update productgroups']);
        Permission::create(['name' => 'delete productgroups']);

        Permission::create(['name' => 'list productions']);
        Permission::create(['name' => 'view productions']);
        Permission::create(['name' => 'create productions']);
        Permission::create(['name' => 'update productions']);
        Permission::create(['name' => 'delete productions']);

        Permission::create(['name' => 'list productionfroms']);
        Permission::create(['name' => 'view productionfroms']);
        Permission::create(['name' => 'create productionfroms']);
        Permission::create(['name' => 'update productionfroms']);
        Permission::create(['name' => 'delete productionfroms']);

        Permission::create(['name' => 'list productionsupportfroms']);
        Permission::create(['name' => 'view productionsupportfroms']);
        Permission::create(['name' => 'create productionsupportfroms']);
        Permission::create(['name' => 'update productionsupportfroms']);
        Permission::create(['name' => 'delete productionsupportfroms']);

        Permission::create(['name' => 'list productiontos']);
        Permission::create(['name' => 'view productiontos']);
        Permission::create(['name' => 'create productiontos']);
        Permission::create(['name' => 'update productiontos']);
        Permission::create(['name' => 'delete productiontos']);

        Permission::create(['name' => 'list provinces']);
        Permission::create(['name' => 'view provinces']);
        Permission::create(['name' => 'create provinces']);
        Permission::create(['name' => 'update provinces']);
        Permission::create(['name' => 'delete provinces']);

        Permission::create(['name' => 'list purchaseorders']);
        Permission::create(['name' => 'view purchaseorders']);
        Permission::create(['name' => 'create purchaseorders']);
        Permission::create(['name' => 'update purchaseorders']);
        Permission::create(['name' => 'delete purchaseorders']);

        Permission::create(['name' => 'list purchaseorderproducts']);
        Permission::create(['name' => 'view purchaseorderproducts']);
        Permission::create(['name' => 'create purchaseorderproducts']);
        Permission::create(['name' => 'update purchaseorderproducts']);
        Permission::create(['name' => 'delete purchaseorderproducts']);

        Permission::create(['name' => 'list purchasereceipts']);
        Permission::create(['name' => 'view purchasereceipts']);
        Permission::create(['name' => 'create purchasereceipts']);
        Permission::create(['name' => 'update purchasereceipts']);
        Permission::create(['name' => 'delete purchasereceipts']);

        Permission::create(['name' => 'list receiptbyitemloyverses']);
        Permission::create(['name' => 'view receiptbyitemloyverses']);
        Permission::create(['name' => 'create receiptbyitemloyverses']);
        Permission::create(['name' => 'update receiptbyitemloyverses']);
        Permission::create(['name' => 'delete receiptbyitemloyverses']);

        Permission::create(['name' => 'list receiptloyverses']);
        Permission::create(['name' => 'view receiptloyverses']);
        Permission::create(['name' => 'create receiptloyverses']);
        Permission::create(['name' => 'update receiptloyverses']);
        Permission::create(['name' => 'delete receiptloyverses']);

        Permission::create(['name' => 'list refunds']);
        Permission::create(['name' => 'view refunds']);
        Permission::create(['name' => 'create refunds']);
        Permission::create(['name' => 'update refunds']);
        Permission::create(['name' => 'delete refunds']);

        Permission::create(['name' => 'list regencies']);
        Permission::create(['name' => 'view regencies']);
        Permission::create(['name' => 'create regencies']);
        Permission::create(['name' => 'update regencies']);
        Permission::create(['name' => 'delete regencies']);

        Permission::create(['name' => 'list remainingstocks']);
        Permission::create(['name' => 'view remainingstocks']);
        Permission::create(['name' => 'create remainingstocks']);
        Permission::create(['name' => 'update remainingstocks']);
        Permission::create(['name' => 'delete remainingstocks']);

        Permission::create(['name' => 'list requeststocks']);
        Permission::create(['name' => 'view requeststocks']);
        Permission::create(['name' => 'create requeststocks']);
        Permission::create(['name' => 'update requeststocks']);
        Permission::create(['name' => 'delete requeststocks']);

        Permission::create(['name' => 'list restaurantcategories']);
        Permission::create(['name' => 'view restaurantcategories']);
        Permission::create(['name' => 'create restaurantcategories']);
        Permission::create(['name' => 'update restaurantcategories']);
        Permission::create(['name' => 'delete restaurantcategories']);

        Permission::create(['name' => 'list rooms']);
        Permission::create(['name' => 'view rooms']);
        Permission::create(['name' => 'create rooms']);
        Permission::create(['name' => 'update rooms']);
        Permission::create(['name' => 'delete rooms']);

        Permission::create(['name' => 'list salesorderemployees']);
        Permission::create(['name' => 'view salesorderemployees']);
        Permission::create(['name' => 'create salesorderemployees']);
        Permission::create(['name' => 'update salesorderemployees']);
        Permission::create(['name' => 'delete salesorderemployees']);

        Permission::create(['name' => 'list salesorderonlines']);
        Permission::create(['name' => 'view salesorderonlines']);
        Permission::create(['name' => 'create salesorderonlines']);
        Permission::create(['name' => 'update salesorderonlines']);
        Permission::create(['name' => 'delete salesorderonlines']);

        Permission::create(['name' => 'list savings']);
        Permission::create(['name' => 'view savings']);
        Permission::create(['name' => 'create savings']);
        Permission::create(['name' => 'update savings']);
        Permission::create(['name' => 'delete savings']);

        Permission::create(['name' => 'list selfconsumptions']);
        Permission::create(['name' => 'view selfconsumptions']);
        Permission::create(['name' => 'create selfconsumptions']);
        Permission::create(['name' => 'update selfconsumptions']);
        Permission::create(['name' => 'delete selfconsumptions']);

        Permission::create(['name' => 'list shiftstores']);
        Permission::create(['name' => 'view shiftstores']);
        Permission::create(['name' => 'create shiftstores']);
        Permission::create(['name' => 'update shiftstores']);
        Permission::create(['name' => 'delete shiftstores']);

        Permission::create(['name' => 'list sops']);
        Permission::create(['name' => 'view sops']);
        Permission::create(['name' => 'create sops']);
        Permission::create(['name' => 'update sops']);
        Permission::create(['name' => 'delete sops']);

        Permission::create(['name' => 'list stockcards']);
        Permission::create(['name' => 'view stockcards']);
        Permission::create(['name' => 'create stockcards']);
        Permission::create(['name' => 'update stockcards']);
        Permission::create(['name' => 'delete stockcards']);

        Permission::create(['name' => 'list stores']);
        Permission::create(['name' => 'view stores']);
        Permission::create(['name' => 'create stores']);
        Permission::create(['name' => 'update stores']);
        Permission::create(['name' => 'delete stores']);

        Permission::create(['name' => 'list storeassets']);
        Permission::create(['name' => 'view storeassets']);
        Permission::create(['name' => 'create storeassets']);
        Permission::create(['name' => 'update storeassets']);
        Permission::create(['name' => 'delete storeassets']);

        Permission::create(['name' => 'list storecashlesses']);
        Permission::create(['name' => 'view storecashlesses']);
        Permission::create(['name' => 'create storecashlesses']);
        Permission::create(['name' => 'update storecashlesses']);
        Permission::create(['name' => 'delete storecashlesses']);

        Permission::create(['name' => 'list suppliers']);
        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'update suppliers']);
        Permission::create(['name' => 'delete suppliers']);

        Permission::create(['name' => 'list transferdailysalaries']);
        Permission::create(['name' => 'view transferdailysalaries']);
        Permission::create(['name' => 'create transferdailysalaries']);
        Permission::create(['name' => 'update transferdailysalaries']);
        Permission::create(['name' => 'delete transferdailysalaries']);

        Permission::create(['name' => 'list transferfuelservices']);
        Permission::create(['name' => 'view transferfuelservices']);
        Permission::create(['name' => 'create transferfuelservices']);
        Permission::create(['name' => 'update transferfuelservices']);
        Permission::create(['name' => 'delete transferfuelservices']);

        Permission::create(['name' => 'list transferstocks']);
        Permission::create(['name' => 'view transferstocks']);
        Permission::create(['name' => 'create transferstocks']);
        Permission::create(['name' => 'update transferstocks']);
        Permission::create(['name' => 'delete transferstocks']);

        Permission::create(['name' => 'list units']);
        Permission::create(['name' => 'view units']);
        Permission::create(['name' => 'create units']);
        Permission::create(['name' => 'update units']);
        Permission::create(['name' => 'delete units']);

        Permission::create(['name' => 'list utilities']);
        Permission::create(['name' => 'view utilities']);
        Permission::create(['name' => 'create utilities']);
        Permission::create(['name' => 'update utilities']);
        Permission::create(['name' => 'delete utilities']);

        Permission::create(['name' => 'list utilitybills']);
        Permission::create(['name' => 'view utilitybills']);
        Permission::create(['name' => 'create utilitybills']);
        Permission::create(['name' => 'update utilitybills']);
        Permission::create(['name' => 'delete utilitybills']);

        Permission::create(['name' => 'list utilityproviders']);
        Permission::create(['name' => 'view utilityproviders']);
        Permission::create(['name' => 'create utilityproviders']);
        Permission::create(['name' => 'update utilityproviders']);
        Permission::create(['name' => 'delete utilityproviders']);

        Permission::create(['name' => 'list utilityusages']);
        Permission::create(['name' => 'view utilityusages']);
        Permission::create(['name' => 'create utilityusages']);
        Permission::create(['name' => 'update utilityusages']);
        Permission::create(['name' => 'delete utilityusages']);

        Permission::create(['name' => 'list vehicles']);
        Permission::create(['name' => 'view vehicles']);
        Permission::create(['name' => 'create vehicles']);
        Permission::create(['name' => 'update vehicles']);
        Permission::create(['name' => 'delete vehicles']);

        Permission::create(['name' => 'list vehiclecertificates']);
        Permission::create(['name' => 'view vehiclecertificates']);
        Permission::create(['name' => 'create vehiclecertificates']);
        Permission::create(['name' => 'update vehiclecertificates']);
        Permission::create(['name' => 'delete vehiclecertificates']);

        Permission::create(['name' => 'list vehicletaxes']);
        Permission::create(['name' => 'view vehicletaxes']);
        Permission::create(['name' => 'create vehicletaxes']);
        Permission::create(['name' => 'update vehicletaxes']);
        Permission::create(['name' => 'delete vehicletaxes']);

        Permission::create(['name' => 'list villages']);
        Permission::create(['name' => 'view villages']);
        Permission::create(['name' => 'create villages']);
        Permission::create(['name' => 'update villages']);
        Permission::create(['name' => 'delete villages']);

        Permission::create(['name' => 'list workingexperiences']);
        Permission::create(['name' => 'view workingexperiences']);
        Permission::create(['name' => 'create workingexperiences']);
        Permission::create(['name' => 'update workingexperiences']);
        Permission::create(['name' => 'delete workingexperiences']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
