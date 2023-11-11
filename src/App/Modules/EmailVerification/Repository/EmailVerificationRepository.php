<?php

namespace App\Modules\EmailVerification\Repository;

use App\Core\Model\EmailVerification;
use App\Core\Repository\Repository;
use App\Model\Contact;
use App\Modules\EmailVerification\DTO\Request\EmailVerificationCreationRequest;
use App\Modules\EmailVerification\DTO\Request\EmailVerificationUpdateRequest;
use Framework\Exception\HttpException;
use Framework\Model\Collection;
use Framework\Model\Model;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class EmailVerificationRepository implements Repository
{
    public function __construct()
    {
    }

    public function findAll(): Collection
    {
        return EmailVerification::all();
    }

    public function findById(int|string $id, bool $throwNotFoundException = false): EmailVerification
    {
        return EmailVerification::find($id, $throwNotFoundException);
    }

    public function findBy(array $comparisons, bool $throwNotFoundException = false): EmailVerification
    {
        return EmailVerification::findBy($comparisons, $throwNotFoundException);
    }

    public function create(object $dto): EmailVerification
    {
        $emailVerification = new EmailVerification();
        $emailVerification->token = $dto->token;
        $emailVerification->user_id = $dto->user_id;
        $emailVerification->save();

        return $emailVerification;
    }

    public function update(Model $emailVerification, object $dto): EmailVerification
    {
        $emailVerification->accepted_at = $dto->accepted_at ?: null;
        $emailVerification->save();

        return $emailVerification;
    }

    public function delete(Model $emailVerification): bool
    {
        EmailVerification::delete($emailVerification->id);

        return true;
    }
}
