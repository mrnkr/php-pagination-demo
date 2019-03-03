<?php

require_once dirname(__FILE__) . '/../utils.php';

class Activity {

  public $table = 'activity';
	public $affiliate = 'affiliate';
  public $partake = 'partake';
  public $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function getAll() {
    $res = array();

    $query = 'select distinct name, id, picture_url from ' . $this->table;
    $stmt  = $this->conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $cur = array(
				'id' => $id,
        'name' => $name,
        'picture_url' => $picture_url
      );

      array_push($res, $cur);
    }

    return $res;
  }

	public function getUsersForActivity($activity) {
		$res = array();

		$query = 'select af.* from ' . $this->partake  . ' as p join ' . $this->affiliate  . ' as af on p.member_id = af.id where p.activity_id = :id';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':id', $activity, PDO::PARAM_INT);

		$stmt->execute();

		if ($stmt->rowCount() == 0) {
			return $res;
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

			array_push($res, $cur);
		}

		return $res;
	}

  public function forUser($user) {
    $res = array();

    $query = '(
			select distinct a.name,
		      	 true as partakes
			from ' . $this->table  . ' as a
			left join ' . $this->partake . ' as p
			on p.activity_id = a.id
			where p.member_id = :user
	  ) union (
			select distinct name,
		       	 false as partakes
			from ' . $this->table . '
			where id not in (
				select distinct a.id
				from ' . $this->table  . ' as a
				left join ' . $this->partake  . ' as p
				on p.activity_id = a.id
				where p.member_id = :user
			)
	  )';

    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $res[$name] = $partakes;
    }

    return $res;
  }

	public function toggleActivityForUser($activity, $user) {
		$isPartaking = $this->isUserPartaking($activity, $user);
		$query = $isPartaking ?
							'delete from ' . $this->partake . ' where activity_id = :activity_id and member_id = :member_id' :
							'insert into ' . $this->partake . ' (activity_id, member_id) values (:activity_id, :member_id)';

		$stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':activity_id', $activity, PDO::PARAM_INT);
    $stmt->bindParam(':member_id', $user, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return !$isPartaking;
		}

		throw new Exception('Something went wrong toggling activity :(');
	}

	public function removeUserFromAllActivities($user) {
		$query = 'delete from ' . $this->partake . ' where member_id = :member_id';
		$stmt  = $this->conn->prepare($query);
		$stmt->bindParam(':member_id', $user, PDO::PARAM_INT);
		return $stmt->execute();
	}

	private function isUserPartaking($activity, $user) {
		$query = 'select if((select count(*) from ' . $this->partake  . ' where member_id = :user and activity_id = :activity) > 0, true, false) as partaking';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':activity', $activity, PDO::PARAM_INT);
		$stmt->bindParam(':user', $user, PDO::PARAM_INT);

		$stmt->execute();

		if ($stmt->rowCount() == 0) {
      throw new Exception('Something went terribly wrong!!');
    }

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);

		return $partaking;
	}

}

?>
