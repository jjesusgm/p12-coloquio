<?php
      $user = $_POST['b'];
       
      if(!empty($user)) {
            comprobar($user);
      }
       
      function comprobar($b) {
            $con = mysql_connect('localhost','coloquio_ie', 'p12coloquio');
            mysql_select_db('coloquio_ie', $con);
       
            $sql = mysql_query("SELECT * FROM usuarios WHERE username = '".$b."'",$con);
             
            $contar = mysql_num_rows($sql);
             
            if($contar == 0){
                  echo "<span style='font-weight:normal;color:green;'>Usuario disponible.</span>";
            }else{
                  echo "<span style='font-weight:normal;color:red;'>El usuario ya existe.</span>";
            }
      }     
?>