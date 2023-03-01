<?php

namespace Saladin;

abstract class Skelton
{
    protected $profile = null;
    protected $parameter = null;
    protected $V = null;
    public function __construct($parameter = null)
    {
        $this->profile = new Profile();
        $this->parameter = $parameter;
        $this->action();
        $this->frame();
    }
    abstract protected function frame();
    abstract protected function action();
}
