<?php include_once('header.php');
 include_once('menu.php');?>
<div id="users"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	    <script>
               $('#users').on('click','.edit' ,function() {
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
                            $('#users').html(msg.editdata);
                        });
                    }
                });

                $('#users').on('click','.save' ,function() {
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
                        $('#users').html(msg.user);
                    });
                });

                $('#users').on('click','.delete' ,function(){
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
                            $('#users').html(msg.user);
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
                $('#users').html(msg.user);

                }); 
            });
        </script>
    <?php include_once('footer.php');?>