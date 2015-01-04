<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
            if (count($albumes) > 0):
              // Hay artistas
              print '<div class="panel panel-default">';
              print '  <table class="table table-striped table-condensed">';
              foreach ($albumes as $album) {
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
                  print <<< ____________________MARCA_FINAL
                    <tr>
                      <td>
                        <a href='album/$id'>
                          <button class="btn btn-primary" type="button">
                            <img src='$imagen' width='64' height='64' alt='Imagen $name' title='$name'>
                          </button>
                        </a>
                      </td>
                      <td><h2>$name</h2></td>
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
                  <h4>¡No se han encontrado resultados!</h4>
                </div>
                <p>
                  <a href="artistas">
                    <button type="button" class="btn btn-primary btn-lg">Nueva Búsqueda</button>
                  </a>
                </p>
________________MARCA_FINAL;
            endif;
?>
</div>