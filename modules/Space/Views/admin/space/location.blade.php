<div class="panel">
    <div class="panel-title"><strong>{{__("Locations")}}</strong></div>
    <div class="panel-body">
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Location")}}</label>
                <div class="">
                    <select name="location_id" class="form-control">
                        <option value="">{{__("-- Please Select --")}}</option>
                        <?php
                        $traverse = function ($locations, $prefix = '') use (&$traverse, $row) {
                            foreach ($locations as $location) {
                                $selected = '';
                                if ($row->location_id == $location->id)
                                    $selected = 'selected';
                                printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $location->name);
                                $traverse($location->children, $prefix . '-');
                            }
                        };
                        $traverse($space_location);
                        ?>
                    </select>
                </div>
            </div>
        @endif
        <div class="form-group">
            <label class="control-label">{{__("Real address")}}</label>
            <input type="text" name="address" class="form-control" placeholder="{{__("Real address")}}" value="{{$translation->address}}">
        </div>
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Map Engine")}}</label>
                <div class="control-map-group">
                    <div id="map_content"></div>
                    <input type="text" placeholder="{{__("Search by name...")}}" class="bravo_searchbox form-control" autocomplete="off" onkeydown="return event.key !== 'Enter';">
                    <div class="g-control">
                        <div class="form-group">
                            <label>{{__("Map Lat")}}:</label>
                            <input type="text" name="map_lat" class="form-control" value="{{$row->map_lat}}" onkeydown="return event.key !== 'Enter';">
                        </div>
                        <div class="form-group">
                            <label>{{__("Map Lng")}}:</label>
                            <input type="text" name="map_lng" class="form-control" value="{{$row->map_lng}}" onkeydown="return event.key !== 'Enter';">
                        </div>
                        <div class="form-group">
                            <label>{{__("Map Zoom")}}:</label>
                            <input type="text" name="map_zoom" class="form-control" value="{{$row->map_zoom ?? "8"}}" onkeydown="return event.key !== 'Enter';">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>