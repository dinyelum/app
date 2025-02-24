<?php
trait Responses {
    
    function resp_invalid($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "$fieldname is invalid",
        };
    }

    function resp_invalid_selection($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Invalid Selection",
        };
    }

    function resp_invalid_selections($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "One or more of the selections is Invalid",
        };
    }

    function resp_invalid_name($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "To make things easier, use only letters (any language) and white spaces",
        };
    }

    function resp_invalid_polite($fieldname, $lang='en') {
        $lang = $this->lang ?? $lang;
        if($fieldname=='fullphone') {
            $newfieldname = match ($lang) {
                'fr' => '',
                default => "phone",
            };
        }
        $response = match ($lang) {
            'fr' => '',
            default => "$fieldname contains invalid characters.",
        };
        return str_ireplace('fullphone', $newfieldname ?? '', $response);
    }

    function resp_invalid_more_info($fieldname, $allowedcharacters, $lang='en') {
        $lang = $this->lang ?? $lang;
        $allowedcharacters = implode(', ', $allowedcharacters);
        return $response = match ($lang) {
            'fr' => '',
            default => "Only $allowedcharacters are allowed",
        };
    }

    function resp_invalid_phone_instruction($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Select your country's flag and type your phone number",
        };
    }

    function resp_empty($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "$fieldname cannot be empty",
        };
    }

    function resp_invalid_length($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        if(isset($this->err['maxlength']) && is_numeric($this->err['maxlength'])) {
            $response = match ($lang) {
                'fr' => '',
                default => "$fieldname cannot be more than ".$this->err['maxlength'].' characters',
            };
        } elseif(isset($this->err['minlength']) && is_numeric($this->err['minlength'])) {
            $response = match ($lang) {
                'fr' => '',
                default => "$fieldname cannot be less than ".$this->err['minlength'].' characters',
            };
        } else {
            $response = match ($lang) {
                'fr' => '',
                default => "length could not be verified. Please contact admin about this.",
            };
        }
        return $response;
    }

    function resp_invalid_size($fieldname, $size, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "$fieldname  size must not be more than $size",
        };
    }

    function resp_already_exists($fieldname, $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "This $fieldname already exists.",
        };
    }

    function resp_unexpected_err($fieldname='', $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "An unexpected error occurred",
        };
    }

    function resp_unknown_err($fieldname='', $lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "An unknown error occurred",
        };
    }

    function resp_try_again($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Please try again later.",
        };
    }

    function resp_invalid_request($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Invalid Request",
        };
    }
    
    function resp_many_registrations($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Too many registrations at the same time. ",
        }.$this->resp_try_again();
    }

    function resp_incorrect_login($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Incorrect login details",
        };
    }

    function resp_max_attempts($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Max attempts reached. Please try again after 1 hour",
        };
    }

    function resp_attempts_remaining($number) {
        $lang = LANG ?? 'en';
        return $response = match ($lang) {
            'fr' => '',
            default => "$number attempts remaining",
        };
    }

    function sth_went_wrong($lang='en') {
        $lang = LANG ?? $lang;
        return $response = match ($lang) {
            'fr' => '',
            default => "Something went wrong.",
        };
    }
}