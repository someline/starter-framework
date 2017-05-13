<?php

namespace Someline\Presenters;

use Someline\Transformers\BasicTransformer;

/**
 * Class BasicPresenter
 *
 * @package namespace Someline\Presenters;
 */
class BasicPresenter extends BasePresenter
{

    /**
     * @var string
     */
    protected $transformer = null;

    /**
     * @param string $transformer
     */
    public function setTransformer(string $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        if ($this->transformer) {
            return new $this->transformer();
        } else {
            return new BasicTransformer();
        }
    }

}
