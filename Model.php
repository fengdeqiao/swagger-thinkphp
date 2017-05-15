<?php

/**
* @SWG\Model(
* id="vps",
* required="['type', 'hostname']",
*  @SWG\Property(name="hostname", type="string"),
*  @SWG\Property(name="label", type="string"),
*  @SWG\Property(name="type", type="string", enum="['vps', 'dedicated']")
* )
*/
class HostVps extends Host implements ResourceInterface
{
    // ...
}
