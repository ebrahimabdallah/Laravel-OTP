<?php

namespace App\Http\Requests\Auth;


// use App\Notifications\TwoFactor;
use App\Models\User;
use App\Notifications\TwoFactor;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
        
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        
        $user = User::where('email', $this->input('email'))->first();
         $user->genrateCode();
         
         //Send By Mail
        //  $user->notify(new TwoFactor());
        
        //Send By Phone
        $message = "Login OTP is " . $user->code;
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_FROM');
        
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            '+201068389295',
            [
                'from' => $twilio_number,
                'body' => $message
            ]
        );
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
