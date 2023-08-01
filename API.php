<?php
    include_once("./dbinfo.php");
    //Coneect To DB
    try
    {
        $objDBConn = new PDO('mysql:host=' . $strDBHost . ';dbname=' . $strDBName . ';charset=utf8', $strDBUser, $strDBPass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $e)
    {
        echo json_encode(array(
                        'Status' => 'Error',
                        'ErrorData' => array(
                                        'FriendlyMSG' => 'DB Connection Failed',
                                        'ErrorMSG' => $e->getMessage(),
                                        'ErrorCode' => $e->getCode()
                                            )
                        ), JSON_FORCE_OBJECT);
        exit();
    }
    if(isset($_GET['from']) && isset($_GET['to']))
    {
        $fromDate = $_GET['from'];
        $toDate = $_GET['to'];
    }
    else
    {
         echo 'something missing!';
         exit();
    }
    $strSQL = "SELECT *
            FROM `workorder`
            WHERE str_to_date(`ORDER DATE`, '%d %M %Y') >= ? And str_to_date(`ORDER DATE`, '%d %M %Y') <= ?
            Order By id;";
    try
    {
        $objfSTMT = $objDBConn->prepare($strSQL);
        $objfSTMT->execute(array($fromDate, $toDate));
    }
    catch(PDOException $e)
    {
        $ResData = array(
                        'Status' => 'Error',
                        'ErrorData' => array(
                                        'FriendlyMSG' => 'DB Query Failed!',
                                        'ErrorMSG' => $e->getMessage(),
                                        'ErrorCode' => $e->getCode()
                                        )
                        );
        $objRConn= null;
        echo json_encode($ResData, JSON_FORCE_OBJECT);
        exit();
    }
    $dbData = $objfSTMT->fetchAll(PDO::FETCH_ASSOC);
    header("Content-Type: application/json");
    echo json_encode(array('Status' => 'Success', 'Data' => $dbData), JSON_FORCE_OBJECT);
    exit();
?>