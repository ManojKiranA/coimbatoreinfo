<?php
/**
* Generated  for CbeInfoBusTimingController with Model CbeInfoBusTiming  At Saturday 23rd of February 2019 10:01:46 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoBusTiming;

class CbeInfoBusTimingRepository extends BaseRepository implements CbeInfoBusTimingRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoBusTimingRepository instance.
     *
     * @return void
     * @param CbeInfoBusTiming $model
     */
    public function __construct(CbeInfoBusTiming $model)
    {
        $this->model = $model;
    }
}