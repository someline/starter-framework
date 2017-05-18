<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Model\Foundation;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Someline\Base\Models\BaseModel;
use Someline\Model\Interfaces\BaseModelEventsInterface;

class User extends BaseModel implements BaseModelEventsInterface,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    Transformable
{
    use Authenticatable, Authorizable, CanResetPassword;
    use TransformableTrait;
    use HasApiTokens, Notifiable;

    const MORPH_NAME = 'User';

    /**
     * Indicates if the model should be auto set user_id.
     *
     * @var bool
     */
    protected $autoUserId = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

}
