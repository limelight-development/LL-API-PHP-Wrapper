<?php

namespace Limelight\API\Models;
use SteamID;
use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ModelInterface;

class Player extends Model implements ModelInterface {
	/** @var SteamID */
	private $steamid;
	private $name = 'Invalid';

	public function __construct($steamid, $name){
		$this->steamid = new SteamID($steamid);
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName(): string{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getSteamID64(): int {
		return $this->steamid->ConvertToUInt64();
	}

	public function getSteamID32(): string {
		return $this->steamid->RenderSteam2();
	}

	public static function fromResponse(string $json){
		$obj = json_decode($json);
		$ply = new static($obj->steamid, $obj->name);
		return $ply;
	}

	public static function fromObject(object $obj, APIClient $api = null){
		if (isset($obj->name)){
			$name = $obj->name;
		} elseif (isset($obj->steamname)){
			// Clan APIs were responding with steamname for a while.
			$name = $obj->steamname;
		}

		$ply = new static($obj->steamid, $name);

		if (!is_null($api)){
			$ply->setClient($api);
		}

		return $ply;
	}
}