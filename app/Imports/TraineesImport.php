<?php

namespace App\Imports;

use App\Models\Trainee;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;


class  TraineesImport implements ToModel,SkipsEmptyRows, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $trainee = new Trainee;
        $account = new Account;

        $columnValues = array_values($row);

            $trainee->id  = $columnValues[0];
            $trainee->first_name   = $columnValues[1];
            $trainee->last_name   = $columnValues[2];
            $trainee->age  = $columnValues[3];
            $trainee->email  = $columnValues[4];
            $trainee->gender  = $columnValues[5];
            $trainee->group_id  = session('idGroup');

            $trainee->save();

            $account->id = $columnValues[0];
            $account->login = $columnValues[6];
            $account->password = Hash::make($columnValues[7]);

            $account->save();

            $trainee->having()->create([
                'account_id' => $columnValues[0],
                'trainee_id' => $columnValues[0]
            ]);

    }


    public function rules(): array
    {
        return [
           'id' => ['required','integer','unique:trainees,id'],
           '*.first_name' => ['required','string','min:3','max:25'],
           '*.last_name' => ['required','string','min:3','max:25'],
           '*.age' => ['required','integer','min:2','max:2'],
           '*.email' => ['email','unique:trainees,email'],
           '*.gender' => ['required',
            function ($attribute, $value, $fail) {
                if (Str::of($value)->lower() != 'male' && Str::of($value)->lower() != 'female' ) {
                    $fail('The '.$attribute.' is invalid.');
                }
            },],
            '*.login' => ['required','string','min:8','max:25'],
            '*.password' => ['required', 'confirmed', Password::min(8)->mixedCase(),'max:35'],
        ];
    }

 /*   public function prepareForValidation($data, $index)
    {
        $data['email'] = $data['email'] ?? $this->myOtherWayOfFindingTheEmail($data);

        return $data;
    } */
}
