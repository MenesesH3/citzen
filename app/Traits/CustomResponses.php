<?php

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait CustomResponses
{
    protected function makeMessage(string $message, array|null $data): array
    {
        return [
            'message' => $message,
            'data' => $data
        ];
    }

    public function sendJsonOK(array|null $data = null, string $message = 'Success!', int $code = Response::HTTP_OK): JsonResponse
    {
        $response = $this->makeMessage($message, $data);
        return response()->json($response, $code);
    }

    public function sendJsonError(Throwable $exception): JsonResponse
    {
        $data = null;

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() != Response::HTTP_INTERNAL_SERVER_ERROR) {
            // abort exceptions
            $code = $exception->getStatusCode();
            $message = $exception->getMessage();
        } else if ($exception instanceof MissingAbilityException) {
            $code = Response::HTTP_FORBIDDEN;
            $message = "Você não tem permissão para acessar esta rota.";
        } else if ($exception instanceof ValidationException) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = 'Os dados fornecidos são inválidos. Por favor, tente novamente!';
            $data = $exception->errors();
        } else if ($exception instanceof AuthenticationException) {
            $code = Response::HTTP_UNAUTHORIZED;
            $message = 'Você não está conectado.';
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Ocorreu um erro interno. Entre em contato com a equipe de suporte!';
            Log::error($exception);
        }

        $response = $this->makeMessage($message, $data);

        return response()->json($response, $code);
    }

    public function redirectBackWithSuccess(string $message): RedirectResponse
    {
        return redirect()->back()->with(['success' => $message]);
    }

    public function redirectBackWithError(Throwable $exception): RedirectResponse
    {
        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() != Response::HTTP_INTERNAL_SERVER_ERROR) {
            // abort exceptions
            $message = $exception->getMessage();
        } else if ($exception instanceof ValidationException) {
            return redirect()->back()->withErrors($exception->errors());
        } else {
            $message = 'Ocorreu um erro interno. Entre em contato com a equipe de suporte!';

            Log::error($exception);
        }

        return redirect()->back()->with(['error' => $message]);
    }

    public function redirectToRouteWithSuccess(string $routeName, string $message, array $routeParams = []): RedirectResponse
    {
        return redirect(route($routeName, $routeParams))->with(['success' => $message]);
    }

//    public function renderPageWithProps(string $component, array $props): InertiaResponse
//    {
//        return Inertia::render($component, $props);
//    }
}
