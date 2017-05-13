<?php

namespace Someline\Repositories;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\PresenterInterface;
use Someline\Presenters\BasicPresenter;

class PresenterRepository
{

    protected $skipPresenter = false;

    protected $presenter = null;

    /**
     * PresenterRepository constructor.
     * @param string|null $transformer
     * @param bool $skipPresenter
     */
    public function __construct(string $transformer = null, $skipPresenter = false)
    {
        $basicPresenter = new BasicPresenter();
        $basicPresenter->setTransformer($transformer);
        $this->presenter = $basicPresenter;
        $this->skipPresenter = $skipPresenter;
    }

    /**
     * @return bool
     */
    public function isSkipPresenter(): bool
    {
        return $this->skipPresenter;
    }

    /**
     * @param bool $skipPresenter
     */
    public function setSkipPresenter(bool $skipPresenter)
    {
        $this->skipPresenter = $skipPresenter;
    }

    /**
     * @return null
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @param null|PresenterInterface $presenter
     */
    public function setPresenter(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Wrapper result data
     *
     * @param mixed $result
     *
     * @return mixed
     */
    public function parserResult($result)
    {
        if ($this->presenter instanceof PresenterInterface) {

            if ($result instanceof Collection || $result instanceof LengthAwarePaginator) {
                $result->each(function ($model) {
                    if ($model instanceof Presentable) {
                        $model->setPresenter($this->presenter);
                    }

                    return $model;
                });
            } elseif ($result instanceof Presentable) {
                $result = $result->setPresenter($this->presenter);
            }

            if (!$this->skipPresenter) {
                return $this->presenter->present($result);
            }
        }

        return $result;
    }

}