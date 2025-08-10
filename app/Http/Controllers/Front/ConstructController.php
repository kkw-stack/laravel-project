<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class ConstructController extends Controller
{
    #[Get('construct/seongok-seowon', 'ko.construct.seongok-seowon')]
    #[Get('en/construct/seongok-seowon', 'en.construct.seongok-seowon')]
    public function seongok_seowon(Request $request)
    {
        return view('front.construct.seongok-seowon', []);
    }

    #[Get('construct/visitor-center', 'ko.construct.visitor-center')]
    #[Get('en/construct/visitor-center', 'en.construct.visitor-center')]
    public function visitor_center(Request $request)
    {
        return view('front.construct.visitor-center', []);
    }

    #[Get('construct/pezo-restaurant', 'ko.construct.pezo-restaurant')]
    #[Get('en/construct/pezo-restaurant', 'en.construct.pezo-restaurant')]
    public function pezo_restaurant(Request $request)
    {
        return view('front.construct.pezo-restaurant', []);
    }
}
