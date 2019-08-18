<?php

namespace Limelight\API\Client;

use GuzzleHttp\Client;
use BadFunctionCallException;

class APIClient {
	public static $BASE_URL = "https://api.limelightgaming.net/v2/";
	private $client;
	private $options = [];

	public function __construct($opts = []){
		if (is_string($opts)){
			$opts = [
				"key" => $opts
			];
		} elseif (is_null($opts)){
			$opts = [];
		} elseif (!is_array($opts)){
			throw new \InvalidArgumentException('Bad "$opts" passed. Expected string, null or array.');
		}

		$guzzle = $opts["guzzle"] ?? [];
		$guzzle["base_uri"] = static::$BASE_URL;
		$guzzle["headers"] = $guzzle["headers"] ?? [];
		$guzzle["headers"]["User-Agent"] = $guzzle["headers"]["User-Agent"] ?? "LL-API-PHP/1.0.0";
		$guzzle["headers"]["Accept"] = $guzzle["headers"]["Accept"] ?? "application/json";

		if (!isset($guzzle["headers"]["Authorization"])){
			if (isset($opts["key"])){
				$guzzle["headers"]["Authorization"] = "Bearer {$opts["key"]}";
			} elseif (isset($opts["username"], $opts["password"])){
				$key = base64_encode("{$opts["username"]}:{$opts["password"]}");
				$guzzle["headers"]["Authorization"] = "Basic {$key}";
			}
		}

		$opts["guzzle"] = $guzzle;
		$this->client = new Client($guzzle);
		$this->options = $opts;
	}

	public function __call($name, $arguments){
		if (method_exists($this->client, $name)){
			return $this->client->{$name}(...$arguments);
		}

		throw new BadFunctionCallException("Attempted to __call() invalid function.");
	}
}