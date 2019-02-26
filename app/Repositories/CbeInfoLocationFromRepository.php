<?php
/**
* Generated  for CbeInfoLocationFromController with Model CbeInfoLocationFrom  At Saturday 23rd of February 2019 12:48:26 PM
*
* @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
*/
namespace App\Repositories;

use App\CbeInfoLocationFrom;

class CbeInfoLocationFromRepository extends BaseRepository implements CbeInfoLocationFromRepositoryInterface
{
     protected $model;
      
     /**
     * Create a new CbeInfoLocationFromRepository instance.
     *
     * @return void
     * @param CbeInfoLocationFrom $model
     */
    public function __construct(CbeInfoLocationFrom $model)
    {
        $this->model = $model;
    }
}