<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
 
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller; 
use Armincms\SanctumLogin\Models\User;
use Armincms\SanctumLogin\Models\MobileVerification;

class VerificationController extends Controller
{  
	use InteractsWithVerifications;

	public function __invoke(Request $request)
	{ 
		$this->validateVerification($request);		 

		if($verification = $this->attemptVerification($request)) {
			return $this->sendLoginResponse($request, $verification);
		}

        return $this->sendFailedVerificationResponse($request);
	} 
}