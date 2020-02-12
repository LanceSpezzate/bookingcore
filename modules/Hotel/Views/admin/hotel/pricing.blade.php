@if(is_default_lang())
    <div class="panel">
        <div class="panel-title"><strong>{{__("Check in/out time")}}</strong></div>
        <div class="panel-body">
            <div class="form-group d-none">
                <label>{{__('Allowed full day booking')}}</label>
                <br>
                <label>
                    <input type="checkbox" name="allow_full_day" @if($row->allow_full_day) checked @endif value="1"> {{__("Enable full day booking")}}
                </label>
                <div class="small">
                    {{__("You can book room with full day")}} <br>
                    {{__("Eg: booking from 22-23, then all days 22 and 23 are full, other people cannot book")}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__("Time for check in")}}</label>
                        <input type="text" value="{{$row->check_in_time}}" placeholder="{{__("Eg: 12:00AM")}}" name="check_in_time" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__("Time for check out")}}</label>
                        <input type="text" value="{{$row->check_out_time}}" placeholder="{{__("Eg: 11:00AM")}}" name="check_out_time" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-title"><strong>{{__("Pricing")}}</strong></div>
        <div class="panel-body">
            @if(is_default_lang())
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">{{__("Price")}}</label>
                            <input type="number" step="any" min="0" name="price" class="form-control" value="{{$row->price}}" placeholder="{{__("Hotel Price")}}">
                        </div>
                    </div>
                    <div class="col-lg-6 d-none">
                        <div class="form-group">
                            <label class="control-label">{{__("Sale Price")}}</label>
                            <input type="number" step="any" name="sale_price" class="form-control" value="{{$row->sale_price}}" placeholder="{{__("Hotel Sale Price")}}">
                            <span><i>{{__("If the regular price is less than the discount , it will show the regular price")}}</i></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
