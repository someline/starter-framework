<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Base\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Presenter\ModelFractalPresenter;
use Someline\Model\Foundation\User;
use Someline\Model\Interfaces\BaseModelEventsInterface;
use Someline\Model\Interfaces\FriendStatusInterface;
use Someline\Model\Traits\BaseModelEvents;

class BaseModel extends Model implements BaseModelEventsInterface
{
    use BaseModelEvents;

    /**
     * Indicates if the model should be auto set user_id.
     *
     * @var bool
     */
    protected $autoUserId = true;

    /**
     * Indicates if the model should be recorded ips.
     *
     * @var bool
     */
    protected $ips = true;

    /**
     * Indicates if the model should be recorded users.
     *
     * @var bool
     */
    protected $update_users = true;

    /**
     * Indicates timestamp is always saved in UTC timezone
     *
     * @var bool
     */
    protected $timestamp_always_save_in_utc = true;

    /**
     * Indicates timestamp is always get in user timezone
     *
     * @var bool
     */
    protected $timestamp_get_with_user_timezone = true;

    /**
     * Get the auth instance.
     *
     * @return \Dingo\Api\Auth\Auth
     */
    protected function api_auth()
    {
        return app('Dingo\Api\Auth\Auth');
    }

    /**
     * Get ID from the model primary key
     *
     * @return mixed
     */
    public function getIdAttribute()
    {
        return $this->getKey();
    }

    /**
     * Get current auth user
     *
     * @return User|null
     */
    public function getAuthUser()
    {
        $user = null;
        if ($this->api_auth()->check()) {
            $user = $this->api_auth()->user();
        } else if (\Auth::check()) {
            $user = \Auth::user();
        }
        return $user;
    }

    /**
     * Get current auth user_id
     *
     * @return mixed|null
     */
    public function getAuthUserId()
    {
        $user_id = null;
        $user = $this->getAuthUser();
        if ($user) {
            $user_id = $user->user_id;
        }
        return $user_id;
    }

    /**
     * Get current model's user_id
     *
     * @return mixed|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Update the creation and update ips.
     *
     * @return void
     */
    protected function updateIps()
    {
        $ip = smart_get_client_ip();

        if (!$this->isDirty('updated_ip')) {
            $this->updated_ip = $ip;
        }

        if (!$this->exists && !$this->isDirty('created_ip')) {
            $this->created_ip = $ip;
        }
    }

    /**
     * Update the creation and update by users.
     *
     * @return void
     */
    protected function updateUsers()
    {
        $user_id = $this->getAuthUserId();
        if (!($user_id > 0)) {
            return;
        }

        if (!$this->isDirty('updated_by')) {
            $this->updated_by = $user_id;
        }

        if (!$this->exists && !$this->isDirty('created_by')) {
            $this->created_by = $user_id;
        }
    }

    /**
     * @return bool
     */
    public function isAuthUserOwner()
    {
        return $this->getAuthUserId() == $this->getUserId();
    }

    /**
     * @return Carbon
     */
    public function getNowUTCTime()
    {
        return Carbon::now('UTC');
    }

    /**
     * @return Carbon
     */
    public function getNowAuthUserTime()
    {
        return Carbon::now($this->getAuthUserDateTimezone());
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return User|null
     */
    public function getRelatedUser()
    {
        return $this->related_user;
    }

    /**
     * Set Model Presenter
     * @return $this
     */
    public function setModelPresenter()
    {
        $this->setPresenter(new ModelFractalPresenter());
        return $this;
    }

    /**
     * Return a timezone for all Datetime objects
     *
     * @return mixed
     */
    public function getAuthUserDateTimezone()
    {
        $user = $this->getAuthUser();
        if ($user && !empty($user->timezone)) {
            return $user->timezone;
        } else {
            return app_timezone();
        }
    }

    /**
     * Set a given attribute on the model.
     *
     *
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {

        if ($this->timestamp_always_save_in_utc) {
            // set to UTC only if Carbon
            if ($value instanceof Carbon) {
                $value->setTimezone('UTC');
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        if ($value instanceof Carbon && $this->timestamp_get_with_user_timezone) {
            $value->setTimezone($this->getAuthUserDateTimezone());
        }

        return $value;
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        if ($date instanceof Carbon && $this->timestamp_get_with_user_timezone) {
            $date->setTimezone($this->getAuthUserDateTimezone());
        }
        return $date->format($this->getDateFormat());
    }

}