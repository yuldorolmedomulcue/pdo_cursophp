<?php 

/*
Php data objects
Una mejor manera y mas segura de acceder a una DB
Permite muchos motores Mysql, Sqlite, Postgress, Sqlserver
Capa de acceso a datos
Orirntado a objetos

VENTAJAS
Multiples DB
Seguridad atravez de sentencias preparadas (prepared statements)
Usabilidad y reusabilidad
Manejador de errores avanzados
*/

//Conexion a Mysql
$host = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "facturacion_crud";


//configurar dsn | nombre del controlador de PDO cadena de conexion
$dsn = 'mysql:host=' . $host . ';dbname=' . $baseDatos;

//crear instancias PDO
$pdo = new PDO($dsn, $usuario, $password);

//Agregar el setattribute de manera global
$pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //ejemplo2 no es necesario nada en fetch()


//Query con PDO
$query = $pdo->query('SELECT * FROM usuario');

//volcar informacion, mostrar las DB
//ejemplo1
// while($fila = $query->fetch()){
//     echo $fila['nombre'];
//     echo "<br />";
// }

//ejemplo2, especificando el modo
// while($fila = $query->fetch()){  //trabajar con objetos
//     echo $fila -> nombre;
//     echo "<br />";
// }

//ejemplo 3, especificar una variable
$nombre = "Andres";
//manera insegura
// $query2 = "SELECT * FROM usuario WHERE nombre= '$nombre'";

//forma segura
$nombre2 = "Yuldor Olmedo";
// //parametros posicionales
// $query3 = "SELECT * FROM usuario WHERE nombre = ? ";
// $stmt = $pdo->prepare($query3);
// //vincular esto
// $stmt->execute([$nombre2]);

// //mostrar en el navegador
// $usuario = $stmt->fetch();
// var_dump($usuario); //o foreach

//parametros posicionales por nombre | evitamos inyecciones SQL
$query3 = "SELECT * FROM usuario WHERE nombre = :nombre "; //primer cambio
$stmt = $pdo->prepare($query3);

//Execute, vincular esto
$stmt->execute([':nombre' => $nombre2]);//segundo cambio

//mostrar en el navegador
$usuario2 = $stmt->fetchAll(); //tercer cambio
// var_dump($usuario2); //o foreach

// foreach ($usuario2 as $usuario) { //cuarto cambio
//     echo $usuario->nombre;
// }

//Traer un unico registro 
$id=3;
$query4 = "SELECT * FROM usuario WHERE id = :id ";
$stmt = $pdo -> prepare($query4);
//opcion fetch un solo registro
$stmt->execute([':id' => $id]);
$usuario3 = $stmt->fetch();
echo $usuario3->email;

//contar filas con ROW COUNT
$id = 1;
$query5 = "SELECT * FROM usuario WHERE id = :id ";
//preparar
$stmt = $pdo->prepare($query5);
//ejecutar
$stmt -> execute([':id' => $id]);
//accedemos al ROW COUNT
$total_usuarios = $stmt->rowCount();
echo "<br>";
echo "Total usuarios: ".$total_usuarios;
echo "<br>";

/*-------------------------------------------------Insertar Datos-----------------------------------------------*/
/* echo "<br>";
$nombre = "Ingeniero";
$apellidos = "Montiel";
$telefono = "666666";
$email = "ingeniero@ingeniero.com";

$query6 = "INSERT INTO usuario(nombre, apellidos, telefono, email) VALUES(:nombre, :apellidos, :telefono, :email)";

//contiene consulta
$stmt = $pdo->prepare($query6);

//$stmt= statements
$stmt -> execute(['nombre' => $nombre, 'apellidos' => $apellidos, 'telefono' => $telefono,'email' => $email ]);
echo "<br>";
echo "Usuario creado correctamente"; */

