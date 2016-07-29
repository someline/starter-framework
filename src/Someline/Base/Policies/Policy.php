<?php

namespace Someline\Base\Policies;

use Someline\Base\Models\BaseModel;
use Someline\Model\Foundation\User;

abstract class Policy
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
