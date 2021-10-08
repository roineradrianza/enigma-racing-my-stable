	let params = new URLSearchParams(location.search);
	var member = params.get('member');
	$(document).ready(function(){
    Swal.fire({
      title: "Verification Pending",
      text: "Your verification has not been approved yet, when it is approved, an message is going to be sent to your email",
      icon: "warning",
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'I understand'
    }).then((result) => {
      if (result.value) {
        location.href="../controller/members.php?op=logout";
      }
      else{
        location.href="../controller/members.php?op=logout";
      }
    })
})