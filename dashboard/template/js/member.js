var table;

//Función que se ejecuta al inicio
function init(){
	list_payment();
	list_syndicates();
	list();
}
function verify(id){
		var memberID = id;
		Swal.fire({
		  title: 'In progress...',
		  html: 'The member is being verified... ',
		  timerProgressBar: true,
		  onBeforeOpen: () => {
		  Swal.showLoading()
		  }
		});
		$.post('../controller/members.php?op=verifyMember', {memberID: memberID}, function(data, textStatus, xhr) {
						var response = JSON.parse(data);
		        if (response.status) {
				        Swal.fire({
					      title:response.title,
					      text:response.message,
					      icon:"success",
					      confirmButtonText:'Done'
					     });   
		        }
		        else{
			            Swal.fire({
			            title:'There was an error',
			            text:data,
			            icon:'warning',
			            confirmButtonText:'Try again'
			           });   
		        }
			});
			table.ajax.reload();
}
function unVerify(id){
		var memberID = id;
		$.post('../controller/members.php?op=unverifyUser', {memberID: memberID}, function(data, textStatus, xhr) {
		       var response = JSON.parse(data);
		        if (response.status === true) {
				        Swal.fire({
					      title:response.title,
					      text:response.message,
					      icon:'success',
					      confirmButtonText:'Done'
					     });   
		        }
		        else{
			            Swal.fire({
			            title:'There was an error',
			            text:data,
			            icon:'warning',
			            confirmButtonText:'Try again'
			           });   
		        }
			});
			table.ajax.reload();
}
	$("#memberForm").on("submit",function(e)
	{
		saveAndEdit(e);	
	})
function cleanInputs(){
	$("form input").val("");
}
function showForm(){
	if ($("#memberModalLabel").text() == 'Add a new member') {
		$("#memberModalLabel").text('Update Member');
	}
		$("#memberFormModal").modal('toggle');
}
function cancelForm(){
	showForm();
	$("#memberModalLabel").text('Add a new member');
	$("#btnSave").text('Create');
	cleanInputs();
}
function editUserForm(id){
		$.post("../controller/members.php?op=show",{memberID : id}, 
			function(data, status)
			{
				data = JSON.parse(data);		
				showForm(true);
				$("#btnSave").text('Update');
				$("#fullname").val(data.fullname);
				$("#email").val(data.email);
				$("select[name='position']").val(data.position);
				$("#memberID").val(data.memberID);
		 	});
}
function deleteUser(id){
	var memberID = id;
	Swal.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
					$.post('../controller/members.php?op=delete', {memberID: memberID}, function(data, textStatus, xhr) {
				        if (data === "Member has been deleted succesfully") {
						        Swal.fire({
							      title:'Operation completed succesfully',
							      text:data,
							      icon:'success',
							      confirmButtonText:'Done'
							     });   
				        }
				        else{
					            Swal.fire({
					            title:'There was an error',
					            text:data,
					            icon:'warning',
					            confirmButtonText:'Try again'
					           });   
				        }
					});
					table.ajax.reload();
	  }
	})
}
//Función Listar
function list()
{
	table=$('#tblist').DataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: 
	    [		          
        'excel',
        'pdf',
        {
            extend: 'print',
            title: 'Members'
        }
      ],
      columnDefs: 
		  [
		    {
		        targets: 0,
		        className: 'dt-body-center'
		    }
		  ],
		"ajax":
				{
					url: '../controller/members.php?op=list',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true
	});
		$("[data-toggle='tooltip']").tooltip();
		$(".dt-button.buttons-print").addClass('btn btn-primary');
		$(".dt-button.buttons-excel").addClass('btn btn-success');
		$(".dt-button.buttons-pdf").addClass('btn btn-danger');
}
function list_payment()
{
	table=$('#tb_list_payment').DataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: 
	    [		          
        'excel',
        'pdf',
        {
            extend: 'print',
            title: 'Payments'
        }
      ],
		  columnDefs: 
		  [
		    {
		        targets: 5,
		        className: 'dt-body-center'
		    }
		  ],
		"ajax":
				{
					url: '../controller/members.php?op=list-payments',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true
	});
		$(".dt-button.buttons-print").addClass('btn btn-primary');
		$(".dt-button.buttons-excel").addClass('btn btn-success');
		$(".dt-button.buttons-pdf").addClass('btn btn-danger');
}
function saveAndEdit(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnSave").prop("disabled",true);
	var formData = new FormData($("#memberForm")[0]);
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
			url: "../controller/members.php?op=saveAndEdit",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(data)
		    { 
				    if (data === "Member created" || data === "Member updated") {

		            Swal.fire({
		            title:'Operation completed succesfully',
		            text:data,
		            icon:'success',
		            confirmButtonText:'Done'
		           });   
								$("#btnSave").prop("disabled",false);
								$("#btnSave").html('Create');
								showForm();
			          table.ajax.reload();
				    } 
				   else{
		            Swal.fire({
		            title:"There was an error",
		            text:data,
		            icon:'warning',
		            confirmButtonText:'Try again'
		           });   
								$("#btnSave").prop("disabled",false);
				   }                   
		    }

		});
		cleanInputs();
	}

}
function list_syndicates()
{
	table=$('#tb_list_syndicates').DataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: 
	    [		          
        'excel',
        'pdf',
        {
            extend: 'print',
            title: 'Syndicates'
        }
      ],
		  columnDefs: 
		  [
		    {
		        targets: 5,
		        className: 'dt-body-center'
		    },
		    {
		        targets: 9,
		        className: 'dt-body-center'
		    }
		  ],
		  "ajax":
				{
					url: '../controller/members.php?op=list-syndicates',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true
	});
		$(".dt-button.buttons-print").addClass('btn btn-primary');
		$(".dt-button.buttons-excel").addClass('btn btn-success');
		$(".dt-button.buttons-pdf").addClass('btn btn-danger');
}
init();