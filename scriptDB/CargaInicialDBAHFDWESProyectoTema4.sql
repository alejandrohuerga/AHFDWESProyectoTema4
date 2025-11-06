/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  alejandro.huefer
 * Created: 3 nov. 2025
 * Script para realizar la carga inicial a la base de datos.
 */

/* 
 * Ejecutamos un 'USE' para seleccionar la base a la cual le realizamos la carga.
*/

USE DBAHFDWESProyectoTema4;

/*
 * Inserción de tuplas en la tabla T02_Departamento.
*/

INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento) VALUES
    ("INF","Departamento de informática","1990-10-10 20:00:00",3500,NULL),
    ("CON","Departamento de contabilidad","2000-12-12 10:20:20",5000,NULL),
    ("MAN","Departamento de mantenimiento","2006-01-15 11:10:00",1500,NULL),
    ("PRO","Departamento de producción","1999-10-10 10:00:00",10000,NULL),
    ("MAR","Departamento de marketing","1990-10-10 20:00:00",2900,NULL),
    ("SOS","Departamento de sostenibilidad","2023-05-11 09:30:55",1000,"2025-02-11 09:30:55"
);

