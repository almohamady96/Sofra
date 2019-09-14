<?php

namespace App\Http\Controllers\Api\Client;

use App\Client;
use App\Item;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function new_order(Request $request)
    {
//        return $request->all();
        $validation = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'items' => 'required|array',
            'items.*' => 'required|exists:items,id',
            'quantity' => 'required|array',
            'notes' => 'required|array',
            'address' => 'required',
            'payment_id' => 'required|exists:payments,id',
            'status'=>'required',
            //            'need_delivery_at' => 'required|date_format:Y-m-d',// H:i:s
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        // restaurant closed
        if ($restaurant->status == 'close') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }
        // client
        // set defaults
        // dd($request->all());
        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'note' => $request->note,
         //   'status' => 'pending', // db default
            'status' => $request->status,
            'address' => $request->address,
            'payment_id' => $request->payment_id,
        ]);
        $cost = 0;
        $delivery_cost = $restaurant->delivery_cost;
        if ($request->has('items')) {
            $counter = 0;
            foreach ($request->items as $itemId) {
                $item = Item::find($itemId);
                $order->items()->attach([
                    $itemId => [
                        'quantity' => $request->quantity[$counter],
                        'price' => $item->price,
                        'note' => $request->notes[$counter],
                    ]
                ]);
                $cost += ($item->price * $request->quantity[$counter]);
                $counter++;
            }
        }
        // minimum charge
        if ($cost >= $restaurant->min_price) {
            $total = $cost + $delivery_cost; // 200 SAR
            $commission = settings()->commission * $cost; // 20 SAR  // 10 // 0.1  // $total; edited to remove delivery cost from percent.
            $net = $total - settings()->commission;
            $update = $order->update([
                'cost' => $cost,
                'delivery_cost' => $delivery_cost,
                'total' => $total,
                'commission' => $commission,
                'net' => $net,
            ]);
            /*
            $order->total=$total;
            $order->commission=$commission;
            $order->net=$net;
            $order->save();
            */
            $request->user()->cart()->detach();
            //Notificatios
            $notification = $restaurant->notifications()->create([
                'title' => 'لديك طلب جديد',
                'title_en' => 'you have new_order',
                'content' => $request->user()->name . 'لديك طلب جديد من العميل ',
                'action' => 'new-order',
                'order_id' => $order->id,
                'client_id' => $request->user()->id,

            ]);
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            //info("tokens result: " . json_encode($tokens));
            if (count($tokens)) {
                public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                ];
                $send = notifyByFirebase($title, $content, $tokens, $data);
                info("firebase result: " . $send);
            }
            /* notification */
            $data = [
                'order' => $order->fresh()->load('items', 'restaurant.region', 'restaurant.categories', 'client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
            ];
            return responseJson(1, 'تم الطلب بنجاح', $data);
        } else {
            $order->items()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $restaurant->min_price . ' ريال');
        }
    }


    public function my_orders(Request $request)
    {
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('status') && $request->status == 'completed') {
                $order->where('status', '!=', 'pending');
            } elseif ($request->has('status') && $request->status == 'current') {
                $order->where('status', '=', 'pending');
            }
        })->with('restaurant', 'items')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function show_order(Request $request)
    {
        $order = Order::with('restaurant', 'items')->find($request->order_id);
        return responseJson(1, 'تم التحميل', $order);
    }

    public function latest_order(Request $request)
    {
        $order = $request->user()->orders()
            ->with('restaurant', 'items')
            ->latest()
            ->first();
        if ($order) {
            return responseJson(1, 'تم التحميل', $order);
        }
        return responseJson(0, 'لا يوجد');
    }

    public function confirm_order(Request $request){

        $order = $request->user()->orders()->find($request->order_id);

        if (!$order) {
            return responseJson(0, 'لايوجد طلبات بهذه البيانات');
        }
        elseif ($order->status != 'accepted') {

            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        else {

            $order->update(['status' => 'delivered']);

            //           $client = Client::find($order->client_id);
           // $client =$order->client;
            $restraunt =$order->restaurant;
            $notification = $restraunt->notifications()->create([

                'title' => 'تم تأكيد توصيل طلبك',
                'content' => 'رقم طلبك' . $request->order_id,
                'title_en' => 'Your order is delivered from client',
                'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
                'order_id' => $request->order_id,

            ]);

            $token = $restraunt->tokens()->where('token', '!=', '')->pluck('token')->toArray();

            if (count($token)) {
                //public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'client',
                ];
                $send = notifyByFirebase($title, $content, $token, $data);
                info("firebase result: " . $send);

            }
            return responseJson(1, 'تم تأكيد الاستلام');

        }


    }

