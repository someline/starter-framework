<?php

namespace Starter\Base\Policies;

use Starter\Base\Models\BaseModel;
use Starter\Model\Foundation\User;

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
