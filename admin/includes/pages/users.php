
        <!-- Navigation -->
        <?php include("navigation.php"); ?>

        <?php $render_user = User::load_all()?>


        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <a href="index.php?page=new_user" ><button class="btn btn-primary" style="margin-top:10px">Create new user</button></a>

                        <h1 class="page-header">
                            Users
                            <small>Subheading</small>
                        </h1>

                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($render_user as $user){

                                    echo "
                                    <tr>
                                        <td>
											".$user[0]."
                                        </td>
                                        <td>".$user[1]."</td>
                                        <td>".$user[2]."</td>
                                        <td>".$user[3]."</td>  
                                        <td>                                       
                                            <a href='index.php?page=delete_user&user_id=".$user[0]."'>Delete</a>
                                            <a href='#'>View</a>
                                        </td>
                                    </tr>
                                    ";
                                }

                                ?>
                            </tbody>

                        </table>
  					                      
                    </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

