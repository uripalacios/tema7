/* Script de creación de la BBDD e introducción de datos para la PR16 (Ismael Maestre) */
create database if not exists PR17;
use PR17;

/* PERFIL */
create table if not exists perfil (
	codigo varchar(25) primary key,
	descripcion varchar(30) not null
);

/* USUARIOS */
create table if not exists usuarios (
	usuario varchar(20) not null primary key unique,
	contraseña varchar(100) not null,
	email varchar(30) not null,
	fecha_nacimiento date not null,
	perfil varchar(25) not null,
	index (perfil),
	foreign key (perfil) references perfil (codigo)
);

/* PAGINAS */
create table if not exists paginas (
	codigo varchar(25) primary key,
	descripcion varchar(50),
	url varchar(75) not null
);

/* ACCEDE */
create table if not exists accede (
	codigoPerfil varchar(25) not null,
	codigoPagina varchar(25) not null,
	index(codigoPerfil),
	index(codigoPagina),
	primary key (codigoPerfil,codigoPagina),
	foreign key (codigoPerfil) references perfil (codigo),
	foreign key (codigoPagina) references paginas (codigo)
);

/* PRODUCTOS */
create table if not exists productos (
	codigo_producto varchar(25) primary key unique,
	descripcion varchar(50) not null,
	precio float not null,
	stock int not null
);

/* VENTA */ 
create table if not exists venta (
	id_venta int not null auto_increment primary key,
	usuario varchar(20) not null,
	fecha_compra date not null,
	cod_producto varchar(25) not null,
	cantidad int not null,
	precio_total float not null,
	foreign key (usuario) references usuarios (usuario),
	foreign key (cod_producto) references productos (codigo_producto)
);

/* ALBARÁN */
create table if not exists albaran (
	id_albaran int not null auto_increment primary key,
	fecha date not null,
	cod_producto varchar(25) not null,
	cantidad int not null,
	usuario varchar(20) not null,
	foreign key (usuario) references usuarios (usuario),
	foreign key (cod_producto) references productos (codigo_producto)
);


/* INSERCIÓN DE DATOS */
/* Perfiles */
insert into perfil (codigo, descripcion) values ('P_ADMIN','Administrador');
insert into perfil (codigo, descripcion) values ('P_MODERADOR','Moderador');
insert into perfil (codigo, descripcion) values ('P_NORMAL','Usuario Normal');

/* Usuarios */
/* Pass: usuarioAd1, usuarioMd1, usuarioNr1 */
insert into usuarios (usuario,contraseña,email,fecha_nacimiento,perfil) values ('u1','ccc427412de7b7a989c46d04047cd9da1aae4364','imc@correo.es',DATE '2021/12/19','P_ADMIN');
insert into usuarios (usuario,contraseña,email,fecha_nacimiento,perfil) values ('u2','6839a5d630320b1864f46fbda32f13bac51742f8','abc@correo.es',DATE '2021/07/25','P_MODERADOR');
insert into usuarios (usuario,contraseña,email,fecha_nacimiento,perfil) values ('u3','8ddf1dcbb4cf6b019c4fc4422f18dbaeac071bb9','tbc@correo.es',DATE '2021/04/03','P_NORMAL');

/* Páginas que contiene la web */
/* Perfil */
insert into paginas (codigo,descripcion,url) values ('PAG_PERFIL','Perfil del Usuario','perfil.php');

/* Productos */
insert into paginas (codigo,descripcion,url) values ('PAG_PRODUCTOS','Productos','productos.php');

/* Venta */
insert into paginas (codigo,descripcion,url) values ('PAG_VENTA','Ventas','ventas.php');

/* Albarán */
insert into paginas (codigo,descripcion,url) values ('PAG_ALBARAN','Albaranes','albaranes.php');

/* Lista de deseos */
insert into paginas (codigo,descripcion,url) values ('PAG_DESEOS','Lista de Deseos','listaDeseos.php');

/* Acceso a las páginas */
/* Usuarios normales (Perfil = 'P_NORMAL') */
insert into accede (codigoPerfil,codigoPagina) values ('P_NORMAL','PAG_PERFIL');
insert into accede (codigoPerfil,codigoPagina) values ('P_NORMAL','PAG_PRODUCTOS');
insert into accede (codigoPerfil,codigoPagina) values ('P_NORMAL','PAG_DESEOS');

/* Usuarios moderadores (Perfil = 'P_MODERADOR') */
insert into accede (codigoPerfil,codigoPagina) values ('P_MODERADOR','PAG_PERFIL');
insert into accede (codigoPerfil,codigoPagina) values ('P_MODERADOR','PAG_PRODUCTOS');
insert into accede (codigoPerfil,codigoPagina) values ('P_MODERADOR','PAG_VENTA');
insert into accede (codigoPerfil,codigoPagina) values ('P_MODERADOR','PAG_ALBARAN');
insert into accede (codigoPerfil,codigoPagina) values ('P_MODERADOR','PAG_DESEOS');

/* Usuarios administradores (Perfil = 'P_ADMIN') */
insert into accede (codigoPerfil,codigoPagina) values ('P_ADMIN','PAG_PERFIL');
insert into accede (codigoPerfil,codigoPagina) values ('P_ADMIN','PAG_PRODUCTOS');
insert into accede (codigoPerfil,codigoPagina) values ('P_ADMIN','PAG_VENTA');
insert into accede (codigoPerfil,codigoPagina) values ('P_ADMIN','PAG_ALBARAN');
insert into accede (codigoPerfil,codigoPagina) values ('P_ADMIN','PAG_DESEOS');

/* Productos */
insert into productos (codigo_producto,descripcion,precio,stock) values ("P01","Ordenador portátil",1350.50,5);
insert into productos (codigo_producto,descripcion,precio,stock) values ("P02","Teclado Gaming",27.85,15);
insert into productos (codigo_producto,descripcion,precio,stock) values ("P03","Ratón Logitech",40.32,10);