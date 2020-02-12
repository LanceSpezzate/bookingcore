<?php
namespace Modules\Vendor\Blocks;

use Modules\Template\Blocks\BaseBlock;

class VendorRegisterForm extends BaseBlock
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
                    'id'        => 'youtube',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Youtube link')
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
        return __('Vendor Register Form');
    }

    public function content($model = [])
    {
        return view('Vendor::frontend.blocks.form-register.index', $model);
    }
}
