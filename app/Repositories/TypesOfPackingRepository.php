<?php

namespace App\Repositories;

use App\Interfaces\TypesOfPackingInterface;
use App\Models\TypesOfPacking; // Make sure you have a model for TypesOfPacking
use Yajra\Datatables\Datatables;

class TypesOfPackingRepository implements TypesOfPackingInterface
{
    private $types_of_packing;

    private $datatables;

    public function __construct()
    {
        $this->types_of_packing = new TypesOfPacking;
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->types_of_packing->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($typesOfPacking) {
                $action = '<ul class="action">';

                // Edit Types of Packing (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="'.$typesOfPacking->id.'" id="editPackingType"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Types of Packing (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$typesOfPacking->id.'" id="deletePackingType"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createPackingType(array $data)
    {
        return $this->types_of_packing->create($data);
    }

    public function findPackingTypeById($id)
    {
        return $this->types_of_packing->find($id);
    }

    public function updatePackingType($id, array $data)
    {
        $typesOfPacking = $this->types_of_packing->find($id);

        return $typesOfPacking ? $typesOfPacking->update($data) : null;
    }

    public function deletePackingType($id)
    {
        $typesOfPacking = $this->types_of_packing->find($id);

        return $typesOfPacking ? $typesOfPacking->delete() : false;
    }
}
