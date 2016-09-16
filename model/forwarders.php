<?php

class Forwarder {
	public $forwader;
	
	public function __construct($domain, $source, $destination) {
		$this->domain		= $domain;
		$this->source		= $source;
		$this->destination	= $destination;
	}
}
