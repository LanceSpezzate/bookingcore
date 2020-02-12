<?php
namespace Modules\User;
use App\User;
use Illuminate\Support\Facades\Auth;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        $noti_verify = User::countVerifyRequest();
        $noti = $noti_verify;
        return [
            'users'=>[
                "position"=>100,
                'url'        => 'admin/module/user',
                'title'      => __('Users :count',['count'=>$noti ? sprintf('<span class="badge badge-warning">%d</span>',$noti) : '']),
                'icon'       => 'icon ion-ios-contacts',
                'permission' => 'user_view',
                'children'   => [
                    'user'=>[
                        'url'   => 'admin/module/user',
                        'title' => __('All Users'),
                        'icon'  => 'fa fa-user',
                    ],
                    'role'=>[
                        'url'        => 'admin/module/user/role',
                        'title'      => __('Role Manager'),
                        'permission' => 'role_view',
                        'icon'       => 'fa fa-lock',
                    ],
                    'subscriber'=>[
                        'url'        => 'admin/module/user/subscriber',
                        'title'      => __('Subscribers'),
                        'permission' => 'newsletter_manage',
                    ],
                    'userUpgradeRequest'=>[
                        'url'        => 'admin/module/user/userUpgradeRequest',
                        'title'      => __('Upgrade Request'),
                        'permission' => 'user_view',
                    ],
                    'user_verification'=>[
                        'url'        => 'admin/module/user/verification',
                        'title'      => __('Verification Request :count',['count'=>$noti_verify ? sprintf('<span class="badge badge-warning">%d</span>',$noti_verify) : '']),
                        'permission' => 'user_view',
                    ],
                ]
            ],
        ];
    }
    public static function getUserMenu()
    {
        /**
         * @var $user User
         */
        $res = [];
        $user = Auth::user();
        if(!empty($user->verification_fields))
        {
            $res['verification']= [
                'url'        => route('user.verification.index'),
                'title'      => __("Verifications"),
                'icon'       => 'fa fa-handshake-o',
                'position'   => 32,
            ];
        }

        return $res;
    }
}
