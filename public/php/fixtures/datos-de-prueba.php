<?php
// Configuración de conexión
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'refugio_bd';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die('Error de conexión: ' . $conn->connect_error);
}

// Desactivar restricciones de clave foránea temporalmente
$conn->query('SET FOREIGN_KEY_CHECKS=0');

// Borra datos existentes
$conn->query('DELETE FROM mascota');
$conn->query('DELETE FROM adopcion');
$conn->query('DELETE FROM perdidos');

// Funciones para generar datos aleatorios
function randomNombre()
{
  $nombres = ['Juan', 'Ana', 'Luis', 'Maria', 'Carlos', 'Lucia', 'Pedro', 'Sofia', 'Miguel', 'Laura'];
  return $nombres[array_rand($nombres)];
}
function randomApellido()
{
  $apellidos = ['Gomez', 'Perez', 'Rodriguez', 'Fernandez', 'Lopez', 'Garcia', 'Martinez', 'Sanchez', 'Diaz', 'Torres'];
  return $apellidos[array_rand($apellidos)];
}
function randomEmail($nombre, $apellido, $i)
{
  return strtolower($nombre . '.' . $apellido . $i . '@mail.com');
}
function randomTelefono()
{
  return '+549' . rand(3408000000, 3408999999);
}
function randomBarrio()
{
  $barrios = ['Centro', 'Norte', 'Sur', 'Este', 'Oeste', 'Juan XXIII', 'Jose Dho'];
  return $barrios[array_rand($barrios)];
}
function randomDireccion()
{
  $calles = ['Belgrano', 'Oroño', 'San Martin', 'Mitre', 'Sarmiento'];
  return $calles[array_rand($calles)];
}
function randomLocalidad()
{
  return 'San Cristobal';
}
function randomProvincia()
{
  return 'Santa Fe';
}
function randomRol()
{
  $roles = ['Administrador', 'Usuario', 'Invitado', 'Veterinario'];
  return $roles[array_rand($roles)];
}
function randomPassword()
{
  // Contraseña hash dummy
  return password_hash('password', PASSWORD_DEFAULT);
}
function randomCategoria()
{
  $cats = ['Canino', 'Felino'];
  return $cats[array_rand($cats)];
}
function randomRaza($categoria)
{
  $razasCanino = ['Mestizo', 'Labrador', 'Poodle', 'Bulldog'];
  $razasFelino = ['Mestizo', 'Siames', 'Persa', 'Bengala'];
  return $categoria === 'Canino' ? $razasCanino[array_rand($razasCanino)] : $razasFelino[array_rand($razasFelino)];
}
function randomColor()
{
  $colores = ['Negro', 'Blanco', 'Tricolor', 'Gris', 'Marrón'];
  return $colores[array_rand($colores)];
}
function randomHeight()
{
  $heights = ['Pequeño', 'Mediano', 'Grande'];
  return $heights[array_rand($heights)];
}
function randomStatusMascota()
{
  $status = ['Perdido', 'Adoptado', 'Disponible'];
  return $status[array_rand($status)];
}
function randomImagen($categoria)
{
  if ($categoria === 'Canino') {
    return '/gestionDeAnimales/public/res/img/animal.png';
  } else {
    return '/gestionDeAnimales/public/res/img/animal.png';
  }
}
function randomChip()
{
  return substr(md5(rand()), 0, 10);
}
function randomFechaReporte()
{
  return date('Y-m-d', strtotime('-' . rand(0, 365) . ' days'));
}
function randomLugar()
{
  $lugares = ['Ruta 13', 'Plaza Central', 'Parque Norte', 'Barrio Sur', 'Estación'];
  return $lugares[array_rand($lugares)];
}

// Insertar 100 personas
for ($i = 1; $i <= 100; $i++) {
  $nombre = randomNombre();
  $apellido = randomApellido();
  $dni = str_pad($i . rand(1000000, 9999999), 8, '0', STR_PAD_LEFT);
  $email = randomEmail($nombre, $apellido, $i);
  $telefono = randomTelefono();
  $barrio = randomBarrio();
  $direccion = randomDireccion();
  $calleAltura = rand(100, 2000);
  $depto = '';
  $piso = 0;
  $localidad = randomLocalidad();
  $provincia = randomProvincia();

  $conn->query("INSERT INTO persona (idPersona, nombre, apellido, dni, email, telefono, barrio, direccion, calleAltura, depto, piso, localidad, provincia) VALUES
    ($i, '$nombre', '$apellido', '$dni', '$email', '$telefono', '$barrio', '$direccion', $calleAltura, '$depto', $piso, '$localidad', '$provincia')");
}

// Insertar 100 usuarios
for ($i = 1; $i <= 100; $i++) {
  $rol = randomRol();
  $password = randomPassword();
  $fecha_alta = date('Y-m-d', strtotime('-' . rand(0, 365) . ' days'));
  $habilitado = 1;

  $conn->query("INSERT INTO usuario (idUsuario, Persona_idPersona, rol, password, fecha_alta, habilitado) VALUES
    ($i, $i, '$rol', '$password', '$fecha_alta', $habilitado)");
}

// Insertar 100 mascotas
for ($i = 1; $i <= 100; $i++) {
  $usuario_id = $i;
  $nombre = randomNombre();
  $categoria = randomCategoria();
  $raza = randomRaza($categoria);
  $edad = rand(1, 20);
  $color = randomColor();
  $height = randomHeight();
  $imagen = randomImagen($categoria);
  $chipNro = randomChip();
  $status = randomStatusMascota();

  $conn->query("INSERT INTO mascota (idMascota, Usuario_idUsuario, nombre, categoria, raza, edad, color, height, imagen, chipNro, status) VALUES
    ($i, $usuario_id, '$nombre', '$categoria', '$raza', $edad, '$color', '$height', '$imagen', '$chipNro', '$status')");
}

// Insertar 100 perdidos (solo para mascotas con status 'Perdido')
for ($i = 1; $i <= 100; $i++) {
  $result = $conn->query("SELECT status FROM mascota WHERE idMascota = $i");
  $row = $result->fetch_assoc();
  if ($row && $row['status'] === 'Perdido') {
    $fecha_de_reporte = randomFechaReporte();
    $lugar = randomLugar();
    $descripcion = NULL;
    $status = 'Perdido';
    $conn->query("INSERT INTO perdidos (idPerdido, Mascota_idMascota, fecha_de_reporte, lugar, descripcion, status) VALUES
      ($i, $i, '$fecha_de_reporte', '$lugar', NULL, '$status')");
  }
}

// Reactivar restricciones de clave foránea
$conn->query('SET FOREIGN_KEY_CHECKS=1');

echo "100 registros aleatorios insertados correctamente.";

$conn->close();
