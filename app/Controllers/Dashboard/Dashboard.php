<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use App\Models\BaksosServiceModel;
use App\Models\BaksosRegistrationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $baksosService = new BaksosServiceModel();
        $baksosRegistration = new BaksosRegistrationModel();

        $totalRegistrations = $baksosRegistration->countAllResults();
        $totalServices = $baksosService->countAllResults();

        $services = $baksosService->findAll();
        $totalQuota = 0;
        foreach ($services as $service) {
            $totalQuota += $service['kuota'];
        }

        $kesiapanKuota = 100;
        if ($totalQuota > 0) {
            $remainingQuota = $totalQuota - $totalRegistrations;
            if ($remainingQuota < 0) $remainingQuota = 0;
            $kesiapanKuota = round(($remainingQuota / $totalQuota) * 100);
        } else {
            $kesiapanKuota = 0;
        }

        $this->dataView['totalRegistrations'] = $totalRegistrations;
        $this->dataView['totalServices'] = $totalServices;
        $this->dataView['kesiapanKuota'] = $kesiapanKuota;

        return view('dashboard/index', $this->dataView);
    }
}
