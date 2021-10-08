var table;
	$("#memberForm").on("submit",function(e)
	{
		saveAndEdit(e);	
	})
//Function which is going to be executed first
function init(){
	list_stables();

}
function cleanInputs(){
	$("form input").val("");	
}
function cancelForm(){
	cleanInputs();
}
function list_stables()
{
	$.fn.dataTable.moment( 'dddd D MMMM YYYY' );
	table=$('#tb_list_stable').DataTable(
	{
		"aProcessing": true,
	    "aServerSide": true,
		  columnDefs: 
		  [
		    {
		        targets: [5,6],
		        className: 'dt-body-center'
		    },
		    {
		        targets: [5,6],
		        className: 'dt-head-center'
		    },
		  ],
	    dom: 'Bfrtip',
	    buttons:
		    [		          

	        {
	            extend: 'excel',
	            title: 'ENIGMA MyStable',
	            filename: 'MyStable',
	        },

	        {
	            extend: 'pdf',
	            title: 'ENIGMA MyStable',
	            textAlign: 'center',
	            filename: 'MyStable',
              customize: function(doc) {
				        doc.styles.tableBodyEven.alignment = 'center';
				        doc.styles.tableBodyOdd.alignment = 'center'; 
				      }     
	        },

	        {
	            extend: 'print',
	            title: 'ENIGMA MyStable',
	        }	
	      ],
		"ajax":
				{
					url: '../controller/members.php?op=myStable',
					type : "get",
					dataType : "json",		
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
	});
	$(".dt-button.buttons-print").addClass('btn btn-primary');
	$(".dt-button.buttons-excel").addClass('btn btn-success');
	$(".dt-button.buttons-pdf").addClass('btn btn-danger');
	$(".dt-buttons, #tb_list_stable_info").addClass('mb-3 mb-md-0 mb-lg-0 ml-1 ml-md-0 ml-lg-0 ');
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
			url: "../controller/members.php?op=changePassword",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(data)
		    { 
				    if (data === "Password updated succesfully") {
		            Swal.fire({
		            title:'Operation completed succesfully',
		            text:data,
		            icon:'success',
		            confirmButtonText:'Done'
		           });   
								$("#btnSave").prop("disabled",false);
								$("#memberFormModal").modal('toggle');
								cleanInputs();
				    } 
				   else{
		            Swal.fire({
		            title:"There was an error",
		            text:data,
		            icon:'warning',
		            confirmButtonText:'Try again'
		           });   
								$("#btnSave").prop("disabled",false);
								$("#memberFormModal").modal('toggle');
				   }                   
		    }

		});
		cleanInputs();
	}

}
init();