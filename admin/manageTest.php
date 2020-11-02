<?php include_once('header.php');
 include_once('menu.php');?>
<div id='test'></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        	$('#test').on('click','.delete' ,function(){
                if (confirm('Are you sure you want to delete this record?'))
		        {
                    var tid = $(this).data('tid');
                    //console.log(tid);
                    $.ajax({
                    method: "POST",
                    url: "fetch_test.php",
                    data:{ id: tid, action:"delete"},
                    dataType: "json"
                    }).done(function( msg ) {
                        $('#test').html(msg.test);
                    });
                }
            });
           

            $('#test').on('click','.addQuestionForm' ,function(){
                var tid = $(this).data('tid');
                //console.log(tid);
                $.ajax({
                method: "POST",
                url: "addquestion.php",
                data:{ id: tid , action:'form'},
                dataType: "json"
                }).done(function( msg ) {
                    $('#test').html(msg.form);
                });
            });

            $('#test').on('click','.addQuestion' ,function(){
                var tid = $(this).data('id');
                var ques = $('.question').val();
                var answer = $('.answer').val();
                var op1 = $('.op1').val();
                var op2 = $('.op2').val();
                var op3 = $('.op3').val();
                var op4 = $('.op4').val();
               
                $.ajax({
                method: "POST",
                url: "addquestion.php",
                data:{ id:tid, ques:ques ,op1:op1 ,op2:op2 ,op3:op3 ,op4:op4 ,answer:answer ,action:'addques'},
                dataType: "json"
                }).done(function( msg ) {
                    if(msg.success !=''){
                        alert(msg.success);
                    }
                    else{
                        alert(msg.error);
                    }
                });
            });

        $( document ).ready( function() {
            $.ajax({
            method: "POST",
            url: "fetch_test.php",
            data:{ action:'' },
            dataType: "json"
            }).done(function( msg ) {
                $('#test').html(msg.test);
            });
        });
    </script>
<?php include_once('footer.php');?>