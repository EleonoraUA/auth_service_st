<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\AnalyticEventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MarketingController
 * @package App\Controller
 */
class MarketingController extends AbstractController
{
    /**
     * @var AnalyticEventDispatcher
     */
    protected $analyticEventDispatcher;

    /**
     * MarketingController constructor.
     * @param AnalyticEventDispatcher $analyticEventDispatcher
     */
    public function __construct(AnalyticEventDispatcher $analyticEventDispatcher)
    {
        $this->analyticEventDispatcher = $analyticEventDispatcher;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function trackAction(Request $request): JsonResponse
    {
        $requestJson = $request->getContent();
        $requestData = json_decode($requestJson, true);

        $sourceLabel = $requestData['source_label'] ?? null;
        if (!$sourceLabel) {
            return new JsonResponse(['status' => false, 'message' => 'No source_label in request'], Response::HTTP_BAD_REQUEST);
        }

        $userId = $this->getUser()
            ? $this->getUser()->getId()
            : $request->cookies->get(User::ANON_USER_ID_KEY);
        $this->analyticEventDispatcher->dispatch($sourceLabel, $userId);

        return new JsonResponse(['status' => true]);
    }
}