<?php include("includes/header.php"); ?>

<?php include("admin/init.php"); 


$photos=Photo::load_all();

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = count(Photo::load_all());

?>

        <div class="row">

            <!-- Render the photos -->
            <div class="col-md-12">
                <div class="thumbnail row">
            <?php foreach($photos as $photo): ?>

                    <div class="col-xs-6 col-md-3">
                        <a class="tumbanails" href="photo.php?id=<?php echo $photo['photo_id'] ?>"  >
                            <img class="img-responsive home_page_picture" src="admin/fotos/<?php echo $photo['filename'] ?>" alt="">
                                

                            </img>

                        </a>         


                    </div>
            <?php endforeach; ?>
                </div>



            
          
         

            </div>




            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

            
                 <?php// include("includes/sidebar.php"); ?>



        </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
