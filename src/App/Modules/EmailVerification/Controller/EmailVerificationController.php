<?php

namespace App\Modules\EmailVerification\Controller;

use App\Core\ErrorHandler\JsonHandler;
use App\Modules\EmailVerification\Service\EmailVerificationService;
use Framework\Controller\Controller;
use Framework\Request\Request;

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

        return ["message"=>"Enviado com sucesso!"];
    }

    public function verify(Request $request) {
        $this->emailVerificationService->verify($request->token);

        return ["message"=>"Verificado com sucesso!"];
    }
}
