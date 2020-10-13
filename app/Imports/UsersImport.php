<?php
namespace App\Imports;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading,WithValidation,SkipsOnError,ShouldQueue
{
    public function model(array $row)
    {
        return new User([
           'name'     => $row['name'],
           'email'    => $row['email'],
           'password' => Hash::make('password'),
           'created_at' => $row['added_time']
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }

	public function rules(): array
	{
		return [
			'.*' => ['email', 'unique:users,email']

		];
	}
	public function onError(\Throwable $e)
	{

	}
}
