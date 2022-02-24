<?php

    interface DAO{
        //busca todos
        public static function findAll();
        //busca por id(busca por la clave primaria)
        public static function findById($id);
        //modifica o actualiza
        public static function update($objeto);
        //crear o insertar
        public static function save($objeto);
        //borrar
        public static function delete($objeto);
        //borrar por id
        /*
        public function deleteById($id);
        */
    }

?>