<form action="{{url(app_get_locale(false,false,'/').config('tour.tour_route_prefix'))}}" class="form bravo_form" method="get">
    <div class="g-field-search">
        <div class="row">
            <div class="col-md-6 border-right">
                <div class="form-group">
                    <i class="field-icon fa icofont-map"></i>
                    <div class="form-content">
                        <label>{{__("Location")}}</label>
                        <?php
                        $location_name = "";
                        $list_json = [];
                        $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json , &$location_name) {
                            foreach ($locations as $location) {
                                $translate = $location->translateOrOrigin(app()->getLocale());
                                if (Request::query('location_id') == $location->id){
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
            <div class="col-md-6 border-right">
                <div class="form-group">
                    <i class="field-icon icofont-wall-clock"></i>
                    <div class="form-content">
                        <div class="form-date-search">
                            <div class="date-wrapper">
                                <div class="check-in-wrapper">
                                    <label>{{__("From - To")}}</label>
                                    <div class="render check-in-render">{{Request::query('start',display_date(strtotime("today")))}}</div>
                                    <span> - </span>
                                    <div class="render check-out-render">{{Request::query('end',display_date(strtotime("+1 day")))}}</div>
                                </div>
                            </div>
                            <input type="hidden" class="check-in-input" value="{{Request::query('start',display_date(strtotime("today")))}}" name="start">
                            <input type="hidden" class="check-out-input" value="{{Request::query('end',display_date(strtotime("+1 day")))}}" name="end">
                            <input type="text" class="check-in-out" name="date" value="{{Request::query('date',date("Y-m-d")." - ".date("Y-m-d",strtotime("+1 day")))}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="g-button-submit">
        <button class="btn btn-primary btn-search" type="submit">{{__("Search")}}</button>
    </div>
</form>