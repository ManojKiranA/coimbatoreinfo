<?php
/*
*Generated By Crud Generator  At Saturday 23rd of February 2019 12:48:26 PM
*/
namespace App\Repositories;

interface BaseRepositoryInterface
{
    
    public function all();

    public function latest($column = null);
    
    public function select($columns = ['*']);
    
    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
