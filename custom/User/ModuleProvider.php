<?php

namespace Custom\User;

use Custom\ModuleServiceProvider;
use Custom\User\RouterServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
//        parent::register();
        $this->app->register(RouterServiceProvider::class);

//        add_action('booking.checkout.before_total_review',[__CLASS__,'show_coupon']);
    }

    public static function getActionsHook()
    {
//        return [
//            [
//                'booking.checkout.before_total_review',
//                [__CLASS__,'show_coupon']
//            ]
//        ];
    }

    public static function show_coupon(){
        ?>
        <div class="coupon-section">
            <h5>Coupon Code</h5>

            <form method="post" action="https://acmap.travelerwp.com/checkout/">

                <div class="form-group">
                    <input id="field-coupon_code" value="" type="text" name="coupon_code">
                    <input type="hidden" name="st_action" value="apply_coupon">
                    <button type="submit" class="btn btn-primary">APPLY</button>
                </div>
            </form>
        </div>
        <?php
    }

}
