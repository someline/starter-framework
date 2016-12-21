<?php

namespace Lyfing\Presenters;

use Lyfing\Transformers\BasicTransformer;

/**
 * Class BasicPresenter
 *
 * @package namespace Lyfing\Presenters;
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
