<?php
/**
* Generated  for CbeInfoBusViaController with Model CbeInfoBusVia  At Saturday 23rd of February 2019 08:49:10 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoBusVia;

class CbeInfoBusViaRepository extends BaseRepository implements CbeInfoBusViaRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoBusViaRepository instance.
     *
     * @return void
     * @param CbeInfoBusVia $model
     */
    public function __construct(CbeInfoBusVia $model)
    {
        $this->model = $model;
    }
}