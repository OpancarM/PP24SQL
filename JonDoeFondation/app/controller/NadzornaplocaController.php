<?php

class NadzornaplocaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'nadzornaPloca',[
            'css'=>'<link rel="stylesheet" href="' . App::config('url') . 'public/css/nadzornaploca.css">',
    
        ]);
    }
}