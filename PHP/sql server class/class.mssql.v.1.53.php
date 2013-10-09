<?php
/*
 * MS-SQL database class
 * @version 1.53
 *
 * This class provides basic methods for working with a MS-SQL database
 *
 * This class contains code to allow this single file to be used in a number of ways
 *
 * This class can be used for a single database on a single host with a single user or
 * it can be used with multiple hosts, databases and users.
 *
 * To use this class in 'multi' mode DO NOT edit any of the vars. Leave them set to XXX and call the set and other methods to
 * make the connection.
 *
 * If you are only going to uset his file to connect to one one server change $sqlHost to the ip of your server
 * If you are only going to connect to one known database you can set $sqlDatabase to the name of your database
 * If you are only going to be connecting as a single known user set $sqlUser and sqlPassword accordingly
 * Setting these values here in the class file will allow you to use this class to create an object that will automaticaly
 * make the connection when the object is created. meaning you do not have to call the connect methods
 */

class mssqlClass {
	// set this to 1 if you are going to edit any of the options below.
	// This will cause the construct method to be exicuted and make the connection automaticaly for you
	private $useConstruct = 0;

	// leave set to XXX if used for multiple users and call setUser method
	private $sqlUser = "XXX";

	// leave set to XXX if used for multiple users and call setPassword method
	private $sqlPassword = "XXX";

	// set this to the database name you wish to use. If this class is used to access a number of Databases
	// leave set as XXX and call the select method to select the desired database
	private $sqlDatabase = "XXX";

	// set this to the database server address. If you are using this class to connect to differant server
	// leave it set to XXX and call the setHost method
	private $sqlHost = "XXX";

	// these options allow for the use of the hidden connection data methods.
	// to use this you must set to 1 and enter the path to the file containing the connection data
	// connection data MUST be formated as follows
	// $configDataFindString->u:USERNAME:p:PASSWORD:d:DATABASE:h:HOSTIP:<-$configDataEndString
	// the connection string can not contain any spaces
	private $UseFileHide = 0;
	private $configLocation = "XXX"; // path to file containing the connection string


	// do not change these
	private $configDataFindString = "SQL_CONNECT_STRING_START";
	private $configDataEndString = "SQL_CONNECT_STRING_END";
	private $strOBJ;
	private $result; // Query result
	private $querycounty; // Total queries executed
	private $linkid;

	/////////////////////////////////////////END CONFIG OPTIONS/////////////////////////////////////////////////////


	function __construct() {
		// if the option to auto connect is set
		// load in needed data and make connection
		if ($this->useConstruct === 1) {
			// if we are using the hidden data methods
			if ($this->UseFileHide === 1) {
				// load in the config string from the file and save to local vars
				require_once ("string.class.php");
				$this->strOBJ = new stringobj ( );
				$this->saveConfig ( $this->loadConfig () );
			}else{
				//skip that bit
			}
			// and continue making the connection using the data provided in this file.
			$this->connect ( $this->sqlHost, $this->sqlUser, $this->sqlPassword );
			$this->select ( $this->sqlDatabase );
		}else{
			// we do nothing
		}
	}

	// function to save the sql login info
	private function saveConfig($infoStr) {
		$sqlLoginArray = explode ( ":", $infoStr );
		$this->sqlUser = $sqlLoginArray [1];
		$this->sqlPassword = $sqlLoginArray [3];
		$this->sqlDatabase = $sqlLoginArray [5];
		$this->sqlHost = $sqlLoginArray [7];
	}

	private function loadConfig() {
		$lines = file ( $this->configLocation );
		$stringOut = "";
		foreach ( $lines as $line ) {
			$stringOut .= $line;
		}
		// extract sql info
		$infoStr = $this->strOBJ->get_middle ( $stringOut, $this->configDataFindString, $this->configDataEndString, 0 );
		return $infoStr;
	}

