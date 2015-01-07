<?php // views/muestraListadoArtistas.php

  $titulo = 'intérpretes favoritos encontrados';

  ob_start();
?>

  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
            Intérpretes favoritos
        </h1>
        <p class="lead">Artistas que usted considera favoritos.</p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">          
          <?php
            if (count($favoritos) > 0):
              // Hay artistas
              print '<div class="panel panel-default">';
              print '  <table class="table table-striped table-condensed">';
              foreach ($favoritos as $artista) {
                  // var_dump($artista);
                  if (count($artista['images']) > 2) {
                      $imagen = $artista['images'][2]['url'];
                  } else {
                      $imagen = '';
                  }
                  // var_dump($artista);
                  $popularidad = sprintf("%02d", $artista['popularity']);
                  $name = $artista['name'];
                  $id = $artista['id'];
                  print <<< ____________________MARCA_FINAL
                    <tr>
                      <td>
                        <a href='artista/$id'>
                          <button class="btn btn-primary" type="button">
                            <img src='$imagen' width='64' height='64' alt='Imagen $name' title='$name'>
                            <span class="badge" title="Popularidad">$popularidad</span>
                          </button>
                        </a>
                      </td>
                      <td>
                            <h2>
                                <a href="favorito/artist/gestionar/$id">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true" title="Quitar Favorito"></span>
                                </a>
                                $name
                            </h2>
                      </td>
                    </tr>
____________________MARCA_FINAL;
              }
              print '  </table>';
              print '</div>';
            else:
              print <<< '________________MARCA_FINAL'
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                  <h4>¡No tiene artistas favoritos registrados!</h4>
                </div>
________________MARCA_FINAL;
            endif;
          ?>
        </div>
      </div>
    </div>

  </div>

<?php

  $contenido = ob_get_clean();

  include 'layout.php';
