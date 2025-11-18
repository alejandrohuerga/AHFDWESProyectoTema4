

CREATE DATABASE IF NOT EXISTS DBAHFDWESProyectoTema4;
USE DBAHFDWESProyectoTema4;

CREATE TABLE IF NOT EXISTS T02_Departamento(
    T02_CodDepartamento VARCHAR(3) PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255) NULL,
    T02_FechaCreacionDepartamento DATETIME NULL,
    T02_VolumenDeNegocio FLOAT NULL,
    T02_FechaBajaDepartamento DATETIME NULL
)Engine=innodb;



USE DBAHFDWESProyectoTema4;

INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento) VALUES
    ("INF","Departamento de informática","1990-10-10 20:00:00",3500,NULL),
    ("CON","Departamento de contabilidad","2000-12-12 10:20:20",5000,NULL),
    ("MAN","Departamento de mantenimiento","2006-01-15 11:10:00",1500,NULL),
    ("PRO","Departamento de producción","1999-10-10 10:00:00",10000,NULL),
    ("MAR","Departamento de marketing","1990-10-10 20:00:00",2900,NULL),
    ("SOS","Departamento de sostenibilidad","2023-05-11 09:30:55",1000,"2025-02-11 09:30:55"
);