/*-----------------------------segunda forma y mas recomendada-----------------------------*/
/* echo "<br>";
$nombre = "Ingeniero";
$apellidos = "Montiel";
$telefono = "666666";
$email = "ingeniero@ingeniero.com";

$query7 = "INSERT INTO usuario(nombre, apellidos, telefono, email) VALUES(:nombre, :apellidos, :telefono, :email)";

contiene consulta
$stmt = $pdo->prepare($query7);

Bind params o viculacion de parametros (ES MAS RECOMENDADA)
$stmt-> bindParam(':nombre', $nombre, PDO::PARAM_STR);
$stmt-> bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
$stmt-> bindParam(':telefono', $telefono, PDO::PARAM_STR);
$stmt-> bindParam(':email', $email, PDO::PARAM_STR);
$stmt -> execute();
echo "<br>";
echo "Usuario creado correctamente";
echo "<br>";
 */

/*----------------------------------------------Actualizar Datos PDO-----------------------------------------------*/
//actualizar datos  | Parametros posicionales por nombre
/* echo "<br>";
$id = 13;
$nombre = "Melodia";
$apellidos = "Monsalve";
$telefono = "32344232";
$email = "Melodia@Melodia.es";

//hacemos la consulta
$query8 = "UPDATE usuario set nombre=:nombre, apellidos=:apellidos, telefono=:telefono, email=:email WHERE id=:id";

//preparamos la consulta
$stmt = $pdo -> prepare($query8);

//Bind params o viculacion de parametros (ES MAS RECOMENDADA)
$stmt-> bindParam(':nombre', $nombre, PDO::PARAM_STR);
$stmt-> bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
$stmt-> bindParam(':telefono', $telefono, PDO::PARAM_STR);
$stmt-> bindParam(':email', $email, PDO::PARAM_STR);
$stmt-> bindParam(':id', $id, PDO::PARAM_INT);

$stmt -> execute();
echo "<br>";
echo "Usuario actualizado correctamente";
echo "<br>";
 */


/*---------------actualizar datos  | Parametros posicionales por incognita o intorracion---------------*/
/* //actualizar datos
echo "<br>";
$id = 13;
$nombre = "Yina";
$apellidos = "Mulcue";
$telefono = "3544563";
$email = "Yina@Yina.es";

//hacemos la consulta
$query8 = "UPDATE usuario set nombre=?, apellidos=?, telefono=?, email=? WHERE id=?";

//preparamos la consulta
$stmt = $pdo -> prepare($query8);

//Bind params o viculacion de parametros (ES MAS RECOMENDADA)
$stmt-> bindParam(1, $nombre, PDO::PARAM_STR);
$stmt-> bindParam(2, $apellidos, PDO::PARAM_STR);
$stmt-> bindParam(3, $telefono, PDO::PARAM_STR);
$stmt-> bindParam(4, $email, PDO::PARAM_STR);
$stmt-> bindParam(5, $id, PDO::PARAM_INT);

$stmt -> execute();
echo "<br>";
echo "Usuario actualizado correctamente";
echo "<br>"; */

/*----------------------------------------------Borrar Datos PDO-----------------------------------------------*/
//Eliminar datos
echo "<br>";
$id=16;

//hacemos la consulta
$query9 = "DELETE FROM usuario WHERE id=:id";

//preparamos la consulta
$stmt = $pdo -> prepare($query9);

//Bind params o viculacion de parametros (ES MAS RECOMENDADA)
$stmt-> bindParam(':id', $id, PDO::PARAM_INT);

$stmt -> execute();
echo "<br>";
echo "Usuario borrado correctamente";
echo "<br>";

/*----------------------------------------------Buscar Datos PDO-----------------------------------------------*/
//Borrar datos
echo "<br>";
echo "<br>";

$texto_buscar = "%ing%";

//hacemos la consulta
$query10 = "SELECT * FROM usuario WHERE nombre like :nombre";

//preparamos la consulta
$stmt = $pdo -> prepare($query10);

//Bind params o viculacion de parametros (ES MAS RECOMENDADA)
$stmt-> bindParam(':nombre', $texto_buscar, PDO::PARAM_STR);

$stmt -> execute();
//volcar
$usuarios = $stmt-> fetchAll();
var_dump($usuarios);
?>