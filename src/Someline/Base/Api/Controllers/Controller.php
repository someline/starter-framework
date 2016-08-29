<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Base\Api\Controllers;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Someline\Api\Foundation\Validation\ValidatesRequests;
use Someline\Auth\AuthUserHelpers;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use AuthUserHelpers;
    use Helpers;

}