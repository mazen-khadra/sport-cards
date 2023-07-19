<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class responseNullConverter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $res =  $next($request);
        $resContent = json_decode($res->getContent(), true);
        if(!empty($resContent)) {
            foreach (array_keys($resContent) as $propKey) {
                if ($resContent[$propKey] == null)
                    unset($resContent[$propKey]);
            }
            $res->setContent(json_encode($resContent));
        }
        return $res;
    }
}
