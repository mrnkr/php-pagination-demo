<?php

class User {

  private $table = 'affiliate';
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function verify($email, $password) {
    // emails are set to be unique so there is no need to limit to one row
    $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email AND password = :password';
    $stmt  = $this->conn->prepare($query);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', md5($password));

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

	public function updatePassword($user, $oldPass, $newPass) {
		$query = 'update ' . $this->table . ' set password = :new_password where id = :id and password = :old_password';
		$stmt  = $this->conn->prepare($query);

		$stmt->bindParam(':id', $user);
		$stmt->bindParam(':old_password', md5($oldPass));
		$stmt->bindParam(':new_password', md5($newPass));

		return $stmt->execute();
	}

}

?>
