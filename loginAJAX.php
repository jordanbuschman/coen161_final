<!DOCTYPE html>
<html>
<body>

<script src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script src="javascript.js"></script>

<script>

function handleLogin(){

    var usr = document.getElementsByName('username')[0].value;
    var pwd = document.getElementsByName('password')[0].value;
    
    $.post( "check.php", { username:usr, password:pwd })
  	.done(function( data ) {
    	if( data == "T" )
    		alert( "Logged In" );
    	else
    		alert( "Not Logged In" );
  	}).fail(function() {
    	alert( "AJAX FAILED" );
  	});

}

</script>

<form name="login" action="javascript:handleLogin();">
    <table>
   		<tr>
            <th>Username</th>
            <td><input name="username" type="text" ></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input name="password" type="password"></td>
        </tr>
        <tr>
            <td><input type="submit" name="Submit" value="Login"></input>
        </tr>
    </table>
</form>
        

</body>
</html>
