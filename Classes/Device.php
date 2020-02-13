<?php
/**
 * Description of Device
 *
 * @author petersen
 * @author lehmann
 * @author jessen
 */
class Device {
    public $deviceID; // numer of the device
    public $name; // name of the device
    public $type;   // type of the device
    public $brand;  // brand of the device
    public $qrCode; // QR-Code of the device
    public $cardId; //number of the cart
	
	public function __construct() {
		$this->DB = Database::getDbConnection()
	}
    
    /**
     * it saves the record
     **/
    abstract public function save() {

	}
	
    /**
     * it deletes the record
     **/
    abstract public function delete($deviceID) {
		$query = "DELETE FROM device WHERE ´deviceID´ = ?";
		$param = ($deviceID);
		$DB->executeQuery($query, $param)
	}
	
    /**
     * it inserts the record
     **/
    abstract protected function insert($name, $type, $brand) {
		$query = "INSERT INTO device (name, type, brand) VALUES (?, ?, ?)";
		$param = ($name, $type, $brand);
		$DB->executeQuery($query, $param)
	}
	
    /**
     * it updates the record
     **/
    abstract protected function update($deviceID, $name, $type, $brand) {
		$query = "UPDATE device SET (name = ?, type = ?, brand = ?) WHERE ´deviceID´ = ?";
		$param = ($name, $type, $brand, $deviceID);
		$DB->executeQuery($query, $param)
	}
	
     /**
     * @return a specific ID
     **/
    abstract static function load($deviceID):ActiveRecord {
		$query = "SELECT * FROM device WHERE ´deviceID´ = ?";
		$param = ($deviceID);
		$DB->executeQuery($query, $param)
	}
}
