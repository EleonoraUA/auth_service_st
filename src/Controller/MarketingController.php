<?php


namespace App\Controller;


use App\Service\AnalyticEventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function trackAction(Request $request)
    {
        $requestJson = $request->getContent();
        $requestData = json_decode($requestJson, true);

        $sourceLabel = $requestData['source_label'] ?? null;
        if (!$sourceLabel) {
            return new JsonResponse(['status' => false, 'message' => 'No source_label in request']);
        }

        $this->analyticEventDispatcher->dispatch($sourceLabel, $this->getUser()->getId());

        return new JsonResponse(['status' => true]);
    }
}