<?php include("config.php");
 $error = array();
 $test ='';
 $question ='';
 global $editdata ;
 $success = '';
    if(isset( $_POST['action'])) {
        if ($_POST['action'] == "test") {
            $test ='<table id="tests">
               <tr class = "row" >
                   <th>Test</th>
               </tr>';
       
            $sql = "SELECT *  FROM test";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $test .=' <tr><ul class = "row">
                       <input type="hidden" name="id" value='.$row['id'].'>
                           <td><li><a data-tid='.$row['id'].' class="ques">'.$row['name'].'</a></li><td>   
                       </ul></tr>';
                }
            }
            $test .='</table>';
        }

        if ($_POST['action'] == "edit") {
            $editdata ='<div id="tests">';

            $id=$_POST['id'];
            $sql = "SELECT *  FROM questions WHERE id=$id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $editdata .=' <form id="tests">
                    <p>
                        Question : "'.$row['question'].'"
                    </p>
                    <p>
                        Option 1 : <input type="text" name="op1" class="op1" value="'.$row['option1'].'">
                    </p>
                    <p>
                        Option 2 : <input type="text" name="op2" class="op2" value="'.$row['option2'].'">
                    </p>
                    <p>
                        Option 3 : <input type="text" name="op3" class="op3" value="'.$row['option3'].'">
                    </p>
                    <p>
                        Option 4 : <input type="text" name="op4" class="op4" value="'.$row['option4'].'">
                    </p>
                    <p>
                        Answer : <input type="text" name="answer" class="answer" value="'.$row['answer'].'">
                    </p>
                    <p>
                        <input type="button" data-id='.$id.' class="update" value="update">
                    </p>
                    </form>';
                }
            }
            $editdata .='</div>';  
        }

        if($_POST['action'] == 'update') {
            $id = $_POST['id'];
            $op1 = isset($_POST['op1']) ? $_POST['op1']:'';
            $op2 = isset($_POST['op2']) ? $_POST['op2']:'';
            $op3 = isset($_POST['op3']) ? $_POST['op3']:'';
            $op4 = isset($_POST['op4']) ? $_POST['op4']:'';
            $answer = isset($_POST['answer']) ? $_POST['answer']:'';

            if (sizeof($error) == 0) {
                $sqledit = "UPDATE questions SET `option1` = '$op1', `option2` = '$op2', `option3` = '$op3' , `option4` = '$op4', `answer` = '$answer'  WHERE `id`= $id ";
                if ($conn->query($sqledit) === true) {
                    $success = "Question updated successfully";
                } else {
                    $error[] = array('input'=>'form','msg'=>'Error deleting record: ' .$conn->error.'');
                }
            }
        }

        if ($_POST['action'] == "delete") {
            if(sizeof($error) == 0) {
                $id=$_POST['id'];
                //echo var_dump($id);
                $sqldelete = "DELETE FROM questions WHERE `id` = '$id'";

                if ($conn->query($sqldelete) === true) {
                // echo "<div id='success'>question deleted successfully</div>";
                }
                else {
                    $error[]=array('input'=>'form','msg'=>'Error deleting record: ' .$conn->error.'');
                }
            }
        }

        if ($_POST['action'] == '') {
            $tid= $_POST['id'];
            $question ='<table id="question">';
            $i =1;
            $sql = "SELECT *  FROM questions WHERE `test_id` = $tid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $question .='
                    <tr id="quest">
                        <input type="hidden" name="id" value='.$row['id'].'>
                        <td><b>'.$i.': </b></td>
                        <td>'.$row['question'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option1'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option2'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option3'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option4'].'</td>
                        <td><input data-qid='.$row['id'].' class="delete" type="button" name="delete" value="delete"></td>
                        <td><input data-qid='.$row['id'].' class="edit" type="button" name="edit" value="edit"></td>
                    </tr>';
                    $i++;
                }
            }
            $question .= '</table>';
        }

         $test = array('question' => $question,'tests'=>$test , 'editdata'=>$editdata , 'success'=>$success);
         echo json_encode($test);
    }