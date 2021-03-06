<?php

namespace App\Imports;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpenseImport implements ToModel, WithHeadingRow
{
    public function __construct($case_list_id)
    {
        $this->case_list_id = $case_list_id;
    }

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Expense([
            'case_list_id' => $this->case_list_id,
            'adjuster' => $row['adjuster'],
            'name' => $row['nama'],
            'qty' => $row['qty'],
            'amount' => $row['amount'],
            'category_expense' => $row['category'],
            'tanggal' => Carbon::createFromFormat('d/m/Y', $row['tanggal'])->format('Y-m-d'),
            'total' => $row['amount'] * $row['qty'],
        ]);
    }
}
