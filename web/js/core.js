
function comprobarDatos()
{
	// chequea que el captcha no sea nulo
	var captcha = $("#captcha").val();
	if(captcha == 0)
	{
		$("#capnull-error").slideDown(500);
		$("#captcha-error").slideUp(500);
		$("#captcha").focus();
		return false;
	}
	else {
		$("#capnull-error").slideUp(500);
		$("#captcha-error").slideUp(500);
	}
	
	// chequea que el captcha sea valido
	if(captcha != captcha_c)
	{
		$("#captcha-error").slideDown(500);
		$("#capnull-error").slideUp(500);
		$("#captcha").focus();
		return false;
	}
	else {
		$("#capnull-error").slideUp(500);
		$("#captcha-error").slideUp(500);
		return true;
	}

	return false;
}

//Generamos el captcha de suma aleatoria
var captcha_c = null;
function generate_captcha(id, img_src)
{
	var captcha_a = Math.ceil(Math.random() * 10);
	var captcha_b = Math.ceil(Math.random() * 10);
	captcha_c = captcha_a + captcha_b;
	var id = (id) ? id : 'lcaptcha';
	$("#"+id).html(
		"<img alt='' src=" + img_src + " onclick='generate_captcha(\"lcaptcha\", \"" + img_src + "\");' style='width: 30px;margin-right: 10px'>" +
		captcha_a + " + " + captcha_b + " = "
	);
}
