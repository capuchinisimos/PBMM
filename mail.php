<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        #Reemplazar este correo por el correo electrónico del destinatario
        $mail_to = "parisbatmeta@gmail.com";
        
        # Envío de datos
       
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
		
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) OR empty($message)) {
            # Establecer un código de respuesta y salida.
            http_response_code(400);
            echo "Remplissez tous les champs du formulaire s'il vous plait ! ";
            exit;
        }
        
        # Contenido del correo
        $content .= "De: $name\n";
        $content .= "E-mail: $email\n\n";
        
        
        # Encabezados de correo electrónico.
        $headers = "Voici la demande de \n  $name \n son mail $email \n son téléphone $phone\n\n  voici son message \n\n\n $message";

        # Envía el correo.
        $success = mail($mail_to, $content, $headers);
        if ($success) {
            # Establece un código de respuesta 200 (correcto).
            http_response_code(200);
            echo "Merci d’avoir pris le temps de nous contacter via notre formulaire.\n\n\n

Votre message a bien été transmis à nos équipes, nous vous répondrons dans les plus brefs délais.";
        } else {
            # Establezce un código de respuesta 500 (error interno del servidor).
            http_response_code(500);
            echo "Une erreur est survenue lors de l'envoi de votre message. Veuillez essayer à nouveau plus tard.";
        }

    } else {
        # No es una solicitud POST, establezce un código de respuesta 403 (prohibido).
        http_response_code(403);
        echo "Une erreur est survenue lors de l'envoi de votre message. Veuillez essayer à nouveau plus tard.";
    }

?>