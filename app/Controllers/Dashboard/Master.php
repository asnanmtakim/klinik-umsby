<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Libraries\APICybercampusCPL;
use App\Models\FakultasModel;
use App\Models\ProgramStudiModel;
use App\Models\SemesterModel;
use Hermawan\DataTables\DataTable;

class Master extends BaseController
{
    public function fakultas()
    {
        return view('dashboard/master/fakultas', $this->dataView);
    }

    public function fakultasAll()
    {
        $FakultasModel = new FakultasModel();
        $builder = $FakultasModel->select(['id', 'nama_fakultas', 'singkatan_fakultas'])
            ->where('deleted_at', null);
        return DataTable::of($builder)
            ->filter(function ($builder, $request) {})
            ->postQuery(function ($builder) {
                $builder->orderBy('created_at', 'ASC');
            })
            ->addNumbering('no')
            ->add('action', function ($row) {
                if (auth()->user()->can('admin.master.manage'))
                    return '<button class="btn btn-warning btn-sm action-edit" data-id="' . $row->id . '" data-name="' . $row->nama_fakultas . '" data-url="' . url_to('master-fakultas-one') . '" title="Edit"><i class="ri-file-edit-line fs-14 align-middle"></i></button>';
            })
            ->toJSON(true);
    }

    public function fakultasSync()
    {
        $fakultas = APICybercampusCPL::getData('cpl/fakultas');
        if ($fakultas['status'] !== 'SUKSES') {
            return $this->response->setStatusCode(500)->setJSON(['status' => '500', 'message' => isset($fakultas['message']) ? $fakultas['message'] : 'Something went wrong']);
        }
        if (empty($fakultas['data'])) {
            return $this->response->setStatusCode(200)->setJSON(['status' => '404', 'message' => lang('App.dashboard.404data')]);
        }
        $data = [];
        $FakultasModel = new FakultasModel();
        foreach ($fakultas['data'] as $value) {
            $data = [
                'nama_fakultas' => $value['name'],
                'singkatan_fakultas' => $value['shortname'],
                'fakultas_cyber_id' => $value['id_fakultas'],
            ];
            $check = $FakultasModel->getDataByCyberID($value['id_fakultas']);
            if (empty($check)) {
                $FakultasModel->insert($data);
            } else {
                $FakultasModel->update($check->id, $data);
            }
        }
        return $this->response->setStatusCode(200)->setJSON(['status' => '200', 'message' => 'Berhasil Sinkronisasi Data']);
    }

    public function fakultasOne()
    {
        $id = $this->request->getPost('id');
        $FakultasModel = new FakultasModel();
        $check = $FakultasModel->find($id);
        if (empty($check)) {
            echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
        } else {
            echo json_encode(array('status' => 200, 'data' => $check));
        }
    }

    public function fakultasSave()
    {
        $FakultasModel = new FakultasModel();
        $rules = [
            'nama_fakultas' => [
                'label' => 'Nama Fakultas',
                'rules' => 'required|min_length[3]|max_length[255]',
            ],
            'singkatan_fakultas' => [
                'label' => 'Singkatan Fakultas',
                'rules' => 'required|alpha_dash|min_length[2]|max_length[255]',
            ],
        ];

        $id = $this->request->getPost('id');
        if ($id != '') {
            $check = $FakultasModel->find($id);
            if (empty($check)) {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
                return;
            }
        }
        $pesan = [];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            foreach ($rules as $key => $value) {
                $pesan[$key] = $validation->getError($key);
            }
            echo json_encode(array('status' => 400, 'pesan' => $pesan));
            return;
        }

