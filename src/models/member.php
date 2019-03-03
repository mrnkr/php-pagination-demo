<?php

require_once dirname(__FILE__) . '/../utils.php';
require_once dirname(__FILE__) . '/activity.php';

class Member {

	private $table = 'associate';
	private $affiliate = 'affiliate';
	private $conn;
	private $activityModel;

	public function __construct($db) {
		$this->conn = $db;
		$this->activityModel = new Activity($db);
	}

	public function count() {
		$query = 'select count(*) as cnt from ' . $this->table;
		$stmt  = $this->conn->prepare($query);
		$stmt->execute();

		if ($stmt->rowCount() == 0) {
			return 0;
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);

		return $cnt;
	}

	public function findOne($id) {
		$query = 'select af.* from ' . $this->table . ' as m join ' . $this->affiliate . ' as af on m.id = af.id where m.id = :id';
		$stmt  = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		if ($stmt->rowCount() == 0) {
			return array();
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

		return array(
			'id' => $id,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'birthdate' => $birthdate,
			'address' => $address,
			'phone' => $phone,
			'email' => $email,
			'picture_url' => $picture_url
		);
	}

	public function find($limit, $offset = 0) {
		$limit -= $offset;
		$ret = array();

		$query = 'select af.* from ' . $this->table . ' as m join ' . $this->affiliate . ' as af on m.id = af.id limit :limit offset :offset';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

		$stmt->execute();

		if ($stmt->rowCount() == 0) {
			return $ret;
		}

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			extract($row);

			$cur = array(
				'id' => $id,
      	'first_name' => $first_name,
      	'last_name' => $last_name,
      	'birthdate' => $birthdate,
      	'address' => $address,
      	'phone' => $phone,
      	'email' => $email,
      	'picture_url' => $picture_url
			);

			array_push($ret, $cur);
		}

		return $ret;
	}

	public function insertOne($member) {
		extract($member);

		$query = 'insert into ' . $this->affiliate .
						' set first_name = :first_name
									last_name = :last_name
									birthdate = :birthdate
									address = :address
									phone = :phone
									email = :email
									password = :password
									picture_url = :picture_url';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':first_name', htmlspecialchars(strip_tags($first_name)));
		$stmt->bindParam(':last_name', htmlspecialchars(strip_tags($last_name)));
		$stmt->bindParam(':birthdate', htmlspecialchars(strip_tags($birthdate)));
		$stmt->bindParam(':address', htmlspecialchars(strip_tags($address)));
		$stmt->bindParam(':phone', htmlspecialchars(strip_tags($phone)));
		$stmt->bindParam(':email', htmlspecialchars(strip_tags($email)));
		$stmt->bindParam(':password', md5($password));
		$stmt->bindParam(':picture_url', htmlspecialchars(strip_tags($picture_url)));

		if ($stmt->execute()) {
      $id = $this->conn->lastInsertId();
      $query = 'insert into ' . $this->table . '\` set id = :id';
      $stmt  = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id);

      if ($stmt->execute()) {
        return $id;
      }
    }

    return -1;
	}

	public function updateOne($id, $diff) {
		$old = $this->findOne($id);

		$query = 'update ' . $this->affiliate .
						' set first_name = :first_name
									last_name = :last_name
                  birthdate = :birthdate
                  address = :address
                  phone = :phone
                  email = :email
                  password = :password
                  picture_url = :picture_url
							where id = :id';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':first_name', isset($diff['first_name']) ? htmlspecialchars(strip_tags($diff['first_name'])) : $old['first_name']);
    $stmt->bindParam(':last_name', isset($diff['last_name']) ? htmlspecialchars(strip_tags($diff['last_name'])) : $old['last_name']);
    $stmt->bindParam(':birthdate', isset($diff['birthdate']) ? htmlspecialchars(strip_tags($diff['birthdate'])) : $old['birthdate']);
    $stmt->bindParam(':address', isset($diff['address']) ? htmlspecialchars(strip_tags($diff['address'])) : $old['address']);
    $stmt->bindParam(':phone', isset($diff['phone']) ? htmlspecialchars(strip_tags($diff['phone'])) : $old['phone']);
    $stmt->bindParam(':email', isset($diff['email']) ? htmlspecialchars(strip_tags($diff['email'])) : $old['email']);
    $stmt->bindParam(':password', isset($diff['password']) ? md5($diff['password']) : $old['password']);
    $stmt->bindParam(':picture_url', isset($diff['picture_url']) ? htmlspecialchars(strip_tags($diff['picture_url'])) : $old['picture_url']);

		if ($stmt->execute()) {
      return true;
    }
    console_error('Error: ' . $stmt->error);
    return false;
	}

	public function deleteOne($id) {
		$this->activityModel->removeUserFromAllActivities($id);

		$query = 'delete from ' . $this->table . ' where id = :id';
		$stmt  = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);

		if ($stmt->execute()) {
      $query = 'delete from ' . $this->affiliate  . ' where id = :id';
      $stmt  = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id);

      if ($stmt->execute()) {
        return true;
      }
    }

    console_error('Error: ' . $stmt->error);
    return false;
	}

}

?>
