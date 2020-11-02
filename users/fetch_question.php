<?php include("config.php");
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
    $_SESSION['test']='';

}
else{
    $a = false;
}
 
    if (isset($_POST['action'])) {
        if ($_POST['action'] == "test") {
            $test ='<div id="tests">';
            $sql = "SELECT *  FROM test";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $test .='<div class ="start">
                       <input type="hidden" name="id" value='.$row['id'].'>
                           <a>'.$row['name'].'</a>
                           <p><input data-tid='.$row['id'].' class="ques" type="button"  name="start" value="Start Test"></p>
                       </div>';
                }
            }
            $test .='</div>';
        }

         if ($_POST['action'] == "ques") {
            $_SESSION['ans'] = 0;
            $tid= $_POST['id'];
            $question ='<div id="tests">';
            $i = 1;
            unset($_SESSION['answer']);
            $sqllast = "SELECT *  FROM questions WHERE `test_id` = '$tid' ORDER BY `id` DESC LIMIT 1";
            $resultlast = $conn->query($sqllast);
            if ($resultlast->num_rows > 0) {
                while ($rowlast = $resultlast->fetch_assoc()) {
                    $last = $rowlast['id'];
                    $sql = "SELECT *  FROM questions WHERE `test_id` = $tid LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $question .='
                            <form class="question">
                                <input type="hidden" name="id" value='.$row['id'].'>
                                <p><b>'.$i.': </b>'.$row['question'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$i.'" value="'.$row['option1'].'" >'.$row['option1'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$i.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$i.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$i.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>
                                <p><input data-qno='.$i.' data-tid='.$row['test_id'].'  data-prev='.$row['id'].'  data-last='.$last.' data-qid='.$row['id'].' class="prev" type="button" name="prev" value="prev" hidden>
                                <input data-qno='.$i.'  data-tid='.$row['test_id'].' data-prev='.$row['id'].'  data-last='.$last.' data-qid='.$row['id'].' class="next" type="button" name="next" value="next"> 
                                <input data-qno='.$i.'  data-tid='.$row['test_id'].'  data-qid='.$row['id'].' data-last='.$last.'  class="submit"  type="button" name="submit" value="submit" hidden></p> 
                            </form>';
                        }
                    }
                }
            }
            $question .= '</div>'; 
        }

        if ($_POST['action'] == "prev") {
            $r = false;
            $tid = $_POST['tid'];
            $id= $_POST['id'];
            $last = $_POST['last'];
            $prev = $_POST['prev'];
            $qno = $_POST['qno'];
           // $val = $_POST["val"];
    
            $sql = "SELECT *  FROM questions WHERE `test_id` = '$tid' AND  `id` < '$id' AND `id` >= '$prev'  ORDER BY `id` DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($_SESSION['answer'] as $k => $v) {
                        $v = (array)$v;
                        // print_r($v);
                        if ($v['qid'] == $row['id']) {
                            $qno--;
                            $question .='
                            <form  class="question">
                                <input type="hidden" name="id" value='.$row['id'].'>
                                <p><b>'.$qno.' : </b>'.$row['question'].'</p>';
                                if ($v['val'] == $row['option1']) {
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" checked >'.$row['option1'].'</p>';
                                }
                                else{
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" >'.$row['option1'].'</p>'; 
                                }
                                if ($v['val'] == $row['option2']) {
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" checked >'.$row['option2'].'</p>';
                                }
                                else{
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>'; 
                                }
                                if ($v['val'] == $row['option3']) {
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" checked >'.$row['option3'].'</p>';
                                }
                                else{
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>'; 
                                }
                                if ($v['val'] == $row['option4']) {
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" checked >'.$row['option4'].'</p>';
                                }
                                else{
                                    $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>'; 
                                }
                                if ($qno != 1) {
                                    $question .= '<p><input data-qno='.$qno.' data-tid='.$row['test_id'].' data-last='.$last.' data-prev='.$prev.' data-qid='.$row['id'].'  class="prev" type="button" name="prev" value="prev">';
                                } else {
                                    $question .= '<p><input data-qno='.$qno.' data-tid='.$row['test_id'].' data-last='.$last.'  data-prev='.$prev.' data-qid='.$row['id'].'  class="prev" type="button" name="prev" value="prev" hidden>';
                                }
                                $question .='<input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.'  data-qid='.$row['id'].' data-last='.$last.' class="next" type="button" name="next" value="next">  
                                <input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-qid='.$row['id'].'  class="submit"  type="button" name="submit" value="submit" hidden></p> 
                            </form>';
                        }
                    }
                    $question .= '</div>';
                }
            }
        }

        if ($_POST['action'] == "next") {
            $tid = $_POST['tid'];
            $id= $_POST['id'];
            $last = $_POST['last'];
            $prev = $_POST['prev'];
            $val = $_POST["val"];
            $qno = $_POST['qno'];
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
                                $_SESSION['answer'][$k]['val']= $val;
                            } else {
                                $_SESSION['answer'][$k]['score']= 0;
                                $_SESSION['answer'][$k]['val']= $val;
                            }
                        }
                    }
                    if($r == false) {
                        if ($rowans['answer'] == $val) {
                            array_push($_SESSION['answer'], array('qno'=>$qno ,'qid'=>$id  ,'val' => $val, 'score'=>1));
                           
                        } else {
                            array_push($_SESSION['answer'], array('qno'=>$qno ,'qid'=>$id ,'val' => $val , 'score'=>0));
                           
                        }
                    }
                }
            }

            $question ='<div id="tests">';
            //  print_r($_SESSION['answer']);
            $sql = "SELECT *  FROM questions WHERE `test_id` = '$tid' AND  `id` > '$id' AND `id`<= $last  LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $qno = $qno+1;
                    $a = false;
                    $i =0;
                    $question .='<form class="question">
                    <input type="hidden" name="id" value='.$row['id'].'>
                    <p><b>'.$qno.' : </b>'.$row['question'].'</p>';
                   
                    foreach ($_SESSION['answer'] as $k => $v) {
                        $v = (array)$v;
                        if ($v['qid'] == $row['id']) {
                            $a = true;
                            if ($v['val'] == $row['option1']) {
                                $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" checked >'.$row['option1'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>';
                                break;
                            } elseif ($v['val'] == $row['option2']) {
                                $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" >'.$row['option1'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" checked >'.$row['option2'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>';
                                break;
                            } elseif ($v['val'] == $row['option3']) {
                                $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'">'.$row['option1'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" checked >'.$row['option3'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>';
                                break;
                            } elseif ($v['val'] == $row['option4']) {
                                $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" >'.$row['option1'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>
                                <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" checked >'.$row['option4'].'</p>';
                                break;
                            }
                        }
                    }

                    if ($a == false) {
                        $question .=  '<p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option1'].'" >'.$row['option1'].'</p>
                        <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option2'].'" >'.$row['option2'].'</p>
                        <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option3'].'" >'.$row['option3'].'</p>
                        <p><input type="radio" class="radio" name="radio'.$qno.'" value="'.$row['option4'].'" >'.$row['option4'].'</p>
                        <p id ="btn"><input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.' data-qid='.$row['id'].'  data-last='.$last.' class="prev" type="button" name="prev" value="prev">';
                        if($last == $row['id']) {
                            $question .= '<input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.'  data-qid='.$row['id'].' data-last='.$last.' class="next" type="button" name="next" value="next" hidden >
                            <input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-qid='.$row['id'].'  class="submit"  type="button" name="submit" value="submit"></p>';
                        }
                        else {
                            $question .= '<input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.'  data-qid='.$row['id'].' data-last='.$last.' class="next" type="button" name="next" value="next">'; 
                        }
                        $question .= ' </form>';
                    }
                    else {
                        $question .= '<p id="btn"><input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.' data-qid='.$row['id'].'  data-last='.$last.' class="prev" type="button" name="prev" value="prev">';
                        if($last == $row['id']) {
                            $question .= '<input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.'  data-qid='.$row['id'].' data-last='.$last.' class="next" type="button" name="next" value="next" hidden >
                            <input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-qid='.$row['id'].'  class="submit"  type="button" name="submit" value="submit"></p>';
                        }
                        else {
                            $question .= '<input data-qno='.$qno.' data-tid='.$row['test_id'].'  data-prev='.$prev.'  data-qid='.$row['id'].' data-last='.$last.' class="next" type="button" name="next" value="next">'; 
                        }
                        $question .= '</form>';
                    }
                    $question .= '</div>';
                }
            }
        }

        $test = array('question' => $question,'tests'=>$test);
        echo json_encode($test);
    }