<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<button type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-bars"></i>
		</button>
		<div>
			<ul class="nav navbar-nav ml-auto" style="display: block ruby;">
				<li class="nav-item active">
					<a class="nav-link" onclick="goBack()" ><i class="fa fa-arrow-left btn btn-primary"> Back </i></a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="" data-toggle="modal" data-target="#account"><i class="fa fa-user btn btn-primary"> <?php if(isset($_SESSION['admin_name'])){ $name = $_SESSION['admin_name'];  echo ucfirst($name);} ?></i></a>
				</li>
			</ul>
		</div>
	</div>
</nav>