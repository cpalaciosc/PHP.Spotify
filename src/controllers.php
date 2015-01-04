<?php // controllers.php

namespace MiW\PracticaPHP;

require 'model.php';

use \MiW\PracticaPHP\Model\datosExternos;
use \MiW\PracticaPHP\Model\datosLocales;

/**
 * Muestra la página principal (búsquedas)
 * @param type $param
 */
function principalAction()
{
  require 'views/principal.php';
}

/**
 * Muestra el formulario para buscar un artista
 */
function buscaArtistasAction()
{
  require 'views/buscaArtista.php';
}

/**
 * Procesa el formulario para buscar un artista concreto
 * Busca un artista en Spotify y muestra los resultados
 * @param string $artista
 */
function buscaArtistaAction($artista)
{
  $artistas = datosExternos::buscarArtista($artista);
  
  require 'views/muestraListadoArtistas.php';
}

/**
 * Muestra la información de un artista identificado por $artistaId
 * @param string $artistaId Identificador del artista en Spotify
 */
function mostrarArtistaAction($artistaId, $limite = 5)
{
  $infoArtista = datosExternos::obtenerArtista($artistaId);
  $albumes = datosExternos::getArtistaAlbumes($artistaId, $limite);
  
  require 'views/muestraArtista.php';
}

/**
 * Muestra formulario para buscar un artista
 */
function buscarAlbumAction()
{
  require 'views/buscarAlbum.php';
}

/**
 * Procesa el formulario para buscar un album concreto
 * Busca un album en Spotify y muestra los resultados
 * @param string $album
 */
function buscaAlbumAction($album)
{
  $albumes = datosExternos::buscarAlbum($album);
  
  require 'views/muestraListadoAlbumes.php';
}

/**
 * Muestra la información de un álbum
 * @param string $albumId Identificador del álbum en Spotify
 */
function mostrarAlbumAction($albumId)
{
  $infoAlbum = datosExternos::obtenerAlbum($albumId);
  $temas = $infoAlbum['tracks']['items'];
  require 'views/muestraAlbum.php';
}


/**
 * Muestra formulario para buscar un artista
 */
function buscarTemaAction()
{
  require 'views/buscarTema.php';
}

/**
 * Procesa el formulario para buscar un tema concreto
 * Busca un tema en Spotify y muestra los resultados
 * @param string $tema
 */
function buscaTemaAction($tema)
{
  $temas = datosExternos::buscarTema($tema);
  
  require 'views/muestraListadoTemas.php';
}

/**
 * Comprueba si el usuario y la contraseña son correctos
 * @param string $usuario Usuario del sistema
 * @param string $pclave  Palabra clave del usuario
 * @return boolean Resultado de la comprobación
 */
function loginAction($usuario, $pclave)
{
  $datos = datosLocales::recupera_usuario($usuario);
  if (!empty($datos) and password_verify($pclave, $datos['password']))
  {
      // var_dump($datos);
      $_SESSION['usuario'] = $usuario;
      $_SESSION['esAdmin'] = ($datos['esAdmin'] === '1');
      $resultado = TRUE;
      // var_dump($_SESSION);
  }
  else
  {
    $resultado = FALSE;
  }

  
  return $resultado;
}

/**
 * Termina la sesión actual
 */
function logoutAction()
{
  $_SESSION = array();
  session_destroy();
  
  return TRUE;
}

/**
 * Genera un listado de los usuarios del sistema
 */
function listadoUsuariosAction()
{
  $usuarios = datosLocales::recupera_todos_usuarios();
  
  require 'views/muestraListadoUsuarios.php';
}

/**
 * Muestra un formulario para dar de alta un nuevo usuario
 */
function muestraNuevoUsuarioAction()
{
  require 'views/muestraNuevoUsuario.php';
}

/**
 * Inserta un nuevo usuario y muestra el listado de usuarios
 * @param type $usuario
 */
function insertarNuevoUsuarioAction($usuario)
{
  @datosLocales::inserta_usuario($usuario['username'], $usuario['password'], $usuario['esAdmin'], $usuario['email']);
  listadoUsuariosAction();
}

/**
 * Error de acceso (permisos insuficientes)
 * @param string $path
 */
function errorAccesoAction($path)
{
  require 'views/errorAcceso.php';
}

/**
 * Ruta sin implementar
 * @param string $path
 */
function sinImplementarAction($path)
{
  require 'views/noImplementado.php';
}