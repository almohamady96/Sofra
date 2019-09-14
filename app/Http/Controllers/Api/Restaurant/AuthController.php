<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Mail\ResetPassword;
use App\Restaurant;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $validation=validator()->make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:restaurants,email',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'delivery_cost' => 'required|numeric',
            'min_price' => 'required|numeric',
            'whatsapp' => 'required',
            'status' => 'required|in:open,close',
            'region_id' => 'required|exists:regions,id',
            'delivery_way' => 'required',
            'categories' => 'required|array|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg',

        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $userToken = str_random(60);
        $request->merge(array('api_token' => $userToken));
        $request->merge(array('password' => bcrypt($request->password)));
        $user_restaurant = Restaurant::create($request->all());

        if ($request->has('categories')) {
            $user_restaurant->categories()->sync($request->categories);
        }
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $user_restaurant->update(['image' => 'uploads/restaurants/' . $name]);
        }
        if ($user_restaurant) {
            $data = [
                'api_token' => $userToken,
                'data' => $user_restaurant->load('region')
            ];
            return responseJson(1,'تم التسجيل بنجاح',$data);
        } else {
            return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
        }
    }


    public function login(Request $request){
        $validation=validator()->make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $user = Restaurant::where('email', $request->input('email'))->first();
        if ($user)
        {
            if (Hash::check($request->password, $user->password))
            {
//
                if ($user->status == "close")
                {
                    return responseJson(0,'الحساب موقوف .. تواصل مع الإدارة');
                }
                $data = [
                    'api_token' => $user->api_token,
                    'user' => $user->load('region'),
                ];
                return responseJson(1,'تم تسجيل الدخول',$data);
            }else{
                return responseJson(0,'بيانات الدخول غير صحيحة');
            }
        }else{
            return responseJson(0,'بيانات الدخول غير صحيحة');
        }
    }
    public  function  update_profile(Request $request){
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('restaurants')->ignore($request->user()->id),
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',

        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $loginUser = $request->user();
        $loginUser->update($request->all());
        if ($request->has('password'))
        {
           // $request->merge(array('password' => bcrypt($request->password)));
            $loginUser->password = bcrypt($request->password);

        }
        $loginUser->save();
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $request->user()->update(['image' => 'uploads/restaurants/' . $name]);
        }

        $data = [
            'user' => $request->user()->fresh()->load('region','categories')
        ];
        return responseJson(1,'تم تحديث البيانات',$data);

}
    public function reset_password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user= Restaurant::where('email',$request->email)->first();
        if ($user){
            $code = rand(111111,999999);
            $update = $user->update(['pin_code' => $code]);
            if ($update)
            {
                //send sms
                // smsMisr($request->phone,"your reset code is :".$code);
                //send email
                Mail::to($user->email)
                  //  ->bcc("almohamady1195@gmail.com")
                    ->send(new ResetPassword($user));

                return responseJson(1,'برجاء فحص هاتفك',
                    [
                        'pin_code_for_test'=>$code,
                        'mail_fails'=>Mail::failures(),
                        'email'=>$user->email,
                    ]);

            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'لا يوجد أي حساب مرتبط بهذا البريد الالكتروني');
        }
}
    public function new_password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code' => 'required',
            'password' => 'confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Restaurant::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

        if ($user)
        {
            $update = $user->update(['password' => bcrypt($request->password), 'pin_code' => null]);
            if ($update)
            {
                return responseJson(1,'تم تغيير كلمة المرور بنجاح');
            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'هذا الكود غير صالح');
        }
    }

    public function register_token(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'platform'  => 'required|in:android,ios',
            'token' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }

    public function remove_token(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        return responseJson(1, 'تم الحذف بنجاح بنجاح');
    }







}


