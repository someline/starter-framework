<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Starter\Base\Api\Controllers;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Starter\Api\Foundation\Validation\ValidatesRequests;
use Starter\Auth\AuthUserHelpers;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use AuthUserHelpers;
    use Helpers;

}