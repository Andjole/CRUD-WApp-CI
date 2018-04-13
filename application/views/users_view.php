<html>  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $titolo; ?></title>  
    <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
	<div class="container">
		<h1><?php echo $titolo; ?></h1>  
		<div id="error"></div>
		<br />
		<button class="btn btn-success" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
		<br /><br /><br />
		<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>				
					<th style="width:125px;">Action</p></th>
					<th>Username</th>
					<th>Email</th>
				</tr>
			</thead>	
		<?php foreach($users as $single) : ?>  
			<tbody>
				<tr>
					<td>
					<button class="btn btn-warning" onclick="edit_user(<?php echo $single->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
					<button class="btn btn-danger" onclick="delete_user(<?php echo $single->id;?>)"><i class="glyphicon glyphicon-remove"></i></button>
					<td><?php echo $single->username; ?></td>  
					<td><?php echo $single->email; ?></td>
				</tr> 
			</tbody>
		<?php endforeach; ?>
			<tfoot>
				<tr>
					<th style="width:125px;">Action</p></th>
					<th>Username</th>
					<th>Email</th>
				</tr>
		  </tfoot>
		</table>
	</div>
	<script src="<?php echo "https://code.jquery.com/jquery-3.1.1.min.js" ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js')?>"></script>
	<script type="text/javascript">
$(document).ready( function () {
    $('#table_id').DataTable({
		"scrollY":        "200px",
        "scrollCollapse": true
	});
} );
		var save_method; //for save method string
		var table;
		function showMessage(msg_type, msg_text){
			var AlertMsg = $('div[role="alert"]');
			$(AlertMsg).find('strong').html("Error");
			$('#msg-alert-form').html(msg_text);
			$(AlertMsg).addClass('alert-' + msg_type);
			$(AlertMsg).show();
		}

		function add_user()
		{
			save_method = 'add';
			$('#form')[0].reset(); // reset form on modals
			$('#modal_form').modal('show'); // show bootstrap modal
			//$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
		}
		function save()
		{
			
			var url;
			if(save_method == 'add')
			{
				url = "<?php echo site_url('/users/newuser')?>";
			}
			else
			{
				url = "<?php echo site_url('/users/updateUsers')?>";
			}
			$.ajax({
				type: 'POST',
				url: url,
				data: $('#form').serialize(),
				dataType: 'json',
				success: function(data)
				{
					//alert("??");
					//$("#msg-warning").html("Succes:  "+xhr.responseText);
					//if success close modal and reload ajax table
					$('#modal_form').modal('hide');
					location.reload();// for reload a page
				},
				error: function(xhr){
					showMessage('danger', xhr.responseText)
					//$("#msg-warning").html("Error:  "+xhr.responseText);
					//$("#error").html(xhr.responseText);
				}
  
			});
		}
		function delete_user(id){
			if(confirm('Are you sure delete this data?'))
			{
				// ajax delete data from database
				$.ajax({
					url : "<?php echo site_url('/users/deleteUsers')?>/"+id,
					type: "POST",
					success: function(data)
					{
						//$("#msg-warning").html(xhr.responseText);
						location.reload();
					},
					error: function(xhr){
					   $("#error").html(xhr.responseText);
					}
				});

			}
		}
		function edit_user(id)
		{
			save_method = 'update';
			$('#form')[0].reset(); // reset form on modals

			//Ajax Load data from ajax
			$.ajax({
				url : "<?php echo site_url('/users/ajax_edit')?>/" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data){
					$('[name="user_id"]').val(data.id);
					$('[name="username"]').val(data.username);
					$('[name="email"]').val(data.email);
					$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
				},
				error: function(xhr){
					$("#error").html(xhr.responseText);
				}
			});
		}
	</script>
	 <!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">User Form</h3>
				</div>
				<div class="modal-body form">					
					<div class="alert alert-warning alert-dismissible collapse" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<strong></strong><span id="msg-alert-form"></span>						
					</div>
					
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="user_id"/>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Username</label>
								<div class="col-md-9">
								<input name="username" placeholder="Username" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Email</label>
								<div class="col-md-9">
								<input name="email" placeholder="Email" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Password</label>
								<div class="col-md-9">
								<input name="password" placeholder="Password" class="form-control" type="password">

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Confirm Password</label>
								<div class="col-md-9">
								<input name="confirm_password" placeholder="Confirm Password" class="form-control" type="password">
							</div>
							</div>

						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->
</body>  
</html>  