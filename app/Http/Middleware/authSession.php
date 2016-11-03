<?php
/**
 * Created by PhpStorm.
 * User: Huyang
 * Date: 2016/10/21
 * Time: 18:03
 */

namespace App\Http\Middleware;

use App\Exceptions\ServiceException;
use App\Http\Constants\CommonExceptionConstants;
use Closure;

class authSession
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
        $data = session('User');
        if (!$data['id']) {
            if ($request->ajax() || $request->wantsJson()) {
                Throw new ServiceException(CommonExceptionConstants::getKey('no_login'));
            } else {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}