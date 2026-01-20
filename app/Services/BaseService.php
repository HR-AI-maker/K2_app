<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * The model instance.
     */
    protected Model $model;

    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * Get the model instance.
     */
    abstract protected function getModel(): Model;

    /**
     * Get all records.
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get paginated records.
     */
    public function paginate($perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Find a record by ID.
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find a record or fail.
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record.
     */
    public function update($id, array $data)
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete a record.
     */
    public function delete($id)
    {
        return $this->findOrFail($id)->delete();
    }
}
