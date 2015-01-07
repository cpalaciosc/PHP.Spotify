<?php // views/buscaArtista.php
  $titulo = 'Nuevo usuario';

  ob_start();  
?>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 
            Usuarios: <small>Actualizar un usuario</small>
        </h1>
        <p class="lead">Desde aquí puede actualizar un usuario existente:</p>
      </div>
      <div class="panel-body">
        <form role="form" class="form-horizontal" method='post' action='usuario/actualizar'>
            
          <!-- div class="input-group input-group-lg">
            <span class="input-group-addon">Usuario:</span>
            <input type="text" class="form-control" name='usuario[username]' id="username" placeholder="Usuario" required="required">
          </div -->
            
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Usuario:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name='usuario[username]' id="username" placeholder="Usuario" required="required" value="<?= $usuario['username'] ?>" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail:</label>
            <div class="col-sm-4">
                <input type="email" class="form-control" name='usuario[email]' id="email" placeholder="E-mail" value="<?= $usuario['email'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="admin" class="col-sm-2 control-label">Administrador:</label>
            <div class="col-sm-4">
                <input type="checkbox" class="form-control" name='usuario[esAdmin]' id="admin" value="1" <?= ($usuario['esAdmin']==1) ? 'checked' : '' ?>>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="col-sm-offset-2 col-sm-1 btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php 
  
  $contenido = ob_get_clean();
  
  include 'layout.php';
  