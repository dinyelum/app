<?php
trait Responses {
    
    function resp_invalid($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => "Le $fieldname n'est pas valide",
            'es' => "El $fieldname no es válido",
            'pt' => "O $fieldname é inválido",
            'de' => "Der $fieldname ist ungültig",
            default => "$fieldname is invalid",
        };
    }

    function resp_invalid_selection($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => "Selección no válida",
            'es' => "Selección no válida",
            'pt' => "Seleção inválida",
            'de' => "Ungültige Auswahl",
            default => "Invalid Selection",
        };
    }

    function resp_invalid_selections($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => "Une ou plusieurs des sélections sont invalides",
            'es' => "Una o más de las selecciones es Inválida",
            'pt' => "Uma ou mais seleções são inválidas",
            'de' => "Eine oder mehrere der Auswahlen sind ungültig",
            default => "One or more of the selections is Invalid",
        };
    }

    function resp_invalid_name($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => "Pour faciliter les choses, utilisez uniquement des lettres (dans n'importe quelle langue) et des espaces",
            'es' => "Para facilitar las cosas, use solo letras (cualquier idioma) y espacios en blanco",
            'pt' => "Para facilitar as coisas, use apenas letras (qualquer idioma) e espaços em branco",
            'de' => "Verwenden Sie zur Vereinfachung nur Buchstaben (beliebige Sprache) und Leerzeichen",
            default => "To make things easier, use only letters (any language) and white spaces",
        };
    }

    function resp_invalid_polite($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        if($fieldname=='fullphone') {
            $newfieldname = match ($lang) {
                'fr' => "Ce numéro",
                'es' => "Este número de teléfono",
                'pt' => "Este número de telefone",
                'de' => "Diese Telefonnummer",
                default => "phone",
            };
        }

        $response = match ($lang) {
            'fr' => "$fieldname contient des caractères non valides.",
            'es' => "$fieldname contiene caracteres no válidos.",
            'pt' => "$fieldname contém caracteres inválidos.",
            'de' => "$fieldname enthält ungültige Zeichen.",
            default => "$fieldname contains invalid characters.",
        };
        return str_ireplace('fullphone', $newfieldname ?? '', $response);
    }

    function resp_invalid_more_info($fieldname, $allowedcharacters, $lang='en') {
        $lang = $this->lang ?? $lang;
        $allowedcharacters = implode(', ', $allowedcharacters);
        return $response = match ($lang) {
            'fr' => "Seuls les $allowedcharacters sont autorisés",
            'es' => "Solo se permiten $allowedcharacters",
            'pt' => "Somente $allowedcharacters são permitidos",
            'de' => "Nur $allowedcharacters sind erlaubt",
            default => "Only $allowedcharacters are allowed",
        };
    }

    function resp_invalid_phone_instruction($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Sélectionnez le drapeau de votre pays et saisissez votre numéro de téléphone",
            'es' => "Selecciona la bandera de tu país y escribe tu número de teléfono",
            'pt' => "Selecione a bandeira do seu país e digite seu número de telefone",
            'de' => "Wählen Sie die Flagge Ihres Landes aus und geben Sie Ihre Telefonnummer ein",
            default => "Select your country's flag and type your phone number",
        };
    }

    function resp_empty($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "$fieldname ne peut pas être vide",
            'es' => "$ fieldname no puede estar vacío",
            'pt' => "$fieldname não pode estar vazio",
            'de' => "$fieldname darf nicht leer sein",
            default => "$fieldname cannot be empty",
        };
    }

    function resp_invalid_length($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        if(isset($this->err['maxlength']) && is_numeric($this->err['maxlength'])) {
            $response = match ($lang) {
                'fr' => "$fieldname ne peut pas contenir plus de ".$this->err['maxlength']." caractères",
                'es' => "$fieldname no puede tener más de ".$this->err['maxlength']." caracteres",
                'pt' => "$fieldname não pode ter mais de ".$this->err['maxlength']." caracteres",
                'de' => "$fieldname darf nicht mehr als ".$this->err['maxlength']." Zeichen lang sein",
                default => "$fieldname cannot be more than ".$this->err['maxlength']." characters",
            };
        } elseif(isset($this->err['minlength']) && is_numeric($this->err['minlength'])) {
            $response = match ($lang) {
                'fr' => "$fieldname ne peut pas contenir moins de ".$this->err['minlength']." caractères",
                'es' => "$fieldname no puede tener menos de ".$this->err['minlength']." caracteres",
                'pt' => "$fieldname não pode ter menos que ".$this->err['minlength']." caracteres",
                'de' => "$fieldname darf nicht weniger als ".$this->err['minlength']." Zeichen haben",
                default => "$fieldname cannot be less than ".$this->err['minlength'].' characters',
            };
        } else {
            $response = match ($lang) {
                'fr' => "La longueur n'a pas pu être vérifiée. Veuillez contacter l'administrateur à ce sujet.",
                'es' => "No se pudo verificar la longitud. Comuníquese con el administrador al respecto.",
                'pt' => "comprimento não pôde ser verificado. Entre em contato com o administrador sobre isso.",
                'de' => "Länge konnte nicht verifiziert werden. Bitte kontaktieren Sie hierzu den Administrator.",
                default => "length could not be verified. Please contact admin about this.",
            };
        }
        return $response;
    }

    function resp_invalid_size($fieldname, $size, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "La taille de $fieldname ne doit pas dépasser $size",
            'es' => "El tamaño del campo no debe ser mayor a $size",
            'pt' => "O tamanho do $fieldname não deve ser maior que $size",
            'de' => "Die Größe von $fieldname darf nicht größer als $size sein.",
            default => "$fieldname  size must not be more than $size",
        };
    }

    function resp_already_exists($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        if($fieldname=='fullphone') {
            $newfieldname = match ($lang) {
                'fr' => "Ce numéro",
                'es' => "Este número de teléfono",
                'pt' => "Este número de telefone",
                'de' => "Diese Telefonnummer",
                default => "This phone",
            };
        }
        return $response = match ($lang) {
            'fr' => "$fieldname existe déjà.",
            'es' => "$fieldname ya existe.",
            'pt' => "$fieldname já existe.",
            'de' => "$fieldname existiert bereits.",
            default => "$fieldname already exists.",
        };
    }

    function resp_unexpected_err($fieldname='', $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Une erreur inattendue s'est produite",
            'es' => "Ocurrió un error inesperado",
            'pt' => "Ocorreu um erro inesperado",
            'de' => "Es ist ein unerwarteter Fehler aufgetreten",
            default => "An unexpected error occurred",
        };
    }

    function resp_unknown_err($fieldname='', $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr'=>'Une erreur inconnue est survenue',
            'es'=>'Un error desconocido ocurrió',
            'pt'=>'Ocorreu um erro desconhecido',
            'de'=>'Ein unbekannter Fehler ist aufgetreten',
            default => "An unknown error occurred",
        };
    }

    function resp_try_again($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Veuillez réessayer plus tard.",
            'es' => "Por favor, inténtelo de nuevo más tarde.",
            'pt' => "Por favor, tente novamente mais tarde.",
            'de' => "Bitte versuchen Sie es später erneut.",
            default => "Please try again later.",
        };
    }

    function resp_invalid_request($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Demande invalide",
            'es' => "Solicitud no válida",
            'pt' => "Solicitação inválida",
            'de' => "Ungültige Anfrage",
            default => "Invalid Request",
        };
    }
    
    function resp_many_registrations($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Trop d'inscriptions en même temps. ",
            'es' => "Demasiados registros al mismo tiempo. ",
            'pt' => "Muitos registros ao mesmo tempo. ",
            'de' => "Zu viele Registrierungen gleichzeitig. ",
            default => "Too many registrations at the same time. ",
        }.$this->resp_try_again();
    }

    function resp_incorrect_login($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Informations de connexion incorrectes",
            'es' => "Detalles de inicio de sesión incorrectos",
            'pt' => "Detalhes de login incorretos",
            'de' => "Falsche Anmeldedaten",
            default => "Incorrect login details",
        };
    }

    function resp_max_attempts($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Nombre maximal de tentatives atteint. Veuillez réessayer après 1 heure.",
            'es' => "Se alcanzó el máximo de intentos. Inténtelo nuevamente después de 1 hora.",
            'pt' => "Máximo de tentativas atingido. Tente novamente após 1 hora.",
            'de' => "Maximale Anzahl Versuche erreicht. Bitte versuchen Sie es in 1 Stunde erneut.",
            default => "Max attempts reached. Please try again after 1 hour.",
        };
    }

    function resp_attempts_remaining($number) {
        $lang = LANG ?? 'en';
        return $response = match ($lang) {
            'fr' => "$number tentatives restantes",
            'es' => "Quedan $number intentos",
            'pt' => "$number tentativas restantes",
            'de' => "Noch $number Versuche übrig",
            default => "$number attempts remaining",
        };
    }

    function sth_went_wrong($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => "Quelque chose s'est mal passé.",
            'es' => "Algo salió mal.",
            'pt' => "Algo deu errado.",
            'de' => "Etwas ist schief gelaufen.",
            default => "Something went wrong.",
        };
    }
}