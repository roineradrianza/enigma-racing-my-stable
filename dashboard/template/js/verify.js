	let params = new URLSearchParams(location.search);
	var member = params.get('member');
	$(document).ready(function(){
         Swal.fire({
        title: 'In progress',
        html: 'Verifying member...',
        timerProgressBar: true,
        onBeforeOpen: () => {
        Swal.showLoading()
        }
      });

       $.post('controller/members.php?op=verifyMember', {memberID: member}, function(data, textStatus, xhr) {
       		var response = JSON.parse(data);
       		if (response.status === true) {
              Swal.fire({
                title: response.title,
                text: response.message,
                icon: "success",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Done'
              }).then((result) => {
                if (result.value) {
                          location.href="panel/";
                }
              })
       		}
       		else{
	            Swal.fire({
		            title:response.title,
		            text:response.messsage,
		            icon:'warning',
		            confirmButtonText:'Try again'
	           }); 
       		}
       });
       
	})