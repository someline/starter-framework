<?php

namespace Starter\Presenters;

use Starter\Transformers\BasicTransformer;

/**
 * Class BasicPresenter
 *
 * @package namespace Starter\Presenters;
 */
class BasicPresenter extends BasePresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BasicTransformer();
    }
}
