<?php

namespace App\Http\Controllers;

use App\Item;
use App\Restaurant;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Restaurant $restaurant)
    {
        $items = $restaurant->items()->paginate(20);
        return view('admin.items.index',compact('items','restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Item $model,Restaurant $restaurant)
    {
        return view('admin.items.create',compact('model','restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Restaurant $restaurant)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $item = Item::create($request->all());
        if ($request->hasFile('photo'))
        {
            $photo = $request->file('image');
            $destinationPath = public_path().'/uploads/items';
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111,99999).'.'.$extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given
            $item->image =  'uploads/items/'.$name;
            $item->save();
        }

        flash()->success('تم إضافة الصنف بنجاح');
        return redirect('admin/'.$restaurant->id.'/item');

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
    public function edit(Restaurant $restaurant,Item $model)
    {
        return view('admin.items.edit',compact('model','restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,Restaurant $restaurant, $item )
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
           // 'section_id' => 'required'
        ]);

        $item->update($request->all());
        if ($request->hasFile('image'))
        {
            $photo = $request->file('image');
            $destinationPath = public_path().'/uploads/items';
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111,99999).'.'.$extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given
            $item->image =  'uploads/items/'.$name;
            $item->save();
        }

        flash()->success('تم تعديل بيانات الصنف بنجاح.');
        return redirect('admin/'.$restaurant->id.'/item/'.$item->id.'/edit');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant ,$item)
    {
        // to do
        // delete addons and options
        $item ->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();

        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $item->id
        ];
        return Response::json($data, 200);
    } //
    public function duplicate(Request $request, $restaurant, $item)
    {
        $addons = $item->addons;
        $newItem = $item->replicate();
        $newItem->save();
        foreach ($addons as $addon)
        {
            $newAddon = $addon->replicate();
            $newAddon->item_id = $newItem->id;
            $newAddon->save();

            $options = $addon->options;

            foreach ($options as $option)
            {
                $newOption = $option->replicate();
                $newOption->addon_id = $newAddon->id;
                $newOption->save();
            }
        }

        flash()->success('تم نسخ بيانات الصنف بنجاح.');
        return back();
    }

}
