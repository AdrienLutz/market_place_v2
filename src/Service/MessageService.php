<?php
namespace App\Service;
use Twig\Extension\AbstractExtension;

class MessageService extends AbstractExtension {
    public function AfficherMessage(): string
    {
        $message = [
            'message de test (service) n°1',
            'message de test (service) n°2'
        ];
        $index = array_rand($message);
        return $message[$index];
    }
}

?>