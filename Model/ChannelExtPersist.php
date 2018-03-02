<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use MSP\Notifier\Model\ChannelExtensionLoaderInterface;
use MSP\NotifierApi\Api\Data\ChannelInterface;
use MSP\NotifierQueueApi\Api\ChannelExtRepositoryInterface;
use MSP\NotifierQueueApi\Api\Data\ChannelExtInterfaceFactory;

class ChannelExtPersist
{
    /**
     * @var ChannelExtensionLoaderInterface
     */
    private $channelExtensionLoader;

    /**
     * @var ChannelExtRepositoryInterface
     */
    private $channelExtRepository;

    /**
     * @var ChannelExtInterfaceFactory
     */
    private $channelExtInterfaceFactory;

    /**
     * ChannelRepositoryInterfacePlugin constructor.
     * @param ChannelExtensionLoaderInterface $channelExtLoader
     * @param ChannelExtRepositoryInterface $channelExtRepository
     * @param ChannelExtInterfaceFactory $channelExtInterfaceFactory
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        ChannelExtensionLoaderInterface $channelExtLoader,
        ChannelExtRepositoryInterface $channelExtRepository,
        ChannelExtInterfaceFactory $channelExtInterfaceFactory
    ) {
        $this->channelExtensionLoader = $channelExtLoader;
        $this->channelExtRepository = $channelExtRepository;
        $this->channelExtInterfaceFactory = $channelExtInterfaceFactory;
    }

    /**
     * Load extension attributes
     * @param ChannelInterface $channel
     */
    public function load(ChannelInterface $channel)
    {
        $this->channelExtensionLoader->execute($channel);
        $extension = $channel->getExtensionAttributes();

        try {
            $channelExt = $this->channelExtRepository->getByChannelId((int) $channel->getId());
            $extension->setImmediateSend($channelExt->getImmediateSend());
            $extension->setRetryFor($channelExt->getRetryFor());
        } catch (NoSuchEntityException $e) {
            $extension->setImmediateSend(null);
            $extension->setRetryFor(null);
        }
    }

    /**
     * Save extension attributes
     * @param ChannelInterface $channel
     */
    public function save(ChannelInterface $channel)
    {
        $extensionAttributes = $channel->getExtensionAttributes();

        if (!$extensionAttributes) {
            return;
        }

        try {
            $channelExt = $this->channelExtRepository->getByChannelId((int) $channel->getId());
        } catch (NoSuchEntityException $e) {
            $channelExt = $this->channelExtInterfaceFactory->create();
        }

        if ($extensionAttributes->getRetryFor() !== null) {
            $channelExt->setRetryFor($extensionAttributes->getRetryFor());
        }
        if ($extensionAttributes->getImmediateSend() !== null) {
            $channelExt->setImmediateSend($extensionAttributes->getImmediateSend());
        }

        $channelExt->setChannelId($channel->getId());
        $this->channelExtRepository->save($channelExt);
    }
}
