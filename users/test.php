<?php include_once('header.php');
include_once('config.php');

if(!isset($_SESSION['user'])) {
   header('location:login.php');
}

?>
<h2>Welcome <?php echo $_SESSION['user']['username'] ;?>
<?php include_once('menu.php');?>
<div id='tests'></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
           
            $( document ).ready( function() {
                $.ajax({
                method: "POST",
                url: "fetch_question.php",
                data:{ action:'test' },
                dataType: "json"
                }).done(function( msg ) {
                    $('#tests').html(msg.tests);
                });
            });

            $('#tests').on('click','.ques' ,function(){
                var tid = $(this).data('tid');
                $.ajax({
                method: "POST" ,
                url: "fetch_question.php",
                data:{ id:tid , action:'ques'},
                dataType: "json"
                }).done(function( msg ) {
                   // console.log(msg.question);
                    $('#tests').html(msg.question);
                });
            });

            $('#tests').on('click','.prev' ,function(){
                var qno = $(this).data('qno');
                var tid = $(this).data('tid');
                var last = $(this).data('last');
                var qid = $(this).data('qid');
                var prev = $(this).data('prev');
                //var val = $('input[name="radio'+qno+'"]:checked').val();
               // console.log(val);
                    if(qid == prev ){
                        $('.prev').hide();
                    }
                    $.ajax({
                    method: "POST" ,
                    url: "fetch_question.php",
                    data:{ id:qid , tid:tid , prev:prev ,last:last ,qno:qno,action:'prev'},
                    dataType: "json"
                    }).done(function( msg ) {
                        // console.log(msg.score);
                        $('#tests').html(msg.question);
                    });
            });

            $('#tests').on('click','.next' ,function(){
                var qno = $(this).data('qno');
                var tid = $(this).data('tid');
                var qid = $(this).data('qid');
                var last = $(this).data('last');
                var prev = $(this).data('prev');
                var val = $('input[name="radio'+qno+'"]:checked').val();
                //console.log(val);
                $.ajax({
                method: "POST" ,
                url: "fetch_question.php",
                data:{ id:qid , tid:tid ,last:last, val:val ,prev:prev,qno:qno ,action:'next'},
                dataType: "json"
                }).done(function( msg ) {
                    //console.log(msg.score);
                    $('#tests').html(msg.question);
                });
            });

            $('#tests').on('click','.submit' ,function(){
                var qno = $(this).data('qno');
                var tid = $(this).data('tid');
                var qid = $(this).data('qid');
                var val = $('input[name="radio'+qno+'"]:checked').val();
                //console.log(val);
                $.ajax({
                method: "POST" ,
                url: "result.php",
                data:{ id:qid , tid:tid , val:val , qno:qno ,action:'submit'},
                dataType: "json"
                }).done(function( msg ) {
                   // console.log(msg.score);
                    $('#tests').html(msg.result);
                });
            });
    </script>
<?php include_once('footer.php');?>