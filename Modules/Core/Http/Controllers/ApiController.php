<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiController extends AbstractBaseController
{
    /**
     * @var mixed
     */
    protected $data = [];

    protected array $messages = [];

    protected int $status;

    protected array $headers = [];

    protected ResponseFactory $response;

    /**
     * ApiController constructor.
     *
     * @param  ResponseFactory  $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->status = HttpResponse::HTTP_OK;
        $this->response = $response;
    }

    /**
     * Get the data
     *
     * @return mixed
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Set the data
     *
     * @param  mixed  $data
     *
     * @return $this
     */
    protected function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the error message as data
     *
     * @param  string  $message
     *
     * @return $this
     */
    protected function setErrorMessage(string $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Get the Status Code
     *
     * @return int
     */
    protected function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * Set the Status Code
     *
     * @param  int  $status
     *
     * @return $this
     */
    protected function setStatusCode(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the headers
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the headers
     *
     * @param  array  $headers
     *
     * @return $this
     */
    protected function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Return the response
     *
     * @return JsonResponse
     */
    protected function respond(): JsonResponse
    {
        return $this->response->json(
            [
                'status' => empty($this->messages),
                'messages' => $this->messages,
                'data' => $this->getData()
            ],
            $this->getStatusCode(),
            $this->getHeaders()
        );
    }

    /**
     * Respond Ok - 200
     *
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondOk($data = []): JsonResponse
    {
        return $this->setData($data)
            ->setStatusCode(HttpResponse::HTTP_OK)
            ->respond();
    }

    /**
     * Respond Created - 201
     *
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondCreated($data = []): JsonResponse
    {
        return $this->setData($data)
            ->setStatusCode(HttpResponse::HTTP_CREATED)
            ->respond();
    }

    /**
     * Respond Accepted - 202
     *
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondAccepted($data = []): JsonResponse
    {
        return $this->setData($data)
            ->setStatusCode(HttpResponse::HTTP_ACCEPTED)
            ->respond();
    }

    /**
     * Respond No Content - 204
     *
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondNoContent($data = []): JsonResponse
    {
        return $this->setData($data)
            ->setStatusCode(HttpResponse::HTTP_NO_CONTENT)
            ->respond();
    }

    /**
     * Respond Bad Request - 400
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondBadRequest(string $message = 'Bad Request'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_BAD_REQUEST)
            ->respond();
    }

    /**
     * Respond Unauthorized - 401
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_UNAUTHORIZED)
            ->respond();
    }

    /**
     * Respond Forbidden - 403
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_FORBIDDEN)
            ->respond();
    }

    /**
     * Respond Not Found - 404
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_NOT_FOUND)
            ->respond();
    }

    /**
     * Respond Expectation Failed - 417
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondExpectationFailed(string $message = 'Expectation Failed'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_EXPECTATION_FAILED)
            ->respond();
    }

    /**
     * Respond Unprocessable Entity - 422
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondUnprocessableEntity(string $message = 'Unprocessable Entity'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond();
    }

    /**
     * Respond Internal Server Error - 500
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondInternalServerError(string $message = 'Internal Server Error'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->respond();
    }

    /**
     * Respond Conflict - 409
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondConflict(string $message = 'Resource Conflict'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_CONFLICT)
            ->respond();
    }

    /**
     * Respond Service Not Available - 503
     *
     * @param  string  $message
     *
     * @return JsonResponse
     */
    public function respondServiceNotAvailable(string $message = 'Service Not Available'): JsonResponse
    {
        return $this->setErrorMessage($message)
            ->setStatusCode(HttpResponse::HTTP_SERVICE_UNAVAILABLE)
            ->respond();
    }

    public function respondDeleted(): JsonResponse
    {
        return $this
            ->setStatusCode(HttpResponse::HTTP_NO_CONTENT)
            ->respond();
    }
}
