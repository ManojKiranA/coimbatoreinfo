<?php
/**
* Generated  for CbeInfoBusNameController with Model CbeInfoBusName  At Saturday 23rd of February 2019 06:33:18 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoBusName;

class CbeInfoBusNameRepository extends BaseRepository implements CbeInfoBusNameRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoBusNameRepository instance.
     *
     * @return void
     * @param CbeInfoBusName $model
     */
    public function __construct(CbeInfoBusName $model)
    {
        $this->model = $model;
    }
}