<?php include("config.php");
 $error = array();
 $test ='';
 $question ='';
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

        if ($_POST['action'] == "ques") {
            $tid= $_POST['id'];
            $question ='<table id="quest">';
            $i =1;
            $sql = "SELECT *  FROM questions WHERE `test_id` = $tid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $question .='
                    <tr id="question">
                        <input type="hidden" name="id" value='.$row['id'].'>
                        <td><b>'.$i.': </b></td>
                        <td>'.$row['question'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option1'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option2'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option3'].'</td>
                        <td><input type="radio" class="radio" name="radio" />'.$row['option4'].'</td>
                        <td><input data-qid='.$row['id'].' class="delete" type="button" name="delete" value="delete"></td>
                        <td><input data-qid='.$row['id'].' class="edit" type="button" name="update" value="update"></td>
                    </tr>';
                    $i++;
                }
            }
            $question .= '</table>';
        }

         $test = array('question' => $question,'tests'=>$test);
         echo json_encode($test);
    }