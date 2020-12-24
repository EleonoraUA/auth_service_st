<?php


namespace App\Controller;

use App\Exceptions\InvalidUserDataException;
use App\Service\UserManager;
use App\Service\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * RegisterController constructor.
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManager $userManager)
    {
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

        $user = $this->userManager->createUserFromData($requestData);

        return new JsonResponse(['status' => true, 'userId' => $user->getId()]);
    }
}