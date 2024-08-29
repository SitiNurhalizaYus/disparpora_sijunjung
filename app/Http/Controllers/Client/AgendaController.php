<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/agenda';
        $data['og']['title'] = 'Agenda';
        $data['og']['description'] = 'Agenda';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['result'] = [];
      
       $data['agendas'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/agenda');

       return view('client.agenda.index', $data);
    }

}
