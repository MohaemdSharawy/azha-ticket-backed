<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;

class MainRepository
{
    protected $model;

    public function __construct()
    {
    }

    public function getAll()
    {
        //   return$this->model::with($this->model::getModelRelations())->get();
        return $this->model::get();
    }

    public function create(array $request)
    {
        return $this->model::create($request);
    }

    public function get(int $id)
    {
        return $this->model::with($this->model::getModelRelations())->find($id);
    }

    public function update(array $request, int $id)
    {
        $row = $this->model::where('id', $id)->first();
        $row->update($request);
        return $row;
    }

    public function delete(int $id)
    {
        return $this->model::where('id', $id)->delete();
    }

    public function getRules()
    {
        return $this->model::getRules() ?? [];
    }

    public function getValidationMessages()
    {
        return $this->model::getValidationMessages() ?? [];
    }
}
