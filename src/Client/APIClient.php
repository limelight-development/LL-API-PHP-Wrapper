<?php

namespace Limelight\API\Client;

use GuzzleHttp\Client;
use BadFunctionCallException;
use Limelight\API\Models\Clan;

class APIClient {
	public static $BASE_URL = "https://api.limelightgaming.net/dev/";
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

	public function get(...$args){
		$rtn = $this->client->get(...$args);
		$code = $rtn->getStatusCode();
		if ($code < 200 || $code >= 300){
			return false;
		} else {
			$obj = json_decode($rtn->getBody()->getContents());
			if ($obj->status !== 'success'){
				return false;
			} else {
				return $obj;
			}
		}
	}

	public function Clans($withMembers = false, $withRanks = false){
		$with = array_keys(array_filter(['members' => $withMembers, 'ranks' => $withRanks]));
		if (empty($with)){
			$url = 'clans';
		} else {
			$url = 'clans?with=' . join(',', $with);
		}

		$rtn = $this->get($url);
		if (!$rtn){return [];}

		return array_map(Clan::class . '::fromObject', $rtn->data, array_fill(0, count($rtn->data), $this));
	}

	public function Clan($id, $withMembers = false, $withRanks = false){
		$with = array_keys(array_filter(['members' => $withMembers, 'ranks' => $withRanks]));
		if (empty($with)){
			$url = "clans/{$id}";
		} else {
			$url = "clans/{$id}?with=" . join(',', $with);
		}

		$rtn = $this->get($url);
		if (!$rtn){return [];}

		return Clan::fromObject($rtn->data, $this);
	}
}