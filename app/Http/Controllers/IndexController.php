<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product as Products;
use App\Slide as Slide;
use App\Catagorie as Catagory;
use Storage;
use App\Subscriber as Subscriber;
use App\Catagories_item as Item;
use App\Simple_index as Simple_index;
use App\Sub_catagorie as Sub_catagory;
use App\Request as Links;
use Session;
use App\Browsed_product as Browse_product;
use Auth;
use App\User as User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PassowrdResetLinkSentMail;
use App\Mail\NewRequestMail;
use App\Admin as Admin;
use App\Mail\NewRequestMailToUser;
use App\Tag as Tags;


class IndexController extends Controller
{
    public function showIndex(){
        $Simple_index = Simple_index::with('simple_belongs')->get();
        $Slide = Slide::all();
        $category  = Catagory::with(['sub' => function($query){
            return $query->orderBy('name','ASC');
        },'sub.item' =>function($query){
            return $query->orderBy('name','ASC');
        },'product'=> function ($query){
            return $query->orderBy('product_id','DESC');
        },'product.Photo'])->orderBy('catagory_name','ASC')->get();
        return view('User.homepage' , ['Slide'=>$Slide , 'data' =>$category]);
    }

    public function showContact(){
        $index_array = ['company_name','company_contact','company_address','company_email','company_about','company_logo'];
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        $obj = new \stdClass();
        foreach ($info as $item) {
            foreach ($index_array as $index) {
                if(preg_match("/$index/",$item)){
                    $replace = $index."=";
                    $str = trim(preg_replace("/$replace/",'',$item));
                    $obj->$index = $str;
                    break;
                }
            }
        }
        return view('User.contact',['info' =>($obj)]);
    }

    public function QuantityContainer($id){
        $Size = Products::find(decrypt($id));
        $Size->Size;
        $Quantity_array = array();
        foreach ($Size->Size as $item){
            $Quantity_array[] = array("size"=>$item->size,"quantity"=>$item->quantity);
        }
        return $Quantity_array;
    }

    public function showProductDetail(Request $request){
        if(Auth::user()){
            $history = Browse_product::where(['user_id'=>Auth::user()->id, 'product_id'=>decrypt($request->id)])->get();
            if(sizeof($history)==0){
                $history = new Browse_product();
                $history->user_id = Auth::user()->id;
                $history->product_id = decrypt($request->id);
                $history->save();
            }
        }
        $Product = Products::find(decrypt($request->id));
        $Color = Products::find(decrypt($request->id));
        $Color->Color;
        $Size = Products::find(decrypt($request->id));
        $Size->Size;
        $Photo = Products::find(decrypt($request->id));
        $Photo->Photo;
        $quantity_array = $this->QuantityContainer($request->id);
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        return view('User.productDetail' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Color' => $Color , 'Size' => $Size , 'Photo' => $Photo, 'Quantity_array'=>$quantity_array]);
    }

    public function showCart(){
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        $Catagory = Catagory::all();
        return view('User.cart',['Catagory'=>$Catagory,'shipping_cost' =>$shipping_cost]);
    }

    public function itemWiseProduct(Request $request){
        $category  = Item::where(['name' =>$request->category])->first();
        $Product = Products::with('Photo')->where(['catagories_item_id' => $category->id],['quantity','>',0])->paginate(24);
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        return view('User.itemProducts' , ['Product' => $Product , 'Category'=>$category,'shipping_cost' =>$shipping_cost]);
    }

    public function subscriber (Request $request){
        $Subscriber = Subscriber::where(['email' => $request->email])->get();
        if(sizeof($Subscriber)>0){
            Session::flash('subscriber_exist','You are already a subscriber');
            return redirect()->back();
        }
        else{
            $Subscriber = new Subscriber();
            $Subscriber->email = $request->email;
            $Subscriber->save();
            Session::flash('unauth_success_subscriber','You will be updated with the latest offers, products.');
            return redirect()->back();
        }
    }

    public function itemFinder(Request $request){
        $Product = Products::with('photo','color','size')->where('title', 'like', '%' . $request->search . '%')->paginate(20);
        $Catagory = Catagory::all();
        return view('User.searchProducts' , ['Catagory'=>$Catagory,'Product' => $Product]);

    }

    public function SubCatagoryWiseProduct(Request $request){
        $sub_category = Sub_catagory::find($request->sub_catagory);
        $Product = Products::with('Photo')->where(['sub_catagorie_id' => $sub_category->id],['quantity','>',0])->paginate(40);
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        return view('User.subCatagoryProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Category'=>$sub_category ]);
    }

