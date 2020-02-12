<?php
namespace Modules\Car\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Core\Models\Terms;

class CarTermFeaturedBox extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id'           => 'term_car',
                    'type'         => 'select2',
                    'label'        => __('Select term car'),
                    'select2'      => [
                        'ajax'     => [
                            'url'      => route('car.admin.attribute.term.getForSelect2', ['type' => 'car']),
                            'dataType' => 'json'
                        ],
                        'width'    => '100%',
                        'multiple' => "true",
                    ],
                    'pre_selected' => route('car.admin.attribute.term.getForSelect2', [
                        'type'         => 'space',
                        'pre_selected' => 1
                    ])
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Car: Term Featured Box');
    }

    public function content($model = [])
    {
        if (empty($term_space = $model['term_car'])) {
            return "";
        }
        $list_term = Terms::whereIn('id',$term_space)->get();
        $model['list_term'] = $list_term;
        return view('Car::frontend.blocks.term-featured-box.index', $model);
    }
}