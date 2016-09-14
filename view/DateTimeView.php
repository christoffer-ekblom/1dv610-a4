<?php

namespace view;

class DateTimeView {
	private $timeString;

	public function __construct($timeString) {
		$this->timeString = $timeString;
	}

	public function show() {
		return '<p>' . $this->timeString . '</p>';
	}
}