<!DOCTYPE html>
<html lang="en">
<?php echo $head;?>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a href=""><b>BODC</b>Dashboard</a>
	</div>
	<?php
		if($this->session->flashdata('error')){
	?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
	<?php
		}
	?>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Sign in to start your session</p>

			<form action="<?php echo base_url().'Account/sign_in_process';?>" method="post">
				<div class="input-group mb-3">
					<input name="username" type="text" class="form-control" placeholder="Username" autocomplete="off" required>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input name="password" type="password" class="form-control" placeholder="Password" autocomplete="off" required>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- /.col -->
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<!-- /.login-box -->

<?php echo $script;?>
</body>
</html>