        $data = [
            'nama_fakultas' => $this->request->getPost('nama_fakultas'),
            'singkatan_fakultas' => $this->request->getPost('singkatan_fakultas'),
        ];
        if (empty($id)) {
            $query = $FakultasModel->insert($data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successAddData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedAddData')));
            }
        } else {
            $query = $FakultasModel->update($id, $data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successUpdateData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedUpdateData')));
            }
        }
    }

    public function programStudi()
    {
        $FakultasModel = new FakultasModel();
        $this->dataView['fakultas'] = $FakultasModel->findAll();
        return view('dashboard/master/program-studi', $this->dataView);
    }

    public function programStudiAll()
    {
        $ProgramStudiModel = new ProgramStudiModel();
        $builder = $ProgramStudiModel->select(['program_studi.id', 'nama_fakultas', 'nama_program_studi', 'level_program_studi', 'urutan_kursi'])
            ->join('fakultas', 'program_studi.id_fakultas = fakultas.id')
            ->where('program_studi.deleted_at', null);
        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if ($request->fakultas != "")
                    $builder->where('program_studi.id_fakultas', $request->fakultas);
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('program_studi.created_at', 'ASC');
            })
            ->addNumbering('no')
            ->add('action', function ($row) {
                if (auth()->user()->can('admin.master.manage'))
                    return '<button class="btn btn-warning btn-sm action-edit" data-id="' . $row->id . '" data-name="' . $row->nama_program_studi . '" data-url="' . url_to('master-program-studi-one') . '" title="Edit"><i class="ri-file-edit-line fs-14 align-middle"></i></button>';
            })
            ->toJSON(true);
    }

    public function programStudiSync()
    {
        $programStudi = APICybercampusCPL::getData('cpl/program-studi');
        if ($programStudi['status'] !== 'SUKSES') {
            return $this->response->setStatusCode(500)->setJSON(['status' => '500', 'message' => 'Something went wrong']);
        }
        if (empty($programStudi['data'])) {
            return $this->response->setStatusCode(200)->setJSON(['status' => '404', 'message' => lang('App.dashboard.404data')]);
        }
        $FakultasModel = new FakultasModel();
        $ProgramStudiModel = new ProgramStudiModel();
        $data = [];
        foreach ($programStudi['data'] as $value) {
            $data = [];
            $fakultas = $FakultasModel->getDataByName($value['fakultas']);
            if (!empty($fakultas)) {
                $data = [
                    'id_fakultas' => $fakultas->id,
                    'nama_program_studi' => $value['program_studi'],
                    'level_program_studi' => $value['jenjang'],
                    'program_studi_cyber_id' => $value['id'],
                ];
            }
            if (!empty($data)) {
                $check = $ProgramStudiModel->getDataByCyberID($value['id']);
                if (empty($check)) {
                    $ProgramStudiModel->insert($data);
                } else {
                    $ProgramStudiModel->update($check->id, $data);
                }
            }
        }
        return $this->response->setStatusCode(200)->setJSON(['status' => '200', 'message' => 'Berhasil Sinkronisasi Data']);
    }

    public function programStudiOne()
    {
        $id = $this->request->getPost('id');
        $ProgramStudiModel = new ProgramStudiModel();
        $check = $ProgramStudiModel->find($id);
        if (empty($check)) {
            echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
        } else {
            echo json_encode(array('status' => 200, 'data' => $check));
        }
    }

    public function programStudiSave()
    {
        $ProgramStudiModel = new ProgramStudiModel();
        $rules = [
            'id_fakultas' => [
                'label' => 'Fakultas',
                'rules' => 'required',
            ],
            'nama_program_studi' => [
                'label' => 'Nama Program Studi',
                'rules' => 'required|min_length[3]|max_length[255]',
            ],
            'level_program_studi' => [
                'label' => 'Level Program Studi',
                'rules' => 'required|alpha_dash|min_length[2]|max_length[20]',
            ],
            'urutan_kursi' => [
                'label' => 'Urutan Kursi',
                'rules' => 'permit_empty|integer',
            ],
        ];
        $id = $this->request->getPost('id');
        if ($id != '') {
            $check = $ProgramStudiModel->find($id);
            if (empty($check)) {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
                return;
            }
        }

        $pesan = [];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            foreach ($rules as $key => $value) {
                $pesan[$key] = $validation->getError($key);
            }
            echo json_encode(array('status' => 400, 'pesan' => $pesan));
            return;
        }

        $data = [
            'id_fakultas' => $this->request->getPost('id_fakultas'),
            'nama_program_studi' => $this->request->getPost('nama_program_studi'),
            'level_program_studi' => $this->request->getPost('level_program_studi'),
            'urutan_kursi' => $this->request->getPost('urutan_kursi') !== '' ? $this->request->getPost('urutan_kursi') : null,
        ];
        if (empty($id)) {
            $query = $ProgramStudiModel->insert($data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successAddData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedAddData')));
            }
        } else {
            $query = $ProgramStudiModel->update($id, $data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successUpdateData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedUpdateData')));
            }
        }
    }

    public function semester()
    {
        return view('dashboard/master/semester', $this->dataView);
    }

    public function semesterAll()
    {
        $SemesterModel = new SemesterModel();
        $builder = $SemesterModel->select(['id', 'nama_semester', 'tahun_semester', 'active'])
            ->where('deleted_at', null);
        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if ($request->active != "")
                    $builder->where('active', $request->active);
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('tahun_semester', 'DESC');
            })
            ->addNumbering('no')
            ->add('tahun_semester', function ($row) {
                return $row->tahun_semester . ' - ' . $row->nama_semester;
            })
            ->edit('active', function ($row) {
                if ($row->active == 0) {
                    return '<button class="btn btn-sm btn-danger action-status" data-id="' . $row->id . '" data-name="' . $row->tahun_semester . '" data-url="' . url_to('/') . '">' . lang('App.dashboard.inactive') . '</button>';
                } else {
                    return '<button class="btn btn-sm btn-success action-status" data-id="' . $row->id . '" data-name="' . $row->tahun_semester . '" data-url="' . url_to('/') . '">' . lang('App.dashboard.active') . '</button>';
                }
            })
            ->add('action', function ($row) {
                if (auth()->user()->can('admin.master.manage'))
                    return '<button class="btn btn-warning btn-sm action-edit" data-id="' . $row->id . '" data-name="' . $row->tahun_semester . '" data-url="' . url_to('master-semester-one') . '" title="Edit"><i class="ri-file-edit-line fs-14 align-middle"></i></button>';
            })
            ->toJSON(true);
    }

    public function semesterSync()
    {
        $semester = APICybercampusCPL::getData('cpl/semester');
        if ($semester['status'] !== 'SUKSES') {
            return $this->response->setStatusCode(500)->setJSON(['status' => '500', 'message' => 'Something went wrong']);
        }
        if (empty($semester['data'])) {
            return $this->response->setStatusCode(200)->setJSON(['status' => '404', 'message' => lang('App.dashboard.404data')]);
        }
        $SemesterModel = new SemesterModel();
        $data = [];
        foreach ($semester['data'] as $value) {
            $data = [
                'nama_semester' => $value['name'],
                'tahun_semester' => $value['tahun_ajaran'],
                'semester_cyber_id' => $value['id'],
                'active' => $value['is_semester_aktif']
            ];
            $check = $SemesterModel->getDataByCyberID($value['id']);
            if (empty($check)) {
                $SemesterModel->insert($data);
            } else {
                $SemesterModel->update($check->id, $data);
            }
        }
        return $this->response->setStatusCode(200)->setJSON(['status' => '200', 'message' => 'Berhasil Sinkronisasi Data']);
    }

    public function semesterOne()
    {
        $id = $this->request->getPost('id');
        $SemesterModel = new SemesterModel();
        $check = $SemesterModel->find($id);
        if (empty($check)) {
            echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
        } else {
            echo json_encode(array('status' => 200, 'data' => $check));
        }
    }
    public function semesterSave()
    {
        $SemesterModel = new SemesterModel();
        $rules = [
            'nama_semester' => [
                'label' => 'Nama Semester',
                'rules' => 'required|min_length[3]|max_length[255]',
            ],
            'tahun_semester' => [
                'label' => 'Tahun Semester',
                'rules' => 'required|min_length[3]|max_length[255]',
            ],
        ];
        $id = $this->request->getPost('id');
        if ($id != '') {
            $check = $SemesterModel->find($id);
            if (empty($check)) {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.404data')));
                return;
            }
        }

        $pesan = [];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            foreach ($rules as $key => $value) {
                $pesan[$key] = $validation->getError($key);
            }
            echo json_encode(array('status' => 400, 'pesan' => $pesan));
            return;
        }

        $data = [
            'nama_semester' => $this->request->getPost('nama_semester'),
            'tahun_semester' => $this->request->getPost('tahun_semester'),
        ];
        if (empty($id)) {
            $query = $SemesterModel->insert($data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successAddData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedAddData')));
            }
        } else {
            $query = $SemesterModel->update($id, $data);
            if ($query) {
                echo json_encode(array('status' => 200, 'pesan' => lang('App.dashboard.successUpdateData')));
            } else {
                echo json_encode(array('status' => 0, 'pesan' => lang('App.dashboard.failedUpdateData')));
            }
        }
    }
}
