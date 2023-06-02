<?php

namespace Tests\Feature;

use App\Models\Debit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DebitApiTest extends TestCase
{
    public function teste_get_debits(): void
    {
        $response = $this->get('/api/debits');

        $response->assertStatus(200);
    }

    public function teste_store_debit_with_csv(): void
    {
        $header = "name,governmentId,email,debtAmount,debtDueDate,debtId";
        $row1 = "John Doe,11111111111,johndoe@kanastra.com.br,1000000.00,2022-10-12," . rand(1000, 99999);
        $row2 = "Kaio Rocha,38521675828,kaio.f.roch@gmail.com,2000000.00,2023-06-01," . rand(1000, 99999);

        $content = implode("\n", [$header, $row1, $row2]);

        $inputs = [
            'debitsFile' => UploadedFile::fake()->createWithContent('debits-test.csv',$content)
        ];

        $response = $this->postJson("/api/debits", $inputs);

        $response->assertStatus(201);
    }

    public function teste_show_debit(): void
    {
        $debits = Debit::first();
        $response = $this->get("/api/debits/{$debits->id}");

        $response->assertStatus(200);
    }

    public function teste_destroy_debit(): void
    {
        $debits = Debit::first();
        $response = $this->delete("/api/debits/{$debits->id}");

        $response->assertStatus(204);
    }
}
