<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $model)
    {

        if ($model->all()->count() > 0)
        {
            $model = Setting::find(1);
        }

      // Setting::all();
        return view('admin.settings.edit',compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    {/*
        $models=Setting::findOrFail($id);
        return view('admin.settings.edit',compact('models'));
*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
/*        $this->validate($request,[
            'facebook'=>'url',
            'instagram'=>'url',
            'twitter'=>'url',

        ]);
        */
        if (Setting::all()->count() > 0)
        {

          /* $model= Setting::findOrFail($id);
            $model->update($request->all());*/

            Setting::find(1)->update($request->all());
            //Setting::findOrFail($id)->update($request->all());

        }else{
            Setting::create($request->all());
        }

        flash()->success('تم التعديل بنجاح');
        return back();
       // return redirect('admin/category');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
