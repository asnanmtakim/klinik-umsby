<?php

namespace App\Models;

use CodeIgniter\Model;

class BaksosServiceModel extends Model
{
    protected $table            = 'baksos_services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_pelayanan', 'kuota', 'deskripsi'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getServicesWithRemainingQuota()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('baksos_services s');
        $builder->select('s.*, (s.kuota - COALESCE(r.used_quota, 0)) as sisa_kuota');
        $builder->join('(SELECT baksos_service_id, COUNT(id) as used_quota FROM baksos_registrations GROUP BY baksos_service_id) r', 'r.baksos_service_id = s.id', 'left');
        return $builder->get()->getResultArray();
    }

    public function getServiceWithQuota($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('baksos_services s');
        $builder->select('s.*, (s.kuota - COALESCE(r.used_quota, 0)) as sisa_kuota');
        $builder->join('(SELECT baksos_service_id, COUNT(id) as used_quota FROM baksos_registrations GROUP BY baksos_service_id) r', 'r.baksos_service_id = s.id', 'left');
        $builder->where('s.id', $id);
        return $builder->get()->getRowArray();
    }
}
