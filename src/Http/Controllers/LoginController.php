<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
 
use Illuminate\Routing\Controller; 

class LoginController extends Controller
{  
	use AuthenticatesUsers; 

	public function __construct()
	{
		$this->middleware('throttle:5');
	} 
}