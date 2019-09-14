<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $restaurants = Restaurant::where(function ($q) use ($request) {


            if ($request->has('name')) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }

            if ($request->has('city_id')) {
                $q->whereHas('region',function ($q2) use($request){
                    // search in restaurant region "Region" Model
                    $q2->whereCityId($request->city_id);
                });
            }

            if ($request->has('status')) {
                $q->where('status',$request->status);
            }


        })->with('region.city')->latest()->paginate(20);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $model)
    {
        return view('admin.restaurants.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
            'address' => 'required',
          //  'latitude' => 'required',
            //'longitude' => 'required',
            'region_id' => 'required'
        ]);
        $restaurant = Restaurant::create($request->all());
        if ($request->hasFile('logo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('logo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $restaurant->logo = 'uploads/restaurants/' . $name;
            $restaurant->save();
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $path = public_path();
                $destinationPath = $path . '/uploads/restaurants/'; // upload path
                $extension = $img->getClientOriginalExtension(); // getting image extension
                $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
                $img->move($destinationPath, $name); // uploading file to given path
                $restaurant->image()->create(['url' => 'uploads/restaurants/' . $name]);
            }
        }
        if ($request->has('regions_list')) {
            $restaurant->delivery_regions()->attach($request->regions_list);
        }

        if ($request->has('categories_list')) {
            $restaurant->categories()->sync($request->categories_list);
        }

        if ($request->has('weekdays')) {
            foreach ($request->weekdays as $key => $value) {
                $restaurant->working_times()->create([
                    'weekday' => $request->weekdays[$key],
                    'opening' => str_replace(' ', '', $request->from[$key]),
                    'closing' => str_replace(' ', '', $request->to[$key])
                ]);
            }
        }


        flash()->success('تم إضافة المطعم بنجاح');
        return redirect('admin/restaurant');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($model)
    {
        return view('admin.restaurants.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurant)
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'region_id' => 'required'
        ]);


        $restaurant->update($request->all());

        if ($request->hasFile('logo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('logo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $restaurant->update(['logo' => 'uploads/restaurants/' . $name]);
        }

        if ($request->hasFile('photos')) {
//            $restaurant->photos()->delete();
            foreach ($request->file('photos') as $photo) {
                $path = public_path();
                $destinationPath = $path . '/uploads/restaurants/'; // upload path
                $extension = $photo->getClientOriginalExtension(); // getting image extension
                $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
                $photo->move($destinationPath, $name); // uploading file to given path
                $restaurant->photos()->create(['url' => 'uploads/restaurants/' . $name]);
            }
        }

        if ($request->has('regions_list')) {
            $restaurant->delivery_regions()->attach($request->regions_list);
        }

        if ($request->has('categories_list')) {
            $restaurant->categories()->sync($request->categories_list);
        }
        if ($request->has('weekdays')) {
            $restaurant->working_times()->delete();
            foreach ($request->weekdays as $key => $value) {
                $restaurant->working_times()->create([
                    'weekday' => $request->weekdays[$key],
                    'opening' => str_replace(' ', '', $request->from[$key]),
                    'closing' => str_replace(' ', '', $request->to[$key])
                ]);
            }
        }

        flash()->success('تم تعديل بيانات المطعم بنجاح.');
        return redirect('admin/restaurant/' . $restaurant->id . '/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
       // $count = $restaurant->orders()->count();
        //if ($count > 0)
        if (count($restaurant->orders) > 0) {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن حذف المطعم ، لان به طلبات مسجلة',
                'id' => $restaurant->id
            ];
            return Response::json($data, 200);
        }

        $restaurant->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $restaurant->id
        ];
        return Response::json($data, 200);
    }
    public function activate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->activated = 1;
        $restaurant->status = 'open';
        $restaurant->save();
        flash()->success('تم التفعيل');
        return back();
    }

    public function de_activate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->activated = 0;
        $restaurant->status = 'close';
        $restaurant->save();
        flash()->success('تم الإيقاف');
        return back();
    }
}
