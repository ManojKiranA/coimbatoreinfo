<?php
/*
*Generated By Crud Generator  At Saturday 23rd of February 2019 12:48:26 PM
*/
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


 class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    public function latest($column = null)
    {
        return $this->model->latest($column = null);
    } 

    public function links($view = null, $data = [])
    {
        return $this->model->links($view = null, $data = []);
    } 

      

    public function select($column = null)
    {
        return $this->model->select($column = null);
    } 

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
