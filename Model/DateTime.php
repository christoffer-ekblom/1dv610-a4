<?php

namespace Model;

class DateTime {
	private static $timeOffsetHours = 2;

	public static function getTime() {
		$timeOffset = self::hoursToSeconds(self::$timeOffsetHours);
		return time() + $timeOffset;
	}

	private static function hoursToSeconds($hours) {
		return $hours*3600;
	}
}
