<?php

require_once __DIR__.'/constants.php';

class DBOperations{
    
    public function fetchData($selectSql, $types = '', $filterParamsArray = null){
        $conn = $this->getDBConnection (); 
        $fetchedDataSet = null;        
        try {
            $statement = $this->prepareAndExecuteStatement($conn, $selectSql, $types, $filterParamsArray);
            $result = $statement->get_result();
            if ($result->num_rows > 0){
                $fetchedDataSet = array();
                $fieldInfosArray = $result->fetch_fields();
                while ($row = $result->fetch_assoc()){
                    $rowDataObject = array();
                    foreach ($fieldInfosArray as $fieldInfo){
                        $rowDataObject[$fieldInfo->name] = $row[$fieldInfo->name];
                    }
                    $fetchedDataSet[] = $rowDataObject;              
                }
            }            
        } finally {
            $this->closeResources($conn, $statement, $result);
        }
        return $fetchedDataSet;
    }
    
    public function cudData($cudSql, $types, $cudParams){
        $conn = $this->getDBConnection ();
        $lasInsertedId = 0;
        try {
            $statement = $this->prepareAndExecuteStatement($conn, $cudSql, $types, $cudParams);
            $lasInsertedId = $conn->insert_id;
            // The last inserted auto incremented id value will be returned. if not, in case of updates, retrun the number of rows affected.
            if ($lasInsertedId == 0) {
                $lasInsertedId = $statement->affected_rows;
            }
        } finally {
            $this->closeResources($conn, $statement);
        }
        return $lasInsertedId;
    }
    
    private function getDBConnection(){
        $conn = new mysqli(SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_SCHEMA);
        if ($conn->connect_errno){
            printf('DB Connection failed : %s \n', $conn->connect_error);
            exit();
        }
        return $conn;
    }
    
    private function prepareAndExecuteStatement($conn, $sql, $types, $sqlParamsArray){
        $statement = $conn->prepare($sql);
        // Using PHP's unpack operator the array values are un-packed as comma separated input params
        //error_log('log for update : '.print_r($sqlParamsArray, true));
        if (isset($sqlParamsArray)) {
            $statement->bind_param($types, ...$sqlParamsArray);    
        }
        $statement->execute();  
        return $statement;
    }
    
    private function closeResources($conn, $statement = false, $result = false){
            if ($result) $result->free();
            if ($statement) $statement->close();
            if ($conn) $conn->close();
    }
}