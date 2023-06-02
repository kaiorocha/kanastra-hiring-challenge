<?php

namespace Tests\Feature;

use App\Models\Debit;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    public function teste_webhook_request(): void
    {
        $debit = Debit::first();
        $response = $this->postJson("/api/webhook", [
            'debtId' => $debit->external_id,
            'paidAt' => "2022-06-09 10:00:00",
            "paidAmount" => 100000.00,
            "paidBy" => "John Doe"
        ]);

        $response->assertStatus(200);
    }
}
