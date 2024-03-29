
<?php 
	include_once 'config.php';
	class DB
	{
		private $host   = DB_HOST;
		private $user   = DB_USER;
		private $pass   = DB_PASS;
		private $dbname = DB_NAME;

		public $link;
		public $error; 

		public function __construct()
		{
			$this->connectDB();
		}

		private function connectDB()
		{
			$this->link = new mysqli('localhost', 'root', '', 'projet');
			if (!$this->link) {
				echo "Connection échoué".$this->link->connect_error;
				return false;
			}
		}

		
		public function insert($query)
		{
			$insert_row = $this->link->query($query) or die($this->link->error.__LINE__);
			if ($insert_row) {
				return $insert_row;
			} else {
				return false;
			}
		}

		
		public function select($query)
		{
			$result = $this->link->query($query) or die($this->link->error.__LINE__);
			if ($result->num_rows > 0) {
				return $result;
			} else {
				return false;
			}
		}
	}
 ?>