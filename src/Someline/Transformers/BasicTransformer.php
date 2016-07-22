<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Transformers;


use Someline\Base\Transformers\Transformer;

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