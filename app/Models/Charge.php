<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Charge extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = ['debit_id', 'amount', 'barcode', 'due_date'];

    /**
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn(Charge $charge) => $charge->id = (string) Uuid::uuid4());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debit()
    {
        return $this->belongsTo(Debit::class);
    }
}
