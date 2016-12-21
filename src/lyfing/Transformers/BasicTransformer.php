<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Lyfing\Transformers;


use Lyfing\Base\Transformers\Transformer;

class BasicTransformer extends Transformer
{

    /**
     * Transform the Any entity
     *
     * @param $value
     * @return mixed
     */
    public function transform($value)
    {
        return $value;
    }
    
}