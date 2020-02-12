<form action="{{ route("hotel.search") }}" class="form bravo_form" method="get">
    <div class="g-field-search">
        <div class="row">
            <div class="col-md-4 border-right">
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
                        $traverse($list_location);
                        ?>
                        <div class="smart-search">
                            <input type="text" class="smart-search-location parent_text form-control" {{ ( empty(setting_item("hotel_location_search_style")) or setting_item("hotel_location_search_style") == "normal" ) ? "readonly" : ""  }} placeholder="{{__("Where are you going?")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                                   data-default="{{ json_encode($list_json) }}">
                            <input type="hidden" class="child_id" name="location_id" value="{{Request::query('location_id')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border-right">
                <div class="form-group">
                    <i class="field-icon icofont-wall-clock"></i>
                    <div class="form-content">
                        <div class="form-date-search-hotel">
                            <div class="date-wrapper">
                                <div class="check-in-wrapper">
                                    <label>{{__("Check In - Out")}}</label>
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
            <div class="col-md-4 border-right dropdown form-select-guests">
                <div class="form-group">
                    <i class="field-icon icofont-travelling"></i>
                    <div class="form-content dropdown-toggle" data-toggle="dropdown">
                        <div class="wrapper-more">
                            <label>{{__('Guests')}}</label>
                            @php
                                $adults = request()->query('adults',1);
                                $children = request()->query('children',0);
                            @endphp
                            <div class="render">
                                <span class="adults" ><span class="one @if($adults >1) d-none @endif">{{__('1 Adult')}}</span> <span class="@if($adults <= 1) d-none @endif multi" data-html="{{__(':count Adults')}}">{{__(':count Adults',['count'=>request()->query('adults',1)])}}</span></span>
                                -
                                <span class="children" >
                            <span class="one @if($children >1) d-none @endif" data-html="{{__(':count Child')}}">{{__(':count Child',['count'=>request()->query('children',0)])}}</span>
                            <span class="multi @if($children <=1) d-none @endif" data-html="{{__(':count Children')}}">{{__(':count Children',['count'=>request()->query('children',0)])}}</span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-menu select-guests-dropdown" >
                        <input type="hidden" name="adults" value="{{request()->query('adults',1)}}" min="1" max="20">
                        <input type="hidden" name="children" value="{{request()->query('children',0)}}" min="0" max="20">
                        <input type="hidden" name="room" value="{{request()->query('room',1)}}" min="1" max="20">
                        <div class="dropdown-item-row">
                            <div class="label">{{__('Rooms')}}</div>
                            <div class="val">
                                <span class="btn-minus" data-input="room"><i class="icon ion-md-remove"></i></span>
                                <span class="count-display">{{request()->query('room',1)}}</span>
                                <span class="btn-add" data-input="room"><i class="icon ion-ios-add"></i></span>
                            </div>
                        </div>
                        <div class="dropdown-item-row">
                            <div class="label">{{__('Adults')}}</div>
                            <div class="val">
                                <span class="btn-minus" data-input="adults"><i class="icon ion-md-remove"></i></span>
                                <span class="count-display">{{request()->query('adults',1)}}</span>
                                <span class="btn-add" data-input="adults"><i class="icon ion-ios-add"></i></span>
                            </div>
                        </div>
                        <div class="dropdown-item-row">
                            <div class="label">{{__('Children')}}</div>
                            <div class="val">
                                <span class="btn-minus" data-input="children"><i class="icon ion-md-remove"></i></span>
                                <span class="count-display">{{request()->query('children',0)}}</span>
                                <span class="btn-add" data-input="children"><i class="icon ion-ios-add"></i></span>
                            </div>
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