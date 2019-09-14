<?php

namespace App\Http\Middleware;

use Closure;

class CheckCommissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        if (($request->user()->total_commissions - $request->user()->total_payments) > 400)
        {
            return responseJson(-1,'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفرة');
        }
        */
        $commission=$request->user()->orders()->where('status','delivered')->sum('commission');
        $pay_off=$request->user()->transactions()->sum('pay_off');
        $remaining=$commission-$pay_off;
        if ($remaining>=400){
            return responseJson(0,'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفره');
        }
        return $next($request);
    }
}
