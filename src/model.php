<?php // model.php

namespace MiW\PracticaPHP\Model;

/***
 * El fichero tiene dos partes: una primera con las funciones de acceso a datos externos (Spotify)
 * y la segunda proporciona el acceso a la base de datos mediante Doctrine DBAL
 */

/*** *******************************************************************
 * Primera parte: Datos externos
 *
 * Referencia: https://developer.spotify.com/web-api/endpoint-reference/
 */

class datosExternos
{
    /**
   * Obtiene un listado de artistas coincidentes con la cadena $artista
   * @param string $artista Cadena de caracteres
   * @return array Resultado de la búsqueda
   * @link https://developer.spotify.com/web-api/search-item/ API Info
   */
  public static function buscarArtista($artista)
  {
      $peticion = SPOTIFY_URL_API.'/v1/search?q='.urlencode($artista).'&type=artist&market=ES';
      $datos = @file_get_contents($peticion);
      $artistas = json_decode($datos, true);

      return $artistas;
  }

  /**
   * Obtiene la información de un artista concreto (identificado por $artistaId)
   * @param string $artistaId Identificador del artista en Spotify
   * @return array Resultado de la búsqueda
   * @link https://developer.spotify.com/web-api/get-artist/ API Info
   */
  public static function obtenerArtista($artistaId)
  {
      $peticion = SPOTIFY_URL_API.'/v1/artists/'.$artistaId;
      $datos = @file_get_contents($peticion);
      $info = json_decode($datos, true);

      return $info;
  }
  
    /**
   * Obtiene un listado de albumes coincidentes con la cadena $album
   * @param string $album Cadena de caracteres
   * @return array Resultado de la búsqueda
   * @link https://developer.spotify.com/web-api/search-item/ API Info
   */
  public static function buscarAlbum($album)
  {
      $peticion = SPOTIFY_URL_API.'/v1/search?q='.urlencode($album).'&type=album&market=ES';
      $datos = @file_get_contents($peticion);
      $albumes = json_decode($datos, true);

      return $albumes;
  }  

  /**
   * Obtiene la información de un álbum concreto (identificado por $albumId)
   * @param string $albumId Identificador del álbum en Spotify
   * @return array Resultado de la búsqueda
   * @link https://developer.spotify.com/web-api/get-album/ API Info
   */
  public static function obtenerAlbum($albumId)
  {
      $peticion = SPOTIFY_URL_API.'/v1/albums/'.$albumId;
      $datos = @file_get_contents($peticion);
      $info = json_decode($datos, true);

      return $info;
  }

  /**
   * Obtiene el catálogo de álbumes de un artista en Spotify
   * @param string $artistaId Identificador del artista en Spotify
   * @param integer $limite El límite debe estar entre 1 y 50
   * @return array() Catálogo de álbumes
   * @link https://developer.spotify.com/web-api/get-artists-albums/ API Info
   */
  public static function getArtistaAlbumes($artistaId, $limite = 5)
  {
      if ($limite < 1):
        $limite =  1; elseif ($limite > 50):
        $limite = 50;
      endif;
      $peticion = SPOTIFY_URL_API.'/v1/artists/'.$artistaId.'/albums?market=ES&limit='.$limite;
      $datos = @file_get_contents($peticion);
      $info = json_decode($datos, true);

      return $info['items'];
  }

  /**
   * Obtiene el lista de temas de un álbum en Spotify
   * @param string $albumId Identificador del álbum en Spotify
   * @return array() Catálogo de temas
   * @link https://developer.spotify.com/web-api/get-albums-tracks/ API Info
   */
  public static function getAlbumTemas($albumId)
  {
      $peticion = SPOTIFY_URL_API.'/v1/albums/'.$albumId.'/tracks';
      $datos = @file_get_contents($peticion);
      $info = json_decode($datos, true);

      return $info['items'];
  }
  
    
    /**
   * Obtiene un listado de temas coincidentes con la cadena $tema
   * @param string $tema Cadena de caracteres
   * @return array Resultado de la búsqueda
   * @link https://developer.spotify.com/web-api/search-item/ API Info
   */
  public static function buscarTema($album)
  {
      $peticion = SPOTIFY_URL_API.'/v1/search?q='.urlencode($album).'&type=track&market=ES';
      $datos = @file_get_contents($peticion);
      $temas = json_decode($datos, true);

      return $temas;
  } 
}

