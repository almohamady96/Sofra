<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function change_password()
    {
        return view('admin.users.reset_password');
    }

    public function change_password_save(Request $request)
    {
        $this->validate($request, [
            'old-password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->input('old-password'), $user->password)) {
            // The passwords match...
            $user->password = bcrypt($request->input('password'));
            $user->save();
            flash()->success('تم تحديث كلمة المرور');
            return view('admin.users.reset_password');
        }else{
            flash()->error('كلمة المرور غير صحيحة');
            return view('admin.users.reset_password');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);

        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $model)
    {
        return view('admin.users.create',compact('model'));
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
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users,email',
            //'roles_list'  => 'required'
        ]);
        $request->merge(['remember_token' => str_random(60)]);
        $request->merge(['password' => bcrypt($request->password)]);
      //  User::create($request->all());

         $user = User::create($request->except('roles_list','permissions_list'));
       // $user->roles()->attach($request->input('roles_list'));

        flash()->success('تم إضافة المستخدم بنجاح');
        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        /*
        $user = User::with('address')->findOrFail($id);
        $orders = $user->orders()->latest()->paginate(5);
        return view('admin.sushi.user',compact('user','orders'));
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('admin.users.edit',compact('model'));
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
        $this->validate($request, [
            'name' => 'required',
            'password' => 'confirmed',
            'email' => 'required|email|unique:users,email,'.$id,
            //'roles_list'  => 'required'
        ]);

        $user = User::findOrFail($id);
       // $user->roles()->sync((array) $request->input('roles_list'));
        $request->merge(['password' => bcrypt($request->password)]);
        $update = $user->update($request->all());

        flash()->success('تم تعديل بيانات المستخدم بنجاح.');
       // return redirect('admin/user/'.$id.'/edit');
       return redirect('admin/user');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
       

        return Response::json($id, 200);
    }
}
