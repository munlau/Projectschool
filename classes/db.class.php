<?php
	class Db
	{
		private $m_sHost = "localhost";
		private $m_sUser = "munlau_yau";
		private $m_sPassword = "i-r0333120";
		private $m_sDatabase = "munlau_restaurant";
		public $conn;


		public function __construct()
		{
			$this->conn = new mysqli($this->m_sHost, $this->m_sUser, $this->m_sPassword, $this->m_sDatabase);
		}
	}
?>