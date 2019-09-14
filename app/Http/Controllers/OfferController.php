<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;
use Response;
class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::with('restaurant')->paginate(20);
        return view('admin.offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Offer;
        return view('admin.offers.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $offer = Offer::create($request->all());
        //$offer = $request->user()->offers()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => 'uploads/offers/' . $name]);
        }
        flash()->success('تم إضافة العرض بنجاح');
        return redirect('admin/offer');

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
    public function edit($id)
    {
        $model = Offer::findOrFail($id);
        return view('admin.offers.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required'
        ]);
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());

        flash()->success('تم تعديل بيانات العرض بنجاح');
        //return redirect('admin/offer/'.$id.'/edit');
        return redirect('admin/offer');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);

        //$image_path = app_path().'/uploads/offers/'.$offer->image;
       $image_path = app_path("uploads/offers/{$offer->image}");

        if (File::exists($image_path)) {
            //File::delete($image_path);
            unlink($image_path);
        }
       /*
        if(file_exists($image_path)){
            //File::delete($image_path);
            File::delete( $image_path);
        }
       */

        $offer->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
       // return redirect('admin/dashboard')->with('message','خبر موفقانه حذف  شد');

        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }

}
