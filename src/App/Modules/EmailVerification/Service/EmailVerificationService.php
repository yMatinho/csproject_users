<?php

namespace App\Modules\EmailVerification\Service;

use App\Core\Api\NotificationsMessageBrokerFacade;
use App\Core\Helper\StringHelper;
use App\Model\Contact;
use App\Core\Model\EmailVerification;
use App\Core\Model\User;
use App\Core\Repository\Repository;
use App\Modules\EmailVerification\DTO\Request\EmailVerificationCreationRequest;
use App\Modules\EmailVerification\DTO\Request\EmailVerificationUpdateRequest;
use App\Modules\EmailVerification\Mail\EmailVerificationPublisher;
use App\Modules\EmailVerification\Repository\EmailVerificationRepository;
use App\Modules\User\Service\UserService;
use Framework\DB\Query\Clausure\WhereComparison;
use Framework\Exception\HttpException;
use Framework\Model\Collection;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class EmailVerificationService
{
    private Repository $repository;
    private UserService $userService;
    private EmailVerificationPublisher $emailVerificationPublisher;
    public function __construct()
    {
        $this->repository = new EmailVerificationRepository();
        $this->userService = new UserService();
        $this->emailVerificationPublisher = new EmailVerificationPublisher();
    }

    public function verify(string $token): void
    {
        $emailVerification = $this->repository->findBy([
            new WhereComparison("token", "=", $token)
        ]);

        if (!$emailVerification)
            throw new \Exception("Token inválido!");

        $this->repository->update($emailVerification, (object)[
            "accepted_at" => date("Y-m-d H:i:s")
        ]);
    }

    public function send(string $email): EmailVerification
    {
        $user = $this->userService->findByEmail($email);
        $emailVerification = $this->createEmailVerification($user);
        $this->emailVerificationPublisher->publishVerificationEmailJob($emailVerification);

        return $emailVerification;
    }

    public function sendFromUser(User $user): EmailVerification
    {
        $emailVerification = $this->createEmailVerification($user);
        $this->emailVerificationPublisher->publishVerificationEmailJob($emailVerification);

        return $emailVerification;
    }

    private function createEmailVerification(User $user): EmailVerification {
        $token = StringHelper::generateRandomToken();
        $emailVerification = $this->repository->create((object)[
            "user_id" => $user->id,
            "token" => $token
        ]);
        $emailVerification->user = $user;

        return $emailVerification;
    }
}
