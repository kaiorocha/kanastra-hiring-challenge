<?php

namespace App\Imports;

use App\Exceptions\ApiException;
use App\Exceptions\CustomException;
use App\Http\Resources\DebitResource;
use App\Repositories\CustomerRepositoryEloquent;
use App\Repositories\DebitRepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DebitsImport implements ToCollection, WithHeadingRow
{
    /**
     * @var CustomerRepositoryEloquent
     */
    protected $customerRepository;
    /**
     * @var DebitRepositoryEloquent
     */
    protected $debitRepository;

    /**
     * @var
     */
    public $debits;

    /**
     *
     */
    public function __construct()
    {
        $this->customerRepository = new CustomerRepositoryEloquent(app());
        $this->debitRepository = new DebitRepositoryEloquent(app());
    }


    /**
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection)
    {
        $debits = collect();

        $collection->map(function ($row) use ($debits){
            $validator = $this->rowValidate($row);

            if (!$validator->fails()){
                $customer = $this->customerCreate($row);
                if ($customer) {
                    $debit = $this->debitCreate($customer, $row);

                    $debits->push(new DebitResource($debit));
                }
            } else {
                throw new ApiException($validator->messages()->first());
            }

        });

        $this->debits = $debits;
    }

    /**
     * @param $row
     * @return \Illuminate\Validation\Validator
     */
    private function rowValidate($row)
    {
        return Validator::make(
            $row->toArray(),
            $this->rules(),
            $this->messages()
        );
    }

    /**
     * @param $customer
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    private function debitCreate($customer, $data)
    {
        $debit = $this->debitRepository->create([
            'customer_id' => $customer->id,
            'external_id' => (int)$data['debtid'],
            'amount' => $data['debtamount'],
            'due_date' => Carbon::make($data['debtduedate'])->format('Y-m-d H:i:s')
        ]);

        return $debit;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function customerCreate($data)
    {
        $customer = $this->customerRepository->firstOrNew([
            'government_id' => $data['governmentid'],
        ]);
        $customer->name = $data['name'];
        $customer->email = $data['email'];

        $customer->save();

        return $customer;
    }

    /**
     * @return string[]
     */
    private function rules()
    {
        return [
            "name" => "required|max:255",
            "governmentid" => "required|max:11",
            "email" => "required|email|max:255",
            "debtamount" => "required|regex:/^\d{1,13}(\.\d{1,4})?$/",
            "debtduedate" => "required|date",
            "debtid" => "required|unique:debits,external_id"
        ];
    }

    /**
     * @return string[]
     */
    private function messages()
    {
        return [
            'required' => 'The :attribute field is required.'
        ];
    }
}
