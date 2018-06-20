<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo as Photo;
use App\Product as Products;
use App\Size as Size;
use App\Color as Color;
use App\Order as Order;
use App\Admin as Admin;
use App\Orders_discussion as discussion;
use App\Log as log;
use Auth;
use App\Notifications\EmployeeAssign;
use App\Notifications\OrderStatusChange;
use App\Notifications\NotifyUserOrderStatus;
use App\User as User;
use App\Catagorie as Catagory;
use App\Size_management as SizeManager;
use App\Size_management as SM;
use App\Notifications\FavouritrProductUpdated;
use App\Users_wishlst as Wishlist;
use Psy\Util\Json;
use Storage;
use App\Notifications\ProductUpdateEmployee;
use App\Sub_catagorie as Sub_Catagory;
use App\Delivery_cost as Shipping;
use File;
use App\Tag as Tags;
use App\Mail\OrderConirmed;
use Mail;

class ProductController extends Controller
{

    public function addProduct(){
        $Catagory = Catagory::all();
        $Sizes = SizeManager::all();
        $Sub = Catagory::with('sub')->get();
        $item = Sub_Catagory::with('item')->get();
        return view('Product.addProduct',['item_sub'=>$item,'Sub'=>$Sub,'Sizes'=>$Sizes, 'Catagory' =>$Catagory]);
    }

    public function store(Request $request){

        $tags = explode(",",$request->tag);
        for($i = 0; $i<sizeof($tags);$i++){
            $tag_existance = Tags::where(['name' => ucwords($tags[$i])])->get();
            if(sizeof($tag_existance)==0){
                $tag = new Tags();
                $tag->name = ucwords($tags[$i]);
                $tag->save();
            }
        }

        $totalQuantity = 0;
        $avilableSizes = SM::all();
        $Product = new Products();
        $Product->title = $request->title;
        $Product->code = $request->code;
        $Product->description = $request->detail;
        $Product->price = $request->price;
        $Product->catagorie_id = $request->catagory;
        if($request->hasFile('resp_img')){
            $file = $request->resp_img;
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path('/images/products'), $fileName);
            $Product->resp_photo = $fileName;
        }
        if($request->sub_catagory){
            $Product->sub_catagorie_id = $request->sub_catagory;
        }
        if($request->item){
            $Product->catagories_item_id = $request->item;
        }

        $Product->has_color = $request->has_color;

        if($request->size == '1'){
            foreach ($avilableSizes as $item){
                $quantityString = $item->id."_quantity";
                if($request->$quantityString){
                    $totalQuantity = $totalQuantity+intval($request->$quantityString);
                }
            }
        }

        else{
            $totalQuantity = $request->quantity;
        }
        $Product->has_size = $request->size;
        $Product->quantity =$totalQuantity;
        $Product->discount = $request->discount;
        $Product->save();
        $Product = Products::select('product_id')->orderBy('product_id','desc')->first();
        foreach ($tags as $item){
            $tag = Tags::where(['name' => $item])->first();
            $id = Tags::find($tag->id);
            $id->Product()->save($Product);
        }

        if($request->has_color == '1'){
            $colorCounter = intval($request->color_counter);
            for($i=1;$i<=$colorCounter;$i++){
                $Product = Products::select('product_id')->orderBy('product_id','desc')->first();
                $Color = new Color();
                $selectedColor = "color_$i";
                $rgb = "color_rgb_$i";
                if($request->$selectedColor){
                    $Color->color = $request->$selectedColor;
                    $Color->rgb = $request->$rgb;
                    $Product->Color()->save($Color);
                }
            }
        }
            if($request->size == "1"){
                foreach ($avilableSizes as $item){
                $sizeString = "size_".$item->id;
                $quantityString = $item->id."_quantity";
                if($request->$sizeString){
                    $Product = Products::select('product_id')->orderBy('product_id','desc')->first();
                    $Size = new Size();
                    $Size->size = $request->$sizeString;
                    $Size->quantity = $request->$quantityString;
                    $Product->Size()->save($Size);
                }
            }
        }


        if($request->file('file')){
            $files = $request->file;
            foreach ($files as $file){
                $fileName = time().$file->getClientOriginalName();
                $file->move(public_path('/images/products'), $fileName);
                $Product = Products::select('product_id')->orderBy('product_id','desc')->first();
                $Photo = new Photo();
                $Photo->url = $fileName;
                $Product->Photo()->save($Photo);
            }

        }


