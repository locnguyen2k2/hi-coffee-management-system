<?php

class HomeController extends Controller
{
    public $data = [];
    function index()
    {
        if (!isset($_SESSION['user_logged'])) {
            $this->data['content'] = 'AccountViews/signin';
            $this->data['sub_content'][] = '';
            $this->render('layouts/user_layout', $this->data);
        } else {
            if (isset($_SESSION['user_logged']['roles']['admin'])) {
                $this->data['content'] = 'HomeViews/admin_home';
                $this->data['sub_content'][] = '';
                $this->render('layouts/admin_layout', $this->data);
            } else if (isset($_SESSION['user_logged']['roles']['staff'])) {
                header('Location: ' . _WEB_ROOT . '/them-don-dat');
            }
        }
    }
}