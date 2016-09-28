<?php

namespace View;

class DateTimeView {
	private $time;
	
	public function __construct($time) {
		$this->time = $time;
	}

	public function show() {
		$format = "l, \\t\\h\\e jS \\o\\f F o, \\T\\h\\e \\t\\i\\m\\e \\i\\s H:i:s";
		$time = gmdate($format, $this->time);
		return '<p>' . $time . '</p>';
	}
}