<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["nombre"]));
                $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
        $telefono = trim($_POST["telefono"]);
        $message = trim($_POST["mensaje"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "¡Huy! Hubo un problema con el envío. Por favor complete el formulario y vuelva a intentarlo.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "hola@transfields.com";


        // Set the email subject.
        $subject = "Formulario de contacto por : $name";

        // Build the email content.
        $email_content = "Nombre:  $name\n";
        $email_content .= "Correo Electrónico:  $email\n";
        $email_content .= "Teléfono: $telefono\n";
        $email_content .= "Mensaje: $message\n";

        // Build the email headers.
        $email_headers = "De: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "¡Gracias! Tu mensaje ha sido enviado.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "¡Huy! Algo salió mal y no pudimos enviar tu mensaje.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Hubo un problema con el envío, por favor intente de nuevo.";
    }

?>