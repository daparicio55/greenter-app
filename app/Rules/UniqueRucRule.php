<?php

namespace App\Rules;

use App\Models\Company;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Tymon\JWTAuth\Facades\JWTAuth;

class UniqueRucRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $company = Company::where('ruc', $value)
        ->where('user_id',JWTAuth::user()->id)
        ->first();
        if($company){
            $fail("La compañia ya existe");
        }
        
    }
}
