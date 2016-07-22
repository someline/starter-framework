<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Auth;

trait AuthUserHelpers
{

    /**
     * @return \Someline\Models\Foundation\User
     */
    public function getAuthUser()
    {
        return auth_user();
    }

    /**
     * @return mixed|null
     */
    public function getAuthUserId()
    {
        return $this->getAuthUser()->getUserId();
    }

}