<?php

/**
 * TLTDataModel.php
 *
 * Returns all movie titles found in the DB as an array.
 *
 * @author     Jordan Rifaey <contact@jordanrifaey.com>
 * @license    https://www.php.net/license/3_01.txt  PHP License 3.1
 */

class TLTDataModel {

    const DSN_KEY = "dsn";
    const DB_USERNAME_KEY = "DBuser";
    const DB_PASSWORD_KEY = "DBpass";
    const PREPARED_STATEMENT_KEY = "preparedStatement";

    private $titles = array();

    function __construct() {
        ini_set('default_socket_timeout', 999999999);
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 999999999);

        //Obtain DB credentials from file. This is a better practice than hard coding the creds.
        define("TLT_DATA_MODEL_INI_FILE", "TLTDataModel.ini");
        $this->iniArray = parse_ini_file(TLT_DATA_MODEL_INI_FILE);
        //Connect to DB
        $dsn = "mysql:host=localhost;dbname=" . ($this->iniArray[self::DSN_KEY]);
        $db = new PDO($dsn, $this->iniArray[self::DB_USERNAME_KEY], $this->iniArray[self::DB_PASSWORD_KEY]);
        //Prepare SQL statement and run. This is the best practice as it protects against SQL injection.
        $query = $this->iniArray[self::PREPARED_STATEMENT_KEY];
        $statement = $db->prepare($query);
        $statement->execute();
        $tempTitles = $statement->fetchAll();
        $statement->closeCursor();

        //Store DB results in private array.
        $newTitles = array();
        foreach($tempTitles as $tempTitle) {
            array_push($newTitles, $tempTitle[0]);
        }
        $this->titles = $newTitles;
    }

    public function getTitles() {
        //Return the array of titles obtained from the DB.
        return $this->titles;
    }

}
