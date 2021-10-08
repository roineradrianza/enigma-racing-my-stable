	let params = new URLSearchParams(location.search);
	var resetCode = params.get('code');
	$("#recoverPasswordForm").on("submit",function(e)
	{
		restorePassword(e);	
	})
function restorePassword(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnRestorePassword").prop("disabled",true);
	var formData = new FormData($("#recoverPasswordForm")[0]);
	formData.append("resetCode",resetCode);
	if ($("#confirm_password").val() !== $("#password").val() ) {
      Swal.fire({
	      title:'Please, verify one of the fields',
	      text:'Check that the password and confirm password field match',
	      icon:'warning',
	      confirmButtonText:'Done'
     });
     $("#btnSave").prop("disabled",false);   
	}
	else{
		$.ajax({
			url: "../controller/members.php?op=resetPassword",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(data)
		    { 
		    	var response = JSON.parse(data);
				    if (response.status === true) {
				    	Swal.fire({
								  title: response.title,
								  text: response.message,
								  icon: data.status,
								  confirmButtonColor: '#3085d6',
								  confirmButtonText: 'Sign In'
								}).then((result) => {
								  if (result.value) {
											location.href="../login.php";
								  }
								})
								$("#btnRestorePassword").prop("disabled",false);
				    } 
				   else{
		            Swal.fire({
		            title:"There was an error",
		            text:data,
		            icon:'warning',
		            confirmButtonText:'Try again'
		           });   
								$("#btnRestorePassword").prop("disabled",false);
				   }                   
		    }

		});
	}

}