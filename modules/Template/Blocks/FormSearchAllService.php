<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class FormSearchAllService extends BaseBlock
{
    function __construct()
    {
        $list_service = [];
        foreach (get_bookable_services() as $key => $service) {
            $list_service[] = ['value'   => $key,
                               'name' => ucwords($key)
            ];
        }
        $this->setOptions([
            'settings' => [
                [
                    'id'            => 'service_types',
                    'type'          => 'checklist',
                    'listBox'          => 'true',
                    'label'         => "<strong>".__('Service Type')."</strong>",
                    'values'        => $list_service,
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title')
                ],
                [
                    'id'    => 'bg_image',
                    'type'  => 'uploader',
                    'label' => __('Background Image Uploader')
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Form Search All Service');
    }

    public function content($model = [])
    {
        $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full') ?? "";
        $model['list_location'] = $model['tour_location'] =  Location::where("status","publish")->limit(1000)->with(['translations'])->get()->toTree();
        return view('Template::frontend.blocks.form-search-all-service.index', $model);
    }
}