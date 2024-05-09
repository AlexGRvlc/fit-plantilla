<?php
require "../lib/errores.php";

class Database {
    public $db;
    protected $resultado;
    protected $prep;
    protected $consulta;

    public function __construct($db_host, $db_user, $db_pass, $db_name){
        $this->db = new mysqli( $db_host, $db_user, $db_pass, $db_name );

        if ($this-> db->connect_errno){
            trigger_error("Fallo al realizar la conexión, Tipo de error -> ({$this->db->connect_error})", E_USER_ERROR);
        }

        $this->db->set_charset(DB_CHARSET);
    }

    public function getSocios(){
        $this->resultado = $this->db->query("SELECT * FROM socios;");
        return $this->resultado->fetch_all();
    }

    public function getCliente(){
        return $this->resultado->fetch_assoc();
    }

    public function preparar( $consulta) {
        $this->consulta = $consulta;
        $this->prep = $this->db->prepare( $this->consulta);
        if(!$this->prep){
            trigger_error("Error al preparar la consulta", E_USER_ERROR);
        }   
     }

     public function ejecutar() {
        $this->prep->execute();
     }

     public function prep(){
        return $this->prep;
     }

     public function resultado(){
        return $this->prep->fetch();
     }

     public function cambiarDatabase($db){
        $this->db->select_db($db);
     }

     public function validarDatabase($db) {
        $this->db->select_db($db);
     }

     public function validarDatos($columna, $tabla, $condicion) {
        $this->resultado = $this->db->query("SELECT $columna FROM $tabla WHERE $columna = '$condicion';");
        $examinar = $this->resultado->num_rows;
        return $examinar;
     }

}

?>