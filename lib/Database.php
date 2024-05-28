<?php
require "../lib/errores.php";

class Database {
    public $db;
    protected $resultado;
    protected $prep;
    protected $consulta;

    public function __construct($db_host, $db_user, $db_pass, $db_name) {
        $this->db = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($this->db->connect_errno) {
            trigger_error("Fallo al realizar la conexión, Tipo de error -> ({$this->db->connect_error})", E_USER_ERROR);
        }

        $this->db->set_charset(DB_CHARSET);
    }

    public function getSocios() {
        $this->resultado = $this->db->query("SELECT * FROM socios;");
        return $this->resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function getCliente() {
        return $this->resultado->fetch_assoc();
    }

    public function preparar($consulta) {
        $this->consulta = $consulta;
        $this->prep = $this->db->prepare($this->consulta);
        if (!$this->prep) {
            trigger_error("Error al preparar la consulta: " . $this->db->error, E_USER_ERROR);
            return false;
        } else {
            return true;
        }
    }

    public function ejecutar() {
        if ($this->prep === null) {
            trigger_error("Error: Consulta no preparada", E_USER_ERROR);
            return false;
        }
        
        if ($this->prep->execute()) {
            $this->resultado = $this->prep->get_result();
            return true;
        } else {
            trigger_error("Error al ejecutar la consulta: " . $this->prep->error, E_USER_ERROR);
            return false;
        }
    }

    public function prep() {
        return $this->prep;
    }

    public function resultado() {
        return $this->resultado->fetch_assoc();
    }

    public function cambiarDatabase($db) {
        $this->db->select_db($db);
    }

    public function validarDatos($columna, $tabla, $condicion) {
        $stmt = $this->db->prepare("SELECT $columna FROM $tabla WHERE $columna = ?");
        $stmt->bind_param('s', $condicion);
        $stmt->execute();
        $this->resultado = $stmt->get_result();
        return $this->resultado->num_rows;
    }

    public function despejar(){
        if ($this->resultado) {
            $this->resultado->free();
            // $this->resultado = null; 
        }
        if ($this->prep) {
            $this->prep->close();
            // $this->prep = null;
        }
    }

    public function cerrar(){
        $this->db->close();
        $this->prep->close();
    }
}
?>
