<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebhookRequest;
use App\Http\Resources\DebitResource;
use App\Repositories\DebitRepositoryEloquent;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    /**
     * @var DebitRepositoryEloquent
     */
    protected $debitRepository;

    /**
     * @param DebitRepositoryEloquent $debitRepository
     */
    public function __construct(DebitRepositoryEloquent $debitRepository)
    {
        $this->debitRepository = $debitRepository;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebhookRequest $request)
    {
        $data = $request->all();
        $debit = $this->debitRepository->paid($data);

        if (!$debit)
            return response()->json(null, 404);

        return new DebitResource($debit);
    }
}
