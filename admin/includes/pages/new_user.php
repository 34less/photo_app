
        <!-- Navigation -->
        <?php include("navigation.php"); ?>

        <?php
        	$control = false;
        	if(isset($_POST['submit'])){

        		if($_POST['password']!=$_POST['password_confirm']){
        			$control=true;
        		}

        		else{
        			$user = new User();

        			$user->username=$_POST['username'];
        			$user->first_name=$_POST['first_name'];
        			$user->last_name=$_POST['last_name'];
        			$user->password=$_POST['password'];
        			$user->save();
        		}
        	}

        ?>



        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users
                            <small>Create a new user</small>
                        </h1>

                    <div class="col-md-6 col-md-push-1">
 						<form action="" method="post">
 							<div class="form-group">
 								<label for="username">Username</label>
 								<input type="text" placeholder="Username" name="username" class="form-control" required="true">	
 							</div>
 							<div class="form-group">
 								<label for="fist_name">Name</label>
  								<input type="text" placeholder="Name" name="first_name" class="form-control">	
  							</div>
 							<div class="form-group">
 								<label for="last_name">last_name</label>
 								<input type="text" placeholder="last_name" name="last_name" class="form-control">	
 							</div>
 							<div class="form-group">
 								<label for="password">Password</label>
 								<input type="password" placeholder="Password" name="password" class="form-control" required="true">	
 							</div>
 							<div class="form-group">
 								<input type="password" placeholder="Confirm password" name="password_confirm" class="form-control" required="true">	
 							</div>
 							<input style="width:30%; text-align:center;" type="submit" name="submit" class="btn btn-primary">
 							<?php if($control==true){echo "confirmed password is different than the password, please try again and submit!";}?>
 						</form>                      
                    </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->