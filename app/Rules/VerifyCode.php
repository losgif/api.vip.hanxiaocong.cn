<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Sms;

class VerifyCode implements Rule
{
    use Sms;

    public $phone;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->verifyCode($this->phone, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '验证码错误';
    }
}