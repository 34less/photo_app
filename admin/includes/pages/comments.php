
        <!-- Navigation -->
        <?php include("navigation.php"); ?>

        <?php 

        if(isset($_GET['comment']))
        {
            $render = Comment::find_the_comments($_GET['comment']);
        }
        else{
            $render = Comment::load_all();
        }

        ?>


        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            Comments
                            <small>the comment of the submitted photos</small>
                        </h1>

                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Photo_id</th>
                                    <th>Author</th>
                                    <th>Body</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($render as $user){

                                    echo "
                                    <tr>
                                        <td>
                                            ".$user[0]."
                                        </td>
                                        <td>".$user[1]."</td>
                                        <td>".$user[2]."</td>
                                        <td>".$user[3]."</td>  
                                        <td>                                       
                                            <a href='index.php?page=delete_comment&user_id=".$user[0]."'>Delete</a>
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

