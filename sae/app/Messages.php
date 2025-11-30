<?php

namespace sae;

class Messages {

    /**
     * Effectue une redirection et enregistre un message d'alerte en session
     * @param string $message Texte du message d'alerte
     * @param string $type Couleur bootstrap de l'alerte (success, danger, warning, info)
     * @param string $page Page de destination (optionnel)
     * @return void
     */
    public static function goHome(string $message, string $type = "info", string $page = "connecte.php") : void {

        if (!session_id()) {
            session_start();
        }

        // Stockage du flash message
        $_SESSION['flash'][$type] = $message;

        // Base URL sécurisée
        $baseurl =
            $_SERVER['HTTP_ORIGIN']
            ?? $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

        // Redirection
        header("Location: {$baseurl}/{$page}");
        exit;
    }

    /**
     * Affiche les messages d'alerte présents dans la session
     * @return void
     */
    public static function messageFlash() : void {

        if (!session_id()) {
            session_start();
        }

        if(isset($_SESSION['flash'])) {
            foreach($_SESSION['flash'] as $type => $message) {

                // contrôle du type (sécurité)
                $type = in_array($type, ["success","danger","warning","info"])
                    ? $type
                    : "info";

                echo <<<HTML
<div class="alert alert-$type alert-dismissible fade show" role="alert">
    $message
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
HTML;
            }
            unset($_SESSION['flash']);
        }
    }
}
