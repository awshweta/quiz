<?php include_once('header.php');
include_once('menu.php');?>
    <div id='test'>
    <form method="POST">
        <p>
            Test : <input type="text" class="test">
        </p>
        <p>
            <input type="button" class='addTest' value="Add Test">
        </p>
    </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $( document ).ready( function() {
           $('.addTest').click(function(){
            var test = $('.test').val();
            console.log(test);
              $.ajax({
                method: "POST",
                url: "test.php",
                data:{ test:test , action:'' },
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
        });
    </script>
<?php include_once('footer.php');?>