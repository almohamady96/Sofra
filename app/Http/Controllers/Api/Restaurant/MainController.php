<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function new_item(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'prepare_time' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $item = $request->user()->items()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/items/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $item->update(['image' => 'uploads/items/' . $name]);
        }

        return responseJson(1,'تم الاضافة بنجاح',$item);
    }
    public function update_item(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'prepare_time' => 'required',
            'image' => 'image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $item = $request->user()->items()->find($request->item_id);
        if (!$item)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $item->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/items/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $item->update(['image' => 'uploads/items/' . $name]);
        }

        return responseJson(1,'تم التعديل بنجاح',$item);
    }
    public function delete_item(Request $request)
    {
        $item = $request->user()->items()->find($request->item_id);
        if (!$item)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        if (count($item->orders) > 0)
        {
            $item->update(['disabled' => 1]);
            return responseJson(1,'تم الحذف بنجاح');
          //     return responseJson(0,'لا يمكن مسح الصنف ، يوجد طلبات مرتبطة به');
        }

        $item->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }

    public function ShowInformation(Request $request){
        /*$validation=validator()->make($request->all(),[
            'restaurant_id'=>'required',
        ]);
        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }*/
        $show = Restaurant::with('region.city')->find($request->restaurant_id);
        return responseJson(1,'information about Restraunt',$show);
        /* $show=Restaurant::select('id','status','min_price','delivery_cost')->where('id',$request->user()->id)->get();
          $region=$request->user()->region()->pluck('regions.name')->toArray();
          $city=$request->user()->region->city->pluck('cities.name');*/

        if ($show){
            return responseJson(1,"information about Restraunt",compact('show','region','city'));
        }
        else{
            return responseJson(0,"لا يوجد معلومات لنشرها ");
        }
    }


    public function my_items(Request $request)
    {
      //  $item = $request->user()->items()->enabled()->latest()->paginate(20);
        $item = $request->user()->items()->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$item);
    }

    public function new_offer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'start_from' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d',
            'image' => 'required|image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $offer = $request->user()->offers()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => 'uploads/offers/' . $name]);
        }

        return responseJson(1,'تم الاضافة بنجاح',$offer);
    }
    public function update_offer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'start_from' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d',
            'image' => 'image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $offer->update($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => 'uploads/offers/' . $name]);
        }

        return responseJson(1,'تم التعديل بنجاح',$offer);
    }

    public function delete_offer(Request $request)
    {
        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $offer->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }
    public function my_offers(Request $request)
    {
        $offers = $request->user()->offers()->with('restaurant')->latest()->paginate(20);
        return responseJson(1,'',$offers);
    }
    public function change_status(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'status' => 'required|in:open,close'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $request->user()->update(['status' => $request->status]);

        return responseJson(1,'',$request->user());

    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$notifications);
    }

    public function commissions(Request $request)
    {
        /*
        $count = $request->user()->orders()->where('status','accepted')->where(function($q){
            $q->where('status','delivered');
        })->count();

        $total = $request->user()->orders()->where('status','accepted')->where(function($q){
            $q->where('status','delivered');
        })->sum('total');

        $commissions = $request->user()->orders()->where('status','accepted')->where(function($q){
            $q->where('status','delivered');
        })->sum('commission');

        $payments = $request->user()->transactions()->sum('amount');

        $net_commissions = $commissions - $payments;

        $commission = settings()->commission;

        return responseJson(1,'',compact('count','total','commissions','payments','net_commissions','commission'));
    */
        $count=$request->user()->orders()->where('status','delivered')->count();
        $total=$request->user()->orders()->where('status','delivered')->sum('total');
        $commission=$request->user()->orders()->where('status','delivered')->sum('commission');
        $pay_off=$request->user()->transactions()->sum('pay_off');
        $remaining=$commission-$pay_off;
        return responseJson(1,'',compact('count','total','commission','pay_off','remaining'));
        }

    public function my_orders(Request $request)
    {
        $orders = $request->user()->orders()->where(function($order) use($request){
            if ($request->has('status') && $request->status == 'completed')
            {
                $order->where('status' , '!=' , 'pending');
            }elseif ($request->has('status') && $request->status == 'current')
            {
                $order->where('status' , '=' , 'accepted');
            }elseif ($request->has('status') && $request->status == 'pending')
            {
                $order->where('status' , '=' , 'pending');
            }
        })->with('client','items','restaurant')->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$orders);
    }

    public function show_order(Request $request)
    {
        $order= Order::with('items','client','restaurant')->find($request->order_id);
        return responseJson(1,'تم التحميل',$order);
    }
    /*
    public function acceptOrder(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'accepted')
        {
            return responseJson(1,'تم قبول الطلب');
        }
        $order->update(['state' => 'accepted']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم قبول طلبك',
            'title_en' => 'Your order is accepted',
            'content' => 'تم قبول الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is accepted',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is accepted',
            'ar' => 'تم قبول الطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'accept-order',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم قبول الطلب');
    }
*/
    public function accept_order(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->status == 'accepted')
        {
            return responseJson(1,'تم قبول الطلب');
        }
        $order->update(['status' => 'accepted']);
        $client = $order->client;
        // $client=Client::find($order->client_id);
        //dd($client);
        $client->notifications()->create([
            'title' => 'تم قبول طلبك',
            'title_en' => 'Your order is accepted',
            'content' => 'تم قبول الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is accepted',
            'order_id' => $request->order_id,

        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //info("tokens result: " . json_encode($tokens));
        if (count($tokens)) {
            public_path();
            $title = $client->notifications()->title;
            $content = [
                'en' => 'Order no. '.$request->order_id.' is accepted',
                'ar' => 'تم قبول الطلب رقم '.$request->order_id,
            ];
            $data = [
                'user_type' => 'client',
                'action' => 'accept-order',
                //'order_id' => $order->id,
                'order_id' => $request->order_id,
                'restaurant_id' => $request->user()->id,
            ];
            $send = notifyByFirebase($title, $content, $tokens, $data);
            info("firebase result: " . $send);
        }
        /* notification */
        //  $data = [
        //    'order' => $order->fresh()->load('items', 'restaurant.region', 'restaurant.categories', 'client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
        //];

        return responseJson(1,'تم قبول الطلب');

    }
/*
    public function rejectOrder(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'rejected')
        {
            return responseJson(1,'تم رفض الطلب');
        }
        $order->update(['state' => 'rejected']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم رفض طلبك',
            'title_en' => 'Your order is rejected',
            'content' => 'تم رفض الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is rejected',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is rejected',
            'ar' => 'تم رفض الطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'reject-order',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم رفض الطلب');
    }
    */

    public function reject_order(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->status == 'rejected')
        {
            return responseJson(1,'تم رفض الطلب');
        }
        $order->update(['status' => 'rejected']);
        $client = $order->client;
        //            $client = Client::find($order->client_id);
        $client->notifications()->create([
            'title' => 'تم رفض طلبك',
            'title_en' => 'Your order is rejected',
            'content' => 'تم رفض الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is rejected',
            'order_id' => $request->order_id,

        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //info("tokens result: " . json_encode($tokens));
        if (count($tokens)) {
            public_path();
            $title = $client->notifications()->title;
            $content = [
                'en' => 'Order no. '.$request->order_id.' is rejected',
                'ar' => 'تم رفض الطلب رقم '.$request->order_id,
            ];
            $data = [
                'user_type' => 'client',
                'action' => 'reject-order',
                'order_id' => $request->order_id,
                'restaurant_id' => $request->user()->id,
            ];
            $send = notifyByFirebase($title, $content, $tokens, $data);
            info("firebase result: " . $send);
        }
        /* notification */
        //  $data = [
        //    'order' => $order->fresh()->load('items', 'restaurant.region', 'restaurant.categories', 'client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
        //];

        return responseJson(1,'تم رفض الطلب');

    }
    /*
     *  public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state != 'accepted')
        {
            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'delivered']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم تأكيد توصيل طلبك',
            'title_en' => 'Your order is delivered',
            'content' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is delivered to you',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is delivered to you',
            'ar' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'confirm-order-delivery',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم تأكيد الاستلام');
    }
     *
     */

    public function confirm_order(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->status != 'accepted')
        {
            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['status' => 'delivered']);
        $client = $order->client;
        //            $client = Client::find($order->client_id);
        $client->notifications()->create([
            'title' => 'تم تأكيد توصيل طلبك',
            'title_en' => 'Your order is delivered',
            'content' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is delivered to you',
            'order_id' => $request->order_id,

        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //info("tokens result: " . json_encode($tokens));
        if (count($tokens)) {
            public_path();
            $title = $client->notifications()->title;
            $content = [
                'en' => 'Order no. '.$request->order_id.' is delivered to you',
                'ar' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            ];
            $data = [
                'user_type' => 'client',
                'action' => 'confirm-order-delivery',
                'order_id' => $request->order_id,
                'restaurant_id' => $request->user()->id,
            ];
            $send = notifyByFirebase($title, $content, $tokens, $data);
            info("firebase result: " . $send);
        }
        /* notification */
        //  $data = [
        //    'order' => $order->fresh()->load('items', 'restaurant.region', 'restaurant.categories', 'client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
        //];

        return responseJson(1,'تم تأكيد الاستلام');

    }




}
