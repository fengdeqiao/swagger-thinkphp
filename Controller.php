<?php

/**
 * @SWG\Resource(
 *  basePath="http://skyapi.dev",
 *  resourcePath="/vps",
 *  @SWG\Api(
 *   path="/vps",
 *   @SWG\Operation(
 *    method="GET",
 *    type="array",
 *    summary="Fetch vps lists",
 *    nickname="vps/index",
 *    @SWG\Parameter(
 *     name="expand",
 *     description="Models to expand",
 *     paramType="query",
 *     type="string",
 *     defaultValue="vps,os_template"
 *    )
 *   )
 *  )
 * )
 */
class VpsController extends Controller
{
    // ...
}
