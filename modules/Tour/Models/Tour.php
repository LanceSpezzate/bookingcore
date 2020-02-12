<?php

    namespace Modules\Tour\Models;
    use App\Currency;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Modules\Booking\Models\Bookable;
    use Modules\Booking\Models\Booking;
    use Modules\Location\Models\Location;
    use Modules\Review\Models\Review;
    use Modules\Tour\Models\TourTerm;
    use Modules\Media\Helpers\FileHelper;
    use Illuminate\Support\Facades\Cache;
    use Validator;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Models\SEO;
    use Modules\User\Models\UserWishList;

    class Tour extends Bookable
    {
        use SoftDeletes;
        protected $table                              = 'bravo_tours';
        public    $checkout_booking_detail_file       = 'Tour::frontend/booking/detail';
        public    $checkout_booking_detail_modal_file = 'Tour::frontend/booking/detail-modal';
        public    $email_new_booking_file             = 'Tour::emails.new_booking_detail';
        public    $type                               = 'tour';
        protected $fillable                           = [
            //Tour info
            'title',
            'slug',
            'content',
            'image_id',
            'banner_image_id',
            'short_desc',
            'category_id',
            'location_id',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
            'is_featured',
            'gallery',
            'video',
            //Price
            'price',
            'sale_price',
            //Tour type
            'duration',
            'max_people',
            'min_people',
            //Extra Info
            'faqs',
            'status',
            'include',
            'exclude',
            'itinerary',
        ];
        protected $slugField                          = 'slug';
        protected $slugFromField                      = 'title';
        protected $seo_type                           = 'tour';
        /**
         * The attributes that should be casted to native types.
         *
         * @var array
         */
        protected $casts = [
            'faqs' => 'array',
            'include' => 'array',
            'exclude' => 'array',
            'itinerary' => 'array',
        ];

        public static function getModelName()
        {
            return __("Tour");
        }

        protected $bookingClass;
        protected $tourTermClass;
        protected $tourTranslationClass;
        protected $tourMetaClass;
        protected $tourDateClass;
        protected $userWishListClass;
        protected $reviewClass;

        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            $this->bookingClass = Booking::class;
            $this->tourTermClass = TourTerm::class;
            $this->tourTranslationClass = TourTranslation::class;
            $this->tourMetaClass = TourMeta::class;
            $this->tourDateClass = TourDate::class;
            $this->userWishListClass = UserWishList::class;
            $this->reviewClass = Review::class;
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function category_tour()
        {
            return $this->hasOne("Modules\Tour\Models\TourCategory", "id", 'category_id')->with(['translations']);
        }

        /**
         * Get SEO fop page list
         *
         * @return mixed
         */
        static public function getSeoMetaForPageList()
        {
            $meta['seo_title'] = __("Search for Tours");
            if (!empty($title = setting_item_with_lang("tour_page_list_seo_title", false))) {
                $meta['seo_title'] = $title;
            } else if (!empty($title = setting_item_with_lang("tour_page_search_title"))) {
                $meta['seo_title'] = $title;
            }
            $meta['seo_image'] = null;
            if (!empty($title = setting_item("tour_page_list_seo_image"))) {
                $meta['seo_image'] = $title;
            } else if (!empty($title = setting_item("tour_page_search_banner"))) {
                $meta['seo_image'] = $title;
            }
            $meta['seo_desc'] = setting_item_with_lang("tour_page_list_seo_desc");
            $meta['seo_share'] = setting_item_with_lang("tour_page_list_seo_share");
            $meta['full_url'] = url(config('tour.tour_route_prefix'));
            return $meta;
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function meta()
        {
            return $this->hasOne($this->tourMetaClass, "tour_id");
        }

        /**
         * Get Category
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function tour_term()
        {
            return $this->hasMany($this->tourTermClass, "tour_id");
        }

        public function getDetailUrl($include_param = true)
        {
            $param = [];
            if($include_param){
                if(!empty($date =  request()->input('date'))){
                    $dates = explode(" - ",$date);
                    if(!empty($dates)){
                        $param['start'] = $dates[0] ?? "";
                        $param['end'] = $dates[1] ?? "";
                    }
                }
            }
            $urlDetail = app_get_locale(false, false, '/') . config('tour.tour_route_prefix') . "/" . $this->slug;
            if(!empty($param)){
                $urlDetail .= "?".http_build_query($param);
            }
            return url($urlDetail);
        }

        public static function getLinkForPageSearch($locale = false, $param = [])
        {

            return url(app_get_locale(false, false, '/') . config('tour.tour_route_prefix') . "?" . http_build_query($param));
        }


        public function getGallery($featuredIncluded = false)
        {
            if (empty($this->gallery))
                return $this->gallery;
            $list_item = [];
            if ($featuredIncluded and $this->image_id) {
                $list_item[] = [
                    'large' => FileHelper::url($this->image_id, 'full'),
                    'thumb' => FileHelper::url($this->image_id, 'thumb')
                ];
            }
            $items = explode(",", $this->gallery);
            foreach ($items as $k => $item) {
                $large = FileHelper::url($item, 'full');
                $thumb = FileHelper::url($item, 'thumb');
                $list_item[] = [
                    'large' => $large,
                    'thumb' => $thumb
                ];
            }
            return $list_item;
        }

        public function getEditUrl()
        {
            return url('admin/module/tour/edit/' . $this->id);
        }

        public function getDiscountPercentAttribute()
        {
            if (!empty($this->price) and $this->price > 0
                and !empty($this->sale_price) and $this->sale_price > 0
                and $this->price > $this->sale_price
            ) {
                $percent = 100 - ceil($this->sale_price / ($this->price / 100));
                return $percent . "%";
            }
        }

        function getDatefomat($value)
        {
            return \Carbon\Carbon::parse($value)->format('j F, Y');
        }

        public function saveMeta(\Illuminate\Http\Request $request)
        {
            $meta = $this->tourMetaClass::where('tour_id', $this->id)->first();
            if (!$meta) {
                $meta = new $this->tourMetaClass();
                $meta->tour_id = $this->id;
            }
            $meta->fill($request->input());
            return $meta->save();
        }

        public function fill(array $attributes)
        {
            if (!empty($attributes)) {
                foreach ($this->fillable as $item) {
                    $attributes[$item] = $attributes[$item] ?? null;
                }
            }
            return parent::fill($attributes); // TODO: Change the autogenerated stub
        }

        public function isBookable()
        {
            if ($this->status != 'publish')
                return false;
            return parent::isBookable();
        }

        public function addToCart(Request $request)
        {
            $this->addToCartValidate($request);
            // Add Booking
            // get Price Availability Calendar
            $dataPriceAvailability = $this->getDataPriceAvailabilityInRanges($request->input('start_date'));
            $total = 0;
            $total_guests = 0;
            $discount = 0;
            $base_price = ($this->sale_price and $this->sale_price > 0 and  $this->sale_price < $this->price) ? $this->sale_price : $this->price;
            // for Availability Calendar
            $base_price = $dataPriceAvailability['base_price'] ?? $base_price;
            $extra_price = [];
            $extra_price_input = $request->input('extra_price');
            $person_types = [];
            $person_types_input = $request->input('person_types');
            $discount_by_people = [];
            $meta = $this->meta;
            if ($meta) {
                // for Availability Calendar
                $meta->person_types = $dataPriceAvailability['person_types'] ?? $meta->person_types;
                if ($meta->enable_person_types and !empty($meta->person_types)) {
                    if (!empty($meta->person_types)) {
                        foreach ($meta->person_types as $k => $type) {
                            if (isset($person_types_input[$k]) and $person_types_input[$k]['number']) {
                                $type['number'] = $person_types_input[$k]['number'];
                                $person_types[] = $type;
                                $total += $type['price'] * $type['number'];
                                $total_guests += $type['number'];
                            }
                        }
                    }
                } else {
                    $total += $base_price * $request->input('guests');
                    $total_guests += $request->input('guests');
                }
                if ($meta->enable_extra_price and !empty($meta->extra_price)) {
                    if (!empty($meta->extra_price)) {
                        foreach ($meta->extra_price as $k => $type) {
                            if (isset($extra_price_input[$k]) and $extra_price_input[$k]['enable'] and $extra_price_input[$k]['enable'] != 'false') {

                                $type_total = 0;

                                switch ($type['type']) {
                                    case "one_time":
                                        $type_total = $type['price'];
                                        break;
                                    case "per_hour":
                                        $type_total = $type['price'] * $this->duration;
                                        break;
                                    case "per_day":
                                        $type_total = $type['price'] * ceil($this->duration / 24);
                                        break;
                                }
                                if (!empty($type['per_person'])) {
                                    $type_total *= $total_guests;
                                }
                                $type['total'] = $type_total;
                                $total += $type_total;
                                $extra_price[] = $type;
                            }
                        }
                    }
                }
                if ($meta->discount_by_people and !empty($meta->discount_by_people)) {
                    foreach ($meta->discount_by_people as $type) {
                        if ($type['from'] <= $total_guests and (!$type['to'] or $type['to'] >= $total_guests)) {

                            $type_total = 0;

                            switch ($type['type']) {
                                case "fixed":
                                    $type_total = $type['amount'];
                                    break;
                                case "percent":
                                    $type_total = $total / 100 * $type['amount'];
                                    break;
                            }
                            $total -= $type_total;
                            $discount += $type_total;
                            $type['total'] = $type_total;
                            $discount_by_people[] = $type;
                        }
                    }
                }
            } else {
                // Default
                $total += $base_price * $request->input('guests');
                $total_guests += $request->input('guests');
            }
            $start_date = new \DateTime($request->input('start_date'));
            if (empty($start_date)) {
                $this->sendError(__("Start date is not a valid date"));
            }

	        if(!$this->checkBusyDate($start_date)){
		        $this->sendError(__("Start date is not a valid date"));
	        }

            //Buyer Fees
            $total_before_fees = $total;
            $list_fees = setting_item('tour_booking_buyer_fees');
            if (!empty($list_fees)) {
                $lists = json_decode($list_fees, true);
                foreach ($lists as $item) {
                    if (!empty($item['per_person']) and $item['per_person'] == "on") {
                        $total += $item['price'] * $total_guests;
                    } else {
                        $total += $item['price'];
                    }
                }
            }

            $booking = new $this->bookingClass();
            $booking->status = 'draft';
            $booking->object_id = $request->input('service_id');
            $booking->object_model = $request->input('service_type');
            $booking->vendor_id = $this->create_user;
            $booking->customer_id = Auth::id();
            $booking->total = $total;
            $booking->total_guests = $total_guests;
            $booking->start_date = $start_date->format('Y-m-d H:i:s');
            $start_date->modify('+ ' . max(1, $this->duration) . ' hours');
            $booking->end_date = $start_date->format('Y-m-d H:i:s');
            $booking->buyer_fees = $list_fees ?? '';
            $booking->total_before_fees = $total_before_fees;

            $booking->calculateCommission();

            $check = $booking->save();
            if ($check) {

                $this->bookingClass::clearDraftBookings();

                $booking->addMeta('duration', $this->duration);
                $booking->addMeta('base_price', $base_price);
                $booking->addMeta('guests', max($total_guests, $request->input('guests')));
                $booking->addMeta('extra_price', $extra_price);
                $booking->addMeta('person_types', $person_types);
                $booking->addMeta('discount_by_people', $discount_by_people);
                $this->sendSuccess([
                    'url' => $booking->getCheckoutUrl()
                ]);
            }
            $this->sendError(__("Can not check availability"));
        }

        public function getDataPriceAvailabilityInRanges($start_date){
            $datesRaw = $this->tourDateClass::getDatesInRanges($start_date,$this->id);
            $dates = [
                'base_price' => null,
                'person_types' => null,
            ];
            if(!empty($datesRaw))
            {
                $dates =  [
                   'base_price' => $datesRaw->price,
                   'person_types' => is_array($datesRaw->person_types) ? $datesRaw->person_types : false,
               ];
            }
            return $dates;
        }

        public function beforeCheckout(Request $request, $booking)
        {
            $maxGuests = $this->getNumberAvailableBooking($booking->start_date);
            if ($booking->total_guests > $maxGuests) {
                $this->sendError(__("There are " . $maxGuests . " guests available for your selected date"));
            }
        }

        public function getNumberAvailableBooking($start_date)
        {
            $tourDate = $this->tourDateClass::where('target_id', $this->id)->where('start_date', $start_date)->where('active', 1)->first();
            $totalGuests = $this->bookingClass::where('object_id', $this->id)->where('start_date', $start_date)->whereNotIn('status', $this->bookingClass::$notAcceptedStatus)->sum('total_guests');
            $maxGuests = !empty($tourDate->max_guests) ? $tourDate->max_guests : $this->max_people;
            $number = $maxGuests - $totalGuests;
            return $number > 0 ? $number : 0;
        }

        public function addToCartValidate(Request $request)
        {
            $meta = $this->meta;
            $rules = [
                'guests'     => 'required|integer|min:1',
                'start_date' => 'required|date_format:Y-m-d'
            ];
            $start_date = $request->input('start_date');
            if ($meta) {

                // Percent Types
                if ($meta->enable_person_types) {
                    unset($rules['guests']);
                    $rules['person_types'] = 'required';
                    $person_types_configs = $meta->person_types;
                    if (!empty($person_types_configs) and is_array($person_types_configs)) {
                        foreach ($person_types_configs as $k => $person_type) {
                            $ruleStr = 'integer';
                            if ($person_type['min']) {
                                $ruleStr .= '|min:' . $person_type['min'];
                            }
                            if ($person_type['max']) {
                                $ruleStr .= '|max:' . $person_type['max'];
                            }
                            if ($ruleStr) {
                                $rules['person_types.' . $k . '.number'] = $ruleStr;
                            }
                        }
                    }
                }
            }

            // Validation
            if (!empty($rules)) {
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $this->sendError('', ['errors' => $validator->errors()]);
                }
            }
            if ($meta) {
                // Open Hours
                if ($meta->enable_open_hours) {

                    $open_hours = $meta->open_hours;
                    $nDate = date('N', strtotime($start_date));
                    if (!isset($open_hours[$nDate]) or empty($open_hours[$nDate]['enable'])) {
                        $this->sendError(__("This tour is not open on your selected day"));
                    }
                }
            }

            if (!empty($request->person_types)) {
                $totalGuests = array_sum(array_pluck($request->person_types, 'number')) ?? 0;
            } else {
                $totalGuests = $request->guests;
            }

            $numberGuestsCanBook = $this->getNumberAvailableBooking($start_date);

            if ($totalGuests > $numberGuestsCanBook) {
                $this->sendError(__("There are " . $numberGuestsCanBook . " guests available for your selected date"));
            }
            return true;
        }

        public function getBookingData()
        {
            $booking_data = [
                'id'              => $this->id,
                'person_types'    => [],
                'max'             => 0,
                'open_hours'      => [],
                'extra_price'     => [],
                'minDate'         => date('m/d/Y'),
                'duration'        => $this->duration,
                'buyer_fees'      => [],
                'start_date'      => request()->input('start') ?? "",
                'start_date_html' => request()->input('start') ? display_date(request()->input('start')) : "",
                'end_date'        => request()->input('end') ?? "",
                'end_date_html'   => request()->input('end') ? display_date(request()->input('end')) : "",
            ];
            $meta = $this->meta ?? false;
            $lang = app()->getLocale();
            if ($meta) {
                if ($meta->enable_person_types) {
                    $booking_data['person_types'] = $meta->person_types;
                    if(!empty($booking_data['person_types'])) {
                        foreach ($booking_data['person_types'] as $k => &$type) {
                            if (!empty($lang) and !empty($type['name_' . $lang])) {
                                $type['name'] = $type['name_' . $lang];
                                $type['desc'] = $type['desc_' . $lang];
                            }
                            $type['min'] = (int)$type['min'];
                            $type['max'] = (int)$type['max'];
                            $type['number'] = $type['min'];
                            $type['display_price'] = format_money($type['price']);
                        }

                        $booking_data['person_types'] = array_values((array)$booking_data['person_types']);
                    }else{
                        $booking_data['person_types'] = [];
                    }
                }
                if ($meta->enable_extra_price) {
                    $booking_data['extra_price'] = $meta->extra_price;
                    if (!empty($booking_data['extra_price'])) {
                        foreach ($booking_data['extra_price'] as $k => &$type) {
                            if (!empty($lang) and !empty($type['name_' . $lang])) {
                                $type['name'] = $type['name_' . $lang];
                            }
                            $type['number'] = 0;
                            $type['enable'] = 0;
                            $type['price_html'] = format_money($type['price']);
                            $type['price_type'] = '';
                            switch ($type['type']) {
                                case "per_day":
                                    $type['price_type'] .= '/' . __('day');
                                    break;
                                case "per_hour":
                                    $type['price_type'] .= '/' . __('hour');
                                    break;
                            }
                            if (!empty($type['per_person'])) {
                                $type['price_type'] .= '/' . __('guest');
                            }
                        }
                    }

                    $booking_data['extra_price'] = array_values((array)$booking_data['extra_price']);
                }
                if ($meta->enable_open_hours) {
                    $booking_data['open_hours'] = $meta->open_hours;
                }
            }

            $list_fees = setting_item_array('tour_booking_buyer_fees');
            if(!empty($list_fees)){
                foreach ($list_fees as $item){
                    $item['type_name'] = $item['name_'.app()->getLocale()] ?? $item['name'] ?? '';
                    $item['type_desc'] = $item['desc_'.app()->getLocale()] ?? $item['desc'] ?? '';
                    $item['price_type'] = '';
                    if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                        $item['price_type'] .= '/' . __('guest');
                    }
                    $booking_data['buyer_fees'][] = $item;
                }
            }
            return $booking_data;
        }

        public static function searchForMenu($q = false)
        {
            $query = static::select('id', 'title as name');
            if (strlen($q)) {

                $query->where('title', 'like', "%" . $q . "%");
            }
            $a = $query->limit(10)->get();
            return $a;
        }

        public static function getMinMaxPrice()
        {
            $model = parent::selectRaw('MIN( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS min_price ,
                                    MAX( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS max_price ')->where("status", "publish")->first();
            if (empty($model->min_price) and empty($model->max_price)) {
                return [
                    0,
                    100
                ];
            }
            return [
                $model->min_price,
                $model->max_price
            ];
        }

        public function getReviewEnable()
        {
            return setting_item("tour_enable_review", 0);
        }

        public function getReviewApproved()
        {
            return setting_item("tour_review_approved", 0);
        }

        public function check_enable_review_after_booking()
        {
            $option = setting_item("tour_enable_review_after_booking", 0);
            if ($option) {
                $number_review = $this->reviewClass::countReviewByServiceID($this->id, Auth::id(),false,$this->type) ?? 0;
                $number_booking = $this->bookingClass::countBookingByServiceID($this->id, Auth::id()) ?? 0;
                if ($number_review >= $number_booking) {
                    return false;
                }
            }
            return true;
        }
        public function check_allow_review_after_making_completed_booking()
        {
            $options = setting_item("tour_allow_review_after_making_completed_booking", false);
            if (!empty($options)) {
                $status = json_decode($options);
                $booking = $this->bookingClass::select("status")
                    ->where("object_id", $this->id)
                    ->where("object_model", $this->type)
                    ->where("customer_id", Auth::id())
                    ->orderBy("id","desc")
                    ->first();
                $booking_status = $booking->status ?? false;
                if(!in_array($booking_status , $status)){
                    return false;
                }
            }
            return true;
        }

        public static function getReviewStats()
        {
            $reviewStats = [];
            if (!empty($list = setting_item("tour_review_stats", []))) {
                $list = json_decode($list, true);
                foreach ($list as $item) {
                    $reviewStats[] = $item['title'];
                }
            }
            return $reviewStats;
        }

        public function getReviewDataAttribute()
        {
            $list_score = [
                'score_total'  => 0,
                'score_text'   => __("Not Rated"),
                'total_review' => 0,
                'rate_score'   => [],
            ];
            $dataTotalReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $this->id)->where('object_model', "tour")->where("status", "approved")->first();
            if (!empty($dataTotalReview->score_total)) {
                $list_score['score_total'] = number_format($dataTotalReview->score_total, 1);
                $list_score['score_text'] = $this->reviewClass::getDisplayTextScoreByLever(round($list_score['score_total']));
            }
            if (!empty($dataTotalReview->total_review)) {
                $list_score['total_review'] = $dataTotalReview->total_review;
            }
            $list_data_rate = $this->reviewClass::selectRaw('COUNT( CASE WHEN rate_number = 5 THEN rate_number ELSE NULL END ) AS rate_5,
                                                            COUNT( CASE WHEN rate_number = 4 THEN rate_number ELSE NULL END ) AS rate_4,
                                                            COUNT( CASE WHEN rate_number = 3 THEN rate_number ELSE NULL END ) AS rate_3,
                                                            COUNT( CASE WHEN rate_number = 2 THEN rate_number ELSE NULL END ) AS rate_2,
                                                            COUNT( CASE WHEN rate_number = 1 THEN rate_number ELSE NULL END ) AS rate_1 ')->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first()->toArray();
            for ($rate = 5; $rate >= 1; $rate--) {
                if (!empty($number = $list_data_rate['rate_' . $rate])) {
                    $percent = ($number / $list_score['total_review']) * 100;
                } else {
                    $percent = 0;
                }
                $list_score['rate_score'][$rate] = [
                    'title'   => $this->reviewClass::getDisplayTextScoreByLever($rate),
                    'total'   => $number,
                    'percent' => round($percent),
                ];
            }
            return $list_score;
        }

        /**
         * Get Score Review
         *
         * Using for loop tour
         */
        public function getScoreReview()
        {
            $tour_id = $this->id;
            $list_score = Cache::rememberForever('review_' . $this->type . '_' . $tour_id, function () use ($tour_id) {
                $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $tour_id)->where('object_model', "tour")->where("status", "approved")->first();
                return [
                    'score_total'  => !empty($dataReview->score_total) ? number_format($dataReview->score_total, 1) : 0,
                    'total_review' => !empty($dataReview->total_review) ? $dataReview->total_review : 0,
                ];
            });
            return $list_score;
        }

        public function getNumberReviewsInService($status = false)
        {
            return $this->reviewClass::countReviewByServiceID($this->id, false, $status, $this->type) ?? 0;
        }

        public function getNumberServiceInLocation($location)
        {
            $number = 0;
            if (!empty($location)) {
                $number = parent::join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_tours.location_id')->where('bravo_locations._lft', '>=', $location->_lft)->where('bravo_locations._rgt', '<=', $location->_rgt);
                })->where("bravo_tours.status", "publish")->with(['translations'])->count("bravo_tours.id");
            }

            if(empty($number)) return false;
            if ($number > 1) {
                return __(":number Tours", ['number' => $number]);
            }
            return __(":number Tour", ['number' => $number]);
        }

        /**
         * @param $from
         * @param $to
         * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         */
        public function getBookingsInRange($from, $to)
        {

            $query = $this->bookingClass::query();
            $query->whereNotIn('status', ['draft']);
            $query->where('start_date', '<=', $to)->where('end_date', '>=', $from)->take(50);

            $query->where('object_id', $this->id);
            $query->where('object_model', 'tour');

            return $query->orderBy('id', 'asc')->get();

        }

        public function saveCloneByID($clone_id)
        {
            $old = parent::find($clone_id);
            if (empty($old)) return false;
            $selected_terms = $old->tour_term->pluck('term_id');
            $old->title = $old->title . " - Copy";
            $new = $old->replicate();
            $new->save();
            //Terms
            foreach ($selected_terms as $term_id) {
                $this->tourTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'tour_id' => $new->id
                ]);
            }
            //Language
            $langs = $this->tourTranslationClass::where("origin_id", $old->id)->get();
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    $langNew = $lang->replicate();
                    $langNew->origin_id = $new->id;
                    $langNew->save();
                    $langSeo = SEO::where('object_id', $lang->id)->where('object_model', $lang->getSeoType() . "_" . $lang->locale)->first();
                    if (!empty($langSeo)) {
                        $langSeoNew = $langSeo->replicate();
                        $langSeoNew->object_id = $langNew->id;
                        $langSeoNew->save();
                    }
                }
            }
            //SEO
            $metaSeo = SEO::where('object_id', $old->id)->where('object_model', $this->seo_type)->first();
            if (!empty($metaSeo)) {
                $metaSeoNew = $metaSeo->replicate();
                $metaSeoNew->object_id = $new->id;
                $metaSeoNew->save();
            }
            //Meta
            $metaTour = $this->tourMetaClass::where('tour_id', $old->id)->first();
            if (!empty($metaTour)) {
                $metaTourNew = $metaTour->replicate();
                $metaTourNew->tour_id = $new->id;
                $metaTourNew->save();
            }
        }

        public function hasWishList()
        {
            return $this->hasOne($this->userWishListClass, 'object_id', 'id')->where('object_model', $this->type)->where('user_id', Auth::id() ?? 0);
        }

        public function isWishList()
        {
            if (Auth::id()) {
                if (!empty($this->hasWishList) and !empty($this->hasWishList->id)) {
                    return 'active';
                }
            }
            return '';
        }
        public static  function getServiceIconFeatured(){
            return "icofont-island-alt";
        }
        public static function isEnable(){
            return setting_item('tour_disable') == false;
        }

    }