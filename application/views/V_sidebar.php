<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index3.html" class="brand-link text-center">
		<span class="brand-text font-weight-light">BODC Dashboard</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo base_url().'assets/dist/img/user2-160x160.jpg';?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php echo $this->session->userdata('username');?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="<?php echo base_url().'Dashboard';?>" class="nav-link <?php if($this->uri->segment(1) == 'Dashboard') echo 'active';?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item" style="display: none;">
					<a href="<?php echo base_url().'Data';?>" class="nav-link <?php if($this->uri->segment(1) == 'Data') echo 'active';?>">
						<i class="nav-icon fas fa-file"></i>
						<p>
							Data Unit
						</p>
					</a>
				</li>
				<li class="nav-item <?php if($this->uri->segment(1) == 'Produksi') echo 'menu-open';?>">
					<a href="#" class="nav-link <?php if($this->uri->segment(1) == 'Produksi') echo 'active';?>">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Produksi
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url().'Produksi/data/3';?>" class="nav-link <?php if($this->uri->segment(1) == 'Produksi' && $this->uri->segment(3) == 3) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>OB</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url().'Produksi/data/4';?>" class="nav-link <?php if($this->uri->segment(1) == 'Produksi' && $this->uri->segment(3) == 4) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Coal</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?php if($this->uri->segment(1) == 'Pa') echo 'menu-open';?>">
					<a href="#" class="nav-link <?php if($this->uri->segment(1) == 'Pa') echo 'active';?>">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							PA
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url().'Pa/data/1';?>" class="nav-link <?php if($this->uri->segment(1) == 'Pa' && $this->uri->segment(3) == 1) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Loader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url().'Pa/data/2';?>" class="nav-link <?php if($this->uri->segment(1) == 'Pa' && $this->uri->segment(3) == 2) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Hauler</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?php if($this->uri->segment(1) == 'Ua') echo 'menu-open';?>">
					<a href="#" class="nav-link <?php if($this->uri->segment(1) == 'Ua') echo 'active';?>">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							UA
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url().'Ua/data/1';?>" class="nav-link <?php if($this->uri->segment(1) == 'Ua' && $this->uri->segment(3) == 1) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Loader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url().'Ua/data/2';?>" class="nav-link <?php if($this->uri->segment(1) == 'Ua' && $this->uri->segment(3) == 2) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Hauler</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?php if($this->uri->segment(1) == 'Productivity') echo 'menu-open';?>">
					<a href="#" class="nav-link <?php if($this->uri->segment(1) == 'Productivity') echo 'active';?>">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Productivity
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url().'Productivity/data/1';?>" class="nav-link <?php if($this->uri->segment(1) == 'Productivity' && $this->uri->segment(3) == 1) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Loader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url().'Productivity/data/2';?>" class="nav-link <?php if($this->uri->segment(1) == 'Productivity' && $this->uri->segment(3) == 2) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Hauler</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?php if($this->uri->segment(1) == 'Fuel_ratio') echo 'menu-open';?>">
					<a href="#" class="nav-link <?php if($this->uri->segment(1) == 'Fuel_ratio') echo 'active';?>">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Fuel Ratio
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url().'Fuel_ratio/data/1';?>" class="nav-link <?php if($this->uri->segment(1) == 'Fuel_ratio' && $this->uri->segment(3) == 1) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Loader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url().'Fuel_ratio/data/2';?>" class="nav-link <?php if($this->uri->segment(1) == 'Fuel_ratio' && $this->uri->segment(3) == 2) echo 'active';?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Hauler</p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
