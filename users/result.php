<?php  
    include("config.php");
    $error = array();
    $test ='';
    $question ='';
    $last =0;
    $qno = 0;
    $total = 0;
    $result ='';
    $a= false;
    if(!isset($_SESSION['answer'])) {
        $a=true;
        $_SESSION['answer']=array();

    }
    else{
        $a = false;
    }    
    if ($_POST['action'] == "submit") {
        $tid = $_POST['tid'];
        $id= $_POST['id'];
        $val = $_POST["val"];
        $qno = $_POST['qno'];
        $user_id = $_SESSION['user']['id'];
        $r = false;
        $sqlans = "SELECT *  FROM questions WHERE `test_id` = '$tid' AND  `id` = '$id'";
        $resultans = $conn->query($sqlans);
        if ($resultans->num_rows > 0) {
            while ($rowans = $resultans->fetch_assoc()) {
                foreach($_SESSION['answer'] as $k => $v) {
                    $v = (array)$v;
                    // print_r($v);
                    if($v['qid'] == $rowans['id']) {
                        $r = true;
                        if ($rowans['answer'] == $val) {
                            $_SESSION['answer'][$k]['score']= 1;
                        } else {
                            $_SESSION['answer'][$k]['score']= 0;
                        }
                    }
                }
                if($r == false) {
                    if ($rowans['answer'] == $val) {
                        array_push($_SESSION['answer'], array('qno'=>$qno ,'qid'=>$id , 'score'=>1));
                    } else {
                        array_push($_SESSION['answer'], array('qno'=>$qno ,'qid'=>$id , 'score'=>0));
                    }
                }
            }
        }
        
        foreach($_SESSION['answer'] as $k => $v) {
            $v = (array)$v;
            $total += $_SESSION['answer'][$k]['score'];
        }
        //echo $total;
        if($total > 4) {
            $result = "pass";
        }
        else{
            $result = "fail";
        }
        // echo $result;
        $sql = "INSERT INTO answers(`user_id`,`test_id` , `correct_answer` , `result`) VALUES ('".$user_id."','".$tid."', '".$total."' ,'".$result."')";
        if ($conn->query($sql) === true) {
            //echo "<div id='success'><script type='text/javascript'>alert(' successfully')</script></div>";
            unset($_SESSION['answer']);
        } else {
            $error[] = array('input' => 'form' , 'msg' => $conn->error);
        } 

        $r ='<table id="result">
                <tr class="results">
                <th>USERNAME</th>
                <th>RESULT</th>
            </tr>';
        $username = $_SESSION['user']['username'];
        $sqlresult = "SELECT *  FROM answers WHERE `test_id` = '$tid' AND `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1";
        $result = $conn->query($sqlresult);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $r .='
                <tr class="results">
                    <input type="hidden" name="id" value='.$row['id'].'>
                    <td>'.$username.'</td>
                    <td>'.$row['result'].'</td>
                </tr>';
            }
        }
        $displayresult = array('result' => $r);
        echo json_encode( $displayresult);
    }
?>