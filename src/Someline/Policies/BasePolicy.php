<?php

namespace Someline\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Someline\Model\BaseModel;
use Someline\Model\Foundation\User;

abstract class BasePolicy
{

    /**
     * @param User $user
     * @param BaseModel $model
     * @return bool
     */
    public function owner(User $user, BaseModel $model)
    {
        return $model->getUserId() == $user->getUserId();
    }

}
