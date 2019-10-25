<?php


namespace Limelight\API\Models;


use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ModelInterface;

class Clan extends Model implements ModelInterface {
	private $id = 0;
	private $name = '';
	private $members;
	private $ranks;

	public function __construct($id, $name){
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * @param mixed $members
	 */
	public function setMembers($members): void{
		$this->members = $members;
	}

	/**
	 * @return mixed
	 */
	public function getMembers(){
		return $this->members;
	}

	public static function fromResponse(string $json): self {
		$obj = parent::fromResponse($json);
		return new static($obj->id, $obj->name);
	}

	public static function fromObject(object $obj, APIClient $api = null): self {
		$clan = new static($obj->id, $obj->name);

		if (!is_null($api)){
			$clan->setClient($api);
		}

		if (isset($obj->members)){
			$clan->setMembers(array_map(ClanMember::class . '::fromObject', $obj->members, array_fill(0, count($obj->members), $api)));
		}

		if (isset($obj->ranks)){
			// TODO: Add ranks.
		}

		return $clan;
	}
}