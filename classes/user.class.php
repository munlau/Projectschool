<?php 
include_once ("db.class.php");
	class User{
		private $m_sUsername;
		private $m_sEmail;
		private $m_sPassword;
		
		public function __set($p_sProperty, $p_vValue){
			switch ($p_sProperty) {
				case 'Username':
					$this->m_sUsername=$p_vValue;
				break;
				case 'Email':
					$this->m_sEmail=$p_vValue;
				break;
				case 'Password':
					if(strlen($p_vValue)<5)
				{
					throw new Exception ("Password must contain 6 chars or more.");
				}
					$salt = "fsldkfjsdmlfksdlmfk65463321!lksdfjlksdjf+65+65%é#fsdlkfj@";
					$this->m_sPassword= md5($p_vValue . $salt);
				break;
			}
			
		}
	public function __get($p_sProperty){
		switch ($p_sProperty) {
			case 'Username':
				return $this->m_sUsername;
				break;
			case 'Email':
				return $this->m_sEmail;
				break;
			case 'Password':
				return $this->m_sPassword;
				break;
		}
	}


	public function Save(){
		$db = new Db();
		$salt = "fsldkfjsdmlfksdlmfk65463321!lksdfjlksdjf+65+65%é#fsdlkfj@";
		$sql = "insert into tblmanagers (ma_username, ma_email, ma_password)
			VALUES (
				'" .$db->conn->real_escape_string($this->Username) . "',
				'" . $db->conn->real_escape_string($this->Email) . "',
				'". $db->conn->real_escape_string(md5($this->Password . $salt)) . "')";

		$check = "SELECT * FROM tblmanagers WHERE ma_username='"
			.$db -> conn -> real_escape_string($this -> Username)."';";
		$result = $db->conn->query($check);
		if($result->num_rows == 0)
		{
		$db->conn->query($sql);
		$_SESSION['loggedin'] = true;
		$_SESSION['name'] = $this->Username;
		header("Location: index.php");
		}
		else
		{
		throw new Exception("This username is already taken!");
		}

	}

	public function canLogin() {
	$salt = "fsldkfjsdmlfksdlmfk65463321!lksdfjlksdjf+65+65%é#fsdlkfj@";
	$db=new Db();
	$sql="SELECT * FROM tblmanagers WHERE ma_username='"
	.$db -> conn -> real_escape_string($this -> Username)."' 
	AND ma_password='"
	.$db -> conn -> real_escape_string(md5($this -> Password . $salt))."';";
	
	$result=$db->conn->query($sql);
	if($result->num_rows == 1)
			{
			$_SESSION['loggedin'] = true;
			$_SESSION['name'] = $this -> Username;
			header("Location: index.php");
			}
			
		}

	

		
	}


?>