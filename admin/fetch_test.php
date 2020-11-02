<?php include("config.php");
 $error = array();

 if(isset( $_POST['action'])) {

        if ($_POST['action'] == "delete") {
            if(sizeof($error) == 0) {
                $id=$_POST['id'];
                //echo var_dump($id);
                $sqldelete = "DELETE FROM questions WHERE `test_id` = '$id'";

                if ($conn->query($sqldelete) === true) {
                   // echo "<div id='success'>question deleted successfully</div>";
                }
                $sqldelete = "DELETE FROM test WHERE id = $id";

                if ($conn->query($sqldelete) === true) {
                   // echo "<div id='success'>Test deleted successfully</div>";
                } else {
                    $error[]=array('input'=>'form','msg'=>'Error deleting record: ' .$conn->error.'');
                }
            }
        }
        
            $test ='<table id="test">
            <tr class = "row" >
                <th>Name</th>
                <th>Action</th>
            </tr>';
    
            $sql = "SELECT *  FROM test";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $test .=' <tr class = "row">
                    <input type="hidden" name="id" value='.$row['id'].'>
                        <td>'.$row['name'].'</td>
                        <td><input data-tid='.$row['id'].' class="addQuestionForm" type="button" name="addQuestion" value="Add Question"></td>
                        <td><input data-tid='.$row['id'].' class="delete" type="button" name="delete" value="DELETE"></td>
                    </tr>';
                }
            }
            $test .='</table>';
        

        $test = array('test' => $test);
        echo json_encode($test);
 }