<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebitStoreRequest;
use App\Http\Resources\DebitResource;
use App\Imports\DebitsImport;
use App\Models\Debit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DebitResource::collection(Debit::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DebitStoreRequest $request)
    {
        $csv = $request->file('debitsFile');
        $extension = $csv->getClientOriginalExtension();
        $name = "debits-" . time() . "." . $extension;

        $path = $csv->move('imports/debits', $name);

        $import = new DebitsImport();

        Excel::import($import, $path->getPathname());

        return response()->json($import->debits, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Debit $debit)
    {
        return new DebitResource($debit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debit $debit)
    {
        $debit->delete();

        return response()->json(['deleted'], 204);
    }
}
