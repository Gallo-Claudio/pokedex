repositorio Github - 

Claudio Vazquez
21052170


Para evitar inconvenientes con la subida de imagenes, modificar en el php.ini los siguientes parametros
post_max_size=10M
upload_max_filesize=10M

PANEL
-----
El sistema, valida el login del usuario
El sistema ingresa los siguientes datos respecto a los pokemones

-nombre
-tipo1
-tipo2
-generacion
-descripcion
-imagen

nombre, tipo1 y generación son campos obligatorios
Al ingresar un registro se valida que dichos campos esten completos, se chequea que el nombre no este ya ingresado y que tipo1 no sea igual a tipo2

Con las imagenes se verifica el tipo de archivo a subir (jpg, png, gif) y el que el tamaño no supere los 200Kb
El campo descripción se hace con un editor wysiwyg

Se crearon las tablas "tipos" y "generacion", para realizar el ingreso y modificacion de sus registros (no se llego a relizar esa parte)



PUBLICA
-------
Desde esta parte se accede al panel (usuario: unlam password: 1234)
En la parte publica del sistema, se muestra el listado de pokemones ingresados y se puede ver un detalle del mismo seleccionandolo
