#SIESC Partes Bundle
------------------------
Modulo para el manejo de sistema de partes, desarrollado por el equipo de desarrolladores de SIESC.

Contacto: team@siesc.com.ar

##Instalacion
El modulo deberia instalarse automaticamente desde el AppBundle, a traves de la linea de comandos:

	./app/console siesc:install

En las opciones, debe seleccionar el modulo PARTES (opcion 2) y luego ingresar la clave de adminsitrador que le fue suministrada.

## Guia de uso

### Cierre de novedades

El cierre de novedades implica el corte de aceptacion de novedades aprobadas que entraran en una liquidacion
mensual. El mismo tiene una fecha de cierre, y se podra marcar como liquidada o no cada novedad.

El mismo acepta nuevas novedades hasta que una o mas novedades del cierre sea liquidada (y por tanto, el estado
del cierra pasara a ser parcial / totalmente liquidado).
