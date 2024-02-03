<?php

use Illuminate\Support\Facades\{
    Route,
    Artisan
};
use App\Http\Controllers\Admin\Auth\{
    ForgotPasswordController,
    AuthController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    PermissionController,
    SubAdminController,
    CustomerController,
    StaffController,
    FuelsController,
    VehiclesController,
    WasteDisposalController,
    RefrigerantController,
    MaterialUseController,
    TransmissionAndDistributionController,
    WatersupplytreatmentController,
    ElectricityController,
    FoodCosumptionController,
    ActivityController,
    ManageDatasheetsController,
    BussinessTravelController,
    EmployeesCommutingController,
    WelltotankFuelsController,
    IndustryScopeController,
    BackupReportsController,
    FreightingGoodsFrscController,
    FreightingGoodsVansHgvsController,
    ContactRequestController,
    ProfilesController,
    CmsPagesController,
    FightsController,
    CityController
};
use App\Http\Controllers\Auth\{
    LoginController
};
use App\Http\Controllers\Frontend\{
    CompanyDetailController,
    CustomerSupportController,
    ProfileController,
    ManageStaffController,
    DatasheetsController,
    DashboardController as FrontendDashboardController,
    DashboardScopeController,
};
use App\Models\Datasheet;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'serverheadermiddleware'], function () {

    Route::match(['get', 'head', 'post'], '/', function () {
        view('auth.login');
    });

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize');
        Artisan::call('optimize:clear');
        return 'All cache has been cleared';
    });


    Route::get('/run-seeder', function () {
        Artisan::call('db:seed --class=CountriesTableSeeder');
        Artisan::call('db:seed --class=UserRolesTableSeeder');
        Artisan::call('db:seed --class=UserSeeder');
        Artisan::call('db:seed --class=ScopeNameSeeder');
        Artisan::call('db:seed --class=CompanyIndustrySeeder');
        Artisan::call('db:seed --class=CitySeeder');
        Artisan::call('db:seed --class=ModuleSeeder');
        Artisan::call('db:seed --class=EmissionTypeSeeder');

        Artisan::call('db:seed --class=EmployeesCommutingSeeder');
        Artisan::call('db:seed --class=FoodConsumationSeeder');
        Artisan::call('db:seed --class=FreightingGoodsSeeder');
        Artisan::call('db:seed --class=FuelSeeder');
        Artisan::call('db:seed --class=BusinessTravelSeeder');
        Artisan::call('db:seed --class=WasteDisposelSeeder');
        Artisan::call('db:seed --class=RefrigerantSeeder');
        Artisan::call('db:seed --class=VehicleSeeder');
        Artisan::call('db:seed --class=WttFulesSeeder');
        Artisan::call('db:seed --class=TransmissionAndDistributionSeeder');
        Artisan::call('db:seed --class=WatersupplytreatmentSeeder');
        Artisan::call('db:seed --class=MaterialUseSeeder');
        Artisan::call('db:seed --class=ElectricitySeeder');
        Artisan::call('db:seed --class=FlightsSeeder');

        return 'All seeder sucessfully created';
    });

    /************************************************* Admin Panel Routes ***********************************************************************/
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AuthController::class, 'index']);
        Route::get('login', [AuthController::class, 'index'])->name('admin.login');
        Route::match(['get', 'post'],'post-login', [AuthController::class, 'postLogin'])->name('admin.loginpost');
        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('admin.forgotpassword');
        Route::post('otp-email-send', [ForgotPasswordController::class, 'sentOtpEmail'])->name('admin.otp_emailsend');
        Route::get('otp-verification/{id}', [ForgotPasswordController::class, 'otpFormView'])->name('admin.otp_verification');
        Route::post('otp-verify', [ForgotPasswordController::class, 'verifyOTP'])->name('admin.otp_verify');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'resetPaswordView'])->name('admin.set_password');
        Route::post('reset-password', [ForgotPasswordController::class, 'setNewPassword'])->name('admin.set_password.post');
        Route::middleware(['throttle:global'])->group(function () {
            Route::get('otp-email-resend/{id}', [ForgotPasswordController::class, 'resentOtpEmail'])->name('admin.otp_emailresend');
        });


        Route::group(['middleware' => 'admin'], function () {
            Route::post('change-password', [DashboardController::class, 'changePassword'])->name('profile.change_password');

            /**************************** Profile Page Routes *********************************************/
            Route::group(['prefix' => "profile"], function () {
                Route::get('/', [ProfilesController::class, 'edit'])->name('profile.edit');
                Route::post('/', [ProfilesController::class, 'update'])->name('profile.update');
            });

            Route::match(['get','post'], 'dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
            //Route::post('ajax', [DashboardController::class, 'chart_filter'])->name('dashboard.ajax');
            Route::any('print-chart', [DashboardController::class, 'print_chart'])->name('dashboard.print-chart');

            /**************************** Backend Permission Module Routes *********************************************/
            Route::group(['prefix' => 'backend-permission'], function () {
                Route::get('/', [PermissionController::class, 'index'])->name('backend-permission.index');
                Route::post('/list-module', [PermissionController::class, 'listModule'])->name('backend-permission.list-module');
                Route::post('/update-permission', [PermissionController::class, 'updatePermission'])->name('backend-permission.update');
            });

            /**************************** Frontend Permission Module Routes *********************************************/
            Route::group(['prefix' => 'frontend-permission'], function () {
                Route::get('/', [PermissionController::class, 'frontendPermission'])->name('frontend-permission.index');
                Route::post('/list-module', [PermissionController::class, 'listModule'])->name('frontend-permission.list-module');
                Route::post('/update-permission', [PermissionController::class, 'updatePermission'])->name('frontend-permission.update');
            });


            /**************************** Sub Admin Management Module Routes *********************************************/
            Route::group(['prefix' => 'sub-admin'], function () {
                Route::get('/', [SubAdminController::class, 'index'])->name('sub-admin.index');
                Route::get('/create', [SubAdminController::class, 'create'])->name('sub-admin.create');
                Route::post('/store', [SubAdminController::class, 'store'])->name('sub-admin.store');
                Route::get('/list/load', [SubAdminController::class, 'ajaxlist'])->name('sub-admin.ajax');
                Route::get('/show/{id}', [SubAdminController::class, 'show'])->name('sub-admin.show');
                Route::get('/show/list/{id}', [SubAdminController::class, 'usershowhistory'])->name('sub-admin.show.list');
                Route::get('/edit/{id}', [SubAdminController::class, 'edit'])->name('sub-admin.edit');
                Route::post('/update/{id}', [SubAdminController::class, 'update'])->name('sub-admin.update');
                Route::get('/delete/{id}', [SubAdminController::class, 'destroy'])->name('sub-admin.delete');
            });

            /**************************** Customer Management Module Routes *********************************************/
            Route::group(['prefix' => 'customer'], function () {
                Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
                Route::get('/list/load', [CustomerController::class, 'ajaxlist'])->name('customer.ajax');
                Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
                Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
                Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
                Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
                Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
                Route::get('/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');
                Route::post('/status/change', [CustomerController::class, 'statusChange'])->name('customer.status-change');
                Route::post('/pending/document/mail', [CustomerController::class, 'pendingDocument'])->name('customer.pending-document');
                Route::get('/manage/emission/{userid}', [CustomerController::class, 'manageEmission'])->name('customer.manageemission');
                Route::post('/manage/emission/store', [CustomerController::class, 'manageEmissionStore'])->name('customer.manage-emission-store');
                Route::post('/emissionData', [CustomerController::class, 'customeremissionData'])->name('customer.emission-data');
            });

            /**************************** Company Staff  Module Routes *********************************************/
            Route::group(['prefix' => 'companystaff'], function () {
                Route::get('/{id}', [StaffController::class, 'index'])->name('companystaff.index');
                Route::get('/create/{id}', [StaffController::class, 'create'])->name('companystaff.create');
                Route::post('/store/{id}', [StaffController::class, 'store'])->name('companystaff.store');
                Route::get('/show/{companyid}/{id}', [StaffController::class, 'show'])->name('companystaff.show');
                Route::get('/edit/{companyid}/{id}', [StaffController::class, 'edit'])->name('companystaff.edit');
                Route::post('/update/{companyid}/{id}', [StaffController::class, 'update'])->name('companystaff.update');
                Route::get('/delete/{companyid}/{id}', [StaffController::class, 'destroy'])->name('companystaff.delete');
                Route::post('/status/change', [StaffController::class, 'statusChange'])->name('companystaff.status.change');
            });

            /**************************** Scopes Module Routes *********************************************/
            Route::group(["prefix" => "scopes"], function () {
                Route::get('/', [IndustryScopeController::class, 'index'])->name('scopes.index');
                Route::get('/create', [IndustryScopeController::class, 'create'])->name('scopes.create');
                Route::post('/store', [IndustryScopeController::class, 'store'])->name('scopes.store');
                Route::get('/edit/{id}', [IndustryScopeController::class, 'create'])->name('scopes.edit');
                Route::get('/show/{id}', [IndustryScopeController::class, 'show'])->name('scopes.show');
            });

            /**************************** Backup Reports Module Routes *********************************************/
            Route::group(["prefix" => 'backup-report'], function () {
                Route::get('/', [BackupReportsController::class, 'index'])->name('backup-report.index');
                Route::get('/create', [BackupReportsController::class, 'create'])->name('backup-report.create');
                Route::post('/store', [BackupReportsController::class, 'store'])->name('backup-report.store');
                Route::get('/show/{id}', [BackupReportsController::class, 'show'])->name('backup-report.show');
            });

            /**************************** Emission Factor Module Routes *********************************************/
            Route::group(['prefix' => 'emission-factors'], function () {
                Route::get('/', [ActivityController::class, 'index'])->name('emission-factors.index');
                Route::get('/create', [ActivityController::class, 'create'])->name('emission-factors.create');
                Route::post('/store', [ActivityController::class, 'store'])->name('emission-factors.store');
                Route::get('/show/{id}', [ActivityController::class, 'show'])->name('emission-factors.show');
                Route::get('/edit/{id}', [ActivityController::class, 'edit'])->name('emission-factors.edit');
                Route::post('/update/{id}', [ActivityController::class, 'update'])->name('emission-factors.update');
                Route::get('/delete/{id}', [ActivityController::class, 'destroy'])->name('emission-factors.delete');
            });

            /**************************** WTT-Fuels Module Routes *********************************************/
            Route::group(['prefix' => 'welltotankfuels'], function () {
                Route::get('/', [WelltotankFuelsController::class, 'index'])->name('welltotankfuels.index');
                Route::get('/create', [WelltotankFuelsController::class, 'create'])->name('welltotankfuels.create');
                Route::post('/store', [WelltotankFuelsController::class, 'store'])->name('welltotankfuels.store');
                Route::get('/show/{id}', [WelltotankFuelsController::class, 'show'])->name('welltotankfuels.show');
                Route::get('/edit/{id}', [WelltotankFuelsController::class, 'edit'])->name('welltotankfuels.edit');
                Route::post('/update/{id}', [WelltotankFuelsController::class, 'update'])->name('welltotankfuels.update');
                Route::get('/delete/{id}', [WelltotankFuelsController::class, 'destroy'])->name('welltotankfuels.delete');
            });

            /**************************** Datsheet Mangement Module Routes *********************************************/
            Route::group(['prefix' => 'datasheet'], function () {
                Route::get('/', [ManageDatasheetsController::class, 'index'])->name('datasheet.index');
                Route::get('/show/{id}', [ManageDatasheetsController::class, 'show'])->name('datasheet.show');
                Route::get('/uploded-sheet/{id}', [ManageDatasheetsController::class, 'uplodedSheet'])->name('datasheet.uploded-sheet');
                Route::get('/emission-calculated/{id}', [ManageDatasheetsController::class, 'emissionCalculated'])->name('datasheet.emission_calculated');
            });

            /**************************** Bussiness Travel Module Routes *********************************************/
            Route::group(['prefix' => 'bussinesstravel'], function () {
                Route::get('/', [BussinessTravelController::class, 'index'])->name('bussinesstravel.index');
                Route::get('/create', [BussinessTravelController::class, 'create'])->name('bussinesstravel.create');
                Route::post('/store', [BussinessTravelController::class, 'store'])->name('bussinesstravel.store');
                Route::get('/show/{id}', [BussinessTravelController::class, 'show'])->name('bussinesstravel.show');
                Route::get('/edit/{id}', [BussinessTravelController::class, 'edit'])->name('bussinesstravel.edit');
                Route::post('/update/{id}', [BussinessTravelController::class, 'update'])->name('bussinesstravel.update');
                Route::get('/delete/{id}', [BussinessTravelController::class, 'destroy'])->name('bussinesstravel.delete');
            });

            /**************************** Employees Communting Module Routes *********************************************/
            Route::group(['prefix' => 'employees-commuting'], function () {
                Route::get('/', [EmployeesCommutingController::class, 'index'])->name('employees-commuting.index');
                Route::get('/create', [EmployeesCommutingController::class, 'create'])->name('employees-commuting.create');
                Route::post('/store', [EmployeesCommutingController::class, 'store'])->name('employees-commuting.store');
                Route::get('/show/{id}', [EmployeesCommutingController::class, 'show'])->name('employees-commuting.show');
                Route::get('/edit/{id}', [EmployeesCommutingController::class, 'edit'])->name('employees-commuting.edit');
                Route::post('/update/{id}', [EmployeesCommutingController::class, 'update'])->name('employees-commuting.update');
                Route::get('/delete/{id}', [EmployeesCommutingController::class, 'destroy'])->name('employees-commuting.delete');
            });

            /**************************** Freighting GoodsGVH Module Routes *********************************************/
            Route::group(['prefix' => 'freighting-goodsgvh'], function () {
                Route::get('/', [FreightingGoodsVansHgvsController::class, 'index'])->name('freighting-goodsgvh.index');
                Route::get('/create', [FreightingGoodsVansHgvsController::class, 'create'])->name('freighting-goodsgvh.create');
                Route::post('/store', [FreightingGoodsVansHgvsController::class, 'store'])->name('freighting-goodsgvh.store');
                Route::get('/show/{id}', [FreightingGoodsVansHgvsController::class, 'show'])->name('freighting-goodsgvh.show');
                Route::get('/edit/{id}', [FreightingGoodsVansHgvsController::class, 'edit'])->name('freighting-goodsgvh.edit');
                Route::post('/update/{id}', [FreightingGoodsVansHgvsController::class, 'update'])->name('freighting-goodsgvh.update');
                Route::get('/delete/{id}', [FreightingGoodsVansHgvsController::class, 'destroy'])->name('freighting-goodsgvh.delete');
            });

            /**************************** Freighting GoodsFR Module Routes *********************************************/
            Route::group(['prefix' => 'freighting-goodsfr'], function () {
                Route::get('/', [FreightingGoodsFrscController::class, 'index'])->name('freighting-goodsfr.index');
                Route::get('/create', [FreightingGoodsFrscController::class, 'create'])->name('freighting-goodsfr.create');
                Route::post('/store', [FreightingGoodsFrscController::class, 'store'])->name('freighting-goodsfr.store');
                Route::get('/show/{id}', [FreightingGoodsFrscController::class, 'show'])->name('freighting-goodsfr.show');
                Route::get('/edit/{id}', [FreightingGoodsFrscController::class, 'edit'])->name('freighting-goodsfr.edit');
                Route::post('/update/{id}', [FreightingGoodsFrscController::class, 'update'])->name('freighting-goodsfr.update');
                Route::get('/delete/{id}', [FreightingGoodsFrscController::class, 'destroy'])->name('freighting-goodsfr.delete');
            });

            /**************************** Fuels Module Routes *********************************************/
            Route::group(['prefix' => 'fuels'], function () {
                Route::get('/create', [FuelsController::class, 'create'])->name('fuels.create');
                Route::post('/store', [FuelsController::class, 'store'])->name('fuels.store');
                Route::get('/', [FuelsController::class, 'index'])->name('fuels.index');
                Route::get('/show/{id}', [FuelsController::class, 'show'])->name('fuels.show');
                Route::get('/edit/{id}', [FuelsController::class, 'edit'])->name('fuels.edit');
                Route::post('/update/{id}', [FuelsController::class, 'update'])->name('fuels.update');
                Route::get('/delete/{id}', [FuelsController::class, 'destroy'])->name('fuels.delete');
            });

            /**************************** Vehicles Module Routes *********************************************/
            Route::group(['prefix' => 'vehicles'], function () {
                Route::get('/create', [VehiclesController::class, 'create'])->name('vehicles.create');
                Route::post('/store', [VehiclesController::class, 'store'])->name('vehicles.store');
                Route::get('/', [VehiclesController::class, 'index'])->name('vehicles.index');
                Route::get('/list/load', [VehiclesController::class, 'ajaxlist'])->name('vehicles.ajax');
                Route::get('/show/{id}', [VehiclesController::class, 'show'])->name('vehicles.show');
                Route::get('/edit/{id}', [VehiclesController::class, 'edit'])->name('vehicles.edit');
                Route::post('/update/{id}', [VehiclesController::class, 'update'])->name('vehicles.update');
                Route::get('/delete/{id}', [VehiclesController::class, 'destroy'])->name('vehicles.delete');
            });

            /**************************** Waste-Disposal Module Routes *********************************************/
            Route::group(['prefix' => 'waste-disposal'], function () {
                Route::get('/create', [WasteDisposalController::class, 'create'])->name('waste-disposal.create');
                Route::post('/store', [WasteDisposalController::class, 'store'])->name('waste-disposal.store');
                Route::get('/', [WasteDisposalController::class, 'index'])->name('waste-disposal.index');
                Route::get('/show/{id}', [WasteDisposalController::class, 'show'])->name('waste-disposal.show');
                Route::get('/edit/{id}', [WasteDisposalController::class, 'edit'])->name('waste-disposal.edit');
                Route::post('/update/{id}', [WasteDisposalController::class, 'update'])->name('waste-disposal.update');
                Route::get('/delete/{id}', [WasteDisposalController::class, 'destroy'])->name('waste-disposal.delete');
            });

            /**************************** Refrigerants Module Routes *********************************************/
            Route::group(['prefix' => 'refrigerants'], function () {
                Route::get('/create', [RefrigerantController::class, 'create'])->name('refrigerants.create');
                Route::post('/store', [RefrigerantController::class, 'store'])->name('refrigerants.store');
                Route::get('/', [RefrigerantController::class, 'index'])->name('refrigerants.index');
                Route::get('/list/load', [RefrigerantController::class, 'ajaxlist'])->name('refrigerants.ajax');
                Route::get('/show/{id}', [RefrigerantController::class, 'show'])->name('refrigerants.show');
                Route::get('/edit/{id}', [RefrigerantController::class, 'edit'])->name('refrigerants.edit');
                Route::post('/update/{id}', [RefrigerantController::class, 'update'])->name('refrigerants.update');
                Route::get('/delete/{id}', [RefrigerantController::class, 'destroy'])->name('refrigerants.delete');
            });

            /**************************** Material-use Module Routes *********************************************/
            Route::group(['prefix' => 'material-use'], function () {
                Route::get('/create', [MaterialUseController::class, 'create'])->name('material-use.create');
                Route::post('/store', [MaterialUseController::class, 'store'])->name('material-use.store');
                Route::get('/', [MaterialUseController::class, 'index'])->name('material-use.index');
                Route::get('/show/{id}', [MaterialUseController::class, 'show'])->name('material-use.show');
                Route::get('/edit/{id}', [MaterialUseController::class, 'edit'])->name('material-use.edit');
                Route::post('/update/{id}', [MaterialUseController::class, 'update'])->name('material-use.update');
                Route::get('/delete/{id}', [MaterialUseController::class, 'destroy'])->name('material-use.delete');
            });

            /**************************** Transmission-and-Distribution(T&D) Module Routes *********************************************/
            Route::group(['prefix' => 'transmission-and-distribution'], function () {
                Route::get('/create', [TransmissionAndDistributionController::class, 'create'])->name('transmission-and-distribution.create');
                Route::post('/store', [TransmissionAndDistributionController::class, 'store'])->name('transmission-and-distribution.store');
                Route::get('/', [TransmissionAndDistributionController::class, 'index'])->name('transmission-and-distribution.index');
                Route::get('/show/{id}', [TransmissionAndDistributionController::class, 'show'])->name('transmission-and-distribution.show');
                Route::get('/edit/{id}', [TransmissionAndDistributionController::class, 'edit'])->name('transmission-and-distribution.edit');
                Route::post('/update/{id}', [TransmissionAndDistributionController::class, 'update'])->name('transmission-and-distribution.update');
                Route::get('/delete/{id}', [TransmissionAndDistributionController::class, 'destroy'])->name('transmission-and-distribution.delete');
            });

            /**************************** Water Module Routes *********************************************/
            Route::group(['prefix' => 'water-supply-treatment'], function () {
                Route::get('/create', [WatersupplytreatmentController::class, 'create'])->name('water-supply-treatment.create');
                Route::post('/store', [WatersupplytreatmentController::class, 'store'])->name('water-supply-treatment.store');
                Route::get('/', [WatersupplytreatmentController::class, 'index'])->name('water-supply-treatment.index');
                Route::get('/show/{id}', [WatersupplytreatmentController::class, 'show'])->name('water-supply-treatment.show');
                Route::get('/edit/{id}', [WatersupplytreatmentController::class, 'edit'])->name('water-supply-treatment.edit');
                Route::post('/update/{id}', [WatersupplytreatmentController::class, 'update'])->name('water-supply-treatment.update');
                Route::get('/delete/{id}', [WatersupplytreatmentController::class, 'destroy'])->name('water-supply-treatment.delete');
            });

            /**************************** Electricity Heat Cooling Module Routes *********************************************/
            Route::group(['prefix' => 'electricity-heat-cooling'], function () {
                Route::get('/create', [ElectricityController::class, 'create'])->name('electricity-heat-cooling.create');
                Route::post('/store', [ElectricityController::class, 'store'])->name('electricity-heat-cooling.store');
                Route::get('/', [ElectricityController::class, 'index'])->name('electricity-heat-cooling.index');
                Route::get('/show/{id}', [ElectricityController::class, 'show'])->name('electricity-heat-cooling.show');
                Route::get('/edit/{id}', [ElectricityController::class, 'edit'])->name('electricity-heat-cooling.edit');
                Route::post('/update/{id}', [ElectricityController::class, 'update'])->name('electricity-heat-cooling.update');
                Route::get('/delete/{id}', [ElectricityController::class, 'destroy'])->name('electricity-heat-cooling.delete');
            });

            /**************************** Food Module Routes *********************************************/
            Route::group(['prefix' => 'foodcosumption'], function () {
                Route::get('/', [FoodCosumptionController::class, 'index'])->name('foodcosumption.index');
                Route::get('/create', [FoodCosumptionController::class, 'create'])->name('foodcosumption.create');
                Route::post('/store', [FoodCosumptionController::class, 'store'])->name('foodcosumption.store');
                Route::get('/show/{id}', [FoodCosumptionController::class, 'show'])->name('foodcosumption.show');
                Route::get('/edit/{id}', [FoodCosumptionController::class, 'edit'])->name('foodcosumption.edit');
                Route::post('/update/{id}', [FoodCosumptionController::class, 'update'])->name('foodcosumption.update');
                Route::get('/delete/{id}', [FoodCosumptionController::class, 'destroy'])->name('foodcosumption.delete');
            });

            /**************************** CMS Module Routes *********************************************/
            Route::group(['prefix' => 'cms'], function () {
                Route::get('/create', [CmsPagesController::class, 'create'])->name('cms.create');
                Route::post('/store', [CmsPagesController::class, 'store'])->name('cms.store');
                Route::get('/', [CmsPagesController::class, 'index'])->name('cms.index');
                Route::get('/show/{id}', [CmsPagesController::class, 'show'])->name('cms.show');
                Route::get('/edit/{id}', [CmsPagesController::class, 'edit'])->name('cms.edit');
                Route::post('/update/{id}', [CmsPagesController::class, 'update'])->name('cms.update');
                Route::get('/delete/{id}', [CmsPagesController::class, 'destroy'])->name('cms.delete');
            });

            /**************************** Flights Module Routes *********************************************/
            Route::group(['prefix' => 'flight'], function () {
                Route::get('/create', [FightsController::class, 'create'])->name('flight.create');
                Route::post('/store', [FightsController::class, 'store'])->name('flight.store');
                Route::get('/', [FightsController::class, 'index'])->name('flight.index');
                Route::get('/show/{id}', [FightsController::class, 'show'])->name('flight.show');
                Route::get('/edit/{id}', [FightsController::class, 'edit'])->name('flight.edit');
                Route::post('/update/{id}', [FightsController::class, 'update'])->name('flight.update');
                Route::get('/delete/{id}', [FightsController::class, 'destroy'])->name('flight.delete');
            });

            /**************************** City Module Routes *********************************************/
            Route::group(['prefix' => 'city'], function () {
                Route::get('/create', [CityController::class, 'create'])->name('city.create');
                Route::post('/store', [CityController::class, 'store'])->name('city.store');
                Route::get('/', [CityController::class, 'index'])->name('city.index');
                Route::get('/show/{id}', [CityController::class, 'show'])->name('city.show');
                Route::get('/edit/{id}', [CityController::class, 'edit'])->name('city.edit');
                Route::post('/update/{id}', [CityController::class, 'update'])->name('city.update');
                Route::get('/delete/{id}', [CityController::class, 'destroy'])->name('city.delete');
            });

            /**************************** Contact US Module Routes *********************************************/
            Route::group(['prefix' => "contactus"], function () {
                Route::get('/', [ContactRequestController::class, 'index'])->name('contactus.index');
                Route::get('/show/{id}', [ContactRequestController::class, 'show'])->name('contactus.show');
            });
        });
    });

    Route::match(['get', 'head', 'post'], '/', [LoginController::class, 'index'])->name('web.login');
    Route::match(['get', 'post'],'post-login',  [LoginController::class, 'postLogin'])->name('web.login.post');
    Route::get('/forgot-password', [LoginController::class, 'forgetpasswordform'])->name('web.forget.password');
    Route::post('/forgot-password/mail', [LoginController::class, 'forgetPasswordMail'])->name('web.forget.password.post');
    Route::get('/forgot-password/otp/{slug}', [LoginController::class, 'forgetpasswordotp'])->name('web.forgetpassword.otp');
    Route::post('/forgot-password/otp/check/{slug}', [LoginController::class, 'otpCheck'])->name('web.forgetpassword.otp.check');

    Route::middleware(['throttle:global'])->group(function () {
        Route::get('/resend/otp/{slug}', [LoginController::class, 'resendOtp'])->name('web.resend.otp');
    });

    Route::get('/reset/passwprd/{token}', [LoginController::class, 'resetpassword'])->name('web.reset.password');
    Route::post('/reset/passwprd/post/{slug}', [LoginController::class, 'resetpasswordsubmit'])->name('web.reset.password.post');
    Route::get('logout', [LoginController::class, 'logout'])->name('web.logout');

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/emissionData', [CompanyDetailController::class, 'emissionData'])->name('emission-data');
        Route::get('front/datasheet/status-update', [DatasheetsController::class, 'datasheetStatusUpdate'])->name('frontend-datasheets.update-status');
        Route::group(['middleware' => 'onboardingcheck'], function () {
            //On Boarding Steps
            Route::get('/company-detail-step-one', [CompanyDetailController::class, 'index'])->name('company-detail-step-one.index');
            Route::post('/company-detail-step-one', [CompanyDetailController::class, 'stepOneCreate'])->name('company-detail-step-one.create');
            Route::get('/company-detail-step-two', [CompanyDetailController::class, 'stepTwoIndex'])->name('company-detail-step-two.index');
            Route::post('/company-detail-step-two', [CompanyDetailController::class, 'stepTwoCreate'])->name('company-detail-step-two.create');
            Route::get('/company-detail-step-three', [CompanyDetailController::class, 'stepThreeIndex'])->name('company-detail-step-three.index');
            Route::post('/company-detail-step-three', [CompanyDetailController::class, 'stepThreeCreate'])->name('company-detail-step-three.create');
            Route::get('/company-detail-step-four', [CompanyDetailController::class, 'stepFourIndex'])->name('company-detail-step-four.index');
            Route::post('/company-detail-step-four', [CompanyDetailController::class, 'stepFourCreate'])->name('company-detail-step-four.create');
            Route::get('/company-detail-step-five', [CompanyDetailController::class, 'stepFiveIndex'])->name('company-detail-step-five.index');
            Route::post('/company-detail-step-five', [CompanyDetailController::class, 'stepFiveCreate'])->name('company-detail-step-five.create');
            Route::group(['prefix' => 'frontend'], function () {
                Route::get('/{slug}', [CmsPagesController::class, 'cmsPages'])->name('cms.cms_page');
            });
        });

        Route::group(['middleware' => ['companyonboradingprocesscheck']], function () {
            Route::get('/access-denied', [FrontendDashboardController::class, 'permission'])->name('access-denied');
            Route::get('/import-excel', [FrontendDashboardController::class, 'readexcelsheet'])->name('import.excel');
            Route::group(['middleware' => ['FrontendPermission']], function () {
                Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard.index');
                Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
                Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.edit');
                Route::post('/staff-profile/store', [ProfileController::class, 'staffDetailsUpdate'])->name('profile.staff-profile-details.store');
                Route::post('/profile-company-details/store', [ProfileController::class, 'companyDetailsUpdate'])->name('profile.store');
                Route::post('/company-document-update', [ProfileController::class, 'companyDocumentUpdate'])->name('profile.company-document-update');
                Route::post('/profile-image-remove', [ProfileController::class, 'profileImageRemove'])->name('profile.profile-image-remove');
                Route::match(['post'], '/profile-image-update', [ProfileController::class, 'profileImageUpdate'])->name('profile.profile-image-update');
                Route::post('/profile-industry-details/store', [ProfileController::class, 'companyIndustryUpdate'])->name('profile.profile-industry-details.store');
                Route::post('/profile-after-industry-details/store', [ProfileController::class, 'companyIndustryUpdateAfterStep'])->name('profile.profile-after-industry-details.store');
                Route::get('/profile-after-industry-details/set-activity', [ProfileController::class, 'setactivityTab'])->name('profile.set-activity');
                Route::post('/generate-pdf', [FrontendDashboardController::class, 'generatePdf'])->name('dashboard.generate-pdf');
                Route::get('/scopeone', [FrontendDashboardController::class, 'scopeone'])->name('dashboard.scope1');
                Route::post('/scopeone/createpdf', [FrontendDashboardController::class, 'scopeOnePdf'])->name('dashboard.scope-one-pdf');
                Route::get('/scopetwo', [FrontendDashboardController::class, 'scopetwo'])->name('dashboard.scope2');
                Route::post('/scopetwo/createpdf', [FrontendDashboardController::class, 'scopeTwoPdf'])->name('dashboard.scope-two-pdf');
                Route::get('/scopethree', [FrontendDashboardController::class, 'scopethree'])->name('dashboard.scope3');
                Route::post('/scopethree/createpdf', [FrontendDashboardController::class, 'scopeThreePdf'])->name('dashboard.scope-three-pdf');
                Route::get('/calculatetotalsum', [FrontendDashboardController::class, 'calculateTotalSum'])->name('dashboard.calculateTotalSum');

                //Customer Support
                Route::group(['prefix' => 'customer-support'], function () {
                    Route::get('/', [CustomerSupportController::class, 'index'])->name('customer-support.index');
                    Route::post('/create', [CustomerSupportController::class, 'create'])->name('customer-support.create');
                });

                Route::group(['prefix' => 'staff'], function () {
                    Route::get('/', [ManageStaffController::class, 'index'])->name('staff.index');
                    Route::get('/create', [ManageStaffController::class, 'create'])->name('staff.create');
                    Route::post('/store', [ManageStaffController::class, 'store'])->name('staff.store');
                    Route::get('/get-member-by-id/{id}', [ManageStaffController::class, 'getMemberById'])->name('staff.getMember');
                    Route::get('/show/{id}', [ManageStaffController::class, 'show'])->name('staff.show');
                    Route::get('/edit/{id}', [ManageStaffController::class, 'edit'])->name('staff.edit');
                    Route::post('/update', [ManageStaffController::class, 'update'])->name('staff.update');
                    Route::get('/delete/{id}', [ManageStaffController::class, 'destroy'])->name('staff.delete');
                    Route::get('/activity/{id}', [ManageStaffController::class, 'activityList'])->name('staff.activity');
                    Route::get('/load-more-data', [ManageStaffController::class, 'loadMoreData'])->name('staff.loadMore');
                    Route::get('/get-staff-activity-by-date/{id}/{date}', [ManageStaffController::class, 'activityListDatewise'])->name('staff.activityDatewise');
                });

                Route::group(['prefix' => 'front/datasheet'], function () {
                    Route::get('/', [DatasheetsController::class, 'index'])->name('frontend-datasheets.index');
                    Route::get('/list/load', [DatasheetsController::class, 'ajaxlist'])->name('frontend-datasheets.ajax');
                    Route::post('/store', [DatasheetsController::class, 'store'])->name('frontend-datasheets.store');
                    Route::get('/show/{id}', [DatasheetsController::class, 'show'])->name('frontend-datasheets.show');
                    Route::get('/edit/{id}', [DatasheetsController::class, 'edit'])->name('frontend-datasheets.edit');
                    Route::post('/update', [DatasheetsController::class, 'update'])->name('frontend-datasheets.update');
                    Route::get('/datasheet/uploded-sheet/{id}', [DatasheetsController::class, 'uplodedSheet'])->name('frontend-datasheets.uploded-sheet');
                    Route::get('/publish-datasheet/{id}', [DatasheetsController::class, 'publishDatasheet'])->name('frontend-datasheets.publish-datasheet');
                    // Route::get('/datasheet/emission-calculated/{id}', [DatasheetsController::class, 'emissionCalculated'])->name('frontend-datasheets.emission_calculated');
                    Route::get('/sample-calculation/{id}', [DatasheetsController::class, 'readDatasheetFile'])->name('frontend-datasheets.sample-calculation');
                });
            });
        });
    });
});