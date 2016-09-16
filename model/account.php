<?php

class Account {
	public $account;
	
	public function __construct($domain, $address) {
		$this->domain	= $domain;
		$this->address	= $address;
	}
}
