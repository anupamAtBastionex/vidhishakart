<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable=['user_id','order_number', 'product_name', 'product_id', 'sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon','size','color', 'quantity_selected', 'is_cache', 'gateway_order_id'];
    protected $appends = ['user_id','order_number', 'product_name', 'product_id', 'sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon', 'size', 'color', 'quantity_selected', 'is_cache', 'gateway_order_id'];
    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder()
    {
        // $data=Order::count();
        $currentDate = Carbon::now()->toDateString();
        //echo $currentDate;
        //$currentDate = "2024-01-06";
        // Get records where the date is between today from midnight to till midnight
        $count = Order::whereBetween('created_at', [$currentDate . ' 00:00:00', $currentDate . ' 23:59:59'])->count();
        if($count){
            return $count;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public static function countNewReceivedOrder(){
        $data = Order::where('status', 'new')->count();
        return $data;
    }
    public static function countProcessingOrder(){
        $data = Order::where('status', 'process')->count();
        return $data;
    }
    public static function countDeliveredOrder(){
        $data = Order::where('status', 'delivered')->count();
        return $data;
    }
    public static function countCancelledOrder(){
        $data = Order::where('status', 'cancel')->count();
        return $data;
    }


}
