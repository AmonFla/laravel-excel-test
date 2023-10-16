<?php

namespace App\Imports;

//use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UserImport implements ToModel, WithUpserts, WithUpsertColumns, WithHeadingRow /*, OnEachRow*/
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //skip lines
        if (!isset($row[0])) {
            return null;
        }

        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
        ]);

        // posible column names
        /*
        In case you want to import rows by several possible column names (using WithHeadingRow), you can use null coalescing operator (??).
        If the column with the first name (in example client_name)
        exists and is not NULL, return its value; otherwise look for second possible name (in example client) etc.

        return new User([
            'name' => $row['client_name'] ?? $row['client'] ?? $row['name'] ?? null
        ]);
        */
    }

    /**
     * @return string|array
     * In the example above, if a user already exists with the same email, the row will be updated instead.
     */
    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * @return array
     * By default, upsert, in case of updating, will update all columns that match model's attributes. However,
     * if you need to update only specific column(s) during upsert, you can also implement the WithUpsertColumns concern.
     */
    public function upsertColumns()
    {
        return ['name', 'role'];
    }

    /**
     * #Handling persistence on your own
     */
    /*
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $group = Group::firstOrCreate([
            'name' => $row[1],
        ]);

        $group->users()->create([
            'name' => $row[0],
        ]);
    }*/
}
