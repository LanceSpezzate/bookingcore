<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;

class VideoPlayer extends BaseBlock
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
        return __('Video Player');
    }

    public function content($model = [])
    {
        $model['id'] = time();
        return view('Template::frontend.blocks.video-player', $model);
    }
}