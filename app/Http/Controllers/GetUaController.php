<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetUaController extends Controller
{
    public function __invoke()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (((strpos($ua, 'iPhone') == true) || (strpos($ua, 'iPod') == true) || (strpos($ua, 'Android') == true))) {
            $user_agent = 'false';
        } else {
            $user_agent = 'true';
        }

        return $user_agent;
    }
}
