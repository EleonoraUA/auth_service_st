<?php


namespace App\Controller;

use App\Exceptions\InvalidUserDataException;
use App\Exceptions\UserAlreadyExistsException;
use App\Service\AnalyticEventDispatcher;
use App\Service\UserManager;
use App\Service\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends AbstractController
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var AnalyticEventDispatcher
     */
    protected $analyticEventDispatcher;

    /**
     * RegisterController constructor.
     * @param UserManager $userManager
     * @param AnalyticEventDispatcher $analyticEventDispatcher
     */
    public function __construct(UserManager $userManager, AnalyticEventDispatcher $analyticEventDispatcher)
    {
        $this->analyticEventDispatcher = $analyticEventDispatcher;
        $this->userManager = $userManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidUserDataException
     * @throws \App\Exceptions\UserAlreadyExistsException
     */
    public function index(Request $request)
    {
        $requestDataJson = $request->getContent();
        $requestData = json_decode($requestDataJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidUserDataException('User data must be JSON');
        }

        try {
            $user = $this->userManager->createUserFromData($requestData);
            $this->analyticEventDispatcher->dispatch('register_success', $user->getId());
        } catch (UserAlreadyExistsException | InvalidUserDataException $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage(), Response::HTTP_BAD_REQUEST]);
        }

        return new JsonResponse(['status' => true, 'userId' => $user->getId(), Response::HTTP_CREATED]);
    }
}