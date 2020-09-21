<?php
namespace App\Imports;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
           'name'     	=> $row['name'],
           'email'    => $row['email'],
           'password' => Hash::make('password'),
           'created_at' => $row['added_time']
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
