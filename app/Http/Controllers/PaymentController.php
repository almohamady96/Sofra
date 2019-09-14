<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::paginate(20);
        return view('admin.payments.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Payment;
        return view('admin.payments.create',compact('model'));
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
        Payment::create($request->all());
        flash()->success('تمت الإضافة بنجاح');
        return redirect('admin/payment');
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
        $model = Payment::findOrFail($id);
        return view('admin.payments.edit',compact('model'));
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
            'name' => 'required',
        ]);
        Payment::findOrFail($id)->update($request->all());
        flash()->success('تم التعديل بنجاح');
        return redirect('admin/payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Payment::findOrFail($id);
        $count = $record->orders()->count();
        if ($count > 0)
        {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن مسح التصنيف ، يوجد مطاعم مسجلة به'
            ];
            return Response::json($data, 200);
        }
        $record->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }
}
