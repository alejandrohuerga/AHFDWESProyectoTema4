/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */

/**
 * Author:  alejandro.huefer
 * Created: 3 nov. 2025
 * Script de borrado de la Base de Datos y el usuario.
 */

/* Borrado de la Base de Datos si existe. */

DROP DATABASE IF EXISTS DBAHFDWESProyectoTema4;

/* Borrado del usuario si existe */

DROP USER IF EXISTS 'userAHFDWESProyectoTema4'@'%';

