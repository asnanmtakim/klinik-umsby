<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaksosServiceModel;
use App\Models\BaksosRegistrationModel;

class Baksos extends BaseController
{
    public function index()
    {
        $serviceModel = new BaksosServiceModel();
        $data['services'] = $serviceModel->getServicesWithRemainingQuota();
        $data['is_closed'] = (date('Y-m-d') > '2026-07-01');
        return view('baksos/register', $data);
    }

    public function store()
    {
        if (date('Y-m-d') > '2026-07-01') {
            return redirect()->back()->with('error', 'Mohon maaf, pendaftaran Bakti Sosial telah ditutup.');
        }

        $validationRules = [
            'nama_lengkap' => 'required|max_length[150]',
            'nik'          => [
                'rules'  => 'required|max_length[16]|is_unique[baksos_registrations.nik]',
                'errors' => [
                    'required'  => 'NIK wajib diisi.',
                    'is_unique' => 'Mohon maaf, NIK ini sudah terdaftar sebelumnya.'
                ]
            ],
            'umur'         => 'required|is_natural_no_zero',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'no_hp'        => 'required|max_length[20]',
            'alamat'       => 'required',
            'service_id'   => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $serviceId = $this->request->getPost('service_id');
        $serviceModel = new BaksosServiceModel();
        $service = $serviceModel->getServiceWithQuota($serviceId);

        if (!$service) {
            return redirect()->back()->withInput()->with('error', 'Layanan tidak ditemukan.');
        }

        if ($service['sisa_kuota'] <= 0) {
            return redirect()->back()->withInput()->with('error', 'Mohon maaf, kuota untuk layanan ini sudah penuh.');
        }

        $registrationModel = new BaksosRegistrationModel();
        $registrationModel->insert([
            'baksos_service_id' => $serviceId,
            'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
            'nik'               => $this->request->getPost('nik'),
            'umur'              => $this->request->getPost('umur'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'no_hp'             => $this->request->getPost('no_hp'),
            'alamat'            => $this->request->getPost('alamat'),
        ]);

        return redirect()->to(url_to('baksos-success'))->with('message', 'Pendaftaran berhasil! Terima kasih telah berpartisipasi.');
    }

    public function success()
    {
        return view('baksos/success');
    }
}
