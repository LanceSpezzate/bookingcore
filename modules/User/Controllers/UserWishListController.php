<?php
namespace Modules\User\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\User\Models\UserWishList;
use Illuminate\Http\Request;

class UserWishListController extends FrontendController
{
    protected $userWishListClass;
    public function __construct()
    {
        parent::__construct();
        $this->userWishListClass = UserWishList::class;
    }

    public function index(Request $request){
        $wishlist = $this->userWishListClass::query()
            ->where("user_wishlist.user_id",Auth::id())
            ->orderBy('user_wishlist.id', 'desc');
        $data = [
            'rows' => $wishlist->paginate(5),
            'breadcrumbs'        => [
                [
                    'name'  => __('Wishlist'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Wishlist"),
        ];
        return view('User::frontend.wishList.index', $data);
    }
    public function handleWishList(Request $request){
        $meta = $this->userWishListClass::where("object_id",$request->input('object_id'))
            ->where("object_model",$request->input('object_model'))
            ->where("user_id",Auth::id())
            ->first();
        if(!empty($meta)){
            $meta->delete();
            $this->sendSuccess(['class'=>""]);
        }
        $meta = new $this->userWishListClass($request->input());
        $meta->user_id = Auth::id();
        $meta->save();
        $this->sendSuccess(['class'=>"active"]);
    }
    public function remove(Request $request){
        $meta = $this->userWishListClass::where("object_id",$request->input('id'))
            ->where("object_model",$request->input('type'))
            ->where("user_id",Auth::id())
            ->first();
        if(!empty($meta)){
            $meta->delete();
            return redirect()->back()->with('success', __('Delete success!'));
        }
        return redirect()->back()->with('success', __('Delete fail!'));
    }
}