<?php

namespace App\Repositories;

use App\Models\Debit;
use App\Notifications\DebitPaid;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Notification;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DebitRepository;
use App\Validators\DebitValidator;

/**
 * Class DebitRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DebitRepositoryEloquent extends BaseRepository implements DebitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Debit::class;
    }

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function paid(array $data)
    {
        $debit = $this->findWhere(['external_id' => $data['debtId']])->first(function ($debit) use ($data){
            $debit->paid_at = Carbon::make($data['paidAt'])->format('Y-m-d H:i:s');
            $debit->paid_amount = $data['paidAmount'];
            $debit->paid_by = $data['paidBy'];
            return $debit;
        });

        if (!$debit) {
            return false;
        }

        if ($debit->save()) {
            /** Aqui enviaria a notificação de boleto pago ao cliente */
            //Notification::sendNow($debit->customer, new DebitPaid($debit));
        }

        return $debit;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
