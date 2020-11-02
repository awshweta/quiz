<?php
    if(isset($_POST['action'])){
        include_once('config.php');
        $success ='';
        $form = '';
        $error = array();
        $r=false;
    
        if($_POST['action'] == 'addques') {
            $id = $_POST['id'];
            //echo $id;
            $ques = isset($_POST['ques']) ? $_POST['ques']:'';
            $op1 = isset($_POST['op1']) ? $_POST['op1']:'';
            $op2 = isset($_POST['op2']) ? $_POST['op2']:'';
            $op3 = isset($_POST['op3']) ? $_POST['op3']:'';
            $op4 = isset($_POST['op4']) ? $_POST['op4']:'';
            $answer = isset($_POST['answer']) ? $_POST['answer']:'';

            if(sizeof($error) == 0) {
                $sqlselect = "SELECT * FROM questions WHERE `test_id` = '$id'";
                $result = $conn->query($sqlselect);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if(($row['question'] == $_POST['ques'])) {
                                $r=true;
                        }
                    }
                }
                if($r == false) {
                    $sqls = "SELECT * FROM questions WHERE `test_id` = '$id'";
                    $results = $conn->query($sqls);
                    if ($results->num_rows < 10) {
                        $sql = "INSERT INTO questions(`question`,`option1`,`option2`,`option3`,`option4`,`answer`,`test_id`) VALUES ('$ques','$op1','$op2','$op3','$op4','$answer','$id')";
                        if ($conn->query($sql) === true) {
                            $success = "question added successfully";
                        } else {
                            $error[] = array($conn->error);
                        }
                    }
                    else{
                        $error[] = array("only 10 question allowed");
                    }
                    
                }else {
                    $error[] = array('Duplicate testName does not exist');
                }
            }
        }

        if($_POST['action'] == 'form') {
                $id = $_POST['id'];
                $form =' <div id="test">
                <p>
                    Question : <input type="text" class="question">
                </p>
                <p>
                    Option 1 : <input type="text" name="op1" class="op1">
                </p>
                <p>
                    Option 2 : <input type="text" name="op2" class="op2">
                </p>
                <p>
                    Option 3 : <input type="text" name="op3" class="op3">
                </p>
                <p>
                    Option 4 : <input type="text" name="op4" class="op4">
                </p>
                <p>
                    Answer : <input type="text" name="answer" class="answer">
                </p>
                <p>
                    <input type="button" data-id='.$id.' class="addQuestion" value="Add Question">
                </p>
                </div>';
        }

        $test = array('form' => $form , 'success'=>$success , 'error'=> $error);
        echo json_encode($test);
    }
?>