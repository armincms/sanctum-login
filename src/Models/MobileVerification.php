<?php 

namespace Armincms\SanctumLogin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model; 

class MobileVerification extends Model
{ 
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(function (Builder $builder) {
            $builder->where('created_at', '>=', now()->subMinutes(config('sanctum-login.code_expiration', 5)));
        });
    }

    /**
     * Create new isntance for the given user.
     * 
     * @param  \Armincms\SanctumLogin\Models\User $user
     * @return static      
     */
    public static function forUser(User $user)
    {
        static::cleanup($user);

        return static::unguarded(function() use ($user) {
            return static::create([
                'code' => rand(99999, 999999),
                'user' => $user->id,
                'hash' => md5(time() . $user->id),
                'created_at' => now(),
            ]);
        });  
    }

    /**
     * Create new isntance for the given user.
     * 
     * @param  \Armincms\SanctumLogin\Models\User $user
     * @return static      
     */
    public static function cleanup(User $user)
    {
        static::whereUser($user->id)->delete();

        return static::class;
    }
}