<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Model\Traits;


use Illuminate\Database\Eloquent\Model;
use Someline\Model\Observers\BaseModelObserver;

/**
 * Whenever a new model is saved for the first time,
 * the creating and created events will fire.
 * If a model already existed in the database and the save method is called,
 * the updating / updated events will fire.
 * However, in both cases, the saving / saved events will fire.
 *
 * @CREATE: saving > creating > created > saved
 * @UPDATE: saving > updating > updated > saved
 *
 */
trait BaseModelEvents
{

    protected static function boot()
    {
        parent::boot();

        /** @var Model $ModelName */
        $ModelName = get_called_class();

        // Setup event bindings...
        $ModelName::observe(new BaseModelObserver);
    }

    public function onCreating()
    {

        /*
         * check whether the UUID primary key is used.
         *
         * if the $primaryKey value is string(single key), not an array(union key),
         * and $incrementing is false, $keyType is string,
         * automatically use UUID as $primaryKey if the $primaryKey is empty.
         */
        $keyIsEmpty = is_string($this->primaryKey) && empty(array_get($this->attributes, $this->primaryKey));
        if ($keyIsEmpty && (false === $this->incrementing) && ('string' === $this->keyType))
            $this->attributes[$this->primaryKey] = $this->uuid();

        // auto set user id
        if ($this->autoUserId && empty($this->user_id)) {
            $user_id = $this->getAuthUserId();
            if ($this->validUserId($user_id)) {
                $this->user_id = $user_id;
            }
        }

    }

    public function onCreated()
    {
    }

    public function onUpdating()
    {
    }

    public function onUpdated()
    {
    }

    public function onSaving()
    {

        // update ips if true
        if ($this->ips) {
            $this->updateIps();
        }

        // update users if true
        if ($this->update_users) {
            $this->updateUsers();
        }

    }

    public function onSaved()
    {
    }

    public function onDeleting()
    {
    }

    public function onDeleted()
    {
    }

    public function onRestoring()
    {
    }

    public function onRestored()
    {
    }

    /**
     * check the $user_id is valid.
     *
     * @param  int|string $user_id
     * @return bool
     */
    protected function validUserId($user_id): bool
    {
        if ('int' === $this->keyType)
            return $user_id > 0;

        if ('string' === $this->keyType)
            return strlen($user_id) > 0;
    }

    /**
     * generate a uuid string.
     *
     * @param  bool $use32bytes
     * @return string the uuid string
     */
    protected function uuid(bool $use32bytes = false): string
    {
        if ($use32bytes)
            return \Ramsey\Uuid\Uuid::uuid4()->getHex();

        return \Ramsey\Uuid\Uuid::uuid4()->getNodeHex();
    }

}