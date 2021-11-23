<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
?>
<!-- Principal Content Start -->
   <div id="index">

    <!-- Header -->
      <div class="row">
         <div class="col-xs-12 intro">
            <div class="carousel-inner">
               <div class="item active">
                <img class="img-responsive" src="images/index/woman.jpg" alt="header picture">
               </div>
               <div class="carousel-caption">
                  <h1>FIND NICE PICTURES HERE</h1>
                  <hr>
               </div>
            </div>
         </div>
      </div>

      <div id="index-body">
      <!-- Pictures Navigation table -->
        <div class="table-responsive">
          <table class="table text-center">
            <thead>
              <tr>
                <td><a class="link active" href="#category1" data-toggle="tab">category I</a></td>
                <td><a class="link" href="#category2" data-toggle="tab">category II</a></td>
                <td><a class="link" href="#category3" data-toggle="tab">category III</a></td>
              </tr>
            </thead>
          </table>
          <hr>
        </div>
      
      <!-- Navigation Table Content -->
        <div class="tab-content">
          <?php
            $categoryId = '1';
            $active = true;
            shuffle($galeria);
            include __DIR__ . "/partials/imagen-galeria.part.php";
            $categoryId = '2';
            $active = false;
            shuffle($galeria);
            include __DIR__ . "/partials/imagen-galeria.part.php";
            $categoryId = '3';
            $active = false;
            shuffle($galeria);
            include __DIR__ . "/partials/imagen-galeria.part.php";

          ?>
  
        </div>
    <!-- End of Navigation Table Content -->
      </div><!-- End of Index-body box -->

    <!-- Newsletter form -->
      <div class="index-form text-center">
        <h3>SUSCRIBE TO OUR NEWSLETTER </h3>
        <h5>Suscribe to receive our News and Gifts</h5>
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
            <input class="form-control" type="text" placeholder="Type here your email address">
            <a href="" class="btn btn-lg sr-button">SUBSCRIBE</a>
            </div>
          </div>
        </form>
      </div>
    <!-- End of Newsletter form -->  

<?php
  include __DIR__ . "/partials/asociado.part.php";
?>

   </div><!-- End of index box -->

   <!-- Footer -->
   <footer class="home-page">
     <div class="container text-muted text-center">
       <div class="row">
         <ul class="nav col-sm-4">
           <li class="footer-number"><i class="fa fa-phone sr-icons"></i>  (00228)92229954 </li>
           <li><i class="fa fa-envelope sr-icons"></i>  kouvenceslas93@gmail.com</li>
           <li>Photography Fanatic Template &copy; 2017</li>
         </ul>
         <ul class="list-inline social-buttons col-sm-4 col-sm-push-4">
            <li><a href="#"><i class="fa fa-facebook sr-icons"></i></a>
            </li>
            <li><a href="#"><i class="fa fa-twitter sr-icons"></i></a>
            </li>
            <li><a href="#"><i class="fa fa-google-plus sr-icons"></i></a>
            </li>
         </ul>
       </div>
     </div>
   </footer>

<?php
  include __DIR__ . "/partials/fin-doc.part.php";
?>