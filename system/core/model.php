<?php
class Model {
	public function __construct() {
	}
	
	protected function get_array($sql_result) {
		$arr = null;
		if(is_object($sql_result) && $sql_result->num_rows > 0) {
			$arr = array();
			while ($row = $sql_result->fetch_assoc()) {
				array_push($arr, $row);
			}
		}
		return $arr;
	}
}
?>