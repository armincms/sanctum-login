<?php 

namespace Armincms\SanctumLogin\Models;

use Core\User\Models\User as Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{ 
	use HasApiTokens {
        HasApiTokens::createToken as sanctumCreateToken;
    } 

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    { 
		return parent::class;
	}

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        return tap($this->sanctumCreateToken($name, $abilities), function($access) {
            if(! is_null($access)) {
                $access->accessToken->forceFill(['tokenable_type' => static::class])->save(); 
            }
        }); 
    }
}