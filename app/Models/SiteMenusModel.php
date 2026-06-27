<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteMenusModel extends Model
{
    protected $table = 'site_menus';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = [
        'type', 'name', 'name_en', 'route', 'params', 'parent', 'order', 'active', 'icon', 'filter', 'filter_value', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function getActiveMenus()
    {
        return $this->where('active', 1)
            ->where('parent', null)
            ->orderBy('order', 'ASC')->find();
    }

    public function getActiveChildMenu($id)
    {
        return $this->where('active', 1)
            ->where('parent', $id)
            ->orderBy('order', 'ASC')->find();
    }

    public function getOneActiveMenubyRoute($route)
    {
        return $this->where('active', 1)
            ->where('route', $route)
            ->first();
    }

    public function getOneActiveMenubySlug($route, $slug)
    {
        return $this->where('active', 1)
            ->where('route', $route)
            ->where('params', $slug)
            ->first();
    }

    public function getAllActiveMenu()
    {
        return $this->where('active', 1)
            ->orderBy('order', 'ASC')->find();
    }

    public function getAllMenus()
    {
        return $this->where('parent', null)
            ->orderBy('order', 'ASC')->find();
    }

    public function getAllChildMenu($id)
    {
        return $this->where('parent', $id)
            ->orderBy('order', 'ASC')->find();
    }

    public function countActiveData()
    {
        return $this->selectCount('*', 'total')
            ->where('active', 1)
            ->first();
    }

    public function setStatus($id, $status)
    {
        return $this->update($id, ['active' => $status]);
    }
}
