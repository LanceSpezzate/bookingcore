<?php

    use Illuminate\Support\Str;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Modules\Media\Models\MediaFile;

    class General extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            //Setting header,footer
            $menu_items_en = array(
                array(
                    'name'       => 'Home',
                    'url'        => '/',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Home Page',
                            'url'        => '/',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Home Hotel',
                            'url'        => '/page/hotel',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Home Tour',
                            'url'        => '/page/tour',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Home Space',
                            'url'        => '/page/space',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Home Car',
                            'url'        => '/page/car',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Hotel',
                    'url'        => '/hotel',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Hotel List',
                            'url'        => '/hotel',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Hotel Map',
                            'url'        => '/hotel?_layout=map',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Hotel Detail',
                            'url'        => '/hotel/parian-holiday-villas',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Tours',
                    'url'        => '/tour',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Tour List',
                            'url'        => '/tour',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Tour Map',
                            'url'        => '/tour?_layout=map',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Tour Detail',
                            'url'        => '/tour/paris-vacation-travel',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Space',
                    'url'        => '/space',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Space List',
                            'url'        => '/space',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Space Map',
                            'url'        => '/space?_layout=map',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Space Detail',
                            'url'        => '/space/stay-greenwich-village',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Car',
                    'url'        => '/car',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Car List',
                            'url'        => '/car',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Car Map',
                            'url'        => '/car?_layout=map',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Car Detail',
                            'url'        => '/car/vinfast-lux-a20-plus',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Pages',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'News List',
                            'url'        => '/news',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'News Detail',
                            'url'        => '/news/morning-in-the-northern-sea',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Location Detail',
                            'url'        => '/location/paris',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Become a vendor',
                            'url'        => '/page/become-a-vendor',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'Contact',
                    'url'        => '/contact',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
            );
            DB::table('core_menus')->insert([
                'name'        => 'Main Menu',
                'items'       => json_encode($menu_items_en),
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            $menu_items_ja = array(
                array(
                    'name'       => 'ホーム',
                    'url'        => '/ja',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'ホームページ',
                            'url'        => '/ja',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ホームホテル',
                            'url'        => '/ja/page/hotel',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ホーム ツアー',
                            'url'        => '/ja/page/tour',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ホームスペース',
                            'url'        => '/ja/page/space',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'ホテル',
                    'url'        => '/ja/hotel',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'ホテル一覧',
                            'url'        => '/ja/hotel',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ホテルの詳細',
                            'url'        => '/ja/hotel/parian-holiday-villas',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'ツアー',
                    'url'        => '/ja/tour',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'ツアーリスト',
                            'url'        => '/ja/tour',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ツアーマップ',
                            'url'        => '/ja/tour?_layout=map',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ツアー詳細',
                            'url'        => '/ja/tour/paris-vacation-travel',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'スペース',
                    'url'        => '/ja/space',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'スペースリスト',
                            'url'        => '/ja/space',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'スペースの詳細',
                            'url'        => '/ja/space/stay-greenwich-village',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'ページ',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'ニュース一覧',
                            'url'        => '/ja/news',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ニュース詳細',
                            'url'        => '/ja/news/morning-in-the-northern-sea',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => '場所の詳細',
                            'url'        => '/ja/location/paris',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'ベンダーになる',
                            'url'        => '/ja/page/become-a-vendor',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => '接触',
                    'url'        => '/ja/contact',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
            );
            DB::table('core_menu_translations')->insert([
                'origin_id'   => '1',
                'locale'      => 'ja',
                'items'       =>json_encode($menu_items_ja),
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'menu_locations',
                        'val'   => '{"primary":1}',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'admin_email',
                        'val'   => 'contact@bookingcore.com',
                        'group' => "general",
                    ], [
                        'name'  => 'email_from_name',
                        'val'   => 'Booking Core',
                        'group' => "general",
                    ], [
                        'name'  => 'email_from_address',
                        'val'   => 'contact@bookingcore.com',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'logo_id',
                        'val'   => MediaFile::findMediaByName("logo")->id,
                        'group' => "general",
                    ],
                    [
                        'name'  => 'site_favicon',
                        'val'   => MediaFile::findMediaByName("favicon")->id,
                        'group' => "general",
                    ],
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
                    ],
                    [
                        'name'  => 'footer_text_left',
                        'val'   => 'Copyright © 2019 by Booking Core',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'footer_text_right',
                        'val'   => 'Booking Core',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'list_widget_footer',
                        'val'   => '[{"title":"NEED HELP?","size":"3","content":"<div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            Call Us\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            + 00 222 44 5678\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            Email for Us\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            hello@yoursite.com\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            Follow Us\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            <a href=\"#\">\r\n                <i class=\"icofont-facebook\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n               <i class=\"icofont-twitter\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n                <i class=\"icofont-youtube-play\"><\/i>\r\n            <\/a>\r\n        <\/div>\r\n    <\/div>"},{"title":"COMPANY","size":"3","content":"<ul>\r\n    <li><a href=\"#\">About Us<\/a><\/li>\r\n    <li><a href=\"#\">Community Blog<\/a><\/li>\r\n    <li><a href=\"#\">Rewards<\/a><\/li>\r\n    <li><a href=\"#\">Work with Us<\/a><\/li>\r\n    <li><a href=\"#\">Meet the Team<\/a><\/li>\r\n<\/ul>"},{"title":"SUPPORT","size":"3","content":"<ul>\r\n    <li><a href=\"#\">Account<\/a><\/li>\r\n    <li><a href=\"#\">Legal<\/a><\/li>\r\n    <li><a href=\"#\">Contact<\/a><\/li>\r\n    <li><a href=\"#\">Affiliate Program<\/a><\/li>\r\n    <li><a href=\"#\">Privacy Policy<\/a><\/li>\r\n<\/ul>"},{"title":"SETTINGS","size":"3","content":"<ul>\r\n<li><a href=\"#\">Setting 1<\/a><\/li>\r\n<li><a href=\"#\">Setting 2<\/a><\/li>\r\n<\/ul>"}]',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'list_widget_footer_ja',
                        'val'   => '[{"title":"\u52a9\u3051\u304c\u5fc5\u8981\uff1f","size":"3","content":"<div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u304a\u96fb\u8a71\u304f\u3060\u3055\u3044\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            + 00 222 44 5678\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u90f5\u4fbf\u7269\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            hello@yoursite.com\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u30d5\u30a9\u30ed\u30fc\u3059\u308b\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            <a href=\"#\">\r\n                <i class=\"icofont-facebook\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n                <i class=\"icofont-twitter\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n                <i class=\"icofont-youtube-play\"><\/i>\r\n            <\/a>\r\n        <\/div>\r\n    <\/div>"},{"title":"\u4f1a\u793e","size":"3","content":"<ul>\r\n    <li><a href=\"#\">\u7d04, \u7565<\/a><\/li>\r\n    <li><a href=\"#\">\u30b3\u30df\u30e5\u30cb\u30c6\u30a3\u30d6\u30ed\u30b0<\/a><\/li>\r\n    <li><a href=\"#\">\u5831\u916c<\/a><\/li>\r\n    <li><a href=\"#\">\u3068\u9023\u643a<\/a><\/li>\r\n    <li><a href=\"#\">\u30c1\u30fc\u30e0\u306b\u4f1a\u3046<\/a><\/li>\r\n<\/ul>"},{"title":"\u30b5\u30dd\u30fc\u30c8","size":"3","content":"<ul>\r\n    <li><a href=\"#\">\u30a2\u30ab\u30a6\u30f3\u30c8<\/a><\/li>\r\n    <li><a href=\"#\">\u6cd5\u7684<\/a><\/li>\r\n    <li><a href=\"#\">\u63a5\u89e6<\/a><\/li>\r\n    <li><a href=\"#\">\u30a2\u30d5\u30a3\u30ea\u30a8\u30a4\u30c8\u30d7\u30ed\u30b0\u30e9\u30e0<\/a><\/li>\r\n    <li><a href=\"#\">\u500b\u4eba\u60c5\u5831\u4fdd\u8b77\u65b9\u91dd<\/a><\/li>\r\n<\/ul>"},{"title":"\u8a2d\u5b9a","size":"3","content":"<ul>\r\n<li><a href=\"#\">\u8a2d\u5b9a1<\/a><\/li>\r\n<li><a href=\"#\">\u8a2d\u5b9a2<\/a><\/li>\r\n<\/ul>"}]',
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title',
                        'val' => "We'd love to hear from you",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title',
                        'val' => "Send us a message and we'll respond as soon as possible",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_desc',
                        'val' => "<!DOCTYPE html><html><head></head><body><h3>Booking Core</h3><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Tell. + 00 222 444 33</p><p>Email. hello@yoursite.com</p><p>1355 Market St, Suite 900San, Francisco, CA 94103 United States</p></body></html>",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_image',
                        'val' => MediaFile::findMediaByName("bg_contact")->id,
                        'group' => "general",
                    ]
                ]
            );

            $banner_image = MediaFile::findMediaByName("banner-search")->id;
            $banner_home_mix = MediaFile::findMediaByName("home-mix")->id;
            $image_home_mix_1 = MediaFile::findMediaByName("image_home_mix_1")->id;
            $image_home_mix_2 = MediaFile::findMediaByName("image_home_mix_2")->id;
            $image_home_mix_3 = MediaFile::findMediaByName("image_home_mix_3")->id;
            $icon_about_1 = MediaFile::findMediaByName("ico_localguide")->id;
            $icon_about_2 = MediaFile::findMediaByName("ico_adventurous")->id;
            $icon_about_3 = MediaFile::findMediaByName("ico_maps")->id;
            $avatar = MediaFile::findMediaByName("avatar")->id;
            $avatar_2 = MediaFile::findMediaByName("avatar-2")->id;
            $avatar_3 = MediaFile::findMediaByName("avatar-3")->id;
            // Setting Home Page
            DB::table('core_templates')->insert([
                'title'       => 'Home Page',
                'content'     => '[{"type":"form_search_all_service","name":"Form Search All Service","model":{"service_types":["hotel","space","tour","car"],"title":"Hi There!","sub_title":"Where would you like to go?","bg_image":'.$banner_home_mix.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"offer_block","name":"Offer Block","model":{"list_item":[{"_active":false,"title":"Special Offers","desc":"Find Your Perfect Hotels Get the best<br>\nprices on 20,000+ properties<br>\nthe best prices on","background_image":'.$image_home_mix_1.',"link_title":"See Deals","link_more":"#","featured_text":"HOLIDAY SALE"},{"_active":true,"title":"Newsletters","desc":"Join for free and get our <br>\ntailored newsletters full of <br>\nhot travel deals.","background_image":'.$image_home_mix_2.',"link_title":"Sign Up","link_more":"/register","featured_icon":"icofont-email"},{"_active":true,"title":"Travel Tips","desc":"Tips from our travel experts to <br>\nmake your next trip even<br>\nbetter.","background_image":'.$image_home_mix_3.',"link_title":"Sign Up","link_more":"/register","featured_text":null,"featured_icon":"icofont-island-alt"}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"Bestseller Listing","desc":"Hotel highly rated for thoughtful design","number":4,"style":"normal","location_id":"","order":"id","order_by":"asc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":["space","hotel","tour"],"title":"Top Destinations","desc":"It is a long established fact that a reader","number":6,"layout":"style_4","order":"id","order_by":"asc","to_location_detail":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"Our best promotion tours","number":6,"style":"box_shadow","category_id":"","location_id":"","order":"id","order_by":"asc","is_featured":"","desc":"Most popular destinations"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"Rental Listing","desc":"Homes highly rated for thoughtful design","number":4,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_car","name":"Car: List Items","model":{"title":"Car Trending","desc":"Book incredible things to do around the world.","number":8,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true},{"type": "list_news", "name": "News: List Items", "model": {"title": "Read the latest from blog", "desc": "Contrary to popular belief", "number": 6, "category_id": null, "order": "id", "order_by": "asc"}, "component": "RegularBlock", "open": true, "is_container": false},{"type":"call_to_action","name":"Call To Action","model":{"title":"Know your city?","sub_title":"Join 2000+ locals & 1200+ contributors from 3000 cities","link_title":"Become Local Expert","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"Our happy clients","list_item":[{"_active":false,"name":"Eva Hicks","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","number_star":5,"avatar":' . $avatar . '},{"_active":false,"name":"Donald Wolf","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","number_star":6,"avatar":' . $avatar_2 . '},{"_active":false,"name":"Charlie Harrington","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.","number_star":5,"avatar":' . $avatar_3 . '}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_template_translations')->insert([
                'origin_id'   => '1',
                'locale'      => 'ja',
                'title'       => 'Home Page',
                'content'     => '[{"type":"form_search_all_service","name":"Form Search All Service","model":{"service_types":["hotel","space","tour","car"],"title":"こんにちは！","sub_title":"どこに行きたい？","bg_image":'.$banner_home_mix.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"offer_block","name":"Offer Block","model":{"list_item":[{"_active":true,"title":"特別オファー","desc":"最適なホテルを探す<br>\n20,000以上の物件の価格<br>\n上の最高の価格","background_image":'.$image_home_mix_1.',"link_title":"取引","link_more":"#","featured_text":"ホリデーセール"},{"_active":true,"title":"ニュースレター","desc":"無料で参加して取得 <br>\nに合わせたニュースレター<br>\nホット旅行情報。","background_image":'.$image_home_mix_2.',"link_title":"サインアップ","link_more":"/register","featured_icon":"icofont-email"},{"_active":true,"title":"旅行のヒント","desc":"旅行の専門家からのヒント <br>\nあなたの次の<br>\nより良い。","background_image":'.$image_home_mix_3.',"link_title":"サインアップ","link_more":"/register","featured_text":null,"featured_icon":"icofont-island-alt"}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"ベストセラーリスト","desc":"思慮深いデザインで高い評価を得ているホテル","number":4,"style":"normal","location_id":"","order":"id","order_by":"asc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":["space","hotel","tour"],"title":"人気の目的地","desc":"読者が","number":6,"layout":"style_4","order":"id","order_by":"asc","to_location_detail":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"最高のプロモーションツアー","number":6,"style":"box_shadow","category_id":"","location_id":"","order":"id","order_by":"asc","is_featured":"","desc":"最も人気のある目的地"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"賃貸物件","desc":"思慮深いデザインで高い評価を受けている家","number":4,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_car","name":"Car: List Items","model":{"title":"Car Trending","desc":"Book incredible things to do around the world.","number":8,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true},{"type": "list_news", "name": "News: List Items", "model": {"title": "Read the latest from blog", "desc": "Contrary to popular belief", "number": 6, "category_id": null, "order": "id", "order_by": "asc"}, "component": "RegularBlock", "open": true, "is_container": false},{"type":"call_to_action","name":"Call To Action","model":{"title":"あなたの街を知？","sub_title":"3000以上の都市から2000人以上の地元民と","link_title":"ローカルエ","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"私たちの幸せなクライアント","list_item":[{"_active":false,"name":"Eva Hicks","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","number_star":5,"avatar":' . $avatar . '},{"_active":false,"name":"Donald Wolf","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","number_star":6,"avatar":' . $avatar_2 . '},{"_active":true,"name":"Charlie Harrington","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","number_star":5,"avatar":' . $avatar_3 . '}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            // Setting Home Tour
            DB::table('core_templates')->insert([
                'title'       => 'Home Tour',
                'content'     => '[{"type":"form_search_tour","name":"Tour: Form Search","model":{"title":"Love where you\'re going","sub_title":"Book incredible things to do around the world.","bg_image":' . $banner_image . '},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"1,000+ local guides","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":' . $icon_about_1 . '},{"_active":false,"title":"Handcrafted experiences","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":' . $icon_about_2 . '},{"_active":false,"title":"96% happy travelers","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":' . $icon_about_3 . '}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"Trending Tours","number":5,"style":"carousel","category_id":"","location_id":"","order":"id","order_by":"desc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"title":"Top Destinations","number":5,"order":"id","order_by":"desc","service_type":"tour"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"Local Experiences You’ll Love","number":8,"style":"normal","category_id":"","location_id":"","order":"id","order_by":"asc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"call_to_action","name":"Call To Action","model":{"title":"Know your city?","sub_title":"Join 2000+ locals & 1200+ contributors from 3000 cities","link_title":"Become Local Expert","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"Our happy clients","list_item":[{"_active":false,"name":"Eva Hicks","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","number_star":5,"avatar":' . $avatar . '},{"_active":false,"name":"Donald Wolf","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","number_star":6,"avatar":' . $avatar_2 . '},{"_active":false,"name":"Charlie Harrington","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.","number_star":5,"avatar":' . $avatar_3 . '}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_template_translations')->insert([
                'origin_id'   => '2',
                'locale'      => 'ja',
                'title'       => 'Home Tour',
                'content'     => '[{"type":"form_search_tour","name":"Tour: Form Search","model":{"title":"どこへ行くのが大好き","sub_title":"世界中で信じられないようなことを予約しましょう。","bg_image":'.$banner_image.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":true,"title":"1,000+ ローカルガイド","sub_title":"プロのツアーガイドとーガイドとーガイドと 験。 光の","icon_image":'.$icon_about_1.'},{"_active":true,"title":"手作りの体験","sub_title":"プロのツアーガイドとーガイドとーガイドと 験。 光の","icon_image":'.$icon_about_2.'},{"_active":true,"title":"96% 幸せな旅行者","sub_title":"プロのツアーガイドとーガイドとーガイドと 験。 光の","icon_image":'.$icon_about_3.'}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"トレンドツアー","number":5,"style":"carousel","category_id":"","location_id":"","order":"id","order_by":"desc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"title":"人気の目的地","number":5,"order":"id","order_by":"desc","service_type":"tour","desc":"","layout":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"あなたが好きになるローカル体験","number":8,"style":"normal","category_id":"","location_id":"","order":"id","order_by":"asc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"call_to_action","name":"Call To Action","model":{"title":"っていますか？","sub_title":"3000以上の都市から2000人以上の地元民と1200人以上の貢献者に参加する","link_title":"ローカルエ","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"私たちの幸せなクライアント","list_item":[{"_active":false,"name":"Eva Hicks","desc":"融づ苦佐とき百配ほづあ禁安テクミ真覧チヱフ行乗ぱたば外味ナ演庭コヲ旅見ヨコ優成コネ治確はろね訪来終島抄がん。","number_star":5,"avatar":'.$avatar.'},{"_active":false,"name":"Donald Wolf","desc":"融づ苦佐とき百配ほづあ禁安テクミ真覧チヱフ行乗ぱたば外味ナ演庭コヲ旅見ヨコ優成コネ治確はろね訪来終島抄がん。","number_star":6,"avatar":'.$avatar_2.'},{"_active":true,"name":"Charlie Harrington","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","number_star":5,"avatar":'.$avatar_3.'}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            // Page Space
            $banner_image_space = MediaFile::findMediaByName("banner-search-space")->id;
            DB::table('core_templates')->insert([
                'title'       => 'Home Space',
                'content'     => '[{"type":"form_search_space","name":"Space: Form Search","model":{"title":"Find your next rental","sub_title":"Book incredible things to do around the world.","bg_image":'.$banner_image_space.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"Recommended Homes","number":5,"style":"carousel","location_id":"","order":"id","order_by":"asc","desc":"Homes highly rated for thoughtful design"},"component":"RegularBlock","open":true,"is_container":false},{"type":"space_term_featured_box","name":"Space: Term Featured Box","model":{"title":"Find a Home Type","desc":"It is a long established fact that a reader","term_space":["26","27","28","29","30","31"]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":"space","title":"Top Destinations","number":6,"order":"id","order_by":"desc","layout":"style_2","desc":"It is a long established fact that a reader"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":" Rental Listing","desc":"Homes highly rated for thoughtful design","number":4,"style":"normal","location_id":"","order":"id","order_by":"desc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"call_to_action","name":"Call To Action","model":{"title":"Know your city?","sub_title":"Join 2000+ locals & 1200+ contributors from 3000 cities","link_title":"Become Local Expert","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_template_translations')->insert([
                'origin_id'   => '3',
                'locale'      => 'ja',
                'title'       => 'Home Space',
                'content'     => '[{"type":"form_search_space","name":"Space: Form Search","model":{"title":"次のレンタルを探す","sub_title":"世界中で信じられないようなことを予約しましょう。","bg_image":'.$banner_image_space.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"おすすめの家","number":5,"style":"carousel","location_id":"","order":"id","order_by":"asc","desc":"思慮深いデザインで高い評価を受けている家"},"component":"RegularBlock","open":true,"is_container":false},{"type":"space_term_featured_box","name":"Space: Term Featured Box","model":{"title":"ホームタイプを見つける","desc":"これは、読者はその長い既成の事実であります","term_space":["26","27","28","29","30","31"]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":"space","title":"人気の目的地","number":6,"order":"id","order_by":"desc","layout":"style_2","desc":"これは、読者はその長い既成の事実であります"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"賃貸物件","desc":"思慮深いデザインで高い評価を受けている家","number":4,"style":"normal","location_id":"","order":"id","order_by":"desc"},"component":"RegularBlock","open":true,"is_container":false},{"type":"call_to_action","name":"Call To Action","model":{"title":"っていますか？","sub_title":"3000以上の都市から2000人以上の地元民と1200人以上の貢献者に参加する","link_title":"ローカルエ","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            // Page Hotel
            $banner_image_hotel = MediaFile::findMediaByName("banner-search-hotel")->id;
            $hotel_icon_1 = MediaFile::findMediaByName("hotel-icon-1")->id;
            $hotel_icon_2 = MediaFile::findMediaByName("hotel-icon-2")->id;
            $hotel_icon_3 = MediaFile::findMediaByName("hotel-icon-3")->id;
            $ico_chat_1 = MediaFile::findMediaByName("ico_chat_1")->id;
            $ico_friendship_1 = MediaFile::findMediaByName("ico_friendship_1")->id;
            $ico_piggy_bank_1 = MediaFile::findMediaByName("ico_piggy-bank_1")->id;
            DB::table('core_templates')->insert([
                'title'       => 'Home Hotel',
                'content'     => '[{"type":"form_search_hotel","name":"Hotel: Form Search","model":{"title":"Find Your Perfect Hotels","sub_title":"Get the best prices on 20,000+ properties","bg_image":'.$banner_image_hotel.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"20,000+ properties","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":'.$hotel_icon_1.',"order":null},{"_active":false,"title":"Trust & Safety","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":'.$hotel_icon_2.',"order":null},{"_active":true,"title":"Best Price Guarantee","sub_title":"Morbi semper fames lobortis ac hac penatibus","icon_image":'.$hotel_icon_3.',"order":null}],"style":"normal"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"Last Minute Deals","desc":"Hotel highly rated for thoughtful design","number":5,"style":"carousel","location_id":"","order":"","order_by":"","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":"hotel","title":"Top Destinations","desc":"It is a long established fact that a reader","number":6,"layout":"style_3","order":"","order_by":"","to_location_detail":false},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h2><span style=\"color: #1a2b48; font-family: Poppins, sans-serif; font-size: 28px; font-weight: 500; background-color: #ffffff;\">Why be a Local Expert</span></h2>\n<div><span style=\"color: #5e6d77; font-family: Poppins, sans-serif; font-size: 10pt; background-color: #ffffff;\">Varius massa maecenas et id dictumst mattis</span></div>","class":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"Earn an additional income","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_piggy_bank_1.',"order":null},{"_active":false,"title":"Open your network","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_friendship_1.',"order":null},{"_active":false,"title":"Practice your language","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_chat_1.',"order":null}],"style":"style3"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"Bestseller Listing","desc":"Hotel highly rated for thoughtful design","number":8,"style":"normal","location_id":"","order":"id","order_by":"asc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_template_translations')->insert([
                'origin_id'   => '4',
                'locale'      => 'ja',
                'title'       => 'Home Hotel',
                'content'     => '[{"type":"form_search_hotel","name":"Hotel: Form Search","model":{"title":"最適なホテルを探す","sub_title":"20,000以上のプロパティで最高の価格を取得","bg_image":'.$banner_image_hotel.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"20,000以上のプロパティ","sub_title":"これは飢饉は常にlobortis交流pede Suspendisseたです","icon_image":'.$hotel_icon_1.',"order":null},{"_active":false,"title":"信頼と安全性","sub_title":"これは飢饉は常にlobortis交流pede Suspendisseたです","icon_image":'.$hotel_icon_2.',"order":null},{"_active":false,"title":"ベストプライス保証","sub_title":"これは飢饉は常にlobortis交流pede Suspendisseたです","icon_image":'.$hotel_icon_3.',"order":null}],"style":"normal"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"直前予約","desc":"思慮深いデザインで高い評価を得ているホテル","number":5,"style":"carousel","location_id":"","order":"","order_by":"","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":"hotel","title":"人気の目的地","desc":"それは長い間確立された事実であり、","number":6,"layout":"style_3","order":"","order_by":"","to_location_detail":false},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h2><span style=\"color: #1a2b48; font-family: Poppins, sans-serif; font-size: 28px; font-weight: 500; background-color: #ffffff;\">ローカルエキスパートになる理由</span></h2>\n<div><span style=\"color: #5e6d77; font-family: Poppins, sans-serif; font-size: 10pt; background-color: #ffffff;\">様々な質量マエケナスとその格言不動産</span></div>\n<div id=\"gtx-trans\" style=\"position: absolute; left: -118px; top: 55.8125px;\">\n<div class=\"gtx-trans-icon\">&nbsp;</div>\n</div>","class":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"追加の収入を得る","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_piggy_bank_1.',"order":null},{"_active":false,"title":"ネットワークを開く","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_friendship_1.',"order":null},{"_active":false,"title":"あなたの言語を練習する","sub_title":"Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_chat_1.',"order":null}],"style":"style3"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"ベストセラーリスト","desc":"思慮深いデザインで高い評価を得ているホテル","number":8,"style":"normal","location_id":"","order":"id","order_by":"asc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            //Page Vendor
            $banner_image_vendor_register = MediaFile::findMediaByName("thumb-vendor-register")->id;
            $video_bg = MediaFile::findMediaByName("bg-video-vendor-register1")->id;
            $ico_chat_1 = MediaFile::findMediaByName("ico_chat_1")->id;
            $ico_friendship_1 = MediaFile::findMediaByName("ico_friendship_1")->id;
            $ico_piggy_bank_1 = MediaFile::findMediaByName("ico_piggy-bank_1")->id;
            DB::table('core_templates')->insert([
                'title'       => 'Become a vendor',
                'content'     => '[{"type":"vendor_register_form","name":"Vendor Register Form","model":{"title":"Become a vendor","desc":"Join our community to unlock your greatest asset and welcome paying guests into your home.","youtube":"https://www.youtube.com/watch?v=AmZ0WrEaf34","bg_image":'.$banner_image_vendor_register.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h3><strong>How does it work?</strong></h3>","class":"text-center"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"Sign up","sub_title":"Click edit button to change this text  to change this text","icon_image":null,"order":null},{"_active":false,"title":" Add your services","sub_title":" Click edit button to change this text  to change this text","icon_image":null,"order":null},{"_active":true,"title":"Get bookings","sub_title":" Click edit button to change this text  to change this text","icon_image":null,"order":null}],"style":"style2"},"component":"RegularBlock","open":true,"is_container":false},{"type":"video_player","name":"Video Player","model":{"title":"Share the beauty of your city","youtube":"https://www.youtube.com/watch?v=hHUbLv4ThOo","bg_image":'.$video_bg.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h3><strong>Why be a Local Expert</strong></h3>","class":"text-center ptb60"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"Earn an additional income","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_piggy_bank_1.',"order":null},{"_active":true,"title":"Open your network","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_friendship_1.',"order":null},{"_active":true,"title":"Practice your language","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_chat_1.',"order":null}],"style":"style3"},"component":"RegularBlock","open":true,"is_container":false},{"type":"faqs","name":"FAQ List","model":{"title":"FAQs","list_item":[{"_active":false,"title":"How will I receive my payment?","sub_title":" Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."},{"_active":true,"title":"How do I upload products?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."},{"_active":true,"title":"How do I update or extend my availabilities?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.\n"},{"_active":true,"title":"How do I increase conversion rate?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            //Page Car
            $banner_image_space = MediaFile::findMediaByName("banner-search-car")->id;
            DB::table('core_templates')->insert([
                'title'       => 'Home Car',
                'content'     => '[{"type":"form_search_car","name":"Car: Form Search","model":{"title":"Search Rental Car Deals","sub_title":"Book better cars from local hosts across the US and around the world.","bg_image":122},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":true,"title":"Free Cancellation","sub_title":"Morbi semper fames lobortis ac","icon_image":103,"order":null},{"_active":true,"title":"No Hidden Costs","sub_title":"Morbi semper fames lobortis","icon_image":104,"order":null},{"_active":true,"title":"24/7 Customer Care","sub_title":"Morbi semper fames lobortis","icon_image":105,"order":null}],"style":"normal"},"component":"RegularBlock","open":true,"is_container":false},{"type":"car_term_featured_box","name":"Car: Term Featured Box","model":{"title":"Browse by categories","desc":"Book incredible things to do around the world.","term_car":["68","67","66","65","64","63","62","61"]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_car","name":"Car: List Items","model":{"title":"Trending used cars","desc":"Book incredible things to do around the world.","number":8,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"how_it_works","name":"How It Works","model":{"title":"How does it work?","list_item":[{"_active":false,"title":"Find The Car","sub_title":"Lorem Ipsum is simply dummy text of the printing","icon_image":132,"order":null},{"_active":false,"title":"Book It","sub_title":"Lorem Ipsum is simply dummy text of the printing","icon_image":133,"order":null},{"_active":false,"title":"Grab And Go","sub_title":"Lorem Ipsum is simply dummy text of the printing","icon_image":134,"order":null}],"background_image":131},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":["car"],"title":"Top destinations","desc":"Lorem Ipsum is simply dummy text of the printing","number":6,"layout":"style_2","order":"id","order_by":"asc","to_location_detail":""},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            DB::table('core_pages')->insert([
                'title'       => 'Home Page',
                'slug'        => 'home-page',
                'template_id' => '1',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'Home Tour',
                'slug'        => 'tour',
                'template_id' => '2',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'Home Space',
                'slug'        => 'space',
                'template_id' => '3',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'Home Hotel',
                'slug'        => 'hotel',
                'template_id' => '4',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'Become a vendor',
                'slug'        => 'become-a-vendor',
                'template_id' => '5',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'Home Car',
                'slug'        => 'car',
                'template_id' => '6',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'home_page_id',
                        'val'   => '1',
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title',
                        'val' => "We'd love to hear from you",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title_ja',
                        'val' => "あなたからの御一報をお待ち",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title',
                        'val' => "Send us a message and we'll respond as soon as possible",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title_ja',
                        'val' => "私たちにメッセージを送ってください、私たちはできるだ",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_desc',
                        'val' => "<!DOCTYPE html><html><head></head><body><h3>Booking Core</h3><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Tell. + 00 222 444 33</p><p>Email. hello@yoursite.com</p><p>1355 Market St, Suite 900San, Francisco, CA 94103 United States</p></body></html>",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_image',
                        'val' => MediaFile::findMediaByName("bg_contact")->id,
                        'group' => "general",
                    ]
                ]
            );


            // Setting Currency
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "currency_main",
                        'val'   => "usd",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_format",
                        'val'   => "left",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_decimal",
                        'val'   => ",",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_thousand",
                        'val'   => ".",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_no_decimal",
                        'val'   => "0",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "extra_currency",
                        'val'   => '[{"currency_main":"eur","currency_format":"left","currency_thousand":".","currency_decimal":",","currency_no_decimal":"2","rate":"0.902807"},{"currency_main":"jpy","currency_format":"right_space","currency_thousand":".","currency_decimal":",","currency_no_decimal":"0","rate":"0.00917113"}]',
                        'group' => "payment",
                    ]
                ]
            );

            //MAP
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'map_provider',
                        'val'   => 'gmap',
                        'group' => "advance",
                    ],
                    [
                        'name'  => 'map_gmap_key',
                        'val'   => '',
                        'group' => "advance",
                    ]
                ]
            );

            // Payment Gateways
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "g_offline_payment_enable",
                        'val'   => "1",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "g_offline_payment_name",
                        'val'   => "Offline Payment",
                        'group' => "payment",
                    ]
                ]
            );

            // Settings general
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "date_format",
                        'val'   => "m/d/Y",
                        'group' => "general",
                    ],
                    [
                        'name'  => "site_title",
                        'val'   => "Booking Core",
                        'group' => "general",
                    ],
                ]
            );

            // Email general
            DB::table('core_settings')->insert(
			[
                [
                    'name' => "site_timezone",
                    'val' => "UTC",
                    'group' => "general",
                ],
                [
                    'name' => "site_title",
                    'val' => "Booking Core",
                    'group' => "general",
				],
				[
					'name'  => "email_header",
					'val'   => '<h1 class="site-title" style="text-align: center">Booking Core</h1>',
					'group' => "general",
				],
				[
					'name'  => "email_footer",
					'val'   => '<p class="" style="text-align: center">&copy; 2019 Booking Core. All rights reserved</p>',
					'group' => "general",
				],
				[
					'name'  => "enable_mail_user_registered",
					'val'   => 1,
					'group' => "user",
				],
				[
					'name'  => "user_content_email_registered",
					'val'   => '<h1 style="text-align: center">Welcome!</h1>
						<h3>Hello [first_name] [last_name]</h3>
						<p>Thank you for signing up with Booking Core! We hope you enjoy your time with us.</p>
						<p>Regards,</p>
						<p>Booking Core</p>',
					'group' => "user",
				],
				[
					'name'  => "admin_enable_mail_user_registered",
					'val'   => 1,
					'group' => "user",
				],
				[
					'name'  => "admin_content_email_user_registered",
					'val'   => '<h3>Hello Administrator</h3>
						<p>We have new registration</p>
						<p>Full name: [first_name] [last_name]</p>
						<p>Email: [email]</p>
						<p>Regards,</p>
						<p>Booking Core</p>',
					'group' => "user",
				],
				[
					'name' => "user_content_email_forget_password",
					'val'  => '<h1>Hello!</h1>
						<p>You are receiving this email because we received a password reset request for your account.</p>
						<p style="text-align: center">[button_reset_password]</p>
						<p>This password reset link expire in 60 minutes.</p>
						<p>If you did not request a password reset, no further action is required.
						</p>
						<p>Regards,</p>
						<p>Booking Core</p>',
					'group' => "user",
				]
            ]
        );

            // Email Setting
            DB::table('core_settings')->insert(
			[
				[
					'name'  => "email_driver",
					'val'   => "log",
					'group' => "email",
				],
				[
					'name'  => "email_host",
					'val'   => "smtp.mailgun.org",
					'group' => "email",
				],
				[
					'name'  => "email_port",
					'val'   => "587",
					'group' => "email",
				],
				[
					'name'  => "email_encryption",
					'val'   => "tls",
					'group' => "email",
				],
				[
					'name'  => "email_username",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_password",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_domain",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_secret",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_endpoint",
					'val'   => "api.mailgun.net",
					'group' => "email",
				],
				[
					'name'  => "email_postmark_token",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_key",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_secret",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_region",
					'val'   => "us-east-1",
					'group' => "email",
				],
				[
					'name'  => "email_sparkpost_secret",
					'val'   => "",
					'group' => "email",
				],
			]
		);

            // Vendor setting
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "vendor_enable",
                        'val'   => "1",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_commission_type",
                        'val'   => "percent",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_commission_amount",
                        'val'   => "10",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_role",
                        'val'   => "1",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "role_verify_fields",
                        'val'   => '{"phone":{"name":"Phone","type":"text","roles":["1","2","3"],"required":null,"order":null,"icon":"fa fa-phone"},"id_card":{"name":"ID Card","type":"file","roles":["1","2","3"],"required":"1","order":"0","icon":"fa fa-id-card"},"trade_license":{"name":"Trade License","type":"multi_files","roles":["1","3"],"required":"1","order":"0","icon":"fa fa-copyright"}}',
                        'group' => "vendor",
                    ],
                ]
            );

        }
}
