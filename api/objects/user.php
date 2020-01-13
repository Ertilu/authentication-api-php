<?php
  // 'user' object
  class User{
  
    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $exp;
    public $level;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    // create new user record
    function create(){
    
      // insert query
      $query = "INSERT INTO " . $this->table_name . "
              SET
                  firstname = :firstname,
                  lastname = :lastname,
                  email = :email,
                  exp = :exp,
                  level = :level,
                  password = :password";

      // prepare the query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->firstname = htmlspecialchars(strip_tags($this->firstname));
      $this->lastname = htmlspecialchars(strip_tags($this->lastname));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->exp = 0;
      $this->level = 1;

      // bind the values
      $stmt->bindParam(':firstname', $this->firstname);
      $stmt->bindParam(':lastname', $this->lastname);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':exp', $this->exp);
      $stmt->bindParam(':level', $this->level);

      // hash the password before saving to database
      $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $password_hash);

      // execute the query, also check if query was successful
      if($stmt->execute()){
          return true;
      }

      return false;
    }

    // check if given email exist in the database
    function emailExists(){
    
      // query to check if email exists
      $query = "SELECT id, firstname, lastname, exp, level, password 
              FROM " . $this->table_name . "
              WHERE email = ?";

      // prepare the query
      $stmt = $this->conn->prepare( $query );

      // sanitize
      $this->email=htmlspecialchars(strip_tags($this->email));

      // bind given email value
      $stmt->bindParam(1, $this->email);

      // execute the query
      $stmt->execute();

      // get number of rows
      $num = $stmt->rowCount();

      // if email exists, assign values to object properties for easy access and use for php sessions
      if($num>0){

          // get record details / values
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // assign values to object properties
          $this->id = $row['id'];
          $this->firstname = $row['firstname'];
          $this->lastname = $row['lastname'];
          $this->password = $row['password'];
          $this->exp = $row['exp'];
          $this->level = $row['level'];

          // return true because email exists in the database
          return true;
      }

      // return false if email does not exist in the database
      return false;
    }

    // update a user record
    public function update(){
    
      // if password needs to be updated
      $password_set=!empty($this->password) ? ", password = :password" : "";

      // if no posted password, do not update the password
      $query = "UPDATE " . $this->table_name . "
              SET
                  firstname = :firstname,
                  lastname = :lastname,
                  email = :email
                  {$password_set}
              WHERE id = :id";

      // prepare the query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->firstname=htmlspecialchars(strip_tags($this->firstname));
      $this->lastname=htmlspecialchars(strip_tags($this->lastname));
      $this->email=htmlspecialchars(strip_tags($this->email));

      // bind the values from the form
      $stmt->bindParam(':firstname', $this->firstname);
      $stmt->bindParam(':lastname', $this->lastname);
      $stmt->bindParam(':email', $this->email);

      // hash the password before saving to database
      if(!empty($this->password)){
          $this->password=htmlspecialchars(strip_tags($this->password));
          $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
          $stmt->bindParam(':password', $password_hash);
      }

      // unique ID of record to be edited
      $stmt->bindParam(':id', $this->id);

      // execute the query
      if($stmt->execute()){
          return true;
      }

      return false;
    }

    function gainExp() {
      $expNow = "SELECT id, firstname, lastname, exp, level, password 
              FROM " . $this->table_name . "
              WHERE id = :id";

      // prepare the query
      $stmt = $this->conn->prepare( $expNow );

      // unique ID of record to be edited
      $stmt->bindParam(':id', $this->id);

      // execute the query
      $stmt->execute();

       // get number of rows
       $num = $stmt->rowCount();
       if($num>0){
 
          // get record details / values
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          $this->firstname = $row['firstname'];
          $this->lastname = $row['lastname'];
          $this->exp = $row['exp'] + 50;

          if ($this->exp >= 50) {
            $this->level = 1;
          } 
          if ($this->exp >= 100) {
            $this->level = 2;
          } 
          if ($this->exp >= 200) {
            $this->level = 3;
          } 
          if ($this->exp >= 400) {
            $this->level = 4;
          } 
          if ($this->exp >= 800) {
            $this->level = 5;
          } 
          if ($this->exp >= 1600) {
            $this->level = 6;
          } 
          if ($this->exp >= 3200) {
            $this->level = 7;
          } 
          if ($this->exp >= 6400) {
            $this->level = 8;
          } 
          if ($this->exp >= 12800) {
            $this->level = 9;
          } 
          if ($this->exp >= 25600) {
            $this->level = 10;
          } 

          $increaseExp = "
            UPDATE " . $this->table_name . "
            SET
                exp = $this->exp,
                level = $this->level
            WHERE id = $this->id
          ";

          $update = $this->conn->prepare($increaseExp);

          $update->execute();

          return true;
       }

      return false;
    }
  }
  