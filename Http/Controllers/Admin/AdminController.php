<?php

namespace  Http\Controllers\Admin;

class AdminController
{
    public function index()
    {
        view('index.view.php', [
            'heading' => 'Home'
        ]);
    }
}
