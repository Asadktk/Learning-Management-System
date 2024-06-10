<?php

namespace  Http\Controllers\Admin;

class AdminController
{
    public function index()
    {
        view('admin/index.view.php', [
            'heading' => 'Home'
        ]);
    }
}
