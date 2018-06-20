<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConirmed;
use Illuminate\Http\Request;
use App\User as user;
use App\Product as Product;
use App\Order as Order;
use App\Size as Size;
use App\Orders_product as OrderedProduct;
use App\Log as log;
use Auth;
use App\Catagorie as Catagory;
use League\Flysystem\Exception;
use Storage;
use App\Mail\OrderRecieved;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showOrderPlacement(){
        $Districts = explode(',',Storage::disk('public')->get('districts.txt')) ;
        $id = auth()->user()->id;
        $user = user::find($id);
        $Catagory = Catagory::all();

        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        return view('User.Order.orderPlacementInfo',['shipping_cost' => $shipping_cost,'Districts'=>$Districts,'Catagory'=>$Catagory,'userId' => $user]);
    }

    public function showCheckOut(){
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        $id = auth()->user()->id;
        $user = user::find($id);
        return view('User.Order.checkOut',['shipping_cost' =>$shipping_cost ,'userId' => $user]);
    }

    public function showOrderPayment(){
        $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
        foreach ($info as $item){
            if(preg_match('/shipping_cost/',$item)){
                $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
            }
        }
        $id = auth()->user()->id;
        $user = user::find($id);
        $Catagory = Catagory::all();
        return view('User.Order.payment',['data' =>$menu_data,'shipping_cost' =>$shipping_cost,'Catagory'=>$Catagory,'userId' => $user]);
    }

    public function logCreator($id, $updated_step, $updated_by){
        $message = 'Order has been recieved to admin';
        $Order = Order::find($id);
        $Log = new log();
        $Log->updated_step = $updated_step;
        $Log->admin_id = $updated_by;
        $Log->message = $message;
        $Order->log()->save($Log);
    }

    function productAvailabilityChecker($product_id,$size,$quantity){
        $Size = Size::where(['product_id'=>$product_id, 'size'=>$size])->get();
        $leftOver = intval($Size[0]->quantity)-intval($quantity);
        return $leftOver;
    }

    public function checkOrderedProductAvailability(Request $request){
        $voucher = $request->voucher;
        $voucher = $voucher[0];
        $availability_checker = [];
        foreach ($voucher['productDetail'] as $item){
            $size = $item['sizes'];
            if($size != 'Not Applicable'){
                $product = Product::with(['size' => function($q) use($size) {
                    $q->where('size', $size);
                }])->where(['product_id' => $item['id']])->first();

                foreach ($product->size as $item2){
                    if(($item2->quantity) > 0){
                        array_push($availability_checker,1);
                    }
                    else{
                        array_push($availability_checker,0);
                    }
                }
            }
            else{
                $product = Product::where(['product_id' => $item['id']])->first();
                if(($product->quantity) > 0){
                    array_push($availability_checker,1);
                }
                else{
                    array_push($availability_checker,0);
                }
            }
        }
        return $availability_checker;
    }

    public function confirmCheckout(Request $request){
        if($request->ajax()){
            $voucher = $request->voucher;
            $voucher = $voucher[0];
            $total =0;
            foreach ($voucher['productDetail'] as $item){
                $discount = ((floatval($item['discount'])/100)*(floatval($item['price'])));
                $unitPrice = (floatval($item['price'])-$discount);
                $total =$total+ ($unitPrice*floatval($item['quantity']));
            }
            $Order = new Order();
            $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
            foreach ($info as $item){
                if(preg_match('/shipping_cost/',$item)){
                    $shipping_cost = trim(preg_replace('/shipping_cost=/','',$item));
                }
            }
            $Order->shipping_cost = $shipping_cost;
            $total = (ceil((floatval($shipping_cost)+$total)/5))*5;
            $Order->order_value = $total;
            $Order->user_id = $voucher['userId'];
            $Order->address = $voucher['address'];
            $Order->email = $voucher['email'];
            $Order->city = $voucher['city'];
            $Order->payment_methode = $request->paymentMethode;
            $Order->phone = $voucher['phone'];
            $Order->status = "Processing";
            $Order->save();

            $uid = (string) $voucher['userId'];
            $Order = Order::select('order_id')->orderBy('order_id','desc')->first();

            $oid = (string) $Order->order_id;
            $this->logCreator($oid,'Recieved','1');

            $orderNumber ="$oid".str_replace(':','',date('Y:m:d'))."$uid";
            $Order->order_number = $orderNumber;
            $Order->save();

            $user = Auth::user();
            $user->district = $voucher['city'];
            $user->address = $voucher['address'];
            $user->mobile = $voucher['phone'];
            $user->save();

            foreach ($voucher['productDetail'] as $item){
                $Order = Order::select('order_id')->orderBy('order_id','desc')->first();
                $OrderedProduct = new OrderedProduct();
                $product = Product::find($item['id']);
                $Order->product()->save($product);

                $has_size = $this->sizeChecker($item['id']);
                //var_dump($has_size);
                if($has_size == 0){
                    $Product = Product::find($item['id']);
                    $avilability = intval($Product->quantity)-intval($item['quantity']);
                    var_dump($avilability);
                }
                else{

                    $avilability = $this->productAvailabilityChecker($item['id'],$item['sizes'],$item['quantity']);
                }

                if($avilability >=0 ) $OrderedProduct->available = "available";
                else $OrderedProduct->available = $avilability;
                $OrderedProduct->product_id = $item['id'];
                $OrderedProduct->size = $item['sizes'];
                $OrderedProduct->title = $item['title'];
                $OrderedProduct->color = $item['colors'];
                $OrderedProduct->photo = $item['photo'];
                $OrderedProduct->quantity = $item['quantity'];
                $OrderedProduct->unit_price = $item['price'];
                $OrderedProduct->total_price = ceil((intval($item['price'])*$item['quantity']));
                $OrderedProduct->discount = ceil($item['discount']);
                $Order->order_product()->save($OrderedProduct);

                if($has_size=='0'){
                    $Product = Product::find($item['id']);
                    $Product->quantity = $avilability;
                    $Product->save();
                }
                else{
                    $this->productQuantityTinker($avilability,$item['id'],$item['sizes'],$item['quantity']);
                }
            }
            $user = Auth::user();
            try{
                 Mail::to($user)->send(new OrderRecieved($user));
            }
            catch(Exception $e){

            }

            if(intval($request->pointUsage)>0){
                $user->points = intval($user->points)-intval($request->pointUsage);
                $user->save();
            }
        }
    }

    public function productQuantityTinker($LeftOver, $product_id, $size, $quantity){
        $Size = Size::where(['product_id'=>$product_id, 'size'=>$size])->update(['quantity' => $LeftOver]);
        $Product = Product::find($product_id);
        $Product->quantity = intval($Product->quantity)-intval($quantity) ;
        $Product->save();
    }

    public function sizeChecker($product_id){
        $Product = Product::find($product_id);
        return $Product->has_size;
    }

    public function showUserOrderDetail(){
        $id = auth()->user()->id;
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->where(['user_id'=>$id])->get();
        return view('User.Order.orderDetail',['Catagory'=>$Catagory,'order' => $Order]);
    }

    public function showIndivisualOrder(Request $request){
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->find(decrypt($request->id));
        return view('User.Order.IndivisualOrderDetail',['Catagory'=>$Catagory,'order' => $Order]);
    }

    public function showOrderTrack(Request $request){
        $Catagory = Catagory::all();
        $Order = Order::with('order_product','admin')->find(decrypt($request->id));
        return view('User.Order.IndivisualOrderTrack',['Catagory'=>$Catagory,'order' => $Order]);

    }

    public function setAdvance(Request $request){
        if($request->ajax()){
            $order = Order::find($request->id);
            $order->advance = $request->advance;
            $order->profit = $request->profit;
            $order->save();
        }
        else{
            return redirect()->back();
        }
    }

    public function setOrderValueInGbp(Request $request){
        if($request->ajax()){
            $order = Order::find($request->id);
            $order->value_gbp = $request->value;
            $order->profit = $request->profit;
            $order->save();
        }
        else{
            return redirect()->back();
        }
    }
}