        if(Auth::user()->role == 'super') return redirect('/productList');
        else return redirect('/employee/productList');
    }

    public function showProducts(){
        $Products = Products::all();
        return view('Product.productList',['Products' => $Products]);
    }

    public function showProductDetail(Request $request){
        $Product = Products::find(decrypt($request->id));
        $Color = Products::find(decrypt($request->id));
        $Color->Color;
        $Size = Products::find(decrypt($request->id));
        $Size->Size;
        $Photo = Products::find(decrypt($request->id));
        $Photo->Photo;
        return view('Product.indivisualProduct' , ['Product' => $Product , 'Color' => $Color , 'Size' => $Size , 'Photo' => $Photo]);
    }

    public function updateProduct(Request $request){
        $Product = Products::find(decrypt($request->id));
        $Color = Products::find(decrypt($request->id));
        $Color->Color;
        $Size = Products::find(decrypt($request->id));
        $Size->Size;
        $Photo = Products::find(decrypt($request->id));
        $Photo->Photo;
        $Catagory = Catagory::all();
        $Sizes = SizeManager::all();
        $Sub = Catagory::with('sub')->get();
        $item = Sub_Catagory::with('item')->get();
        return view('Product.updateProduct' , ['item_sub'=>$item,'Sub'=>$Sub,'Sizes'=>$Sizes,'Catagory' =>$Catagory,'Product' => $Product , 'Color' => $Color , 'Size' => $Size , 'Photo' => $Photo]);
    }

    public function update(Request $request){
        //return "done";
        $tags = explode(",",$request->tag);
        for($i = 0; $i<sizeof($tags);$i++){
            $tag_existance = Tags::where(['name' => ucwords($tags[$i])])->get();
            if(sizeof($tag_existance)==0){
                $tag = new Tags();
                $tag->name = ucwords($tags[$i]);
                $tag->save();
            }
        }

        $oldTags = Products::with('tag')->find($request->id);
            $Tags = [];
            foreach ($oldTags->tag as $item){
                array_push($Tags,$item['name']);
                $tag_to_remove = Tags::find($item['id']);
                $tag_to_remove->Product()->detach($oldTags);
            }

            foreach ($tags as $item){
                $tag_existance = Tags::where(['name' => ucwords($item)])->first();
                if(sizeof($tag_existance)==0){
                    $tag = new Tags();
                    $tag->name = ucwords($item);
                    $tag->save();
                    $newTag = Tags::orderBy('id','DESC')->first();
                    $newTag = Tags::find($newTag->id);
                    $newTag->Product()->save($oldTags);
                }
                else{
                    $tt = Tags::find($tag_existance->id);
                    $tt->Product()->save($oldTags);
                }
            }

        $avilableSizes = SM::all();
        $totalQuantity = 0;
        $Product = Products::find($request->id);
        $Product->has_color = $request->has_color;
        $Product->title = htmlspecialchars($request->title,ENT_QUOTES);
        $Product->code = $request->code;
        $Product->discount = $request->discount;
        $Product->price = $request->price;
        $Product->description = $request->detail;

        if($request->hasFile('resp_img')){
            $file = $request->resp_img;
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path('/images/products'), $fileName);
            $Product->resp_photo = $fileName;
        }

        if($request->sub_catagory){
            $Product->sub_catagorie_id = $request->sub_catagory;
        }
        if($request->item){
            $Product->catagories_item_id = $request->item;
        }

        if($request->size == '1'){
            foreach ($avilableSizes as $item){
                $quantityString = $item->id."_quantity";
                if($request->$quantityString){
                    $totalQuantity = $totalQuantity+intval($request->$quantityString);
                }
            }
        }

        else{
            $totalQuantity = $request->quantity;
        }
        $Product->has_size = $request->size;
        $Product->quantity =$totalQuantity;
        $Product->save();

        $colorCounter = intval($request->color_counter);
        $Color = Products::find($request->id);
        $oldColor =[];
        $newColor =[];
        $oldRGB =[];
        $newRGB =[];
        foreach ($Color->color as $item){
           array_push($oldColor,$item->color);
            array_push($oldRGB,$item->rgb);
        }
        for($i=1;$i<$colorCounter+2;$i++){
            $selectedColor = "color_$i";
            $rgb = "color_rgb_$i";
            echo $request->$selectedColor;
            if($request->$selectedColor){
               array_push($newColor,$request->$selectedColor);
               array_push($newRGB,$request->$rgb);
            }
        }
        if(count($oldColor) < count($newColor)){
            $compSize = array_diff($newColor,$oldColor);
            $compRGB = array_diff($newRGB,$oldRGB);
            $keys = (array_keys($compSize));
            $p=0;

            foreach ($compSize as $item){
                $Product = Products::find($request->id);
                $Color = new Color();
                $Color->color = $item;
                $Color->rgb = $compRGB[$keys[$p]];
                $Product->Color()->save($Color);
                array_push($oldColor,$item);
                $p = $p+1;
            }
        }

        else if(count($oldColor) > count($newColor)){
            $compSize = array_diff($oldColor,$newColor);
            foreach ($compSize as $item){
                $Color = Color::where(['product_id' => $request->id , 'color' => $item])->delete();
            }
        }

        for ($i =0;$i<sizeof($newColor);$i++){
            if(count($oldColor)>0){
                $Color = Color::where(['product_id' => $request->id , 'color' => $oldColor[$i]])->update(
                    [
                        'color' =>$newColor[$i],
                        'rgb' =>$newRGB[$i]
                    ]
                );
            }
        }


        $oldSize =[];
        $newSize =[];
        foreach ($avilableSizes as $item){
            $sizeString = "size_".$item->id;
            echo $sizeString;
            if($request->$sizeString){
                array_push($newSize,$request->$sizeString);
            }
        }

        $Size = Products::find($request->id);
        foreach ($Size->size as $item){
            array_push($oldSize,$item->size);
        }

        if(count($oldSize) > count($newSize)){
            $compSize = array_diff($oldSize,$newSize);
            foreach ($compSize as $item){
                $Size = Size::where(['product_id' => $request->id , 'size' => $item])->delete();
            }
        }

        else if(count($oldSize) < count($newSize)){
            $compSize = array_diff($newSize,$oldSize);
            foreach ($compSize as $item){
                $Product = Products::find($request->id);
                $Size = new Size();
                $Size->size = $item;
                foreach ($avilableSizes as $mn){
                    $sizeString = "size_".$mn->size;
                    $quantityString = $mn->size."_quantity";
                    if($item == $mn->size) $quantity = $request->$quantityString;
                }
                $Size->quantity = $quantity;
                $Product->Size()->save($Size);
                array_push($oldSize,$item);
            }
        }
        for ($i =0;$i<sizeof($newSize);$i++){
                if(count($oldSize)>0){
                    foreach ($avilableSizes as $mn){
                        $sizeString = "size_".$mn->id;
                        $quantityString = $mn->id."_quantity";
                        if($newSize[$i] == $mn->size) $quantity = $request->$quantityString;
                    }

                    $Size = Size::where(['product_id' => $request->id , 'size' => $oldSize[$i]])->update(
                        [
                            'size' => $newSize[$i],
                            'quantity' => $quantity
                        ]
                    );
                }
            else{
                $Product = Products::find($request->id);
                $Size = new Size();
                foreach ($avilableSizes as $mn){
                    $sizeString = "size_".$mn->id;
                    $quantityString = $mn->id."_quantity";
                    if($newSize[$i] == $mn->size) $quantity = $request->$quantityString;
                }
                $Size->size = $newSize[$i];
                $Size->quantity = $quantity;
                $Product->Size()->save($Size);
            }

        }


        if($request->hasfile('file')){
            $photo = Photo::where(['product_id'=>$request->id])->get();
            foreach ($photo as $item){
                $path = $item->url;
                File::delete(public_path('/images/products/'.$path));
                $img =  Photo::where(['product_id'=>$request->id,'url'=>$item->url])->delete();
            }

            $files = $request->file;
            foreach ($files as $file){
                $fileName = time().$file->getClientOriginalName();
                $file->move(public_path('/images/products'), $fileName);
                $Product = Products::find($request->id);
                $Photo = new Photo();
                $Photo->url = $fileName;
                $Product->Photo()->save($Photo);
            }
        }
        $WishList = Wishlist::with('user')->where(['product_id'=> $request->id])->get();
        if(sizeof($WishList)>0){
            $Product = Products::find($request->id);
            foreach ($WishList as $user){
                $user['user']->notify(new FavouritrProductUpdated($Product));
            }
        }

        if(Auth::user()->role == 'employee'){
            $Employee = Auth::user();
            $Product = Products::find($request->id);
            $SuperAdmin = Admin::where(['role'=>'super'])->get();
            foreach ($SuperAdmin as $admin){
                $admin->notify(new ProductUpdateEmployee($Product,$Employee));
            }

        }

        if(Auth::user()->role == 'super') return redirect('/productList');
        else return redirect('/employee/productList');
    }

    public function orders(){
        $employees = Admin::where(['role' => 'employee'])->get();
        $array = array();
        foreach ($employees as $item){
            $label = $item->name;
            $id = $item->id;
            $array[] = array("value"=>$id,"text"=>$label);
        }
        $Order = Order::with('order_product','user','admin','product')->orderBy('order_id','DESC')->get();
        //return $Order;
        return view('admin.orders.orders',['Orders' => $Order , 'Employees' => $array]);
    }

    public function logCreator($id, $updated_step, $updated_by){
        if($updated_step == 'Employee Assigned') $message = 'Employee has been assigned';
        else if($updated_step == 'invoice') $message = 'Order invoice created';
        else if($updated_step == 'shipping') $message = 'Shipping Document created';
        else if($updated_step == 'Processing-Delivery') $message = 'Customer has been contracted for delivery processing';
        else  $message = 'Order has been confirmed for delivery';
        $Order = Order::find($id);
        $Log = new log();
        $Log->updated_step = $updated_step;
        $Log->admin_id = $updated_by;
        $Log->message = $message;
        $Order->log()->save($Log);
    }

    public function changeOrderStatus(Request $request){
        if($request->ajax()){
            $Order  = Order::find($request->id);
            $Order->status = $request->status;
            $notifyUserFlag = 0;
            if($request->status == "Confirmed"){
                $user = $Order::with('user')->find($request->id);
                Mail::to($user->user)->send(new OrderConirmed($user.$Order));
            }

            $Order->save();
            $updated_by = Auth::id();
            $this->logCreator($request->id,$request->status,$updated_by);

            $Order  = Order::find($request->id);
            $status = $request->status;
            $employee = Order::find($request->id)->admin()->get();
            $Admin = Auth::user();
            foreach ($employee as $admin){
                $admin->notify(new OrderStatusChange($Order,$status,$Admin));
            }

            if($notifyUserFlag == 1){
                $Order = Order::with('user')->find($request->id);
                $User = User::find($Order['user']->id);
                $userOrderStatus = 'Processing';
                $User->notify(new NotifyUserOrderStatus($Order,$userOrderStatus,$User));
                echo $notifyUserFlag;
            }
        }
        else{
            echo "unchanged";
        }
    }

    public function indivisualOrderDetail(Request $request){
        $Order = Order::with('order_product','user')->find(decrypt($request->id));
        return view('admin.orders.indivisualOrderDetail',['Order' => $Order]);
    }

    public function storeFile(Request $request){
        if($request->ajax()){
            if($request->file('file')){
                $this->validate($request, [
                    'file'=> 'max:100048',
                ]);
                $fileName = time().'.'.$request->file('file')->getClientOriginalExtension();
                $request->file->move(public_path('admin/shipping-files'), $fileName);
               echo $fileName;
            }
        }
    }

    public function storeOrderDiscussion(Request $request){
        if($request->ajax()){
            echo "got it";
            $employee_id = Auth::id();

            $Order = Order::find($request->id);
            $Order->status = $request->status;
            $Order->save();

            $Order = Order::find($request->id);
            foreach ($request->discussion as $item){
                $Order_discussion = new discussion();
                $Order_discussion->query = $item['query'];
                $Order_discussion->feedback = $item['feedback'];
                $Order_discussion->employee_id = $employee_id;
                $Order->order_discussion()->save($Order_discussion);
            }
            $updated_by = Auth::id();
            $this->logCreator($request->id,$request->status,$updated_by);

            $Order  = Order::find($request->id);
            $status = $request->status;
            $employee = Order::find($request->id)->admin()->get();
            $Admin = Auth::user();
            foreach ($employee as $admin){
                $admin->notify(new OrderStatusChange($Order,$status,$Admin));
            }
        }
        else{echo "not ajax";}
    }

    public function logViewer(Request $request){
        $Log = log::with('admin')->where(['order_id'=> decrypt($request->id)])->get();
        //echo decrypt($request->id);
        return view('admin.orders.logs',['Logs' => $Log]) ;
    }

    public function deleteProduct(Request $request){
        if($request->ajax()){
            $Product = Products::find($request->id)->delete();
        }
    }

}
