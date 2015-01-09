<?php // views/principal.php
  $titulo = 'PHP: Mi música';

  ob_start();  
?>

    <div class="jumbotron">
      <div class="container">
        <h1>Memoria Descriptiva</h1>
        <p>La memoria descriptiva del proyecto la puede revisar <a href="https://drive.google.com/file/d/0B2SJNHAx3G8oZFNhQXM5bkFGYms/view?usp=sharing">aquí</a></p>
         </div>
    </div>


<?php 
  
  $contenido = ob_get_clean();
  
  include 'layout.php';
  