<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Settings extends BaseController
{
    public function index()
    {
        return view('dashboard/settings/index', $this->dataView);
    }
}
