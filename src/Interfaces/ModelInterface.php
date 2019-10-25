<?php

namespace Limelight\API\Interfaces;

interface ModelInterface {
	public static function fromResponse(string $json);
}