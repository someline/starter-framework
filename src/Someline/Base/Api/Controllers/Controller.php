<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Base\Api\Controllers;


use Dingo\Api\Routing\Helpers;
use Someline\Api\Foundation\Validation\ValidatesRequests;
use Someline\AuthUserHelpers;
use Someline\Base\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ValidatesRequests;
    use Helpers;

}