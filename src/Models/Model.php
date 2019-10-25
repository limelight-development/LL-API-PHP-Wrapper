<?php


namespace Limelight\API\Models;


use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ClientAware;

class Model implements ClientAware {
	private $client;
	public function setClient(APIClient $client){$this->client = $client;}
	public function getClient(): APIClient {return $this->client;}

	public static function fromResponse(string $json){
		return json_decode($json);
	}
}