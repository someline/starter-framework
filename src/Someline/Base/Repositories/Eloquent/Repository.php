<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Base\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Someline\Base\Presenters\Presenter;
use Someline\Base\Repositories\Interfaces\RepositoryInterface;
use Someline\Repositories\Criteria\AuthUserCriteria;

abstract class Repository extends BaseRepository implements RepositoryInterface
{

    /**
     * @var bool
     */
    protected $isSearchableForceAndWhere = false;

    /**
     * @var Model
     */
    protected $relateModel;

    /**
     * @var Relation
     */
    protected $relation;

    public function byAuthUser()
    {
        $this->pushCriteria(new AuthUserCriteria());
        return $this;
    }

    public function authUserId()
    {
        return current_auth_user()->user_id;
    }

    public function validateCreate(array $attributes)
    {
        if (!is_null($this->validator)) {
            $this->validator->with($attributes)
                ->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
    }

    public function validateUpdate(array $attributes)
    {
        if (!is_null($this->validator)) {
            $this->validator->with($attributes)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }
    }

    /**
     * @param $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function present($results)
    {
        return $this->parserResult($results);
    }

    /**
     * @param Model $relateModel
     * @return $this
     */
    public function setRelateModel(Model $relateModel)
    {
        $this->relateModel = $relateModel;
        if ($relateModel) {
            $this->makeModel();
        }
        return $this;
    }

    /**
     * @return Relation
     */
    public function relation()
    {
        return null;
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->relateModel ? $this->relation() : $this->app->make($this->model());

        if (!($model instanceof Model || $model instanceof Relation)) {
            throw new RepositoryException("Class " . get_class($model) . " must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }


    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();
        $this->applyScope();

        $lists = $this->model->lists($column, $key);

        $this->resetModel();

        return $lists;
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($this->model instanceof \Illuminate\Database\Eloquent\Builder
            || $this->model instanceof \Illuminate\Database\Eloquent\Relations\Relation
        ) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        return $this->parserResult($results);
    }


    /**
     * Add a basic where clause to the model.
     *
     * @param  string|array|\Closure $column
     * @param  mixed $value
     * @return $this
     */
    protected function modelWhere($column, $value = null)
    {
        $this->model = $this->model->where($column, $value);
        return $this;
    }

    /**
     * @return \Prettus\Repository\Contracts\PresenterInterface
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @param array $meta
     */
    public function setPresenterMeta(array $meta)
    {
        if ($this->presenter instanceof Presenter) {
            $this->presenter->setMeta($meta);
        }
    }

    /**
     * @return bool
     */
    public function getIsSearchableForceAndWhere()
    {
        return $this->isSearchableForceAndWhere;
    }

    /**
     * Find data by where conditions
     *
     * @param array $where
     *
     * @return $this
     */
    public function where(array $where)
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);

        return $this;
    }

    /**
     * Retrieve first data of repository with fail if not found
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function firstOrFail($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->firstOrFail($columns);

        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * Where first
     *
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function whereFirst(array $where, $columns = ['*'])
    {
        return $this->where($where)->firstOrFail($columns = ['*']);
    }

    /**
     * Use Model for custom usages
     *
     * @param callable $callback
     * @return $this
     */
    public function useModel(callable $callback)
    {
        $this->model = $callback($this->model);
        return $this;
    }

    /**
     * Remove all or passed registered global scopes.
     *
     * @param  array|null  $scopes
     * @return $this
     */
    public function withoutGlobalScopes(array $scopes = null)
    {
        $this->model = $this->model->withoutGlobalScopes($scopes);
        return $this;
    }

}