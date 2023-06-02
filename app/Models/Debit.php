<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Debit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = ['customer_id', 'external_id', 'amount', 'paid_amount', 'paid_at', 'due_date'];

    /**
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn(Debit $debit) => $debit->id = (string) Uuid::uuid4());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
