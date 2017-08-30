        <!-- Navigation -->
        <?php include("navigation.php"); ?>

        <?php $render = Photo::load_all()?>


        
        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Photos
                            <small>All the submitted photos</small>
                        </h1>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Id</th>
                                    <th>File Name</th>
                                    <th>Title</th>
                                    <th>Size</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($render as $foto){

                                    echo "
                                    <tr>
                                        <td>
                                            <img style='width:200px; border-radius:5px' src=fotos/".$foto[2].">
                                            <div class='pictures_link'>
                                                <a href='index.php?page=delete&foto_id=".$foto[0]."'>Delete</a>
                                                <a href='../photo.php?id=".$foto[0]."'>View</a>
                                            </div>
                                        </td>

                                        <td>".$foto[0]."</td>
                                        <td>".$foto[2]."</td>
                                        <td>".$foto[1]."</td>
                                        <td>".$foto[3]."</td>
                                        <td><a href='index.php?page=comments&comment=".$foto[0]."'>".count(Comment::find_the_comments($foto[0]))."</a></td>  
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

