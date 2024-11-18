<?php
require_once('model.php');
class EquipoApiModel extends Model
{
    public function getEquipos()
    {
        $pDO = $this->createConnection();
        $sql = "select * from equipo";
        $query = $pDO->prepare($sql);
        $query->execute();
        $equipos = $query->fetchAll(PDO::FETCH_OBJ);
        return $equipos;
    }
    public function getEquipo($equipo)
    {
        $pDO = $this->createConnection();
        $sql = 'SELECT * FROM equipo WHERE nombre_equipo = ?';
        $query = $pDO->prepare($sql);
        $query->execute([$equipo]);
        $equipo = $query->fetch(PDO::FETCH_OBJ);
        return $equipo;
    }
    public function deleteEquipo($equipo)
    {
        $pDO = $this->createConnection();
        $sql = 'DELETE FROM equipo WHERE nombre_equipo = ?';
        $query = $pDO->prepare($sql);
        $query->execute([$equipo]);
    }
    public function createequipo($nombre_equipo, $id_equipo, $ciudad, $year_fundado, $biografia, $imagen_url)
    {
        $pDO = $this->createConnection();
        $sql = 'INSERT INTO equipo (nombre_equipo, id_equipo, ciudad, year_fundado, biografia, imagen_url) VALUES (?, ?, ?, ?, ?, ?)';
        $query = $pDO->prepare($sql);
        $query->execute([$nombre_equipo, $id_equipo, $ciudad, $year_fundado, $biografia, $imagen_url]);
    }
    public function teamExist($equipo)
    {
        $pDO = $this->createConnection();
        $sql = 'SELECT * FROM equipo WHERE nombre_equipo = ?';
        $query = $pDO->prepare($sql);
        $query->execute([$equipo]);
        $equipo = $query->fetch(PDO::FETCH_OBJ);
        return $equipo;
    }
    public function updateEquipo($id, $nombre_equipo, $ciudad, $year_fundado, $biografia, $imagen_url){
        
        $pdo = $this->createConnection(); // Asume que tienes un método createConnection()
        $sql = 'UPDATE equipo SET nombre_equipo = ?, ciudad = ?, year_fundado = ?, biografia = ?, imagen_url = ? WHERE nombre_equipo = ?';
        $query = $pdo->prepare($sql);
        $query->execute([$nombre_equipo, $ciudad, $year_fundado, $biografia, $imagen_url, $id]);        
        
    }
}