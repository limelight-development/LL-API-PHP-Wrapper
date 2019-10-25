<?php


namespace Limelight\API\Models;


use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ClientAware;

class Model implements ClientAware {
	private $client;
	public function setClient(APIClient $client){$this->client = $client;}
	public function getClient(): APIClient {return $this->client;}

	public static function substantiate(string $class, array $data, APIClient $api){
		return array_map(
			$class . '::fromObject', $data,
			array_fill(0, count($data), $api)
		);
	}
}