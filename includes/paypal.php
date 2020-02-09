<?php 

    require 'paypal/autoload.php';

    define('URL_SITIO', 'http://localhost/gdlwebcamp');

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            // ClienteID
            'AUB_83abp-SsJocwoxuJEuFcRQvWTURQ_NMRy87EG8M-GnahIhBEVXrpf2frKGl4n0CDtSTWJGnRMvWz',
            // Secret
            'ECn8DlDNIrgi5HOizbqehsEt_thm-Q5ANx8TWSQF4dWtMthuQIF4kFo0GqP_cAHDTqdhBvJzkgN2gqnB'
        )
    );