<?php
	/**
	 * Created by PhpStorm.
	 * User: hicham benkachoud
	 * Date: 06/01/2020
	 * Time: 20:39
	 */

	namespace App\Controller;

	use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Security\Core\User\UserInterface;

	class ApiController extends AbstractController
	{

		/**
		 * @var integer HTTP status code - 200 (OK) by default
		 */
		protected $statusCode = 200;

		/**
		 * Gets the value of statusCode.
		 *
		 * @return integer
		 */
		public function getStatusCode()
		{
			return $this->statusCode;
		}

		/**
		 * Sets the value of statusCode.
		 *
		 * @param integer $statusCode the status code
		 *
		 * @return self
		 */
		protected function setStatusCode($statusCode)
		{
			$this->statusCode = $statusCode;

			return $this;
		}

		/**
		 * Returns a JSON response
		 *
		 * @param array $data
		 * @param array $headers
		 *
		 * @return JsonResponse
		 */
		public function response($data, $headers = [])
		{
			return new JsonResponse($data, $this->getStatusCode(), $headers);
		}

		/**
		 * Sets an error message and returns a JSON response
		 *
		 * @param string $errors
		 * @param $headers
		 * @return JsonResponse
		 */
		public function respondWithErrors($errors, $headers = [])
		{
			$data = [
				'status' => $this->getStatusCode(),
				'errors' => $errors,
			];

			return new JsonResponse($data, $this->getStatusCode(), $headers);
		}


		/**
		 * Sets an error message and returns a JSON response
		 *
		 * @param string $success
		 * @param $headers
		 * @return JsonResponse
		 */
		public function respondWithSuccess($success, $headers = [])
		{
			$data = [
				'status' => $this->getStatusCode(),
				'success' => $success,
			];

			return new JsonResponse($data, $this->getStatusCode(), $headers);
		}


		/**
		 * Returns a 401 Unauthorized http response
		 *
		 * @param string $message
		 *
		 * @return JsonResponse
		 */
		public function respondUnauthorized($message = 'Not authorized!')
		{
			return $this->setStatusCode(401)->respondWithErrors($message);
		}

		/**
		 * Returns a 422 Unprocessable Entity
		 *
		 * @param string $message
		 *
		 * @return JsonResponse
		 */
		public function respondValidationError($message = 'Validation errors')
		{
			return $this->setStatusCode(422)->respondWithErrors($message);
		}

		/**
		 * Returns a 404 Not Found
		 *
		 * @param string $message
		 *
		 * @return JsonResponse
		 */
		public function respondNotFound($message = 'Not found!')
		{
			return $this->setStatusCode(404)->respondWithErrors($message);
		}

		/**
		 * Returns a 201 Created
		 *
		 * @param array $data
		 *
		 * @return JsonResponse
		 */
		public function respondCreated($data = [])
		{
			return $this->setStatusCode(201)->response($data);
		}

		// this method allows us to accept JSON payloads in POST requests
		// since Symfony 4 doesn’t handle that automatically:

		protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
		{
			$data = json_decode($request->getContent(), true);

			if ($data === null) {
				return $request;
			}

			$request->request->replace($data);

			return $request;
		}


	}
