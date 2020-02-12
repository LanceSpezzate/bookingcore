<form action="{{url( app_get_locale(false,false,'/').config('tour.tour_route_prefix') )}}" class="form bravo_form d-flex justify-content-start" method="get" onsubmit="return false;">
    <div class="filter-item">
        <div class="form-group">
            <i class="field-icon fa icofont-map"></i>
            <div class="form-content">
                <?php
                $location_name = "";
                $list_json = [];
                $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json , &$location_name) {
                    foreach ($locations as $location) {
                        $translate = $location->translateOrOrigin(app()->getLocale());
                        if (request()->query('location_id') == $location->id){
                            $location_name = $translate->name;
                        }
                        $list_json[] = [
                            'id' => $location->id,
                            'title' => $prefix . ' ' . $translate->name,
                        ];
                        $traverse($location->children, $prefix . '-');
                    }
                };
                $traverse($tour_location);
                ?>
                <div class="smart-search">
                    <input type="text" class="smart-search-location parent_text form-control" {{ ( empty(setting_item("tour_location_search_style")) or setting_item("tour_location_search_style") == "normal" ) ? "readonly" : ""  }} placeholder="{{__("Where are you going?")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                           data-default="{{ json_encode($list_json) }}">
                    <input type="hidden" class="child_id" name="location_id" value="{{Request::query('location_id')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="filter-item">
        <div class="form-group">
            <i class="field-icon icofont-beach"></i>
            <div class="form-content">
                <?php
                $cat_name = "";
                $list_cat_json = [];
                $traverse = function ($categories, $prefix = '') use (&$traverse, &$list_cat_json , &$cat_name) {
                    foreach ($categories as $category) {
                        $translate = $category->translateOrOrigin(app()->getLocale());
                        if (request()->query('cat_id') == $category->id){
                            $cat_name = $translate->name;
                        }
                        $list_cat_json[] = [
                            'id' => $category->id,
                            'title' => $prefix . ' ' . $translate->name,
                        ];
                        $traverse($category->children, $prefix . '-');
                    }
                };
                $traverse($tour_category);
                ?>
                <div class="smart-search">
                    <input type="text" class="smart-select parent_text form-control" readonly placeholder="{{__("All Category")}}" value="{{ $cat_name }}" data-default="{{ json_encode($list_cat_json) }}">
                    <input type="hidden" class="child_id" name="cat_id" value="{{Request::query('cat_id')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="filter-item">
        <div class="form-group form-date-field form-date-search clearfix  has-icon">
            <i class="field-icon icofont-wall-clock"></i>
            <div class="date-wrapper clearfix">
                <div class="check-in-wrapper d-flex align-items-center">
                    <div class="render check-in-render">{{Request::query('start',display_date(strtotime("today")))}}</div>
                    <span> - </span>
                    <div class="render check-out-render">{{Request::query('end',display_date(strtotime("+1 day")))}}</div>
                </div>
            </div>
            <input type="hidden" class="check-in-input" value="{{Request::query('start',display_date(strtotime("today")))}}" name="start">
            <input type="hidden" class="check-out-input" value="{{Request::query('end',display_date(strtotime("+1 day")))}}" name="end">
            <input type="text" class="check-in-out input-filter" name="date" value="{{Request::query('date')}}">
        </div>
    </div>
    <div class="filter-item filter-simple dropdown">
        <div class="form-group dropdown-toggle" data-toggle="dropdown" >
            <span class="filter-title">{{__('Price filter')}} <i class="fa fa-angle-down"></i></span>
        </div>
        <div class="filter-dropdown dropdown-menu dropdown-menu-right">
            <div class="bravo-filter-price">
                <?php
                $price_min = $pri_from = floor ( App\Currency::convertPrice($tour_min_max_price[0]) );
                $price_max = $pri_to = ceil ( App\Currency::convertPrice($tour_min_max_price[1]) );
                if (!empty($price_range = Request::query('price_range'))) {
                    $pri_from = explode(";", $price_range)[0];
                    $pri_to = explode(";", $price_range)[1];
                }
                $currency = App\Currency::getCurrency( App\Currency::getCurrent() );
                ?>
                <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                       data-symbol=" {{$currency['symbol'] ?? ''}}"
                       data-min="{{$price_min}}"
                       data-max="{{$price_max}}"
                       data-from="{{$pri_from}}"
                       data-to="{{$pri_to}}"
                       readonly="" value="{{$price_range}}">
                <div class="text-right">
                    <br>
                    <a href="#" onclick="return false;" class="btn btn-primary btn-sm btn-apply-advances">{{__("APPLY")}}</a>

                </div>
            </div>
        </div>
    </div>
    <div class="filter-item filter-simple">
        <div class="form-group">
            <span class="filter-title toggle-advance-filter" data-target="#advance_filters">{{__('More filters')}} <i class="fa fa-angle-down"></i></span>
        </div>
    </div>
</form>
