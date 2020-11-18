<?php 

namespace Armincms\SanctumLogin\Http\Controllers;
 
use Illuminate\Http\Request;

class SimpleLoginController extends LoginController
{ 
	public function __invoke(Request $request)
	{
		return parent::login($request);
	}
}