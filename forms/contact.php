<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

// Validar método
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(403);
  echo "Método no permitido";
  exit;
}

// Obtener datos
$name = htmlspecialchars(trim($_POST["name"] ?? ""));
$email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(trim($_POST["subject"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"] ?? ""));

// Validaciones
if (!$name || !$email || !$subject || !$message) {
  http_response_code(400);
  echo "Todos los campos son obligatorios.";
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Correo inválido.";
  exit;
}

// Crear instancia
$mail = new PHPMailer(true);

try {

  // Configuración SMTP Gmail
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;

  $mail->Username = 'vladiir.rod96@gmail.com';

  // ⚠️ IMPORTANTE: usa contraseña de aplicación
  $mail->Password = 'ajqzkushofpmaivt';

  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->CharSet = 'UTF-8';

  // Remitente
  $mail->setFrom('vladiir.rod96@gmail.com', 'Listo En Línea');

  // DESTINOS (AQUI VAN LOS 2 CORREOS)
  $mail->addAddress('vladiir.rod96@gmail.com');
  $mail->addAddress('juanheuforico@gmail.com');

  // Para responder al cliente
  $mail->addReplyTo($email, $name);

  // Contenido
  $mail->isHTML(true);
  $mail->Subject = "Nuevo contacto - " . $subject;

  $mail->Body = "
    <h2>Nuevo mensaje desde Listo En Línea</h2>
    <p><strong>Nombre:</strong> {$name}</p>
    <p><strong>Correo:</strong> {$email}</p>
    <p><strong>Asunto / Empresa:</strong> {$subject}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{$message}</p>
  ";

  $mail->AltBody = "
Nuevo mensaje desde Listo En Línea

Nombre: {$name}
Correo: {$email}
Asunto / Empresa: {$subject}

Mensaje:
{$message}
  ";

  // Enviar
  $mail->send();

  // RESPUESTA PARA TU FRONT (IMPORTANTE)
  echo "OK";

} catch (Exception $e) {
  http_response_code(500);
  echo "Error al enviar: {$mail->ErrorInfo}";
}