<?php

	/**
	 * 
	 * DBImport
	 * Simple class for import mysql dump's
	 * 
	 * @version 1.0.0
	 * @author César Silva <cesar98silva@outlook.com>
	 * @link https://github.com/thesilvacesar/DBImport
	 * 
	*/

	class DBImport {

		public $config;
		protected $connection, $query, $explode, $comments = [ '--', '/*', '//' ];

		protected function connection() {
			$this->connection	=	new mysqli(
				$this->config['host'],
				$this->config['user'],
				$this->config['pass'],
				$this->config['db']
			);

			if (!$this->connection) {
				$this->message([
					'error'	=>	'Connection error'
				]);
			}
		}

		protected function message($message) {
			echo json_encode($message);
			die;
		}

		protected function check_file_exist() {
			$explode	=	explode('.', $this->config['file']);

			if (file_exists($this->config['file']) && end($explode) == 'sql') {
				return true;
			} else if (end($explode) != 'sql') {
				$this->message([
					'error'	=>	'File not supported (only files .sql)'
				]);
			} else {
				$this->message([
					'error'	=>	'File not found'
				]);
			}
		}

		protected function load_file() { return file($this->config['file']); }

		public function __construct($config) {
			error_reporting(0);

			$this->config	=	[
				'db'		=>	$config['db'],
				'host'		=>	$config['host'],
				'user'		=>	$config['user'],
				'file'		=>	$config['file'],
				'pass'		=>	($config['pass']) ?: '',
			];

			$this->connection();
			$this->check_file_exist();
		}

		public function execute() {
			foreach ($this->load_file() as $line) {
				if (empty($line) || in_array(substr(trim($line), 0, 2), $this->comments)) { continue; }
				
				$this->query	=	$this->query . $line;
				if (substr(trim($line), -1, 1) == ';') {
					mysqli_query($this->connection, $this->query) or $this->message([
						'error' => 'Problem in executing the SQL query',
						'query'	=>	$this->query
					]);

					$this->query	=	'';		
				}
			}

			$this->message([
				'success' => 'Database imported successfully'
			]);
		}

	}