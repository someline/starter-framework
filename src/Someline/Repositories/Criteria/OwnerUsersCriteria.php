<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class OwnerUsersCriteria implements CriteriaInterface
{

    protected $userIds = [];

    /**
     * AuthUserCriteria constructor.
     * @param array $userIds
     */
    public function __construct($userIds)
    {
        $this->userIds = $userIds;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereIn('user_id', $this->userIds);
        return $model;
    }

}