    public function showCategoryWiseProduct(Request $request){
        $category = Catagory::find($request->id);
        $Product = Products::with('Photo')->where(['catagorie_id' => $category->id],['quantity','>',0])->paginate(40);
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        return view('User.catagoryProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Category'=>$category ]);
    }

    public function storeLink(Request $request){
        $link = new Links();
        $link->url = $request->url;
        $link->quantity = $request->quantity;
        $link->size = $request->size;
        $link->email = $request->email;
        $link->phone = $request->phone;
        $link->name = $request->name;
        $link->color = $request->color;
        $link->user_name = $request->name;
        $link->user_id = Auth::user()->id;
        $link->save();
        $latest_request = Links::orderBy('id','desc')->first();
        $Admins = Admin::all();
        foreach ($Admins as $item){
           Mail::to($item)->send(new NewRequestMail($latest_request));
        }
        Mail::to(Auth::user())->send(new NewRequestMailToUser($latest_request,Auth::user()));
        Session::flash('success_link_share','We have received your request. We will contact with you soon;');
        return redirect()->back();
    }

     public function search(Request $request){
         $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
         foreach ($info as $item){
             if(preg_match('/shipping_cost/',$item)){
                 $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
             }
         }
        $Product = Products::with('Photo')->Where('title', 'like', '%' . $request->search_item . '%')->get();
        if(sizeof($Product) == 0){
            $array = explode(" ",$request->search_item);
            $new_array = array();
            foreach ($array as $item){
                $array = Tags::with('Product','Product.photo')->where('name', 'like', '%' . ($item) . '%')->get();
                foreach ($array as $value) {
                    foreach ($value->product as $product) {
                        $flag = true;
                        foreach ($new_array as $old_product) {
                            if ($old_product->product_id == $product->product_id) {
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            array_push($new_array, $product);
                        }
                    }
                }
            }
            return view('User.searchProductsTag' , ['Shipping_cost'=>$shipping_cost,'Product' =>$new_array ,'search_text' =>$request->search_item]);

        }
        else{
            return view('User.searchProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product,'search_text' =>$request->search_item]);
        }

    }

    public function activateUser(Request $request){
        $user = User::find($request->id);
        $user->status = "active";
        $user->save();

        if(Auth::loginUsingId($user->id)){
            return redirect()->intended('/');
        }
    }

    public function sendPasswordChangeLink(Request $request){
        $user = User::where(['email' =>$request->email])->get();
        if(sizeof($user)>0){
            Mail::to($user)->send(new PassowrdResetLinkSentMail($user));

            Session::flash('correct_email_reset','We have sent you password reset mail to you.');
            return redirect()->back();
        }
        else{
            Session::flash('false_email_reset','Sorry wrong email provided. Try again');
            return redirect()->back();
        }
    }

    public function showPasswordReset(Request $request){
        $user = User::find(($request->id));
        return view('User.resetPassword',['user'=>$user]);
    }

    public function changePassword(Request $request){
        $user = User::find(decrypt($request->id));
        $user->password = bcrypt(trim($request->password));
        $user->save();
        Session::flash('success_password_reset','Your password has been changed successfully.');
        return redirect('/login');
    }
}
