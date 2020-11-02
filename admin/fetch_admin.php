<?php 
 include("config.php");
 $error = array();

 if(isset( $_POST['action'])) {
     global $editdata;

    if($_POST['action'] == "edit") {
      $editdata ='<table id="users">
        <tr class = "row" >
            <th>User_Name</th>
            <th>Old Password</th>
            <th>New Password</th>
            <th>Role</th>
            <th>Action</th>
        </tr>';

        $uid=$_POST['id'];
        $sql = "SELECT *  FROM users WHERE `id` = $uid";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $editdata .=' <tr class = "row">
                <input type="hidden" name="id" value='.$row['id'].'>
                <td>'.$row['username'].'</td>
                <td><input type="password" name="oldPassword" value='. $row['password'].' required></td>
                <td><input class= "newpass'.$row['id'].'" type="password" name="newPassword" required></td>
                <td>'.$row['role'].'</td>
                <td><input data-uid='.$row['id'].' class="save" type="button" name="save" value="Update"></td>
                </tr>';
            }
        }
        $editdata .='</table>';  
    } 

    if($_POST['action'] == "save"){
        $newPass = md5($_POST['newPassword']);
        if (sizeof($error) == 0) {
            $id=$_POST['id'];
            $sqledit = "UPDATE users SET `password` = '$newPass'  WHERE `id`=$id ";
            if ($conn->query($sqledit) === true) {
               // echo "<div id='success'>Password updated successfully</div>";
            } else {
                $error[] = array('input'=>'form','msg'=>'Error deleting record: ' .$conn->error.'');
            }
        }
    }

        if ($_POST['action'] == "delete") {
            if(sizeof($error) == 0) {
                $id=$_POST['id'];
                //echo var_dump($id);
                $sqldelete = "DELETE FROM users WHERE `id` = $id";

                if ($conn->query($sqldelete) === true) {
                   // echo "<div id='success'>User account deleted successfully</div>";
                } else {
                    $error[]=array('input'=>'form','msg'=>'Error deleting record: ' .$conn->error.'');
                }
            }
        }
        
            $userdata ='<table id="users">
            <tr class = "row" >
                <th>User_Name</th>
                <th>Password</th>
                <th></th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>';
    
            $sql = "SELECT *  FROM users WHERE role='admin'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $userdata .=' <tr class = "row">
                    <input type="hidden" name="id" value='.$row['id'].'>
                    <input type="hidden" name="name" value='.$row['username'].'>
                        <td>'.$row['username'].'</td>
                        <td>'.$row['password'].'</td>
                        <td><input class="new'.$row['id'].'" type="password" name="newPassword" hidden required></td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['role'].'</td>
                        <td><input data-uid='.$row['id'].' class="delete" type="button" name="delete" value="DELETE"></td>
                        <td><input data-uid='.$row['id'].' class="edit" type="button" name="update" value="EDIT"></td>
                    </tr>';
                }
            }
            $userdata .='</table>';
            $conn->close();
        

        $users = array('user' => $userdata, 'editdata' => $editdata);
        echo json_encode($users);
 }