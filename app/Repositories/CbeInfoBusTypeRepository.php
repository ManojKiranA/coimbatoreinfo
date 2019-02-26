<?php
/**
* Generated  for CbeInfoBusTypeController with Model CbeInfoBusType  At Saturday 23rd of February 2019 06:37:17 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoBusType;

class CbeInfoBusTypeRepository extends BaseRepository implements CbeInfoBusTypeRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoBusTypeRepository instance.
     *
     * @return void
     * @param CbeInfoBusType $model
     */
    public function __construct(CbeInfoBusType $model)
    {
        $this->model = $model;
    }
}