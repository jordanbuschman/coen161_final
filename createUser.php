<script src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script src="javascript.js"></script>

<form name="login" method="post" action="addUser.php">
	<table>
		<tr>
			<th>Username</th>
			<td><input name="username" type="text" id="newUsername"></td>
			<td id="validUsername"></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input name="password" type="password" id="newPassword"></td>
			<td id="validPassword"></td>
		</tr>
		<tr>
			<th>Confirm Password</th>
			<td><input name="password2" type="password" id="newPassword2"></td>
			<td id="validPassword2"></td>
		</tr>
		<tr>
			<td><input type="submit" name="Submit" value="Create" id="create" disabled="disabled"></input>
		</tr>
	</table>
</form>
