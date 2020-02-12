<?php
namespace Modules\User\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\User\Events\UserVerificationSubmit;
use Modules\User\Models\UserWishList;
use Illuminate\Http\Request;

class VerificationController extends FrontendController
{

    public function index(){

        $user = Auth::user();

        $data = [
            'fields'=>$user->verification_fields,
            'only_show_data'=>1,
            'breadcrumbs'        => [
                [
                    'name'  => __('Verification'),
                    'class' => 'active'
                ],
            ],
        ];

        return view('User::frontend.verification.index',$data);
    }
    public function update(){

        $user = Auth::user();

        $data = [
            'fields'=>$user->verification_fields,
            'breadcrumbs'        => [
                [
                    'name'  => __('Verification'),
                    'url'=>route('user.verification.index')
                ],
                [
                    'name'  => __('Update Verification Data'),
                    'class' => 'active'
                ],
            ],
        ];

        return view('User::frontend.verification.update',$data);
    }

    public function store(){

        /**
         * @var $user User
         */
        $user = Auth::user();
        $fields = $user->verification_fields;

        $rules = [];
        $messages = [];
        $input = \request()->input();
        foreach ($fields as $field) {
            if(!empty($field['required']))
            {
                $rules[$field['field_id']][] = 'required';
                $messages[$field['field_id'].'.required'] = __("The :name is required",['name'=>$field['name']]);
            }
            switch ($field['type'])
            {
                case "file":
                    if(!empty($input[$field['field_id']])){
                        $rules[$field['field_id'].'.path'][] = 'required';
                        $messages[$field['field_id'].'.path.required'] = __("The :name path is required",['name'=>$field['name']]);
                        $input[$field['field_id']] = json_decode($input[$field['field_id']],true);
                    }
                    break;
                case "multi_files":
                    if(!empty($input[$field['field_id']])){
                        $rules[$field['field_id'].'.*.path'][] = 'required';
                        $messages[$field['field_id'].'.*.path.required'] = __("The :name path is required",['name'=>$field['name']]);
                        foreach ($input[$field['field_id']] as $k=>$val){
                            $input[$field['field_id']][$k] = json_decode($val,true);
                        }
                    }
                    break;
            }
        }
        if(!empty($rules)){
            \Validator::make($input, $rules, $messages)->validate();
        }
        $checkAll = false;
        foreach ($fields as $field)
        {
            $check = false;
            $old = $user->getVerifyData($field['id']);

            switch ($field['type'])
            {
                case "multi_files":
                    if($old != json_encode(\request()->input($field['field_id']))){
                        $check = true;
                    }
                    break;
                case "file":
                default:
                    if($old != \request()->input($field['field_id'])){
                        $check = true;
                    };
                break;
            }
            if($check){
                $user->addMeta($field['field_id'],\request()->input($field['field_id']));
                $user->addMeta('is_verified_'.$field['id'],0);
            }

            if($check) $checkAll = true;

        }

        if($checkAll){
            $user->verify_submit_status = 'new';
            $user->is_verified = 0;
            $user->save();
            event(new UserVerificationSubmit($user));
        }

        return redirect()->back()->with('success',__("Verification data saved. Please wait for admin approval"));

    }
}
