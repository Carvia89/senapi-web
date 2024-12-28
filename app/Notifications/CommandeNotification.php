<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommandeNotification extends Notification
{
    use Queueable;

    protected $numeroCommande;
    protected $libelle;
    protected $totalQteCmdee;
    protected $pdfPath;


    /**
     * Create a new notification instance.
     */
    public function __construct($numeroCommande, $libelle, $totalQteCmdee, $pdfPath)
    {
        $this->numeroCommande = $numeroCommande;
        $this->libelle = $libelle;
        $this->totalQteCmdee = $totalQteCmdee;
        $this->pdfPath = $pdfPath;
    }

    public function via($notifiable)
    {
        return ['mail']; // Vous pouvez ajouter d'autres canaux ici si nécessaire
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle Commande Validée')
            ->line('Une nouvelle commande a été validée.')
            ->line('N° de commande: ' . $this->numeroCommande)
            ->line('Libellé: ' . $this->libelle)
            ->line('Total Quantité Commandée: ' . $this->totalQteCmdee)
            ->attach($this->pdfPath) // Attacher le PDF
            ->action('Télécharger le PDF', url($this->pdfPath));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
