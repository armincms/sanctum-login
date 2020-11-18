<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
 
use Illuminate\Http\Request;
use Armincms\SanctumLogin\Models\User;

class MobileLoginController extends LoginController
{  
    use InteractsWithVerifications;

	public function __invoke(Request $request)
	{
		return parent::login($request);
	}

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    { 
        return User::whereHas('metas', function($query) use ($request) {
            $query->where($query->qualifyColumn('key'), 'mobile')->whereValue($request->geT('mobile'));
        })->first() ?: $this->attemptRegister($request); 
    }

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

    /**
     * Attempt to register the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptRegister(Request $request)
    {  
    	$users = User::count();

    	return tap(User::create([
    		'username' => $mobile = $request->get('mobile'),
    		'password' => bcrypt($mobile),
    		'firstname' 	=> "User {$users}",
    		'lastname' 		=> "User {$users}",
    		'displayname' 	=> "User {$users}",
    		'email' 		=> "user{$users}@example.com", 
    	]), function($user) use ($mobile) {
    		$user->setMeta('mobile', $mobile);
    		$user->save();
    	}); 
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', function($attribute, $value, $fail) {
            	if(! preg_match('/^(0|98)[0-9]{10}$/', $value)) {
            		$fail(__('Invalid mobile number'));
            	}
            }], 
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'mobile';
    } 
}