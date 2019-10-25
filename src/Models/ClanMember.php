<?php

namespace Limelight\API\Models;
use SteamID;
use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ModelInterface;

class ClanMember extends Player {
	private $rankid = 0;
	private $icname = '';

	/**
	 * @param string $icname
	 */
	public function setICName(string $icname): void{
		$this->icname = $icname;
	}

	/**
	 * @param int $rankid
	 */
	public function setRankID(int $rankid): void{
		$this->rankid = $rankid;
	}

	/**
	 * @return string
	 */
	public function getICName(): string{
		return $this->icname;
	}

	/**
	 * @return int
	 */
	public function getRankID(): int{
		return $this->rankid;
	}

	public static function fromObject(object $obj, APIClient $api = null): self {
		$ply = parent::fromObject($obj, $api);
		/** @var $ply ClanMember */
		$ply->setICName($obj->icname);
		$ply->setRankID($obj->rankid);
		return $ply;
	}
}