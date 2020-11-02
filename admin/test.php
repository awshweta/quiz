<?php 
	include("config.php");
    $error = array();
    $success ='';
	$r=false;
		if(isset($_POST['action'])) {
            if($_POST['action'] == '') {
                $test = isset($_POST['test']) ? $_POST['test']:'';

                if(sizeof($error) == 0) {
                    $sqlselect = "SELECT * FROM test ";
                    $result = $conn->query($sqlselect);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            if(($row['name'] == $_POST['test'])) {
                                    $r=true;
                            }
                        }
                    }
                    if($r == false){
                        $sql = "INSERT INTO test(`name`) VALUES ('".$test."')";
                        if ($conn->query($sql) === true) {
                            $success = "test added successfully";
                        } else {
                            $error[] = array('input' => 'form' , 'msg' => $conn->error);
                        }
                    }else {
                        $error[] = array('input' => 'form' , 'msg' => 'Duplicate testName does not exist');
                    }
                }
            }
        }
         
        $msg = array('success'=>$success , 'error'=> $error);
        echo json_encode($msg);
?>