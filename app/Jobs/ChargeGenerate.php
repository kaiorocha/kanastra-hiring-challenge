<?php

namespace App\Jobs;

use App\Notifications\DebitCharge;
use App\Repositories\ChargeRepositoryEloquent;
use App\Repositories\DebitRepositoryEloquent;
use Faker\Core\Barcode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ChargeGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $debits = $this->getDebits();

        $debits->map(function ($debit) {
            $charge = $this->chargeCreate($debit);

            if ($charge) {
                /** Aqui enviaria a notificação de boleto ao cliente */
                //Notification::sendNow($charge->debit->customer, new DebitCharge($charge));
                Log::info("Charge {$charge->id} created! Barcode is: {$charge->barcode}.");
            }
        });

        return;
    }

    private function getDebits()
    {
        $debitRepository = new DebitRepositoryEloquent(app());

        return $debitRepository->doesnthave('charges')->get();
    }

    private function chargeCreate($debit)
    {
        $chargeRepository = new ChargeRepositoryEloquent(app());

        $barcode = new Barcode();

        return $chargeRepository->create([
            'debit_id' => $debit->id,
            'amount' => $debit->amount,
            'barcode' => $barcode->isbn13(),
            'due_date' => $debit->due_date
        ]);
    }
}
