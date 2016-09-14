<?php

namespace model;

class DateTime {
	public function getDate() {
		$unixTime = time();
		$format = "l, \\t\\h\\e j\\t\\h \\o\\f F o, \\T\\h\\e \\t\\i\\m\\e \\i\\s H:i:s";
		return gmdate($format, $unixTime);
	}
}