<?php
/**
* Generated  for CbeInfoLocationToController with Model CbeInfoLocationTo  At Saturday 23rd of February 2019 05:53:44 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoLocationTo;

class CbeInfoLocationToRepository extends BaseRepository implements CbeInfoLocationToRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoLocationToRepository instance.
     *
     * @return void
     * @param CbeInfoLocationTo $model
     */
    public function __construct(CbeInfoLocationTo $model)
    {
        $this->model = $model;
    }
}