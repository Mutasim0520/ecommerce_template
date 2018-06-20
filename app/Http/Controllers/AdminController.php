<?php

namespace App\Http\Controllers;

use App\Catagorie;
use App\Mail\PriceSetRequestMail;
use App\Sub_catagorie;
use Illuminate\Http\Request;
use App\Order as Order;
use App\Admin as Admin;
use App\Orders_discussion as discussion;
use Auth;

use App\User as User;
use App\Points_management as Point;
use App\Catagorie as catagory;
use App\Slide as Slide;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribersMail;
use App\Size_management as Size_manager;
use Storage;
use App\Orders_product as OrderedProduct;
use App\Ticket as Ticket;
use Hash;
use DB;
use App\Subscriber as Subscribers;
use App\Notifications\AssignEmployeeToTicket;
use App\Sub_catagorie as Sub_catagory;
use App\Catagories_item as Item;
use App\Gbp as GBP;
use App\Simple_index as Simple_index;
use App\Simpe_index_belong as Simple_index_belongs;
use App\Cost_estimation as Estimation;
use App\Request as links;
use File;
use App\Delivery_cost as Delivery_cost;
use App\Notifications\NotifyUserRequestedPriceSet;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function stringTinker($main_string,$position,$replacement){
        $string_to_be_replaced = substr($main_string,$position);
        $new_string = trim(preg_replace("/$string_to_be_replaced/",$replacement,$main_string));
        return $new_string;
    }

    public function editCompanyProfile(Request $request){
        $index_array = ['company_name','company_contact','company_address','company_email','company_about','shipping_cost'];
        if($request->hasFile('company_logo')){
            $file = $request->company_logo;
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path('/images/logo'), $fileName);

            $file = Storage::disk('public')->get('company.txt');
            $info = explode(PHP_EOL, Storage::disk('public')->get('company.txt'));
            foreach ($info as $item) {
                if (preg_match("/company_logo/", $item)) {
                    $replacement = $fileName;
                    $new_string = $this->stringTinker($item,13, $replacement);
                    $contents = str_replace($item, $new_string, $file);
                    Storage::disk('public')->put('company.txt', $contents);
                    break;
                }
            }
        }
        foreach ($index_array as $index) {
            $replacement = $request->$index;
            if($replacement){
                $replacement = $index."=".trim(preg_replace('/\s\s+/', ' ', $replacement));
                $file = Storage::disk('public')->get('company.txt');
                $info = explode(PHP_EOL, Storage::disk('public')->get('company.txt'));
                foreach ($info as $item) {
                    if (preg_match("/$index/", $item)) {
                        $contents = str_replace($item, $replacement, $file);
                        Storage::disk('public')->put('company.txt', $contents);
                        break;
                    }
                }
            }
        }
        return redirect("/admin/index");
    }

    public function getCompanyProfile(){
        $index_array = ['company_name','company_contact','company_address','company_email','company_about','company_logo','shipping_cost'];
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
        return json_encode($obj);
    }

    public function showIndex(){
        $compny_info = json_decode($this->getCompanyProfile());
        $Order = Order::where(['status'=>'Confirmed'])->count();
        $from = date('Y-m-d').' 00:00:00';
        $to = date('Y-m-d', strtotime(' +1 day')).' 00:00:00';
        $newUser = User::whereBetween('created_at',[$from,$to])->count();
        $User = User::all()->count();
        $Catagories = catagory::with('sub')->get();
        $Subscriber = User::where(['subscriber' => 'subscriber'])->count();
        $Slide = Slide::all();
        $Sizes = Size_manager::all();
        $OrderedProduct = OrderedProduct::groupBy('product_id')->orderBy('count', 'desc')->get(['product_id', DB::raw('count(product_id) as count')]);
        $Sub = Catagorie::with('sub')->get();
        $Shipping_cost = "50";
        $Sub_category = Sub_catagory::with('Catagorie')->get();
        $sub_sub_category = Item::with('Sub_catagorie','Catagorie')->get();
        //return $sub_sub_category;
        return view('admin.index',['company_info'=>$compny_info,'sub_sub_category'=>$sub_sub_category,'sub_category'=>$Sub_category,'shipping_cost'=>$Shipping_cost,'Sub'=>$Sub,'OrderedProduct' => $OrderedProduct,'Avilable_size'=>$Sizes,'Slide' => $Slide,'Catagory'=>$Catagories ,'newOrder'=>$Order , 'newUser'=>$newUser, 'user'=>$User, 'subscriber'=>$Subscriber]);
    }

    public function addCatagory(Request $request){
        $Catagory = new catagory();
        $Catagory->catagory_name = htmlspecialchars($request->catagory_name,ENT_QUOTES);
        if($request->hasFile('catagory_photo')){
            $file = $request->catagory_photo;
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path('/images/category'), $fileName);
            $Catagory->photo = $fileName;
        }
        $Catagory->save();
        return redirect('/admin/index');
    }

    public function updateCatagory(Request $request){
        $Catagory = catagory::find($request->id);
        $Catagory->catagory_name = htmlspecialchars($request->catagory_name,ENT_QUOTES);
        if($request->hasFile('catagory_photo')){
            if($Catagory->photo){
                $path = $Catagory->photo;
                File::delete(public_path('/images/category/'.$path));
            }
            $file = $request->catagory_photo;
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path('/images/category'), $fileName);
            $Catagory->photo = $fileName;
        }
        $Catagory->save();
        return redirect('/admin/index');
    }

    public function deleteCatagory(Request $request){
        $Catagory = catagory::find($request->id);
        $Catagory->delete();
        return redirect()->back();
    }

    public function addSubCatagory(Request $request){
        $Catagory = Catagorie::find($request->sub_catagory);
        $Sub_catagory = new Sub_catagorie();
        $Sub_catagory->name = htmlspecialchars($request->sub_name, ENT_QUOTES);
        $Catagory->sub()->save($Sub_catagory);
        return redirect('/admin/index');
    }

    public function updateSubCatagory(Request $request){
        $Catagory = Catagorie::find($request->sub_catagory);
        $Sub_catagory =Sub_catagorie::find($request->id);
        $Sub_catagory->name = htmlspecialchars($request->sub_name,ENT_QUOTES);
        $Catagory->sub()->save($Sub_catagory);
        return redirect('/admin/index');
    }

    public function deleteSubCatagory(Request $request){
        $Sub_catagory =Sub_catagorie::find($request->id);
        $Sub_catagory->delete();
        return redirect('/admin/index');
    }

    public function addItemCatagory(Request $request){
        $Catagory = Catagorie::find($request->item_catagory);
        $Sub = Sub_catagory::find($request->item_sub_catagory);
        $item = new Item();
        $item->name = htmlspecialchars($request->item_name,ENT_QUOTES);
        $item->catagorie_id = $Catagory->id;
        $item->sub_catagorie_id = $Sub->id;
        $item->save();
        return redirect('/admin/index');
    }

    public function updateItemCatagory(Request $request){
        $cata_string = "item_catagory_".$request->id;
        $sub_cata_string = "item_sub_catagory_".$request->id;
        $name_string = "item_name_".$request->id;

        $Catagory = Catagorie::find($request->$cata_string);
        $Sub = Sub_catagory::find($request->$sub_cata_string);
        $item = Item::find($request->id);
        $item->name = htmlspecialchars($request->item_name,ENT_QUOTES);
        $item->catagorie_id = $Catagory->id;
        $item->sub_catagorie_id = $Sub->id;
        $item->save();
        return redirect('/admin/index');
    }

    public function deleteItemCatagory(Request $request){
        $item = Item::find($request->id);
        $item->delete();
        return redirect('/admin/index');
    }

    public function employeeManagement(){
        $Admin = Admin::where(['role' =>'employee'])->get();
        return view('admin.employeeManagement',['Admins' => $Admin]);
    }

    public function employeeUpdate(Request $request){
        $Admin = Admin::find(decrypt($request->id));
        return view('admin.updateEmployee',['Admin' =>$Admin]);
    }

    public function update(Request $request){
        $Admin = Admin::find(decrypt($request->id));
        $Admin->name = $request->name;
        $Admin->email = $request->email;
        $Admin->save();
        return redirect('/admin/employee/management');
    }

    public function deleteEmployee(Request $request){
        if($request->ajax()){
            $Admin = Admin::find($request->id)->delete();
        }
    }

    public function addSlide(Request $request){
        $Slide = new Slide();
        if($request->file('file')){
            $fileName = time().'.'.$request->file('file')->getClientOriginalExtension();
            $request->file->move(public_path('images/user/slides'), $fileName);
            $Slide->url = $fileName;
        }
        $Slide->title = $request->slide_title;
        $Slide->description = $request->slide_description;
        $Slide->link = $request->slide_link;
        $Slide->save();
        return redirect()->back();
    }

    public function deleteSlide(Request $request){
        $Slide = Slide::find($request->id);
        $path = $Slide->url;
        File::delete(public_path('/images/user/slides/'.$path));
        $Slide->delete();
        return redirect()->back();
    }

    public function showUsers(){
        $User = User::all();
        return view('admin.userManagement',['Users'=>$User]);
    }

    public  function sendMail(Request $request){
        $Subcribers = Subscribers::all();
        $subject = $request->mail_subject;
        $body = $request->mail_body;
        foreach ($Subcribers as $subcriber){
            Mail::to($subcriber)->send(new SubscribersMail($subject,$body,$subcriber));
        }
    }

    public function saveSize(Request $request){
        $Size = new Size_manager();
        $Size->size = strtoupper($request->size);
        $Size->save();
        return redirect('/admin/index');
    }

    public function assignEmployeeToTicket(Request $request){
        if($request->ajax()){
            $Admin = Admin::find($request->employee);
            $Ticket = Ticket::find($request->id);
            $Admin->ticket()->save($Ticket);
            $Admin->notify(new AssignEmployeeToTicket($Ticket));
        }
    }

    public function showRegistrationForm(){
        $admin = Admin::all();
        return view('admin.createUser',['Admins'=>$admin]);
    }

    public function registerUser(Request $request){
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->district = $request->email;
        $User->password = Hash::make($request->password);
        $User->gender = $request->gender;
        $User->mobile = $request->phone;
        $User->save();
        return redirect('/user/management');
    }

    public function checkSize(Request $request){
        $check = sizeof(Size_manager::where(['size' => strtoupper($request->size) ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function checkShowcase(Request $request){
        $check = sizeof(Simple_index::where(['name' => strtoupper($request->showcase_name) ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function checkEmail(Request $request){

        $check = sizeof(Admin::where(['email' => $request->email ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function checkGBPlower(Request $request){
        $check = sizeof(GBP::where(['lower' => $request->min ])->get());
        if ($check>0) {
            $check = "false";
            return $check;
        }
        $array = GBP::all();
        foreach ($array as $item){
            if($item->upper){
                if(floatval($request->min)>floatval($item->lower) && floatval($request->min)<floatval($item->upper)){
                    $check = "false";
                    return $check;
                }
            }
        }

        $check = "true";
        return $check;

    }

    public function checkCategory(Request $request){
        $check = sizeof(Catagorie::where(['catagory_name' => $request->catagory_name ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function IndexSettings(){
        $sub_items =catagory::with('sub')->get();
        $existing_simple_index  = Simple_index::whereBetween('count',[1,4])->get();
        $Simple_index = Simple_index::with('simple_belongs')->get();
        //return $existing_simple_index;
        return view('admin.indexSetting',['Sub' =>$sub_items,'simple_index'=>$Simple_index , 'existing_simple_index' => $existing_simple_index]);
    }

    public function changeGBP(Request $request){
        $GBP = GBP::find($request->id);
            $GBP->upper = $request->max;
            $GBP->lower = $request->min;
            $GBP->rate = $request->rate;
            $GBP->save();
            return redirect()->back();
    }

    public function deleteGBP(Request $request){
        $GBP = GBP::find($request->id);
        $GBP->delete();
        return redirect()->back();
    }

    public function AddGBP(Request $request){
            $GBP = new GBP();
            $GBP->upper = $request->max;
            $GBP->lower = $request->min;
            $GBP->rate = $request->rate;
            $GBP->save();
            return redirect()->back();
    }

    public function addShippingCost(Request $request){
        $GBP = GBP::first();
        if($GBP->rate || $GBP->shipping_cost){
            $GBP->shipping_cost = $request->shipping_cost;
            $GBP->save();
            return redirect()->back();

        }
        else{
            $GBP = new GBP();
            $GBP->shipping_cost = $request->shipping_cost;
            $GBP->save();
            return redirect()->back();
        }
    }

    public function addShowcase(Request $request){
        $Simple_index = new Simple_index();
        $Simple_index->name = strtoupper($request->showcase_name);
        $Simple_index->count = 1;
        $Simple_index->save();

        if($request->hasFile('photo')){
            $file = $request->photo;
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/images'), $fileName);
        }

        $Simple_index = Simple_index::orderBy('id','desc')->first();

        $Simple_index_belongs = new Simple_index_belongs();
        $Simple_index_belongs->heading = $request->heading;
        $Simple_index_belongs->label = $request->label;
        $Simple_index_belongs->photo = $fileName;
        $Simple_index_belongs->sub_catagorie_id = $request->sub_catagory;
        $Simple_index_belongs->catagorie_id = $request->catagory;
        $Simple_index->simple_belongs()->save($Simple_index_belongs);
        return redirect()->back();
    }

    public function addExistingShowcase(Request $request){
        $Simple_index = Simple_index::find($request->showcase);
        $Simple_index->count = intval($Simple_index->count)+1;
        $Simple_index->save();

        if($request->hasFile('photo')){
            $file = $request->photo;
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/images'), $fileName);
        }

        $Simple_index =  Simple_index::find($request->showcase);

        $Simple_index_belongs = new Simple_index_belongs();
        $Simple_index_belongs->heading = $request->heading;
        $Simple_index_belongs->label = $request->label;
        $Simple_index_belongs->photo = $fileName;
        $Simple_index_belongs->sub_catagorie_id = $request->existing_sub_catagory;
        $Simple_index_belongs->catagorie_id = $request->existing_catagory;
        $Simple_index->simple_belongs()->save($Simple_index_belongs);
        return redirect()->back();
    }

    public function deleteShowcase(Request $request){
        $Simple_index = Simple_index::with('simple_belongs')->find(decrypt($request->id));
        //return $Simple_index;
        $photo_array = $Simple_index['simple_belongs'];
        foreach ($photo_array as $item){
            $path = $item->photo;
            File::delete(public_path('/images/'.$path));

        }
        $showcase = Simple_index::find(decrypt($request->id));
        $showcase->delete();
        return redirect()->back();
    }

    public function updateCostEstimationWebsite(Request $request){
        $estimation = Estimation::find($request->id);
        $estimation->website = $request->website;
        $estimation->url = $request->url;
        $estimation->shipping_cost = $request->shipping;
        $estimation->dlv_charge_website = $request->dlv_charge;
        $estimation->save();
        return redirect()->back();
    }

    public function addCostEstimationWebsite(Request $request){
        $estimation = new Estimation();
        $estimation->website = strtoupper($request->website);
        $estimation->url = $request->url;
        $estimation->shipping_cost = $request->shipping;
        $estimation->dlv_charge_website = $request->dlv_charge;
        $estimation->save();
        return redirect()->back();
    }

    public function deleteCostEstimationWebsite(Request $request){
        $estimation = Estimation::find($request->id);
        $estimation->delete();
        return redirect()->back();
    }

    public function checkWebsite(Request $request){
        $check = sizeof(Estimation::where(['website' => strtoupper($request->website) ])->get());
        if ($check>0) $check = "false";
        else $check = "true";
        return $check;
    }

    public function showSharedLinks(Request $request){
        $links = links::with('admin')->orderBy('created_at','desc')->get();
        return view('admin.sharedLinks',['Links'=>$links]);
    }

    public function setRequestPrice(Request $request){
        $links = links::find($request->id);
        $links->price = trim($request->price);
        $links->save();
        $user = User::find($links->user_id);
        $user ->notify(new NotifyUserRequestedPriceSet($links));
        Mail::to($user->email)->send(new PriceSetRequestMail($links));

    }

    public function addDeliveryCharge(Request $request){
        $dlv = new Delivery_cost();
        $dlv->dlv_charge = $request->charge;
        $dlv->weight = $request->weight;
        $dlv->save();
        return redirect()->back();
    }

    public function updateDeliveryCharge(Request $request){
        $dlv = Delivery_cost::find($request->id);
        $dlv->dlv_charge = $request->charge;
        $dlv->weight = $request->weight;
        $dlv->save();
        return redirect()->back();
    }

    public function deleteDeliveryCharge(Request $request){
        $dlv = Delivery_cost::find($request->id);
        $dlv->delete();
        return redirect()->back();
    }

    public function changeShippingCost(Request $request){
        $GBP=GBP::first();
        $GBP->shipping_cost = $request->shipping_cost;
        $GBP->save();
        return redirect()->back();
    }

    public function createAdmin(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6',
        ]);
        $Admin = new Admin();
        $Admin->email = $request->email;
        $Admin->password = bcrypt($request->password);
        $Admin->role = 'super';
        $Admin->name = $request->name;
        $Admin->save();

        return redirect()->back();
    }

    public function changeRequestStatus(Request $request){
        if($request->ajax()){
            $link = links::find($request->id);
            $link->is_responded = 1;
            $link->admin_id = $request->admin;
            $link->save();
        }
        else{
            return redirect()->back();
        }
    }
}
