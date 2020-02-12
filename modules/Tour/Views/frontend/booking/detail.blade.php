@php $lang_local = app()->getLocale() @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    @php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    @endphp
                    <h3 class="service-name"><a href="{{$service->getDetailUrl()}}">{{$service_translation->title}}</a></h3>
                    @if($service_translation->address)
                        <p class="address"><i class="fa fa-map-marker"></i>
                            {{$service_translation->address}}
                        </p>
                    @endif
                </div>
                {{--<div>
                    @if($image_url = $service->getImageUrl())
                        <img src="{{$image_url}}" alt="{{$service->title}}">
                    @endif
                </div>--}}
            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{__('Start date:')}}</div>
                        <div class="val">
                            {{display_date($booking->start_date)}}
                        </div>
                    </li>
                    <li>
                        <div class="label">{{__('Duration:')}}</div>
                        <div class="val">
                            {{human_time_diff($booking->end_date,$booking->start_date)}}
                        </div>
                    </li>
                @endif
                @php $person_types = $booking->getJsonMeta('person_types')@endphp
                @if(!empty($person_types))
                    @foreach($person_types as $type)
                        <li>
                            <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}:</div>
                            <div class="val">
                                {{$type['number']}}
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="label">{{__("Guests")}}:</div>
                        <div class="val">
                            {{$booking->total_guests}}
                        </div>
                    </li>
                @endif

            </ul>
        </div>
        {{--@include('Booking::frontend/booking/checkout-coupon')--}}
        @do_action('booking.checkout.before_total_review')
        <div class="review-section total-review">
            <ul class="review-list">
                @php $person_types = $booking->getJsonMeta('person_types') @endphp
                @if(!empty($person_types))
                    @foreach($person_types as $type)
                        <li>
                            <div class="label">{{ $type['name_'.$lang_local] ?? $type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                            <div class="val">
                                {{format_money($type['price'] * $type['number'])}}
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="label">{{__("Guests")}}: {{$booking->total_guests}} * {{format_money($booking->getMeta('base_price'))}}</div>
                        <div class="val">
                            {{format_money($booking->getMeta('base_price') * $booking->total_guests)}}
                        </div>
                    </li>
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div class="label-title"><strong>{{__("Extra Prices:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}:</div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @php $discount_by_people = $booking->getJsonMeta('discount_by_people')@endphp
                @if(!empty($discount_by_people))
                    <li>
                        <div class="label-title"><strong>{{__("Discounts:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($discount_by_people as $type)
                                <li>
                                    <div class="label">
                                        @if(!$type['to'])
                                            {{__('from :from guests',['from'=>$type['from']])}}
                                        @else
                                            {{__(':from - :to guests',['from'=>$type['from'],'to'=>$type['to']])}}
                                        @endif
                                        :
                                    </div>
                                    <div class="val">
                                        - {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if(!empty($booking->buyer_fees))
                    <?php
                    $buyer_fees = json_decode($booking->buyer_fees , true);
                    foreach ($buyer_fees as $buyer_fee){
                    ?>
                    <li>
                        <div class="label">
                            {{$buyer_fee['name_'.$lang_local] ?? $buyer_fee['name']}}
                            <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $buyer_fee['desc_'.$lang_local] ?? $buyer_fee['desc'] }}"></i>
                            @if(!empty($buyer_fee['per_person']) and $buyer_fee['per_person'] == "on")
                                : {{$booking->total_guests}} * {{format_money( $buyer_fee['price'] )}}
                            @endif
                        </div>
                        <div class="val">
                            @if(!empty($buyer_fee['per_person']) and $buyer_fee['per_person'] == "on")
                                {{ format_money( $buyer_fee['price'] * $booking->total_guests ) }}
                            @else
                                {{ format_money($buyer_fee['price']) }}
                            @endif
                        </div>
                    </li>
                    <?php } ?>
                @endif
                <li class="final-total">
                    <div class="label">{{__("Total:")}}</div>
                    <div class="val">{{format_money($booking->total)}}</div>
                </li>
            </ul>
        </div>
    </div>
</div>
