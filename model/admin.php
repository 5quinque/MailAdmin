<?php

require 'vendor/autoload.php';

class Admin {
	public $admin;
	
	public function __construct($db) {
		session_start();
		//$this->admin	= $admin;
		$this->db	= $db;
	}

	public function login($username, $password, $remember=1) {
		$stmt = $this->db->prepare("SELECT password FROM admin where username = :username");
		$stmt->bindParam(":username", $username);
		$stmt->execute();

		$user = $stmt->fetch();
		
		if (!$user) {
			return "Username not found";
		}

		$hash = $user["password"];

		if (password_verify($password, $hash)) {
			$this->username = $username;
			$this->getIDs();
			return true;
		} else {
			return "Incorrect password";
		}
	}

	public function logout() {
		if (!isset($_SESSION["user"])) {
			return false;
		}

		$stmt = $this->db->prepare("DELETE FROM admin_sessions WHERE sid = :sid");
		$stmt->bindParam(":sid", $_SESSION["sid"]);

		$stmt->execute();

		session_destroy();

		header('Location: /mailadmin/');
	}

	public function register($username, $password, $repeatPassword) {
		if ($password !== $repeatPassword) {
			return "Passwords don't match";
		}

		if ($this->adminExists($username)) {
			return "Admin already exists";
		}

		$hash = password_hash($password, PASSWORD_BCRYPT);
		$stmt = $this->db->prepare("INSERT INTO admin VALUES(NULL, :username, :hash, 1)");

		$stmt->bindParam(":username", $username);
		$stmt->bindParam(":hash", $hash);

		echo $username;
		echo $hash;

		$stmt->execute();

		return "Done..";
	}

	public function adminExists($username) {
		$stmt = $this->db->prepare("SELECT username FROM admin WHERE username = :username");
		$stmt->bindParam(":username", $username);
		$stmt->execute();

		return count($stmt->fetchAll()) == 1;
	}


	public function isLogged() {
		if (!isset($_SESSION["user"])) {
			return false;
		}

		$stmt = $this->db->prepare("SELECT * FROM admin_sessions WHERE username = :username AND sid = :sid ORDER BY timestamp DESC");

		$stmt->bindParam(":username", $_SESSION["user"]);
		$stmt->bindParam(":sid", $_SESSION["sid"]);

		$stmt->execute();

		$row = $stmt->fetch();

		if ($row["username"] != $_SESSION["user"]) {
			return false;
		}

		if ($row["sid"] != $_SESSION["sid"]) {
			return false;
		}

		if ($row["tid"] != $_SESSION["tid"]) {
			return false;
		}

		if ($row["ip"] != $_SERVER["REMOTE_ADDR"]) {
			return false;
		}

		$this->username = $row["username"];
		$this->updateIDs($_SESSION["sid"]);

		return true;
	}


	function getIDs() {
		$sid = session_id();
		$tid = md5(microtime(true));
		$ip = $_SERVER["REMOTE_ADDR"];

		$stmt = $this->db->prepare("INSERT INTO admin_sessions VALUES(NULL, :username, :sid, :tid, :ip)");

		$stmt->bindValue(":username", $this->username);
		$stmt->bindValue(":sid", $sid);
		$stmt->bindValue(":tid", $tid);
		$stmt->bindValue(":ip", $ip);

		$stmt->execute();

		$_SESSION["user"] = $this->username;
		$_SESSION["sid"] = $sid;
		$_SESSION["tid"] = $tid;
	}

	function updateIDs($sid) {
		$tid = md5(microtime(true));
		$ip = $_SERVER["REMOTE_ADDR"];

		$stmt = $this->db->prepare("UPDATE admin_sessions SET tid = :tid WHERE sid = :sid");

		$stmt->bindValue(":sid", $sid);
		$stmt->bindValue(":tid", $tid);

		$stmt->execute();

		$_SESSION["tid"] = $tid;
	}


}
