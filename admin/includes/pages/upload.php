
        <!-- Navigation -->
        <?php include("navigation.php"); ?>

        <?php

            // ONLY FOR DEBUG
            if(isset($_POST['submit'])){
                echo "<h1>HELLO</h1>";
            }

            /* ************* */
            $photo = new Photo();
            $photo->title = $_POST['title'];
            $photo->set_file($_FILES['file_upload']);    
           

            if ($photo->save()){
                $message = "photo uploaded Succefully";
            }
            else {
                $message = "<br>" . $photo->errors;
            }
            echo $message;


        ?>



        <div id="page-wrapper">




           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Upload
                            <small>Upload your picture here!</small>
                        </h1>

                        <div class="col-md-6">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <input type="text" name="title" class="form-control">
                                    <input type="file" name="file_upload">

                                </div>

                                <input type="submit" name="submit">

                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

