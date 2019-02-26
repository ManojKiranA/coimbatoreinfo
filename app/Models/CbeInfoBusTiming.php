<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Models\Traits\UserStampsTrait;

/**
 * Class CbeInfoBusTiming
 *
 * @package App
*/

class CbeInfoBusTiming extends Model
{
	use SoftDeletes;
    use UserStampsTrait;
    // YourModel::flushEventListeners();

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cbe_info_bus_timings';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 
                        [
                                'bus_id','bus_type_id','bus_route_id','bus_point_from','bus_point_to','bus_time',
                                'created_by','updated_by','created_at','updated_at'
                        ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at','updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection ='';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // protected $with = [];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    // protected $withCount = [];

    /**
     * Indicates if the model exists.
     *
     * @var bool
     */
    // public $exists = true;

    /**
    * The name of the "created at" column.
    *
    * @var string
    */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'deleted_at';


    /**
    * Belongs-to relations with User.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
    * Belongs-to relations with CbeInfoBusName.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function busName()
    {
        return $this->belongsTo(CbeInfoBusName::class, 'bus_id');
    }

    /**
    * Belongs-to relations with CbeInfoBusType.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function busType()
    {
        return $this->belongsTo(CbeInfoBusType::class, 'bus_type_id');
    }

    /**
    * Belongs-to relations with CbeInfoBusVia.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function busRouteName()
    {
        return $this->belongsTo(CbeInfoBusVia::class, 'bus_route_id');
    }

    /**
    * Belongs-to relations with CbeInfoLocationFrom.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */

    public function busStartingPoint()
    {
        return $this->belongsTo(CbeInfoLocationFrom::class, 'bus_point_from');
    }

    /**
    * Belongs-to relations with CbeInfoLocationFrom.
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */

    public function busReachingPoint()
    {
        return $this->belongsTo(CbeInfoLocationTo::class, 'bus_point_to');
    }

    /**
     * Scope a query to only the time which is greter than current time.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeCurrentTime($query)
    {
        return $query->orWhereTime('bus_time', '>=', date('h:i A'));
    }

    /**
     * Scope a query to only the time which is greter than current time.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeNextTime($query='',$nextTimeLimit='')
    {
        return $query->orWhereTime('bus_time', '<=', $nextTimeLimit);
    }
    
    

}