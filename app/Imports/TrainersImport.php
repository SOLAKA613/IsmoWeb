<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Trainer;
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

class TrainersImport implements ToModel,SkipsEmptyRows, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $trainer = new Trainer;
        $account = new Account;

        $columnValues = array_values($row);

            $trainer->id  = $columnValues[0];
            $trainer->first_name   = $columnValues[1];
            $trainer->last_name   = $columnValues[2];
            $trainer->age  = $columnValues[3];
            $trainer->email  = $columnValues[4];
            $trainer->gender  = $columnValues[5];

            $trainer->save();

            $account->id = $columnValues[0];
            $account->login = $columnValues[6];
            $account->password = Hash::make($columnValues[7]);

            $account->save();

            $trainer->concerned()->create([
                'account_id' => $columnValues[0],
                'trainer_id' => $columnValues[0]
            ]);

    }


    public function rules(): array
    {
        return [
           'id' => ['required','integer','unique:trainers,id'],
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

}

