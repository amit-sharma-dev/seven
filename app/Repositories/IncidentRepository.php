<?php


namespace App\Repositories;


use App\Models\Incident;

class IncidentRepository
{
    public function create($item) {
        return Incident::create($item);
    }

    public function getAll() {
        return Incident::with('peoples')->get();
    }

}
