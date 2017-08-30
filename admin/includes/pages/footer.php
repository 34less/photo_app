  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views',     <?php echo $_SESSION['count'];  ?>],
          ['Comments',      <?php echo count(Comment::load_all()) ?>],
          ['User',  <?php echo count(User::load_all()) ?>],
          ['Photos', <?php echo count(Photo::load_all()) ?>],
        ]);

        var options = {
        	legend:'none',
        	pieSliceText: 'label',
        	backgroundColor: 'transparent' ,
          	title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

</body>

</html>
