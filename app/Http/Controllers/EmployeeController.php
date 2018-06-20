<?php

namespace App\Http\Controllers;

use App\Catagorie;
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
use App\User as User;
use App\Points_management as Point;
use App\Catagorie as catagory;
use App\Slide as Slide;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribersMail;
use App\Mail\TickteSolved;
use App\Size_management as Size_manager;
use Storage;
use App\Orders_product as OrderedProduct;
use App\Product as Product;
use App\Ticket as Ticket;
use App\Notifications\TicketSolved;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function showDashboard()
    {
        $Point = Point::all();
        $Order = Order::where(['status'=>'Confirmed'])->count();
        $from = date('Y-m-d').' 00:00:00';
        $to = date('Y-m-d', strtotime(' +1 day')).' 00:00:00';
        $newUser = User::whereBetween('created_at',[$from,$to])->count();
        $User = User::all()->count();
        $Catagories = catagory::all();
        $Subscriber = User::where(['subscriber' => 'subscriber'])->count();
        $Slide = Slide::all();
        $Sizes = Size_manager::all();
        return view('employee.index',['Avilable_size'=>$Sizes,'Slide' => $Slide,'Catagory'=>$Catagories ,'newOrder'=>$Order , 'newUser'=>$newUser, 'user'=>$User, 'subscriber'=>$Subscriber, 'point' =>$Point]);

    }

    public function showOrders(){
        $id = Auth::id();
        $Orders =Admin::find($id)->order()->get();
        return view('employee.orders.orders',['Orders' => $Orders]);
    }

    public function logViewer(Request $request){
        $Log = log::with('admin')->where(['order_id'=> decrypt($request->id)])->get();
        //echo decrypt($request->id);
        return view('employee.orders.logs',['Logs' => $Log]) ;
    }

    public function indivisualOrderDetail(Request $request){
        $Order = Order::with('order_product','user')->find(decrypt($request->id));
        $Order_discussion = discussion::where(['order_id' =>decrypt($request->id)])->get();
        return view('employee.orders.indivisualOrderDetail',['Order' => $Order, 'Discussion' =>$Order_discussion]);
    }

    public function changeOrderStatus(Request $request){
        if($request->ajax()){
            $Order  = Order::find($request->id);
            $Order->status = $request->status;
            $status = $request->status;

            if($request->status == "invoice"){
                $invoice_id ="#"."$request->id"."iNv".str_replace(':','',date('Y:m:d'));
                $Order->invoice_id = $invoice_id;
            }

            else if($request->status == "shipping"){
                $shipping_id ="#"."$request->id"."sHp".str_replace(':','',date('Y:m:d'));
                $Order->shipping_id = $shipping_id;
                $Order->tracking_code = $request->tracking_code;
                $Order->company_name = $request->company;
                $Order->file = $request->file;
                echo ("shawwa");
            }

            $Order->save();
            $updated_by = Auth::id();
            $this->logCreator($request->id,$request->status,$updated_by);

            $Admin = Admin::where(['role' => 'super'])->get();
            $employee = Auth::user();
            foreach ($Admin as $admin){

                $admin->notify(new OrderStatusChange($Order,$status,$employee));
            }
        }
        else{
            echo "unchanged";
        }
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

    public function storeFile(Request $request){
        if($request->ajax()){
            if($request->file('file')){
                $this->validate($request, [
                    'file'=> 'max:10048',
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
            $status = $request->status;

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

            $Admin = Admin::where(['role' => 'super'])->get();
            $employee = Auth::user();
            foreach ($Admin as $admin){

                $admin->notify(new OrderStatusChange($Order,$status,$employee));
            }
        }
        else{echo "not ajax";}
    }

    public function addCatagory(Request $request){
        $Catagory = new catagory();
        $Catagory->catagory_type = $request->catagory_type;
        $Catagory->catagory_name = $request->catagory_name;
        $Catagory->save();
        return redirect('/employee/dashboard');
    }

    public function showUsers(){
        $User = User::all();
        return view('employee.userManagement',['Users'=>$User]);
    }

    public  function sendMail(Request $request){
        $Subcribers = User::where(['subscriber'=>'subscriber'])->get();
        $subject = $request->mail_subject;
        $body = $request->mail_body;
        foreach ($Subcribers as $subcriber){
            Mail::to($subcriber)->send(new SubscribersMail($subject,$body,$subcriber));
        }
    }

    public function changeTicketStatus(Request $request){
        if($request->ajax()){
            $Ticket = Ticket::find($request->id);
            $Ticket->status = $request->status;
            $Ticket->save();
            $Employee = Auth::user();
            $Admin = Admin::where(['role' => 'super'])->get();
            $Ticket = Ticket::with('user')->find($request->id);
            $Ticket['user']->notify(new TicketSolved($Ticket,$Employee));
            foreach ($Admin as $item){
                $item->notify(new TicketSolved($Ticket,$Employee));
            }

        }
    }

    public function showAcceptedTickets(){
        $id = Auth::id();
        $Ticket = Admin::find($id)->ticket()->get();
        //return json_encode($Ticket);
        return view('employee.acceptedTicketList',['Tickets'=>$Ticket]);
    }

    public function sendTicketSolvationMail(Request $request){
        $Ticket = Ticket::find($request->ticketId);
        $Ticket->feedback = $request->mail_body;
        $Ticket->save();
        $User = Ticket::with('user')->find($request->ticketId);
//        var_dump($User);
        //  return $User['user']->email;
        $subject = $request->mail_subject;
        $body = $request->mail_body;
        //return $body;
        Mail::to($User['user']->email)->send(new TickteSolved($subject,$User,$body));
        return redirect('/employee/accepted/tickets');
    }
}
