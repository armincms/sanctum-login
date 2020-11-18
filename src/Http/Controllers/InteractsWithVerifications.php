<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
   
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Armincms\SanctumLogin\Models\User;
use Armincms\SanctumLogin\Models\MobileVerification;

trait InteractsWithVerifications
{    
    /**
     * Attempt to verify the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptVerification(Request $request)
    { 
        return MobileVerification::whereHash($request->route('hash'))
                    ->whereCode($request->get($this->verify()))
                    ->first();
    } 

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendVerificationResponse(Request $request, $user)
    { 
        $this->sendVerificationCode($verification = $this->freshVerification($user), $user); 

        return [
            'verify' => route('login.verification', $verification->hash),
        ];
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request, $verification)
    {  
        $verification::cleanup($user = User::findOrFail($verification->user));

        return [
            'token' => $user->createToken(class_basename($this))->plainTextToken,
            'id'    => $user->id,
        ];
    } 

    /**
     * Create new verification instance.
     * 
     * @param \Armincms\SanctumLogin\Models\User   $user
     * @return \Armincms\SanctumLogin\Models\MobileVerification      
     */
    public function freshVerification(User $user)
    {  
        return MobileVerification::forUser($user);
    }  

    /**
     * Message the verification code.
     * 
     * @param \Armincms\SanctumLogin\Models\MobileVerification $verification
     * @param \Armincms\SanctumLogin\Models\User   $user
     * @return string
     */
    public function sendVerificationCode(MobileVerification $verification, $user)
    { 
        app('qasedak')->send($this->verificationMessage($verification), $user->getMeta('mobile'));

        return $this;
    }

    /**
     * Get the verification message.
     * 
     * @param \Armincms\SanctumLogin\Models\MobileVerification $verification
     * @return string
     */
    public function verificationMessage(MobileVerification $verification)
    {
        return __("Welcom to :name. Your verification code is :code.", [
            'name' => config('app.name'),
            'code' => $verification->code,
        ]);
    }

    /**
     * Validate the user verify request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateVerification(Request $request)
    {
        $request->validate([ 
            $this->verify() => 'required|string',
        ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedVerificationResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->verify() => [__('Invalid verify code')],
        ]);
    }

    /**
     * Get the verify code name.
     * 
     * @return string
     */
    public function verify()
    {
        return 'verify_code';
    }
}