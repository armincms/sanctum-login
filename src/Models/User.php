<?php 

namespace Armincms\SanctumLogin\Models;

use Core\User\Models\User as Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{ 
	use HasApiTokens; 

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    { 
		return parent::class;
	}
}