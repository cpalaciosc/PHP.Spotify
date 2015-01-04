<?php // views/buscarAlbum.php
  $titulo = 'Buscar Álbum - PHP: Mi música';
  ob_start();  
?>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>
            <span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> 
            Álbumes: <small>Buscando a nuestros álbumes favoritos</small>
        </h1>
        <p class="lead">Desde aquí puede obtener la información de sus álbumes preferidos:</p>
      </div>
      <div class="panel-body">
        <form role="form" class="form-horizontal" method='post' action='buscarAlbum'>
          <div class="form-group">
            <label for="albumes" class="col-sm-2 control-label">Album:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name='albumes' id="albumes" placeholder="Álbum" required="required">
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="col-sm-offset-2 col-sm-1 btn btn-primary">Buscar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php 
  
  $contenido = ob_get_clean();
  
  include 'layout.php';
  