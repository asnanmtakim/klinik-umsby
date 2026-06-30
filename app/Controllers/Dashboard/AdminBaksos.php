<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BaksosServiceModel;
use App\Models\BaksosRegistrationModel;
use Hermawan\DataTables\DataTable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminBaksos extends BaseController
{
    // ==========================================
    // SERVICES MANAGEMENT
    // ==========================================
    public function services()
    {
        return view('dashboard/baksos/services', $this->dataView);
    }

    public function servicesAll()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('baksos_services s')
            ->select('s.id, s.nama_pelayanan, s.kuota, s.deskripsi, s.created_at, (s.kuota - COALESCE(r.used_quota, 0)) as sisa_kuota')
            ->join('(SELECT baksos_service_id, COUNT(id) as used_quota FROM baksos_registrations GROUP BY baksos_service_id) r', 'r.baksos_service_id = s.id', 'left');

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {})
            ->postQuery(function ($builder) {
                $builder->orderBy('s.created_at', 'ASC');
            })
            ->addNumbering('no')
            ->add('action', function ($row) {
                // if (auth()->user()->can('admin.baksos.manage')) // Use session filter since permissions were removed
                $editBtn = '<button class="btn btn-warning btn-sm action-edit" data-id="' . $row->id . '" data-name="' . $row->nama_pelayanan . '" data-url="' . url_to('admin-baksos-services-one') . '" title="Edit"><i class="ri-file-edit-line fs-14 align-middle"></i></button>';
                $deleteBtn = '<button class="btn btn-danger btn-sm action-delete ms-1" data-id="' . $row->id . '" data-name="' . $row->nama_pelayanan . '" data-url="' . url_to('admin-baksos-services-delete') . '" title="Hapus"><i class="ri-delete-bin-line fs-14 align-middle"></i></button>';
                return $editBtn . $deleteBtn;
            })
            ->toJSON(true);
    }

    public function servicesOne()
    {
        $id = $this->request->getPost('id');
        $baksosServiceModel = new BaksosServiceModel();
        $check = $baksosServiceModel->find($id);

        if (empty($check)) {
            return $this->response->setJSON(['status' => 0, 'pesan' => lang('App.dashboard.404data')]);
        } else {
            return $this->response->setJSON(['status' => 200, 'data' => $check]);
        }
    }

    public function servicesSave()
    {
        $baksosServiceModel = new BaksosServiceModel();
        $rules = [
            'nama_pelayanan' => [
                'label' => 'Nama Layanan',
                'rules' => 'required|min_length[3]|max_length[255]',
            ],
            'kuota' => [
                'label' => 'Total Kuota',
                'rules' => 'required|numeric|greater_than[0]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'rules' => 'permit_empty|max_length[500]',
            ],
        ];

        $id = $this->request->getPost('id');
        if (!empty($id)) {
            $check = $baksosServiceModel->find($id);
            if (empty($check)) {
                return $this->response->setJSON(['status' => 0, 'pesan' => lang('App.dashboard.404data')]);
            }
        }

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            $pesan = [];
            foreach ($rules as $key => $value) {
                if ($validation->hasError($key)) {
                    $pesan[$key] = $validation->getError($key);
                }
            }
            return $this->response->setJSON(['status' => 0, 'pesan' => $pesan]);
        }

        $data = [
            'nama_pelayanan' => $this->request->getPost('nama_pelayanan'),
            'kuota' => $this->request->getPost('kuota'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        if (empty($id)) {
            $baksosServiceModel->insert($data);
            return $this->response->setJSON(['status' => 200, 'pesan' => lang('App.dashboard.successAdd')]);
        } else {
            $baksosServiceModel->update($id, $data);
            return $this->response->setJSON(['status' => 200, 'pesan' => lang('App.dashboard.successUpdateData')]);
        }
    }

    public function servicesDelete()
    {
        $id = $this->request->getPost('id');
        $baksosServiceModel = new BaksosServiceModel();
        $check = $baksosServiceModel->find($id);

        if (empty($check)) {
            return $this->response->setJSON(['status' => 0, 'pesan' => lang('App.dashboard.404data')]);
        }

        $baksosServiceModel->delete($id);
        return $this->response->setJSON(['status' => 200, 'pesan' => lang('App.dashboard.successDeleteData')]);
    }

    // ==========================================
    // REGISTRATIONS MANAGEMENT
    // ==========================================
    public function registrations()
    {
        $baksosServiceModel = new BaksosServiceModel();
        $this->dataView['services'] = $baksosServiceModel->findAll();

        return view('dashboard/baksos/registrations', $this->dataView);
    }

    public function registrationsAll()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('baksos_registrations r')
            ->select('r.id, r.nama_lengkap, r.nik, r.umur, r.jenis_kelamin, r.alamat, r.no_hp, r.created_at, s.nama_pelayanan')
            ->join('baksos_services s', 's.id = r.baksos_service_id', 'left');

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if (isset($request->baksos_service_id) && $request->baksos_service_id != "") {
                    $builder->where('r.baksos_service_id', $request->baksos_service_id);
                }
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('r.created_at', 'DESC');
            })
            ->addNumbering('no')
            ->format('created_at', function ($value) {
                return date('d M Y H:i', strtotime($value));
            })
            ->add('action', function ($row) {
                $deleteBtn = '<button class="btn btn-danger btn-sm action-delete" data-id="' . $row->id . '" data-name="' . $row->nama_lengkap . '" data-url="' . url_to('admin-baksos-registrations-delete') . '" title="Hapus"><i class="ri-delete-bin-line fs-14 align-middle"></i></button>';
                return $deleteBtn;
            })
            ->toJSON(true);
    }

    public function registrationsDelete()
    {
        $id = $this->request->getPost('id');
        $baksosRegistrationModel = new BaksosRegistrationModel();
        $check = $baksosRegistrationModel->find($id);

        if (empty($check)) {
            return $this->response->setJSON(['status' => 0, 'pesan' => lang('App.dashboard.404data')]);
        }

        $baksosRegistrationModel->delete($id);
        return $this->response->setJSON(['status' => 200, 'pesan' => lang('App.dashboard.successDeleteData')]);
    }

    public function registrationsExport()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('baksos_registrations r')
            ->select('r.nama_lengkap, r.nik, r.umur, r.jenis_kelamin, r.alamat, r.no_hp, r.created_at, s.nama_pelayanan')
            ->join('baksos_services s', 's.id = r.baksos_service_id', 'left');

        $serviceId = $this->request->getGet('baksos_service_id');
        if (!empty($serviceId)) {
            $builder->where('r.baksos_service_id', $serviceId);
        }

        $builder->orderBy('r.created_at', 'DESC');
        $data = $builder->get()->getResult();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'NIK');
        $sheet->setCellValue('D1', 'Umur');
        $sheet->setCellValue('E1', 'Jenis Kelamin');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'No HP');
        $sheet->setCellValue('H1', 'Layanan Baksos');
        $sheet->setCellValue('I1', 'Waktu Daftar');

        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item->nama_lengkap);
            // using string format for NIK & No HP to prevent scientific notation
            $sheet->setCellValueExplicit('C' . $row, $item->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $item->umur);
            $sheet->setCellValue('E' . $row, $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('F' . $row, $item->alamat);
            $sheet->setCellValueExplicit('G' . $row, $item->no_hp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('H' . $row, $item->nama_pelayanan);
            $sheet->setCellValue('I' . $row, date('d M Y H:i', strtotime($item->created_at)));
            $row++;
            $no++;
        }

        // Auto size columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data_Pendaftar_Baksos_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
