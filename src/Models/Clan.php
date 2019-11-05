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
	 * @param mixed $ranks
	 */
	public function setRanks($ranks): void{
		$this->ranks = $ranks;
	}

	/**
	 * @return mixed
	 */
	public function getMembers(){
		if (!isset($this->members)){
			$this->members = $this->getClient()->ClanMembers($this->id);
		}

		return $this->members;
	}

	public static function fromObject(object $obj, APIClient $api = null): self {
		$clan = new static($obj->id, $obj->name);

		if (!is_null($api)){
			$clan->setClient($api);
		}

		if (isset($obj->members)){
			$clan->setMembers(Model::substantiate(ClanMember::class, $obj->members, $api));
		}

		if (isset($obj->ranks)){
			$clan->setRanks(Model::substantiate(ClanRank::class, $obj->ranks, $api));
		}

		return $clan;
	}
}