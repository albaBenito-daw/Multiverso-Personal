<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
class ConexionMySQL{
    private $conexion;
    private $total_consultas = 0;

    public function __construct() { 
        $this->conexion = new mysqli("localhost", "root", "", "multiversopersonaldb");

        if ($this->conexion->connect_error) {
            error_log("Error de conexión: " . $this->conexion->connect_error);
            die("Error al conectar con la base de datos. Contacte con el administrador.");
        }
        $this->conexion->set_charset("utf8mb4");
    }

    public function consulta($query, $parametros = []) { 
        $this->total_consultas++;

        $stmt = $this->conexion->prepare($query);
        if (!$stmt) {
            error_log("Error en la consulta: " . $this->conexion->error);
            return false;
        }

        if (!empty($parametros)) {
            $tipos = str_repeat("s", count($parametros));
            $stmt->bind_param($tipos, ...$parametros);
        }

        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta: " . $stmt->error);
            return false;
        }

        $resultado = $stmt->get_result();
        if ($resultado === false) {
            return true;
        }
        
        return $resultado; //Resultado de la consulta
    }

    public function devuelve($resultado) {
        return $resultado ? $resultado->fetch_assoc() : null;
    }

    public function lineas($resultado) {
        return $resultado ? $resultado->num_rows : 0;
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>