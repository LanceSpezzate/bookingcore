<?php

    namespace Modules\Location\Models;

    use App\BaseModel;
    use Kalnoy\Nestedset\NodeTrait;
    use Modules\Booking\Models\Bookable;
    use Modules\Media\Helpers\FileHelper;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Models\SEO;

    class Location extends Bookable
    {
        use SoftDeletes;
        use NodeTrait;
        protected $table         = 'bravo_locations';
        protected $fillable      = [
            'name',
            'slug',
            'content',
            'image_id',
            'map_lat',
            'map_lng',
            'map_zoom',
            'status',
            'parent_id',
            'banner_image_id',
            'trip_ideas',
        ];
        protected $slugField     = 'slug';
        protected $slugFromField = 'name';
        protected $seo_type      = 'location';
        protected $casts         = [
            'trip_ideas' => 'array'
        ];

        public static function getModelName()
        {
            return __("Location");
        }

        public static function searchForMenu($q = false)
        {
            $query = static::select('id', 'name');
            if (strlen($q)) {

                $query->where('name', 'like', "%" . $q . "%");
            }
            $a = $query->limit(10)->get();
            return $a;
        }

        public function getImageUrl($size = "medium")
        {
            $url = FileHelper::url($this->image_id, $size);
            return $url ? $url : '';
        }

        public function getDisplayNumberServiceInLocation($service_type)
        {
            $allServices = get_bookable_services();
            if(empty($allServices[$service_type])) return false;
            $module = new $allServices[$service_type];
            return $module->getNumberServiceInLocation($this);
        }


        public function getDetailUrl($locale = false)
        {
            return url(app_get_locale(false, false, '/') . config('location.location_route_prefix') . "/" . $this->slug);
        }

        public function getLinkForPageSearch($service_type)
        {
            $allServices = get_bookable_services();
            $module = new $allServices[$service_type];
            return $module->getLinkForPageSearch(false, ['location_id' => $this->id]);
        }
    }
