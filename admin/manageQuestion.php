<?php include_once('header.php');
 include_once('menu.php');?>
<div id='tests'></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
            $('#tests').on('click','.delete' ,function(){
                if (confirm('Are you sure you want to delete this record?'))
		        {
                    var qid = $(this).data('qid');
                    //console.log(qid);
                    $.ajax({
                    method: "POST",
                    url: "fetchQuestions.php",
                    data:{ id: qid, action:"delete"},
                    dataType: "json"
                    }).done(function( msg ) {
                        $('#tests').html(msg.question);
                    });
                }
            });

            $('#tests').on('click','.edit' ,function(){
                if (confirm('Are you sure you want to edit options?'))
		        {
                    var qid = $(this).data('qid');
                    //console.log(qid);
                    $.ajax({
                    method: "POST",
                    url: "fetchQuestions.php",
                    data:{ id: qid, action:"edit"},
                    dataType: "json"
                    }).done(function( msg ) {
                        $('#tests').html(msg.editdata);
                    });
                }
            });

            $('#tests').on('click','.update' ,function(){
                var qid = $(this).data('id');
                var answer = $('.answer').val();
                var op1 = $('.op1').val();
                var op2 = $('.op2').val();
                var op3 = $('.op3').val();
                var op4 = $('.op4').val();
               
                $.ajax({
                method: "POST",
                url: "fetchQuestions.php",
                data:{ id:qid ,op1:op1 ,op2:op2 ,op3:op3 ,op4:op4 ,answer:answer ,action:'update'},
                dataType: "json"
                }).done(function( msg ) {
                    if(msg.success != ''){
                        alert(msg.success);
                    }
                });
            });


            $( document ).ready( function() {
                $.ajax({
                method: "POST",
                url: "fetchQuestions.php",
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
                url: "fetchQuestions.php",
                data:{ id:tid , action:''},
                dataType: "json"
                }).done(function( msg ) {
                    //console.log(msg.question);
                    $('#tests').html(msg.question);
                });
            });
    </script>
<?php include_once('footer.php');?>