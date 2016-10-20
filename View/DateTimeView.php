<?php

namespace View;

class DateTimeView {
	private $time;
	
	public function __construct($time) {
		$this->time = $time;
	}

	public function show() {
		// Matching [DAY_OF_WEEK], the [DAY](st/nd/rd/th) [MONTH] [YEAR], The time is [H:i:s]
		$format = "l, \\t\\h\\e jS \\o\\f F o, \\T\\h\\e \\t\\i\\m\\e \\i\\s H:i:s";
		$time = gmdate($format, $this->time);
		return '<p>' . $time . '</p>';
	}
}
