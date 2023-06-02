<?php

namespace App\Repositories;

use App\Models\Charge;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ChargeRepository;
use App\Validators\ChargeValidator;

/**
 * Class ChargeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChargeRepositoryEloquent extends BaseRepository implements ChargeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Charge::class;
    }

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
