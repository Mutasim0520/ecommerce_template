<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product as Products;
use App\Users_wishlst as wishlist;
use App\User as User;
use Auth;
use App\Catagorie as Catagory;
use Storage;
use Hash;
use App\Subscriber as Subscriber;
use App\Admin as Admin;
use App\Notifications\CreateTicket;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addToWishlist(Request $request){
            $User = User::find(Auth::id());
            $Product = Products::find(decrypt($request->id));
            $WishList = new wishlist();
            $WishList->product_id =$Product->product_id;
            $WishList->user_id =$User->id;
            $WishList->save();
           return redirect()->back();
    }

    public function showWishList(){
        $id= Auth::id();
      //  $WishList = wishlist::with('user','product')->where(['user_id'=>$id])->get();
        $WishList = DB::table('products')
                ->join('users_wishlsts', 'users_wishlsts.product_id', '=', 'products.product_id')
                ->join('photos','photos.product_id','=','products.product_id')
                ->join('users', 'users.id', '=', 'users_wishlsts.user_id')
                ->where('users.id', '=', $id)
                ->get();
        $Catagory = Catagory::all();
        //return json_encode($WishList);
        return view('User.wishList',['Catagory'=>$Catagory ,'WishList'=>$WishList]);
    }

    public function removeWish(Request $request){
        if($request->ajax()){
            $Wish = wishlist::where(['user_id'=>decrypt($request->uid) , 'product_id'=>decrypt($request->pid)])->delete();
        }
    }

    public function subscriber (Request $request){
        $User = User::find(Auth::id());
        $User->subscriber = "subscriber";
        $User->save();
        $Subscriber = new Subscriber();
        $Subscriber->email = $request->email;
        $Subscriber->save();
        Session::flash('success_subscriber_message','You will be updated with the latest offers, products.');
        return redirect()->back();
    }

     public function showAccountSettingsPage(){
         $menu_data  = Catagory::with(['sub' => function($query){
             return $query->orderBy('name','ASC');
         },'sub.item' =>function($query){
             return $query->orderBy('name','ASC');
         }])->orderBy('catagory_name','ASC')->get();
        $Catagory = Catagory::all();
        $Districts = explode(',',Storage::disk('public')->get('districts.txt')) ;
        return view('User.accountSettings',['data'=>$menu_data,'User'=>Auth::user(),'Catagory'=>$Catagory , 'Districts'=>$Districts]) ;
    }

    public  function updatePersonalInfo(Request $request){
        $User = User::find(decrypt($request->id));
        $User->name = $request->name;
        $User->email = $request->email;
        $User->mobile = $request->mobile;
        $User->district = $request->district;
        $User->address = $request->address;
        $User->save();

        return redirect('/account/settings');
    }

    public function changePassword(Request $request){
        $User = User::find(decrypt($request->id));
        $User->password = bcrypt($request->password);
        $User->save();
        return redirect('/account/settings');
    }

}
