<?php

require_once dirname(__FILE__) . '/../utils.php';

class Activity {

  public $table = 'activity';
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

  public function forUser($user) {
    $res = array();

    $query = '(
			select distinct a.name,
		      	 true as partakes
			from ' . $this->table  . ' as a
			left join ' . $this->partake . ' as p
			on p.activity_id = a.id
			where p.associate_id = :user
	  ) union (
			select distinct name,
		       	 false as partakes
			from ' . $this->table . '
			where id not in (
				select distinct a.id
				from ' . $this->table  . ' as a
				left join ' . $this->partake  . ' as p
				on p.activity_id = a.id
				where p.associate_id = :user
			)
	  )';

    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':user', $user);

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
							'delete from ' . $this->partake . ' where activity_id = :activity_id and associate_id = :associate_id' :
							'insert into ' . $this->partake . ' (activity_id, associate_id) values (:activity_id, :associate_id)';

		$stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':activity_id', $activity);
    $stmt->bindParam(':associate_id', $user);

		if ($stmt->execute()) {
			return !$isPartaking;
		}

		throw new Exception('Something went wrong toggling activity :(');
	}

	public function removeUserFromAllActivities($user) {
		$query = 'delete from ' . $this->partake . ' where associate_id = :associate_id';
		$stmt  = $this->conn->prepare($query);
		$stmt->bindParam(':associate_id', $user);
		return $stmt->execute();
	}

	private function isUserPartaking($activity, $user) {
		$query = 'select if((select count(*) from ' . $this->partake  . ' where associate_id = :user and activity_id = :activity) > 0, true, false) as partaking';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':activity', $activity);
		$stmt->bindParam(':user', $user);

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
