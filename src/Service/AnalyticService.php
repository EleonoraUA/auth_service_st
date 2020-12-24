<?php


namespace App\Service;


use App\Message\AnalyticEventMessage;
use \SocialTech\SlowStorage;

/**
 * Class AnalyticService
 * @package App\Service
 */
class AnalyticService implements AnalyticServiceInterface
{
    protected const FILE_FORMAT = '.json';

    /**
     * @var SlowStorage
     */
    protected $slowStorage;

    /**
     * @var string
     */
    protected $analyticFilesSaveDir;

    /**
     * AnalyticService constructor.
     * @param SlowStorage $slowStorage
     * @param string $analyticFilesSaveDir
     */
    public function __construct(SlowStorage $slowStorage, string $analyticFilesSaveDir)
    {
        $this->slowStorage = $slowStorage;
        $this->analyticFilesSaveDir = $analyticFilesSaveDir;
    }

    /**
     * @param AnalyticEventMessage $message
     */
    public function handleEvent(AnalyticEventMessage $message): void
    {
        $userPath = $this->getPath($message->getUserId());

        $this->slowStorage->exists($userPath)
            ? $this->slowStorage->append($userPath, self::getEventData($message))
            : $this->slowStorage->store($userPath, self::getEventData($message));
    }

    /**
     * @param AnalyticEventMessage $message
     * @return string
     */
    protected static function getEventData(AnalyticEventMessage $message): string
    {
        return json_encode([
            'dateCreated' => (new \DateTime())->setTimestamp($message->getDateCreated())->format('Y-m-d H:i:s'),
            'source_label' => $message->getSourceLabel(),
            'user_id' => $message->getUserId()
        ]);
    }

    /**
     * @param string $userId
     * @return string
     */
    protected function getPath(string $userId): string
    {
        return $this->analyticFilesSaveDir . $userId . self::FILE_FORMAT;
    }
}