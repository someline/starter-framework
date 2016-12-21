<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Lyfing\Auth;

trait AuthUserHelpers
{

    /**
     * @return \Lyfing\Models\Foundation\User
     */
    public function getAuthUser()
    {
        return current_auth_user();
    }

    /**
     * @return mixed|null
     */
    public function getAuthUserId()
    {
        return $this->getAuthUser()->getUserId();
    }

}