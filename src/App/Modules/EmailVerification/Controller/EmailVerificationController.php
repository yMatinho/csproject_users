<?php

namespace App\Modules\EmailVerification\Controller;

use App\Core\ErrorHandler\JsonHandler;
use App\Model\Contact;
use App\Modules\EmailVerification\Service\EmailVerificationService;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\DTO\Request\UserUpdateRequest;
use App\Modules\User\Resource\Endpoint\CreateResource;
use App\Modules\User\Resource\Endpoint\DeleteResource;
use App\Modules\User\Resource\Endpoint\FindAllResource;
use App\Modules\User\Resource\Endpoint\FindResource;
use App\Modules\User\Resource\Endpoint\UpdateResource;
use App\Modules\User\Resource\UserResource;
use App\Modules\User\Service\UserService;
use Framework\Controller\Controller;
use Framework\Request\Request;
use Framework\Response\JsonResource;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class EmailVerificationController extends Controller
{

    private readonly EmailVerificationService $emailVerificationService;
    public function __construct()
    {
        $this->emailVerificationService = new EmailVerificationService();
        $this->errorHandler = new JsonHandler();
    }

    public function send(Request $request) {
        $this->emailVerificationService->send($request->email);
    }

    public function verify(Request $request) {
        $this->emailVerificationService->verify($request->token);
    }
}
