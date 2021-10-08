$("#resetButton").on("click",function(e){
    e.preventDefault();
        Swal.fire({
          title: 'Submit your member email',
          input: 'email',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Send',
          showLoaderOnConfirm: true,
          preConfirm: (email) => {
            Swal.fire({
                  title: 'In progress...',
                  html: 'Wait while we process your request ',
                  timerProgressBar: true,
                  onBeforeOpen: () => {
                  Swal.showLoading()
                  }
            });
            $.post('controller/members.php?op=resetPasswordRequest', {email: email}, function(data, textStatus, xhr) {
                        console.log(data);
                        console.log(textStatus);
                        console.log(xhr);
                        var response = JSON.parse(data);
                        if (response.status === true) {
                            Swal.fire({
                                title:response.title,
                                text:response.message,
                                icon:'success',
                                confirmButtonText:'Done'
                            })            
                        }
                        else if (response.status == false) {
                            Swal.fire({
                                    title:response.title,
                                    text:response.message,
                                    icon:'warning',
                                    confirmButtonText:'Try again'
                           });        
                        }

                    });
              },
          allowOutsideClick: () => !Swal.isLoading()
          })
        })
$("#loginForm").on('submit',function(e){
    e.preventDefault();
    if ($("#login").val() == "") {
        if ($("#password").val() == "") {
            Swal.fire({
                title:'There was a problem',
                text:'Please fill the email and password field',
                icon:'warning',
                confirmButtonText:'Try again'
             }); 
        }
        else{
            Swal.fire({
                title:'There was a problem',
                text:'Please fill the email field',
                icon:'warning',
                confirmButtonText:'Try again'
           });  
        }
    }
    else if ($("#password").val() == "") {
        if ($("#login").val() == "") {
            Swal.fire({
                title:'There was a problem',
                text:'Please fill the email and password field',
                icon:'warning',
                confirmButtonText:'Try again'
             }); 
        }
        else{
            Swal.fire({
                title:'There was a problem',
                text:'Please fill the password field',
                icon:'warning',
                confirmButtonText:'Try again'
           }); 
        }
    }
    else {
        var login = $("#login").val();
        var password = $("#password").val();
        var remember = $("#remember").prop("checked") ? 1 : 0;

        $.post("controller/members.php?op=verify",
            {"email":login,"password":password, "remember": remember },
            function(data)
        {
            if (data!=="null")
            {
                var data = JSON.parse(data);
                if (data.position == "admin") {
                    $(location).attr("href","dashboard/members.php");            
                }
                else{
                  $(location).attr("href","panel/");            
                }
                //
            }
            else
            {
                Swal.fire({
                title:'There was a problem',
                text:'Your email or password is incorrect',
                icon:'warning',
                confirmButtonText:'Try again'
               });   
            }
        });
    }
})
$("#registerForm").on('submit',function(e)
{
    e.preventDefault();
    var fullname=$("#fullname").val();
    var email = $("#email").val();
    var password=$("#password").val();
    if ($("#confirm_password").val() !== password) {
      Swal.fire({
          title:'Please, verify one of the fields',
          text:'Check that the password and confirm password field match',
          icon:'warning',
          confirmButtonText:'Done'
     });
     $("#btnSave").prop("disabled",false);   
    }
    else{
        Swal.fire({
              title: 'In progress...',
              html: 'Wait while we process your request ',
              timerProgressBar: true,
              onBeforeOpen: () => {
              Swal.showLoading()
              }
        });
        $.post("controller/members.php?op=register",
            {"fullname":fullname,"email":email,"password":password},
            function(data)
        {
            var response = JSON.parse(data);  
            if (response.status === true)
            {
                Swal.fire({
                  title: response.title,
                  text: response.message,
                  icon: "success",
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Done'
                }).then((result) => {
                  if (result.value) {
                            location.href="login.php";
                  }
                })
            }
            else
            {
                Swal.fire({
                  title: response.title,
                  text: response.message,
                icon:'warning',
                confirmButtonText:'Try again'
               });   
            }
        });
    }
})