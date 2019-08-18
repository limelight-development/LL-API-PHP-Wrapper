<?php

namespace Limelight\API\Models;
use Limelight\API\Client\APIClient;
use Limelight\API\Interfaces\ModelInterface;

class Player extends APIClient implements ModelInterface {
	/** Internal 64 bit representation of the player's steamID.
	 * @var string
	 */
	private $steamid = "0";

	/** Player's last known steam name.
	 * @var string
	 */
	private $name = "Invalid";
}