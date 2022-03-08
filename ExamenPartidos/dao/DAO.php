<?php

interface DAO
{
    // Método que lista todos los usuarios
    public static function findAll();

    // Método que busca un usuario por su id
    public static function findById($id);

    // Método que modifica/actualiza un usuario
    public  static function update($objeto);

    // Método que crea un nuevo usuario
    public static function save($objeto);

    // Método que elimina un usuario existente
    public static function delete($objeto);

    // Método que elimina un usuario en funcion de su id
    public static function deleteById($id);
}

?>