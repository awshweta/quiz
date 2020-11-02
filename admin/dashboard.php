<?php include_once('header.php');?>
<?php include_once('menu.php');?>
    <h2 id='heading'>(1) All Test list</h2>
    <div id='testd'></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('#testd').on('click','.delete' ,function(){
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
                        $('#testd').html(msg.test);
                    });
                }
            });
           

            $('#testd').on('click','.addQuestionForm' ,function(){
                var tid = $(this).data('tid');
                //console.log(tid);
                $.ajax({
                method: "POST",
                url: "addquestion.php",
                data:{ id: tid , action:'form'},
                dataType: "json"
                }).done(function( msg ) {
                    $('#testd').html(msg.form);
                });
            });

            $('#testd').on('click','.addQuestion' ,function(){
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
                $('#testd').html(msg.test);
            });
        });
    </script>

    <h2 id='head'>(2) All Test link list </h2>
    <div id='testc'></div>
    <script>
        $('#testc').on('click','.delete' ,function(){
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
                    $('#testc').html(msg.question);
                });
            }
        });

        $('#testc ').on('click','.edit' ,function(){
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
                    $('#testc').html(msg.question);
                });
            }
        });

        $( document ).ready( function() {
            $.ajax({
            method: "POST",
            url: "fetchQuestions.php",
            data:{ action:'test' },
            dataType: "json"
            }).done(function( msg ) {
                $('#testc').html(msg.tests);
            });
        });

        $('#testc').on('click','.ques' ,function(){
            var tid = $(this).data('tid');
            $.ajax({
            method: "POST" ,
            url: "fetchQuestions.php",
            data:{ id:tid , action:'ques'},
            dataType: "json"
            }).done(function( msg ) {
                $('#testc').html(msg.question);
            });
        });
    </script>
    <h2 id="head"> (3) All Admin list</h2>
    <div id="user"></div>
	    <script>
               $('#user').on('click','.edit' ,function() {
                if (confirm('Are you sure you want to update password?'))
		            {
                        var uid = $(this).data('uid');
                        console.log(uid);
                        $.ajax({
                        method: "POST",
                        url: "fetch_admin.php",
                        data:{ id: uid, action:"edit"},
                        dataType: "json"
                        }).done(function( msg ) {
                            console.log(msg.editdata);
                            $('#user').html(msg.editdata);
                        });
                    }
                });

                $('#user').on('click','.save' ,function() {
                var uid = $(this).data('uid');
                var newpass = $('.newpass'+uid+'').val();
                    console.log(uid);
                  $.ajax({
                    method: "POST",
                    url: "fetch_admin.php",
                    data:{ id: uid, action:"save" , newPassword : newpass},
                    dataType: "json"
                    }).done(function( msg ) {
                        //console.log(msg.user);
                        $('#user').html(msg.user);
                    });
                });

                $('#user').on('click','.delete' ,function(){
                    if (confirm('Are you sure you want to delete this record?'))
		            {
                        var uid = $(this).data('uid');
                        //console.log(uid);
                        $.ajax({
                        method: "POST",
                        url: "fetch_admin.php",
                        data:{ id: uid, action:"delete"},
                        dataType: "json"
                        }).done(function( msg ) {
                            $('#user').html(msg.user);
                        });
                    }
                });


           $( document ).ready( function() {
                $.ajax({
                method: "POST",
                url: "fetch_admin.php",
                data:{ action:'' },
                dataType: "json"
                }).done(function( msg ) {
                $('#user').html(msg.user);

                }); 
            });
        </script>
<?php include_once('footer.php');?>
