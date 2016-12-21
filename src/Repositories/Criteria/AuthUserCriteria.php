<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Starter\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class AuthUserCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('id', '=', current_auth_user()->id);
        return $model;
    }

}