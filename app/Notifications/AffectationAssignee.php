<?php

namespace App\Notifications;

use App\Interfaces\InformationsNotification;
use App\Utils\Constantes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AffectationAssignee extends Notification
{
    use Queueable;

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    const VAL_DATA_ID_STAGE = 'id_stage';
    private $idStage;

    /* ====================================================================
     *                           CONSTRUCTEUR
     * ====================================================================
     */
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $idStage)
    {
        $this->idStage = $idStage;
    }


    /* ====================================================================
     *                            OVERRIDES
     * ====================================================================
     */
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /* ====================================================================
     *                            UTILITAIRES
     * ====================================================================
     */
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            self::VAL_DATA_ID_STAGE => $this->idStage
        ];
    }
}
