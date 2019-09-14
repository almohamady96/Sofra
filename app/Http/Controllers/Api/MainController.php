<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\City;
use App\Contact;
use App\Item;
use App\Offer;
use App\Payment;
use App\Region;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function categories(Request $request)
    {
        $categories = Category::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->paginate(10);
        return responseJson(1,'تم التحميل',$categories);
    }
    /*
    public function categories()
    {
        $categories = Category::all();
        return responseJson(1,'تم التحميل',$categories);
    }
    */
    public function cities(Request $request)
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->paginate(10);
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regions(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->paginate(10);
        return responseJson(1,'تم التحميل',$regions);
    }
/*
    public function  regions(Request $request){

        $cities=Region::where(function ($query) use($request){
            if($request->has('city_id'))
            {
                $query->where('city_id',$request->city_id);
            }
            if ($request->has('name')){
                $query->where('name','LIKE','%'.$request->name.'%');
            }
        })->get();
        return responseJson(1,"success",$cities);
    }
*/
    public function citiesNotPaginated(Request $request)
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->get();
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regionsNotPaginated(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }

    public function ajax_region(Request $request)
    {
        $regions = Region::where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }

    public function payment_methods()
    {
        $methods = PaymentMethod::all();
        return responseJson(1,'تم التحميل',$methods);
    }

    public function restaurants(Request $request)
    {
        $restaurants = Restaurant::where(function($q) use($request) {
            if ($request->has('keyword'))
            {
                $q->where(function($q2) use($request){
                    $q2->where('name','LIKE','%'.$request->keyword.'%');
                });
            }

            if ($request->has('region_id'))
            {
                $q->where('region_id',$request->region_id);
            }

            if ($request->has('categories'))
            {
                $q->whereHas('categories',function($q2) use($request){
                    $q2->whereIn('categories.id',$request->categories);
                });
            }

            if ($request->has('status'))
            {
                $q->where('status',$request->status);
            }


        })->has('items')->with('region', 'categories')->paginate(10);
        return responseJson(1,'تم التحميل',$restaurants);
        /*
         *->orderByRating()
         * ->sortByDesc(function ($restaurant) {
            return $restaurant->reviews->sum('rate');
        })
         * */

    }

    public function restaurant(Request $request)
    {
        $restaurant = Restaurant::with('region','categories')->activated()->findOrFail($request->restaurant_id);

        return responseJson(1,'تم التحميل',$restaurant);

    }

    public function items(Request $request)
    {
        $items = Item::where('restaurant_id',$request->restaurant_id)->enabled()->paginate(20);
        return responseJson(1,'تم التحميل',$items);
    }

    public function offers(Request $request)
    {
        $offers = Offer::where(function($offer) use($request){
            if($request->has('restaurant_id'))
            {
                $offer->where('restaurant_id',$request->restaurant_id);
            }
        })->has('restaurant')->with('restaurant')->latest()->paginate(20);
        return responseJson(1,'',$offers);
    }

    public function offer(Request $request)
    {
        $offer = Offer::with('restaurant')->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'no data');
        }
        return responseJson(1,'',$offer);
    }


    public function reviews(Request $request)
    {
        $restuarant = Restaurant::find($request->restaurant_id);
        if (!$restuarant)
        {
            return responseJson(0,'no data');
        }
        $reviews = $restuarant->rates()->paginate(10);
        return responseJson(1,'',$reviews);

    }

    public function contact(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'status' => 'required|in:complaint,suggestion,inquiry',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'notes' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Contact::create($request->all());

        return responseJson(1,'تم الارسال بنجاح');
    }

    public function settings()
    {
        return responseJson(1,'',settings());
    }

    public function payments()
    {
        $methods = Payment::all();
        return responseJson(1,'تم التحميل',$methods);
    }

}