	/* Connects to the MySQL database server. */
	function connect($sqlHost, $sqlUser, $sqlPassword) {
		try {
			$this->linkid = @mssql_pconnect ( $sqlHost, $sqlUser, $sqlPassword );
			if (! $this->linkid) {
				throw new Exception ( "I Could not connect to the SQL server $sqlHost." );
			}
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
	}

	/* Selects the MySQL database. */
	function select($sqlDatabase) {
		try {
			if (! @mssql_select_db ( $sqlDatabase, $this->linkid ))
			throw new Exception ( "I Could not connect to the SQL database : $sqlDatabase." );
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
	}

	/**

	* method to query sql database
	* take mssql query string
	* returns false if no results or NULL result is returned by query
	* if query action is not expected to return results eg delete
	* returns false on sucess else returns result set
	*
	* @param unknown_type $query
	* @return unknown
	*/
	function query($query) {
		// ensure clean results
		$this->result = "";
		// make query
		$this->result = mssql_query ( $query, $this->linkid );
		if (! $this->result) {
			return FALSE;
		} else {
			//echo "query processed!";
			return $this->result;
		}
	}

	/* Determine total rows affected by query. */
	function affectedRows() {
		$count = mssql_rows_affected ( $this->linkid );
		return $count;
	}

	/* Determine total rows returned by query. */
	function numRows() {
		$count = @mssql_num_rows ( $this->result );
		return $count;
	}

	/* Return query result row as an object. */
	function fetchObject() {
		$row = @mssql_fetch_object ( $this->result );
		return $row;
	}

	/* Return query result row as an indexed array. */
	function fetchRow() {
		$row = @mssql_fetch_row ( $this->result );
		return $row;
	}

	/* Return query result row as an associative array. */
	function fetchArray() {
		//$row = @mssql_fetch_array($this->result);
		$row = @mssql_fetch_assoc( $this->result);
		return $row;
	}
	function nextResult()
	{
		return @mssql_next_result($this->result);
	}

	/**
	 * 	Return total number queries executed during lifetime of this object.
	 *
	 * @return unknown
	 */
	function numQueries() {
		return $this->querycount;
	}

	function setResult($resultSet) {
		$this->result = $resultSet;
	}

	/* Return the number of fields in a result set. */

	function numberFields() {

		return @mssql_num_fields ( $this->result );

	}

	/* Return a field name given an integer offset. */

	function fieldName($offset) {
		return @mssql_field_name ( $this->result, $offset );
	}

	/**
	 * method to test if a row conatining $x in the feild $y exists in the given $table
	 * returns unformated result list of instenses of true if exists else returns false
	 * @param string $table
	 * @param string $col
	 * @param string $val
	 * @return
	 *  */
	function getRow($table, $col, $val) {
		$this->query ( "SELECT * FROM `$table` WHERE `$col` = '$val'" );
		return $this->result;
	}

	/**
	 * method to delete all rows where $col=$val in $table
	 * returns int of number of affected rows or false on fail
	 *
	 * @param string $table
	 * @param string $col
	 * @param string $val
	 * @return none
	 */
	function deleteRow($table, $col, $val) {
		$this->query ( "DELETE FROM `$table` WHERE `$col` = '$val'" );
		return $this->result;
	}

	// Misc methods to do some convertions and stuff
	// round or pad to 2 decimal points
	function formatNum($num, $dec = 2) {
		for($x = 0; $x <= 5; $x ++) {
			$num = sprintf ( "%01." . ($dec + $x) . "f", $num );
			return $num;
		}
	}

	/**
	 * method to reverse the order of a given date
	 * and fix to mssql date format
	 * so DD/MM/YYYY becomes YYYY-MM-DD
	 *
	 * @param unknown_type $date
	 */
	function revDate($date) {
		// first split the date string @ / int o three parts
		$dateArray = explode ( '/', $date, 3 );
		// then reorder them to YYY/MM/DD
		$revDate = array_reverse ( $dateArray );
		$i = 0;
		foreach ( $revDate as $eliment ) {
			$correctDate .= $eliment;
			if ($i < 2) {
				$correctDate .= "-";
			}
			$i ++;
		}

		return $correctDate;
	}

	/**
	 * method to revers dates taken from sql database
	 * so YYYY-MM-DD becomes DD/MM/YYYY
	 *
	 * @param unknown_type $date
	 */
	function revSqlDate($date) {
		// first split the date string @ / int o three parts
		$dateArray = explode ( '-', $date, 3 );
		// then reorder them to DD/MM/YYYY
		$revDate = array_reverse ( $dateArray );
		$i = 0;
		foreach ( $revDate as $eliment ) {
			$correctDate .= $eliment;
			if ($i < 2) {
				$correctDate .= "/";
			}
			$i ++;
		}

		return $correctDate;
	}

	function exeStoredProc($procName) {

	}


	function rowExistsInDB($table, $col, $val) {

		$query = "SELECT $col FROM $table WHERE $col = '$val'";

		$this->query ( $query );

		if ($this->numRows () > 0) {
				
			return true;

		} else {
				
			return false;

		}

	}

	function rowExistsInDB2($table, $col, $val, $col2, $val2) {

		$query = "SELECT $col FROM $table WHERE $col = '$val' AND $col2 = '$val2'";

		$this->query ( $query );

		if ($this->numRows () > 0) {
				
			return true;

		} else {
				
			return false;

		}
	}
	function getLastMessage() {
		return mssql_get_last_message ();
	}

	function getLastError(){
		return mssql_get_last_message();
	}
	/**
	 * method to escape string before inserting in to a database
	 * as MS Server does not know how to deal with standard escape strings such as \'
	 * we have to use strings that the database can handel
	 * @param string $string
	 */
	public function cq($string) {
		// escape single quotes
		$string = str_ireplace ( "'", "''", $string );
		// replace double quotes with escaped single quote
		$string = str_ireplace ( '"', "''", $string );
		return $string;
	}

}

?>
