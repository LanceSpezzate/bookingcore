<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Car\Models\CarTranslation;
use Modules\Core\Models\Settings;
use Modules\Hotel\Models\Hotel;
use Modules\Page\Models\Page;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\Tag;
use Modules\News\Models\News;
use Modules\Review\Models\Review;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceTranslation;
use Modules\Tour\Models\Tour;
use Modules\Car\Models\Car;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_page_id = setting_item('home_page_id');
        if($home_page_id && $page = Page::where("id",$home_page_id)->where("status","publish")->first())
        {
            $this->setActiveMenu($page);
            $translation = $page->translateOrOrigin(app()->getLocale());
            $seo_meta = $page->getSeoMetaWithTranslation(app()->getLocale(), $translation);
            $seo_meta['full_url'] = url("/");
            $seo_meta['is_homepage'] = true;
            $data = [
                'row'=>$page,
                "seo_meta"=> $seo_meta
            ];
            return view('Page::frontend.detail',$data);
        }
        $model_News = News::where("status", "publish");
        $data = [
            'rows'=>$model_News->paginate(5),
            'model_category'    => NewsCategory::where("status", "publish"),
            'model_tag'         => Tag::query(),
            'model_news'        => News::where("status", "publish"),
            'breadcrumbs' => [
                ['name' => __('News'), 'url' => url("/news") ,'class' => 'active'],
            ],
            "seo_meta" => News::getSeoMetaForPageList()
        ];
        return view('News::frontend.index',$data);
    }

    public function test()
    {
        Artisan::call('cache:clear');
    }

    public function updateMigrate(){
        Artisan::call('cache:clear');
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        echo $this->updateTo110();
        echo "<br>";
        echo $this->updateTo120();
        echo "<br>";
        echo $this->updateTo130();
        echo "<br>";
        echo $this->updateTo140();
        echo "<br>";
        echo $this->updateTo150();
        echo "<br>";
        echo $this->updateTo151();
        Artisan::call('cache:clear');
    }

    /**
     * @todo Update From 1.0 to 1.1
     */
    public function updateTo110(){
        if(setting_item('update_to_110')){
            return "Updated Up 1.10";
        }
        Permission::findOrCreate('dashboard_vendor_access');
        $vendor = Role::findOrCreate('vendor');
        $vendor->givePermissionTo('media_upload');
        $vendor->givePermissionTo('tour_view');
        $vendor->givePermissionTo('tour_create');
        $vendor->givePermissionTo('tour_update');
        $vendor->givePermissionTo('tour_delete');
        $vendor->givePermissionTo('dashboard_vendor_access');
        $role = Role::findOrCreate('administrator');
        $role->givePermissionTo('dashboard_vendor_access');
        Settings::store('update_to_110',true);
        return "Migrate Up 1.10";
    }

    /**
     * @todo Update From 1.1.0 to 1.2.0
     */
    public function updateTo120(){

        if(setting_item('update_to_120')){
            return "Updated Up 1.20";
        }
        Permission::findOrCreate('space_view');
        Permission::findOrCreate('space_create');
        Permission::findOrCreate('space_update');
        Permission::findOrCreate('space_delete');
        Permission::findOrCreate('space_manage_others');
        Permission::findOrCreate('space_manage_attributes');
        // Vendor
        $vendor = Role::findOrCreate('vendor');
        $vendor->givePermissionTo('space_create');
        $vendor->givePermissionTo('space_view');
        $vendor->givePermissionTo('space_update');
        $vendor->givePermissionTo('space_delete');
        // Admin
        $role = Role::findOrCreate('administrator');
        $role->givePermissionTo('space_view');
        $role->givePermissionTo('space_create');
        $role->givePermissionTo('space_update');
        $role->givePermissionTo('space_delete');
        $role->givePermissionTo('space_manage_others');
        $role->givePermissionTo('space_manage_attributes');

        if(empty(setting_item('topbar_left_text'))){
            DB::table('core_settings')->insert(
                [
                    'name'  => 'topbar_left_text',
                    'val'   => '<div class="socials">
    <a href="#"><i class="fa fa-facebook"></i></a>
    <a href="#"><i class="fa fa-linkedin"></i></a>
    <a href="#"><i class="fa fa-google-plus"></i></a>
</div>
<span class="line"></span>
<a href="mailto:contact@bookingcore.com">contact@bookingcore.com</a>',
                    'group' => "general",
                ]
            );
        }
        Settings::store('update_to_120',true);
        return "Migrate Up 1.20";
    }

    public function updateTo130(){

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'vendor_commission_amount')) {
                $table->integer('vendor_commission_amount')->nullable();
                $table->decimal('total_before_fees',10,2)->nullable();
            }
            if (!Schema::hasColumn('users', 'vendor_commission_type')) {
                $table->string('vendor_commission_type',30)->nullable();
            }
        });

       if(setting_item('update_to_130')){
           return "Updated Up 1.30";
       }

        $this->__updateReviewVendorId();

        // Fix null status user
        User::query()->whereRaw('status is NULL')->update([
            'status'=>'publish'
        ]);

        Settings::store('update_to_130',true);
        return "Migrate Up 1.30";
    }
    public function updateTo140(){

        if(setting_item('update_to_140')){
           return "Updated Up 1.40";
        }

        Permission::findOrCreate('vendor_payout_view');
        Permission::findOrCreate('vendor_payout_manage');

        Permission::findOrCreate('hotel_view');
        Permission::findOrCreate('hotel_create');
        Permission::findOrCreate('hotel_update');
        Permission::findOrCreate('hotel_delete');
        Permission::findOrCreate('hotel_manage_others');
        Permission::findOrCreate('hotel_manage_attributes');

        // Admin
        $role = Role::findOrCreate('administrator');
        $role->givePermissionTo('vendor_payout_view');
        $role->givePermissionTo('vendor_payout_manage');
        $role->givePermissionTo('hotel_view');
        $role->givePermissionTo('hotel_create');
        $role->givePermissionTo('hotel_update');
        $role->givePermissionTo('hotel_delete');
        $role->givePermissionTo('hotel_manage_others');
        $role->givePermissionTo('hotel_manage_attributes');

        $vendor = Role::findOrCreate('vendor');
        $vendor->givePermissionTo('hotel_view');
        $vendor->givePermissionTo('hotel_create');
        $vendor->givePermissionTo('hotel_update');
        $vendor->givePermissionTo('hotel_delete');

        Settings::store('update_to_140',true);
        return "Migrate Up 1.40";
    }

    public function updateTo150(){
        if(setting_item('update_to_150')){
           return "Updated Up 1.50";
        }
        Permission::findOrCreate('plugin_manage');
        $role = Role::findOrCreate('administrator');
        $role->givePermissionTo('plugin_manage');

        // Car
        Permission::findOrCreate('car_view');
        Permission::findOrCreate('car_create');
        Permission::findOrCreate('car_update');
        Permission::findOrCreate('car_delete');
        Permission::findOrCreate('car_manage_others');
        Permission::findOrCreate('car_manage_attributes');
        // Vendor
        $vendor = Role::findOrCreate('vendor');
        $vendor->givePermissionTo('car_create');
        $vendor->givePermissionTo('car_view');
        $vendor->givePermissionTo('car_update');
        $vendor->givePermissionTo('car_delete');
        // Admin
        $role = Role::findOrCreate('administrator');
        $role->givePermissionTo('car_view');
        $role->givePermissionTo('car_create');
        $role->givePermissionTo('car_update');
        $role->givePermissionTo('car_delete');
        $role->givePermissionTo('car_manage_others');
        $role->givePermissionTo('car_manage_attributes');

        Settings::store('update_to_150',true);
        return "Migrate Up 1.50";
    }

    public function updateTo151(){
//        if(setting_item('update_to_151')){
//           return "Updated Up 1.51";
//        }

        $allServices = get_bookable_services();
        foreach ($allServices as $service){
            $alls = $service::query()->whereNull('review_score')->get();
            if(!empty($alls)){
                foreach ($alls as $item){
                    $item->update_service_rate();
                }
            }
        }

	    Schema::table(Tour::getTableName(), function (Blueprint $table) {
		    if (!Schema::hasColumn(Tour::getTableName(), 'ical_import_url')) {
			    $table->string('ical_import_url')->nullable();
		    }
	    });
	    Schema::table(Space::getTableName(), function (Blueprint $table) {
		    if (!Schema::hasColumn(Space::getTableName(), 'ical_import_url')) {
			    $table->string('ical_import_url')->nullable();
		    }
	    });
	    Schema::table(Hotel::getTableName(), function (Blueprint $table) {
		    if (!Schema::hasColumn(Hotel::getTableName(), 'ical_import_url')) {
			    $table->string('ical_import_url')->nullable();
		    }
	    });
	    Schema::table(Car::getTableName(), function (Blueprint $table) {
		    if (!Schema::hasColumn(Car::getTableName(), 'ical_import_url')) {
			    $table->string('ical_import_url')->nullable();
		    }
	    });

	    Schema::table(CarTranslation::getTableName(), function (Blueprint $table) {
		    if (Schema::hasColumn(CarTranslation::getTableName(), 'extra_price')) {
			    $table->dropColumn('extra_price');
		    }
	    });
	    Schema::table(SpaceTranslation::getTableName(), function (Blueprint $table) {
		    if (Schema::hasColumn(SpaceTranslation::getTableName(), 'extra_price')) {
			    $table->dropColumn('extra_price');
		    }
	    });


        DB::statement('ALTER TABLE bravo_spaces MODIFY bed integer');
        DB::statement('ALTER TABLE bravo_spaces MODIFY bathroom integer');
        DB::statement('ALTER TABLE bravo_spaces MODIFY square integer');
        DB::statement('ALTER TABLE bravo_hotel_rooms MODIFY size integer');

        Settings::store('update_to_151',true);
        return "Migrate Up 1.51";
    }

    protected function __updateReviewVendorId(){
        $all = Review::query()->whereNull('vendor_id')->get();
        if(!empty($all))
        {
            foreach ($all as $item){
                switch ($item->object_model)
                {
                    case "tour":
                        $tour = Tour::find($item->object_id);
                        if($tour){
                            $item->vendor_id = $tour->create_user;
                            $item->save();
                        }
                        break;
                    case "space":
                        $tour = Space::find($item->object_id);
                        if($tour){
                            $item->vendor_id = $tour->create_user;
                            $item->save();
                        }
                        break;
                }
            }
        }
    }

    public function checkConnectDatabase(Request $request){
        $connection = $request->input('database_connection');
        config([
            'database' => [
                'default' => $connection."_check",
                'connections' => [
                    $connection."_check" => [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ],
                ],
            ],
        ]);
        try {
            DB::connection()->getPdo();
            $check = DB::table('information_schema.tables')->where("table_schema","performance_schema")->get();
            if(empty($check) and $check->count() == 0){
                $this->sendSuccess(false , __("Access denied for user!. Please check your configuration."));
            }
            if(DB::connection()->getDatabaseName()){
                $this->sendSuccess(false , __("Yes! Successfully connected to the DB: ".DB::connection()->getDatabaseName()));
            }else{
                $this->sendSuccess(false , __("Could not find the database. Please check your configuration."));
            }
        } catch (\Exception $e) {
            $this->sendError( $e->getMessage() );
        }
    }
}
