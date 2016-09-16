	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script>

function genPassword() {
	var password = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for (var i=0; i < 12; i++) {
		password += possible.charAt(Math.floor(Math.random() * possible.length));
	}

	return password;
}

$('#plainPass').on('change', function() {
	if(this.checked) {
		$("#password1").prop("type", "text");
		$("#password2").prop("type", "text");
	} else {
		$("#password1").prop("type", "password");
		$("#password2").prop("type", "password");
	}
});

$('.plainPass').on('change', function() {
	if(this.checked) {
		$('#'+($(this).attr('id').replace(/plainPass/i, 'password1'))).prop("type", "text");
		$('#'+($(this).attr('id').replace(/plainPass/i, 'password2'))).prop("type", "text");
	} else {
		$('#'+($(this).attr('id').replace(/plainPass/i, 'password1'))).prop("type", "password");
		$('#'+($(this).attr('id').replace(/plainPass/i, 'password2'))).prop("type", "password");
	}
});


$('.usersettings').on('click', function() {
	console.log($(this).attr('href'));
	$($(this).attr('href')).toggleClass('hidden');
	$(this).toggleClass('active');
	
});
 

$('#genPass').on('click', function() {
	var password = genPassword();
	$('#password1').val(password);
	$('#password2').val(password);
});

$('.genPass').on('click', function() {
	var password = genPassword();
	$('#'+($(this).attr('id').replace(/genPass/i, 'password1'))).val(password);
	$('#'+($(this).attr('id').replace(/genPass/i, 'password2'))).val(password);
});

$('#addAccount').on('click', function() {
	$('#newAccount').toggleClass('hidden');
});



$('#addForwarder').on('click', function() {
	$('#newForwarder').toggleClass('hidden');
});

$('.sourceForward').on('click', function () {
	$('.sourceForward').parent().removeClass('active');
	$(this).parent().addClass('active');
	$('#sourceSet').html($(this).html() + ' <span class="caret"></span>');
	$('#realSource').val($(this).html());
});

</script>


</html>
