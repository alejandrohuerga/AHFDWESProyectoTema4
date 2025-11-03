/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  alejandro.huefer
 * Created: 3 nov. 2025
 * Script de creación de la base de datos y el usuario.
 */

/**
 * Creacion de la base de datos (Si todavía no esta creada).
 */

CREATE DATABASE IF NOT EXISTS DBAHFDWESProyectoTema4;

/** 
 * Usamos la base de datos para poder trabajar sobre ella.
*/

USE DBAHFDWESProyectoTema4;

/**
 * Creación de la tabla Departamento (Si todavía no esta creada).
 * PK: T02_CodDepartamento.
*/


CREATE TABLE IF NOT EXISTS T02_Departamento(
    T02_CodDepartamento VARCHAR(3) PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255) NULL,
    T02_FechaCreacionDepartamento DATETIME NULL,
    T02_VolumenDeNegocio FLOAT NULL,
    T02_FechaBajaDepartamento DATETIME NULL
)Engine=innodb;


/** 
 * Creación del usuario para la Base de Datos (Si todavía no existe).
 * Accesible desde cualquier IP.
*/

CREATE USER 'userAHFDWESProyectoTema4'@'%' IDENTIFIED BY "paso";

/**
 * Le damos permisos al usuario en la base de datos.
 * Tiene permisos en todas las tablas.
*/

GRANT ALL PRIVILEGES ON DBAHFDWESProyectoTema4.* TO 'userAHFDWESProyectoTema4'@'%';
