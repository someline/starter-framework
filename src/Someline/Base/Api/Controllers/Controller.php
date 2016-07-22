<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Base\Api\Controllers;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Someline\Api\Foundation\Validation\ValidatesRequests;
use Someline\AuthUserHelpers;
use Someline\Base\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    use Helpers;

}