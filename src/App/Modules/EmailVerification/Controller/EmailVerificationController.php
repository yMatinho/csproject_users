<?php

namespace App\Modules\EmailVerification\Controller;

use App\Core\ErrorHandler\JsonHandler;
use App\Modules\EmailVerification\Resource\Endpoint\SendResource;
use App\Modules\EmailVerification\Resource\Endpoint\VerifyResource;
use App\Modules\EmailVerification\Service\EmailVerificationService;
use Framework\Controller\Controller;
use Framework\Request\Request;
use Framework\Response\JsonResource;

class EmailVerificationController extends Controller
{

    private readonly EmailVerificationService $emailVerificationService;
    private readonly JsonResource $sendResource;
    private readonly JsonResource $verifyResource;
    public function __construct()
    {
        $this->emailVerificationService = new EmailVerificationService();
        $this->errorHandler = new JsonHandler();
        $this->sendResource = new SendResource();
        $this->verifyResource = new VerifyResource();
    }

    public function send(Request $request) {
        $this->emailVerificationService->send($request->email);

        return $this->sendResource->exportFromArray(["message"=>"Enviado com sucesso!"]);
    }

    public function verify(Request $request) {
        $this->emailVerificationService->verify($request->token);

        return $this->verifyResource->exportFromArray(["message"=>"Verificado com sucesso!"]);
    }
}
