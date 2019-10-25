<?php

use Limelight\API\Client\APIClient;

require __DIR__ . '/vendor/autoload.php';

$x = new APIClient();
var_dump($x->Clans()[5]);
var_dump($x->Clan(511, true)->getMembers()[0]);