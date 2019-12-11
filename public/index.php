<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use N1215\SimpleAdr\Action\UserShowAction;
use N1215\SimpleAdr\Domain\User;
use N1215\SimpleAdr\Domain\UserId;
use N1215\SimpleAdr\Domain\UserName;
use N1215\SimpleAdr\Domain\UserShowUseCase;
use N1215\SimpleAdr\Responder\UserShowJsonResponder;

function createAction(): UserShowAction {
    $useCase = new UserShowUseCase(
        new User(new UserId(1), new UserName('Tom')),
        new User(new UserId(2), new UserName('Mary'))
    );
    $responder = new UserShowJsonResponder(
        new \Zend\Diactoros\ResponseFactory(),
        new \Zend\Diactoros\StreamFactory()
    );
    return new UserShowAction($useCase, $responder);
}

$action = createAction();
$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
$response = $action->handle($request);
(new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
