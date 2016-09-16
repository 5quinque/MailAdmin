<?php

require 'model/admin.php';

require 'model/domain.php';
require 'model/account.php';
require 'model/forwarders.php';
//require 'vendor/autoload.php';

class Model {
	public function __construct() {
		// [TODO] Remove these from here
		$dbhost = "10.131.22.59";
		$dbname = "mail";
		$dbuser = "mail_remote";
		$dbpswd = "obvsnotarealpassword";

		try {
			$this->db = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpswd);
		} catch (PDOException $e) {
			throw new PDOException("Error : " . $e->getMessage());
		}

		$this->admin = new admin($this->db);
	}

	public function getDomainList() {
		$domains = array();

		$sql = "SELECT * FROM domains";
		foreach($this->db->query($sql) as $row) {
			$domains[$row["domain"]] = new Domain($row["domain"]);
		}
		
		return $domains;
	}

	public function getUserList($domain) {
		$users = array();

		$stmt = $this->db->prepare("SELECT * FROM users WHERE domain = :domain");
		$stmt->bindParam(':domain', $domain);
		$stmt->execute();

		while ($row = $stmt->fetch() ) {
			$users[$row["email"]] = new Account($domain, $row["email"]);
		}
		
		return $users;
	}

	public function getForwardList($domain) {
		$forwards = array();

		$stmt = $this->db->prepare("SELECT * FROM forwardings WHERE domain = :domain");
		$stmt->bindParam(':domain', $domain);
		$stmt->execute();

		while ($row = $stmt->fetch() ) {
			$forwards[$row["source"]] = new Forwarder($domain, $row["source"], $row["destination"]);
		}

		return $forwards;
	}

	public function addForwarder($data) {
		$domain			= $data['domain'];
		$source			= $data['source'];
		$destination		= $data['destination'];

		$stmt = $this->db->prepare("INSERT INTO forwardings(domain, source, destination) VALUES(:domain, :source, :destination)");

		$stmt->bindParam(':domain', $domain);
		$stmt->bindParam(':source', $source);
		$stmt->bindParam(':destination', $destination);

		$stmt->execute();
	}

	public function removeForwarder($emailAddress) {
		$stmt = $this->db->prepare("DELETE FROM forwardings WHERE source = :email");
		$stmt->bindParam(':email', $emailAddress);
		$stmt->execute();
	}

	public function getDomain($domain) {
		$allDomains = $this->getDomainList();
	
		return $allDomains[$domain];
	}

	public function addDomain($domain) {
		$stmt = $this->db->prepare("INSERT INTO domains(domain) VALUES(:domain)");
		$stmt->bindParam(':domain', $domain, PDO::PARAM_STR);

		$stmt->execute();
	}

	public function removeDomain($domain) {
		$stmt = $this->db->prepare("DELETE FROM domains WHERE domain = :domain");
		$stmt->bindParam(':domain', $domain, PDO::PARAM_STR);

		$stmt->execute();

		$stmt = $this->db->prepare("DELETE FROM users WHERE domain = :domain");
		$stmt->bindParam(':domain', $domain, PDO::PARAM_STR);

		$stmt->execute();
	}

	public function addUser($data) {
		//[TODO]
		// Check domain exists
		// Check user already doesn't exist

		// Check passwords match
		if ($data['password1'] != $data['password2']) {
			return false;
		}

		$domain		= $data['domain'];
		$email		= $data['username'] . '@' . $data['domain'];
		$password	= $data['password1'];

		$stmt = $this->db->prepare("INSERT INTO users(domain, email, password) VALUES(:domain, :email, encrypt(:password))");

		$stmt->bindParam(':domain', $domain);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		
		$stmt->execute();
	}

	public function updatePassword($data) {
		//[TODO]
		// Check user already doesn't exist

		// Check passwords match
		if ($data['password1'] != $data['password2']) {
			return false;
		}

		$email		= $data['username'];
		$password	= $data['password1'];
		
		$stmt = $this->db->prepare("UPDATE users SET password = encrypt(:password) WHERE email = :email");

		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':email', $email);
		
		$stmt->execute();
	}

	public function removeUser($address) {
		$stmt = $this->db->prepare("DELETE FROM users WHERE email = :address");
		$stmt->bindParam(':address', $address);

		$stmt->execute();
	}

}
