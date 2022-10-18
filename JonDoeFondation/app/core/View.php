<?php

class View
{
    private $template;

    public function __construct($template='template')
    {
        $this->template=$template;
    }

    public function render($phtmlPage,$param=[])
    {
        ob_start();
        extract($param);
        include_once BP_APP . 'view' . DIRECTORY_SEPARATOR . $phtmlPage. '.phtml';
        $content = ob_get_clean();
        include_once BP_APP . 'view' .  DIRECTORY_SEPARATOR . $this->template . '.phtml';
    }
}