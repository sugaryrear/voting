<?php
class Database {

	private $con;

	private $host;
	private $user;
	private $pass;
	private $data;

	public function __construct($host, $user, $pass, $data) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->data = $data;
	}

	public function connect() {
		try {
			$this->con = new PDO('mysql:host='.$this->host.';dbname='.$this->data.';charset=utf8', $this->user, $this->pass);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			return true;
		} catch (Exception $e) {
			echo 'Unable to connect to database. Please check credentials and try again.';
			return false;
		}
	}

	public function getSites() {
		$stmt = $this->con->prepare("SELECT * FROM sites WHERE active=1");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getAllSites() {
		$stmt = $this->con->prepare("SELECT * FROM sites");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getSite($value) {
		$stmt = $this->con->prepare("SELECT * FROM sites WHERE id=:value LIMIT 1");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getSiteByIp($value) {
		$stmt = $this->con->prepare("SELECT * FROM sites WHERE ip_address=:value LIMIT 1");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getSiteBy($column, $value) {
		$stmt = $this->con->prepare("SELECT * FROM sites WHERE $column=:value LIMIT 1");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getVoteStats() {
		$stmt = $this->con->prepare("SELECT COUNT(*) AS amount, MONTH(callback_date) AS month FROM votes WHERE callback_date IS NOT NULL AND YEAR(callback_date) = YEAR(CURDATE()) GROUP BY month ORDER BY month ASC");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function deleteSite($id) {
		$stmt = $this->con->prepare("DELETE FROM sites WHERE id=:id LIMIT 1");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
	}

	public function setActive($id, $active) {
		$stmt = $this->con->prepare("UPDATE sites SET active=:active WHERE id=:id LIMIT 1");
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":active", $active);
		$stmt->execute();
	}

	public function addSite($data) {
		$stmt = $this->con->prepare("INSERT INTO sites (title, url, site_id) VALUES (:title, :url, :site_id)");
		foreach ($data as $key => $value) {
			$stmt->bindParam($key, $value);
		}
		$stmt->execute();
	}

	public function startVote($siteId, $username, $ip, $uid) {
		$stmt = $this->con->prepare("INSERT INTO votes (username, site_id, ip_address, uid) VALUES (:user, :sid, :addr, :uid)");
		$stmt->bindParam(":user", $username);
		$stmt->bindParam(":sid", $siteId);
		$stmt->bindParam(":addr", $ip);
		$stmt->bindParam(":uid", $uid);
		$stmt->execute();
	}

	public function getMostRecentVote($siteId, $username, $addr) {
		$stmt = $this->con->prepare("SELECT * FROM votes WHERE site_id=:sid AND (username=:user OR ip_address=:addr) AND started > DATE_SUB(now(), INTERVAL 12 HOUR) AND callback_date IS NULL ORDER BY started DESC LIMIT 1");
		$stmt->bindParam(":user", $username);
		$stmt->bindParam(":sid", $siteId);
		$stmt->bindParam(":addr", $addr);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getVote($siteId, $username, $addr) {
		$stmt = $this->con->prepare("SELECT * FROM votes WHERE site_id=:sid AND username=:user AND callback_date > DATE_SUB(now(), INTERVAL 12 HOUR) AND callback_date IS NOT NULL");
		$stmt->bindParam(":user", $username);
		$stmt->bindParam(":sid", $siteId);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getVotesById($siteId) {
		$stmt = $this->con->prepare("SELECT COUNT(*) FROM votes WHERE site_id=:sid AND callback_date IS NOT NULL");
		$stmt->bindParam(":sid", $siteId);
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	public function getVoteByUid($uid) {
		$stmt = $this->con->prepare("SELECT * FROM votes WHERE uid=:uid");
		$stmt->bindParam(":uid", $uid);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function insertVote($uid) {
		$stmt = $this->con->prepare("UPDATE votes SET callback_date = NOW() WHERE uid=:uid AND started > DATE_SUB(now(), INTERVAL 12 HOUR) AND callback_date IS NULL");
		$stmt->bindParam(":uid", $uid);
		$stmt->execute();
	}

	public function getVotm() {
		$stmt = $this->con->prepare("SELECT COUNT(*) AS votes,username FROM votes WHERE YEAR(callback_date) = YEAR(CURDATE()) AND MONTH(callback_date) = MONTH(CURDATE()) GROUP BY username ORDER BY votes DESC LIMIT 5");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getVotes() {
		$stmt = $this->con->prepare("SELECT COUNT(*) AS votes FROM votes WHERE YEAR(callback_date) = YEAR(CURDATE()) AND MONTH(callback_date) = MONTH(CURDATE()) ORDER BY votes DESC LIMIT 5");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function updateSite($id, $title, $voteId, $url) {
		$stmt = $this->con->prepare("UPDATE sites SET title=:title, url=:url, site_id=:sid WHERE id=:id");
		$stmt->execute(array(
			"title" => $title,
			"url" => $url,
			"sid" => $voteId,
			"id" => $id
		));
	}

	public function insert($table, $vars) {
        $keys = array_keys($vars);
        $query = "INSERT INTO $table (";
        for ($i = 0; $i < count($keys); $i++) {
            $query .= ''.$keys[$i].($i < count($keys) - 1 ? ", " : ") VALUES (");
        }
        for ($i = 0; $i < count($keys); $i++) {
            $query .= ':'.$keys[$i].($i < count($keys) - 1 ? ", " : ")");
        }
        $stmt = $this->con->prepare($query);
        $stmt->execute($vars);
    }

    public function update($table, $key, $vars) {
    	$keys = array_keys($vars);
    	$query = "UPDATE $table SET ";
    	for ($i = 0; $i < count($keys); $i++) {
    		 $query .= "".$keys[$i]."=:".$keys[$i]."".($i < count($keys) - 1 ? ", " : " WHERE id=$key");
    	}
    	$stmt = $this->con->prepare($query);
        $stmt->execute($vars);
    }
}
?>
