<?php

namespace App\Repositories;

use App\Interfaces\ServiceModeInterface;
use App\Models\ServiceMode;
use Yajra\Datatables\Datatables;

class ServiceModeRepository implements ServiceModeInterface
{
    private $service_mode;

    private $datatables;

    public function __construct()
    {
        $this->service_mode = new ServiceMode;
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->service_mode->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($serviceMode) {
                $action = '<ul class="action">';

                // Edit Service Mode (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="'.$serviceMode->id.'" id="editServiceMode"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Service Mode (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$serviceMode->id.'" id="deleteServiceMode"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createServiceMode(array $data)
    {
        return $this->service_mode->create($data);
    }

    public function findServiceModeById($id)
    {
        return $this->service_mode->find($id);
    }

    public function updateServiceMode($id, array $data)
    {
        $serviceMode = $this->service_mode->find($id);

        return $serviceMode ? $serviceMode->update($data) : null;
    }

    public function deleteServiceMode($id)
    {
        $serviceMode = $this->service_mode->find($id);

        return $serviceMode ? $serviceMode->delete() : false;
    }
}
