<?php


namespace Limelight\API\Interfaces;


use Limelight\API\Client\APIClient;

interface ClientAware {
	public function setClient(APIClient $client);
	public function getClient(): APIClient;
}