<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'debtId' => $this->id,
            'debtExternalId' => $this->external_id,
            'customer' => new CustomerResource($this->customer),
            'debtAmount' => number_format($this->amount, 2, '.', ''),
            'paidBy' => $this->paid_by,
            'paidAmount' => number_format($this->paid_amount, 2, '.', ''),
            'paidAt' => $this->paid_at,
            'debtDueDate' => $this->due_date,
            'charges' => new ChargeResource($this->charges)
        ];
    }
}
