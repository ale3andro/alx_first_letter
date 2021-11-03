<?php
            $id = $_GET['id'];
            $string = file_get_contents("activities.json");
            $json_a = json_decode($string,true);
    
            $valid_keys = array();
            $description = '';
            $url_subfolder = '';
            $images = '';
            $jq_function = '';
            $jq_function_message = '';
            foreach ($json_a as $key => $value)
                array_push($valid_keys, $value['id']);
            
            if (!in_array($id, $valid_keys))
                $id='a001';

            $images = " images = [";

            foreach ($json_a as $key => $value){
                if ($id==$value['id']) {
                    $description = $value['description'];
                    $url_subfolder = $value['url_subfolder'];
                    $jq_function = $value['jquery_function'];
                    foreach ($value["images"] as $bkey => $bvalue) {
                        $images .= "['" . $bvalue['image'] . "', '" . $bvalue["letter0"] . "', '" . $bvalue["letter1"] . "', '" . $bvalue["letter2"] . "'],";
                    }
                }
            }
            $images .= "];";
            
            if ($jq_function=='click')
                $jq_function_message = 'μονό κλικ';
            else {
                $jq_function='dblclick';
                $jq_function_message = 'διπλό κλικ';
            }
                
        ?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Από τι γράμμα ξεκινά η λέξη;</title>

    <!-- Bootstrap core CSS -->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/2-col-portfolio.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Πρώτο γράμμα</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Αρχική
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 id="alx_header" class="my-4"><?php echo $description; ?></h1>
      <h3><?php echo $jq_function_message; ?></h3>

      <div class="row" id="image">
        
      </div>

      <div class="row">
        <div class="col" id="alx0"></div>
      </div>
      <div class="row">
        <div class="col" id="alx1"></div>
        <div class="col" id="alx2"></div>
        <div class="col" id="alx3"></div>
      </div>

      <!-- /.row -->

      <br /><br />

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyleft ale3andro.gr 11-2021 - revision 0.2</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/jquery-ui-dist/jquery-ui.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
      $( function() {
        <?php
            echo $images;
        ?>     
      });

      $( document ).ready(function() {
        counter=0;
        $('#alx1').<?php echo $jq_function; ?>(function() {
          $('#alx1').html('<img src="emojis/happy_emoji.png">');
          if (counter==(images.length-1)) {
            if (sessionStorage.getItem("quest_ordinal") === null) {
              $('#alx0').html('<img width="461" height="200" src="emojis/emojis-high-five.gif">');
              $('#alx1').html('');
              $('#alx2').html('');
              $('#alx3').html('');
            } else {
              $('#alx0').html('<img width="461" height="200" src="emojis/emojis-high-five.gif"><br /><a href="' + sessionStorage.getItem("quest_return") +'">Επιστροφή</a>');
              sessionStorage.setItem("quest" + sessionStorage.getItem("quest_ordinal") + "_is_complete", "yes");
              $('#alx1').html('');
              $('#alx2').html('');
              $('#alx3').html('');
            }
            
          }
          else {
            counter+=1;
            prep_challenge();
          }
        });
        $('#alx2').<?php echo $jq_function; ?>(function() {
          $('#alx2').html('<img src="emojis/sad_emoji.png">');
        });
        $('#alx3').<?php echo $jq_function; ?>(function() {
          $('#alx3').html('<img src="emojis/sad_emoji.png">');
        });
        prep_challenge();
      });

      function prep_challenge() {
        var number = 1 + Math.floor(Math.random() * 3);
        console.log(number);
        if (number==1) {
            $("#alx1").insertBefore($("#alx2"));
            $("#alx2").insertBefore($("#alx3"));
        }
        if (number==2) { 
            $("#alx2").insertBefore($("#alx1")); 
            $("#alx1").insertBefore($("#alx3"));

        }
        if (number==3) { 
            $("#alx2").insertBefore($("#alx1")); 
            $("#alx3").insertBefore($("#alx2")); 
        }
        $('#alx_header').html('<?php echo $description; ?> ' + (counter+1) + '/' + images.length);
        $('#alx0').html('<img width="400" height="200" src="<?php echo $url_subfolder; ?>/' + images[counter][0] + '">');
        $('#alx1').html('<img src="letters/' + images[counter][1] + '.png">');
        $('#alx2').html('<img src="letters/' + images[counter][2] + '.png">');
        $('#alx3').html('<img src="letters/' + images[counter][3] + '.png">');
      }
      
</script>

  </body>

</html>
