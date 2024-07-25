<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;

class AutoCreateLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $req = [
            'fingerprint' => $request->fingerprint(),
            'method' => $request->method(),
            'fullurl' => $request->fullUrl(),
            'path' => $request->path(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'os' => Agent::platform(),
            'os_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
            'device' => Agent::device(),
            'is_desktop' => Agent::isDesktop(),
            'is_mobile' => Agent::isPhone(),
            'is_tablet' => Agent::isTablet(),
            'ip' => $request->ip(),
            'country_code' => '',
            'country_name' => '',
            'region_code' => '',
            'region_name' => '',
            'city_code' => '',
            'city_name' => '',
            'zip_code' => '',
            'latitude' => '',
            'longitude' => '',
        ];

        if($request->ip() != '127.0.0.1') {
            $position = Location::get($request->ip());
            if ($position) {
                $req['country_code'] = $position->countryCode;
                $req['country_name'] = $position->countryName;
                $req['region_code'] = $position->regionCode;
                $req['region_name'] = $position->regionName;
                $req['city_code'] = '';
                $req['city_name'] = $position->cityName;
                $req['zip_code'] = $position->zipCode;
                $req['latitude'] = $position->latitude;
                $req['longitude'] = $position->longitude;
            }
        }

        $data = \App\Models\Log::create($req);
        return $next($request);
    }
}
