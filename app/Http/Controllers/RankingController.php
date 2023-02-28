<?php
/**
 * author: Alexander Kuziv
 * e-mail: hola.kuziv@gmail.com 
 *  fecha: 26-02-2023
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankingController extends Controller
{
    //
    public function rankings()
    {
        //
        return view('rankings.index');
    }
}