/*
    public function confirm_order(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->status != 'accepted') {
            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ، لم يتم قبول الطلب');
        }

        $order->update(['status' => 'delivered']);
        $restaurant = $order->restaurant;
        $restaurant->notifications()->create([
            'title' => 'تم تأكيد توصيل طلبك من العميل',
            'title_en' => 'Your order is delivered from client',
            'content' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
            'order_id' => $request->order_id,
        ]);

        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();

        if (count($tokens)) {
            public_path();
            $title = $restaurant->notifications->title;
            $content = [
                'en' => 'Order no. ' . $request->order_id . ' is delivered to client',
                'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            ];
            $data = [
                'user_type' => 'restaurant',
                'action' => 'confirm-order-delivery',
                'order_id' => $request->order_id,
            ];
            $send = notifyByFirebase($title, $content, $tokens, $data);
            info("firebase result: " . $send);
        }

       $send = json_decode($send);

        return responseJson(1, 'تم تأكيد الاستلام');
    }
*/
/*
    public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ، لم يتم قبول الطلب');
        }
        if ($order->delivery_confirmed_by_client == 1) {
            return responseJson(1, 'تم تأكيد الاستلام');
        }
        $order->update(['state' => 'delivered']);
        $restaurant = $order->restaurant;
        $restaurant->notifications()->create([
            'title'      => 'تم تأكيد توصيل طلبك من العميل',
            'title_en'   => 'Your order is delivered to client',
            'content'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
            'order_id'   => $request->order_id,
        ]);

        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. ' . $request->order_id . ' is delivered to client',
            'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
        ];
        $send = notifyByOneSignal($audience, $contents, [
            'user_type' => 'restaurant',
            'action'    => 'confirm-order-delivery',
            'order_id'  => $request->order_id,
        ]);
        $send = json_decode($send);

        return responseJson(1, 'تم تأكيد الاستلام');
    }
*/
    //'canceled'
    public function decline_order(Request $request){
        $order=$request->user()->orders()->find($request->order_id);
        if (!$order){
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->status!='accepted'){
            return responseJson(0, 'لا يمكن رفض استلام الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['status'=>'declined']);

       // $restraunt=Restaurant::find($order->restaurant_id);
        $restraunt =$order->restaurant;
        $notification= $restraunt->notifications()->create([
            'title'=>'تم الغاء الطلب من العميل',
            'content'=>'الطلب رقم'.$request->order_id,
            'title_en' => 'Your order is canceled from client',
            'content_en' => 'Order no. ' . $request->order_id . ' is canceled to client',
            'order_id' => $request->order_id,
        ]);
        $token=$restraunt->tokens()->where('token','!=','')->pluck('token')->toArray();
        if (count($token)){
            public_path();
            $title = $notification->title;
            $content = $notification->content;
            $data =[
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title , $content , $token,$data);
            info("firebase result: " . $send);
            return responseJson(1,'تم الغاء الطلب من العميل');
        }
    }


        /*
         *  public function declineOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن رفض استلام الطلب ، لم يتم قبول الطلب');
        }
        if ($order->delivery_confirmed_by_client == -1) {
            return responseJson(1, 'تم رفض استلام الطلب');
        }
        $order->update(['state' => 'declined']);
        $restaurant = $order->restaurant;
        $restaurant->notifications()->create([
            'title'      => 'تم رفض توصيل طلبك من العميل',
            'title_en'   => 'Your order delivery is declined by client',
            'content'    => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'content_en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
            'order_id'   => $request->order_id,
        ]);

        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
            'ar' => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
        ];
        $send = notifyByOneSignal($audience, $contents, [
            'user_type' => 'restaurant',
            'action'    => 'decline-order-delivery',
            'order_id'  => $request->order_id,
        ]);
        $send = json_decode($send);

        return responseJson(1, 'تم رفض استلام الطلب');
    }
        */


    public function review(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'rate'          => 'required',
            'comment'       => 'required',
            'restaurant_id' => 'required|exists:restaurants,id',

        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $restaurant = Restaurant::find($request->restaurant_id);
        if (!$restaurant) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $request->merge(['client_id' => $request->user()->id]);
        $clientOrdersCount = $request->user()->orders()
            ->where('restaurant_id', $restaurant->id)
            ->where('status', 'accepted')
            ->count();
        if ($clientOrdersCount == 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد تنفيذ طلب من المطعم');
        }
        $checkOrder = $request->user()->orders()
            ->where('restaurant_id', $restaurant)
            ->where('status', 'accepted')
            ->count();
        if ($checkOrder > 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد بيان حالة استلام الطلب');
        }
        $review = $restaurant->rates()->create($request->all());
        return responseJson(1, 'تم التقييم بنجاح', [
            'review' => $review
        ]);

    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $notifications);
    }
}
