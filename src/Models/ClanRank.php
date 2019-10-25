<?php

namespace Limelight\API\Models;
use Limelight\API\Client\APIClient;

class ClanRank extends Model {
	private $id = 0;
	private $rank = '';

	public function __construct($id, $rank){
		$this->id = $id;
		$this->rank = $rank;
	}

	/**
	 * @return int
	 */
	public function getID(): int{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getRank(): string{
		return $this->rank;
	}

	public static function fromObject(object $obj, APIClient $api = null): self {
		$rank = new static($obj->id, $obj->rank);

		if (!is_null($api)){
			$rank->setClient($api);
		}

		return $rank;
	}
}