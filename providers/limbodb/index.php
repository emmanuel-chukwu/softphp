<?php

class LimboDB {

   public $conn;
   private $host;
   private $db_name;
   private $db_pass;
   private $user_name;

   public function init ($host, $user_name, $db_pass, $db_name) {
      $this->host = $host;
      $this->db_name = $db_name;
      $this->user_name = $user_name;
      $this->db_pass = $db_pass;
   }

   private function clean($string) {
      return "'".$string."'";
   }

   public function connect() {
      $this->conn = mysqli_connect($this->host, $this->user_name, $this->db_pass, $this->db_name) or die(mysqli_error($conn));
   }

   public function close() {
      mysqli_close($this->conn);
   }

   public function delete($table, $where) {
      
      $delete = "DELETE FROM ".$table." WHERE ".$where."";

      mysqli_query ($this->conn, $delete) or die (mysqli_error($this->conn) . "Delete Query = " . $delete);
   }

   public function insert($table, $rows, $values) {
      $row = implode (',',$rows);
      $value = implode (',',$values);
      $insert = "INSERT INTO ".$table." (".$row.") VALUES (".$value.")";

      mysqli_query ($this->conn, $insert) or die (mysqli_error($this->conn) . "Insert Query = " . $insert);
   }

   public function update($table, $rows, $values, $where = NULL) {

      if ($where === null) $query = "UPDATE ".$table." SET ".$rows." = ".$values." ";
      else $query = "UPDATE ".$table." SET ".$rows." = ".$values." WHERE ".$where." ";

      mysqli_query ($this->conn, $query) or die (mysqli_error($this->conn) . "Update Query = " . $insert);
   }

   public function select($rows, $table, $where = NULL, $order = NULL, $limit = NULL, $join = NULL) {
      $query =  "SELECT ".$rows." FROM ".$table;
	   if ($join != null) $query .= " ". $join;
	   if ($where != null) $query .= " WHERE ". $where;
	   if ($order != null) $query .= " ORDER BY ". $order;
      if ($limit != null) $query .= " LIMIT ". $limit;
      
      $select = mysqli_query($this->conn, $query) or die (mysqli_error($this->conn) . "Select Query = " . $delete);
      
      if (mysqli_num_rows($select) > 0) {
         $rows = array();
	      while ($row = mysqli_fetch_assoc($select)) {
		      $rows[] = $row;
         }
      }
      
      return $rows;
   }
}
?>
