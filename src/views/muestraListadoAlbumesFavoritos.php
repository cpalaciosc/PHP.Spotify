<?php // views/muestraListadoArtistas.php

  $titulo = 'álbumes favoritos encontrados';

  ob_start();
?>

  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
            Álbumes favoritos
        </h1>
        <p class="lead">Albumes que usted considera favoritos.</p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">          
          <?php
            if (count($favoritos) > 0):
              // Hay artistas
              print '<div class="panel panel-default">';
              print '  <table class="table table-striped table-condensed">';
              foreach ($favoritos as $album) {
                  // var_dump($artista);
                  if (count($album['images']) > 2) {
                      $imagen = $album['images'][2]['url'];
                  } else {
                      $imagen = '';
                  }
                  // var_dump($artista);
                  //$popularidad = sprintf("%02d", $artista['popularity']);
                  $name = $album['name'];
                  $id = $album['id'];
                  $nombre_artista = "";
                  foreach($album["artists"] as $index=>$artista )
                  {
                    $nombre_artista = $nombre_artista." ".$artista["name"];
                    if($index<count($album["artists"])-1)
                    {
                        $nombre_artista = $nombre_artista.',';
                    }
                  }                   
                  print <<< ____________________MARCA_FINAL
                    <tr>
                      <td>
                        <a href='album/$id'>
                          <button class="btn btn-primary" type="button">
                            <img src='$imagen' width='64' height='64' alt='Imagen $name' title='$name'>
                          </button>
                        </a>
                      </td>
                      <td>
                          <h2>
                            <a href="favorito/album/gestionar/$id">
                                <span class="glyphicon glyphicon-star" aria-hidden="true" title="Marcar Favorito"></span>
                            </a>                          
                            $nombre_artista - $name
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
                  <h4>¡No tiene álbumes favoritos registrados!</h4>
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