/*** *******************************************************************
 * Segunda parte: Datos locales
 */

require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

class datosLocales
{
    /**  \Doctrine\DBAL\Connection Objeto conexi&oacute;n */
  protected static $idDB = null;

  /**
   * gets the instance via lazy initialization (created on first usage)
   *
   * @return \Doctrine\DBAL\Connection Objeto conexi&oacute;n
   */
  protected static function getInstance()
  {
      if (static::$idDB === NULL) {
          static::$idDB = new static();
      }

      // DBAL: Doctrine database abstraction & access layer
      $config = new \Doctrine\DBAL\Configuration();
      $parametros = self::_parametros();
      static::$idDB = DriverManager::getConnection($parametros, $config);
      
    return static::$idDB;
  }

  /**
   * Proporciona los parámetros de conexión a la BD
   *
   * @return array() Par&aacute;metros de conexi&oacute;n a la base de datos
   * @link http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html Doctrine DBAL Configuration
   */
  private static function _parametros()
  {
      $cfg = array(
          'driver' => MYSQL_DRIVER,
          'host' => MYSQL_SERVER,
          'dbname' => MYSQL_DATABASE,
          'user' => MYSQL_USER,
          'password' => MYSQL_PASSWORD,
      );

      return $cfg;
  }

  /**
   * Cierra la conexión con la BD
   *
   * @param \Doctrine\DBAL\Connection $idDB
   * @return void
   */
  public static function cerrar_conexion_basededatos()
  {
      self::getInstance();

      return self::$idDB->close();
  }

  /**
   * Recupera un usuario de la base de datos
   *
   * @param string $usuario Nombre del usuario
   * @return array() matriz asociativa recuperada
   */
  public static function recupera_usuario($usuario)
  {
      self::getInstance();

      $consulta = 'SELECT * FROM usuarios WHERE `username` = :user';

      return self::$idDB->fetchAssoc($consulta, array('user' => $usuario));
  }

  /**
   * Inserta un usuario en la tabla de usuarios
   * @param string $username Nombre del usuario
   * @param string $pclave Palabra Clave
   * @param boolean $esAdmin Indica si el usuario es administrador
   * @param string $email
   * @param int $hora Timestamp de la creación
   * @return integer N&uacute;mero de filas insertadas
   */
  public static function inserta_usuario($username, $pclave, $esAdmin = false, $email = null, $hora = null)
  {
      $resultado = 0;
      self::getInstance();

      $consulta = 'SELECT * FROM usuarios WHERE `username` = :user';
      if (!self::$idDB->fetchAssoc($consulta, array('user' => $username))) {
          $datos = array(
            'username' => $username,
            'password' => password_hash($pclave, PASSWORD_DEFAULT),
            'esAdmin' => ($esAdmin) ? 1 : 0,
            'email' => $email,
            'create_time' => is_null($hora) ? date('Y-m-d H:i:s') : $hora,
        );
        // var_dump($datos);
        $resultado = self::$idDB->insert('usuarios', $datos);
      }

      return $resultado;
  }

  /**
   * Recupera todos los usuarios
   *
   * @return array() tabla de usuarios
   */
  public static function recupera_todos_usuarios()
  {
      self::getInstance();

      $resultado = self::$idDB->query('SELECT * FROM usuarios');

      return $resultado->fetchAll();
  }

  /**
   * Elimina un usuario de la tabla
   *
   * @param integer $username Nombre del usuario a eliminar
   * @return integer N&uacute;mero de filas afectadas
   */
  public static function borrar_usuario($username)
  {
      self::getInstance();

      return self::$idDB->delete('usuarios', array('username' => $username));
  }

  /**
   * Actualiza un usuario en la tabla
   *
   * @param array() $usuario Usuario a actualizar
   * @return integer N&uacute;mero de filas afectadas
   */
  public static function actualiza_usuario($usuario)
  {
      self::getInstance();

      return self::$idDB->update('usuarios', $usuario, array('username' => $usuario['username']));
  }

  /**
   * is not allowed to call from outside: private!
   *
   */
  private function __construct()
  {
  }

  /**
   * prevent the instance from being cloned
   *
   * @return void
   */
  private function __clone()
  {
  }

  /**
   * prevent from being unserialized
   *
   * @return void
   */
  private function __wakeup()
  {
  }
}
