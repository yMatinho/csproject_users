<?php

namespace App\Modules\EmailVerification\Mail;

use App\Core\Api\NotificationsMessageBrokerFacade;
use App\Core\Model\EmailVerification;
use App\Core\Model\User;

class EmailVerificationPublisher {
    private NotificationsMessageBrokerFacade $notificationMessageBrokerFacade;
    public function __construct() {
        $this->notificationMessageBrokerFacade = new NotificationsMessageBrokerFacade();
    }
    public function publishVerificationEmailJob(EmailVerification $emailVerification): void
    {
        $this->notificationMessageBrokerFacade->dispatchEmail(
            $emailVerification->getUser()->email,
            "CSProject - Verifique seu email",
            sprintf(
                "Olá, %s! Por favor, clique no link abaixo para verificar seu email: <br><br><br>%s",
                $emailVerification->getUser()->first_name,
                sprintf("%s/verify-email/%s", FRONT_URL, $emailVerification->token)
            )
        );
    }
    public function publishEmailVerifiedSuccessfully(EmailVerification $emailVerification): void
    {
        $this->notificationMessageBrokerFacade->dispatchEmail(
            $emailVerification->getUser()->email,
            "CSProject - Email verificado com sucesso!",
            sprintf(
                "Olá, %s! Você verificou seu email com sucesso e já pode acessar a plataforma!",
                $emailVerification->getUser()->first_name
            )
        );
    }
}