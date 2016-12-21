<?php

namespace Lyfing\Base\Policies;

use Lyfing\Base\Models\BaseModel;
use Lyfing\Model\Foundation\User;

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
