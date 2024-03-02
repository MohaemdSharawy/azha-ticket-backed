<?php

namespace App\Http\Middleware;

use App\Models\Modules;
use App\Models\User;
use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $request->segment(1);
        $module =  Modules::where('permission_name', $url)->first();
        // dd($url);
        $user_permission =  UserPermission::where(['u_id' =>Auth::id(),  'module_id' => $module->id])->first();

        if (isset($user_permission->view)) {
            if ($user_permission->view == 1) {

                return $next($request);
            } else {
                return redirect()->back()->with(['failed_notify' => 'Sorry You Do not Have Permission!!']);
            }
        } else {
            return redirect()->back()->with(['failed_notify' => 'Sorry You Do not Have Permission!!']);
        }


        // dd($module);
    }
}
