<?php
class HomeController extends Controller
{
    public $data = [];
    function index()
    {
        if (!isset($_SESSION['user_logged'])) {
            $this->data['content'] = 'AccountView/Signin';
            $this->data['sub_content'][] = '';
            $this->render('layouts/user_layout', $this->data);
        } else {
            if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
                $this->data['content'] = 'AdminHome';
                $this->data['sub_content'][] = '';
                $this->render('layouts/admin_layout', $this->data);
            } else if (isset($_SESSION['user_logged']['groups']['staff_permission'])) {
                header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
            }
        }
    }
}
