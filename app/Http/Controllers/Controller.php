<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function cons(){
        $con['chatid'] = '-914376932';
        $con['token']  = '5910980115:AAHqL9WTJlBav8Xa1_pBNzVZQChotDySnC8';
        return $con;
    }
}
