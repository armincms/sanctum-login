<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
 
use Illuminate\Http\Request;

class TwoFactorLoginController extends SimpleLoginController
{ 
	use InteractsWithVerifications;  

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request, $user)
    { 
        return $this->sendVerificationResponse($request, $user);     
    }
}