<?php

require 'model/model.php';

class Controller {
	public $model;

	public function __construct() {
		$this->model = new Model();
	}

	public function invoke() {
		if (isset($_POST["login"])) {
			if (isset($_POST["remember"])) {
				$remember = 1;
			} else {
				$remember = 0;
			}

			$this->model->admin->login($_POST["login"], $_POST["password"], $remember);
		}

		if (isset($_GET["action"])) {
			if ($_GET["action"] == "logout") {
				$this->model->admin->logout();
			}
		}

		if (!$this->model->admin->isLogged()) {
			include 'view/login.php';
			exit();
		}

		if (isset($_GET["newdomain"])) {
			$this->model->addDomain($_GET['newdomain']);
		}

		if (isset($_GET["remove"])) {
			$this->model->removeDomain($_GET['remove']);
		}

		if (isset($_POST["username"])) {
			$this->model->addUser($_POST);
		}

		if (isset($_POST["deleteUser"])) {
			$this->model->removeUser($_POST["deleteUser"]);
		}

		if (isset($_POST["updatePassword"])) {
			$this->model->updatePassword($_POST);
		}

		if (isset($_POST["source"])) {
			$this->model->addForwarder($_POST);
		}

		if (isset($_POST["forward_address"])) {
			$this->model->removeForwarder($_POST["forward_address"]);
		}


		$domains = $this->model->getDomainList();
		$domainCount = count($domains);

		if (!isset($_GET['domain'])) {
			include 'view/domainlist.php';
		} else {
			$domain		= $this->model->getDomain($_GET['domain']);

			$users		= $this->model->getUserList($_GET['domain']);
			$forwarders	= $this->model->getForwardList($_GET['domain']);

			$userCount	= count($users);
			$forwardCount	= count ($forwarders);			

			include 'view/viewdomain.php';
		}



	}

}
