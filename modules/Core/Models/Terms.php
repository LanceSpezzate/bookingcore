<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Terms extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bravo_terms';
    protected $fillable = [
        'name',
        'content',
        'image_id',
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    /**
     * @param $term_IDs array or number
     * @return mixed
     */
    static public function getTermsById($term_IDs){
        $listTerms = [];
        if(empty($term_IDs)) return $listTerms;
        $terms = parent::query()->with(['translations','attribute'])->find($term_IDs);
        if(!empty($terms)){
            foreach ($terms as $term){
                if(!empty($attr = $term->attribute)){
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['parent'] = $attr;
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['child'] = [];
                    $listTerms[$term->attr_id]['child'][] = $term;
                }
            }
        }
        return $listTerms;
    }

    public function attribute()
    {
        return $this->hasOne("Modules\Core\Models\Attributes", "id" , "attr_id");
    }


    public static function getForSelect2Query($service,$q=false)
    {
        $query =  static::query()->select('bravo_terms.id', DB::raw('CONCAT(at.name,": ",bravo_terms.name) as text'))
        ->join('bravo_attrs as at','at.id','=','bravo_terms.attr_id')
        // ->where("bravo_terms.status","publish")
        // ->where("at.status","publish")
        ->where("at.service",$service)
        ->whereRaw("at.deleted_at is null");

        if ($query) {
            $query->where('bravo_terms.name', 'like', '%' . $q . '%');
        }
        return $query;
    }

}
