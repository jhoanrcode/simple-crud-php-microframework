/**
* Author: Jhoan Avila
*/

create database if not exists nexuradb;

use nexuradb;

create table if not exists empleados (
  id int unsigned not null auto_increment,
  nombre varchar(255) not null,
  email varchar(255) not null,
  genero char(1) not null,
  area_id int(10) not null,
  boletin int(10) not null,
  descripcion text not null,
  primary key (id)
);

create table if not exists areas (
  id int unsigned not null auto_increment,
  nombre varchar(255) not null,
  primary key (id)
);

insert into areas (nombre) values ("Administración"),("Calidad"),("Producción"),("Ventas");

create table if not exists empleado_rol (
  id int unsigned not null auto_increment,
  empleado_id int(10) not null,
  rol_id int(10) not null,
  primary key (id)
);

create table if not exists roles (
  id int unsigned not null auto_increment,
  nombre varchar(255) not null,
  primary key (id)
);

insert into roles (nombre) values ("Auxiliar Administrativo"),("Gerente estrategico"),("Profesional de proyectos");