<?php

namespace Saladin;

class AccessManager extends Skelton
{
    protected function frame()
    {
    }
    protected function action()
    {
        session_start();
    }
    public function login()
    {
        $_SESSION['user_id'] = "Saladin";
        header('Location: test');
        exit();
    }
    public function logout()
    {
        session_destroy();
        header('Location: ./');
        exit();
    }
}
