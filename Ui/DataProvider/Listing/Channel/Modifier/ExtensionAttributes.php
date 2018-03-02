<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Ui\DataProvider\Listing\Channel\Modifier;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use MSP\NotifierApi\Api\Data\ChannelInterface;
use MSP\NotifierQueueApi\Api\ChannelExtRepositoryInterface;

class ExtensionAttributes implements ModifierInterface
{
    /**
     * @var ChannelExtRepositoryInterface
     */
    private $channelExtRepository;

    /**
     * RuleDataProviderPlugin constructor.
     * @param ChannelExtRepositoryInterface $channelExtRepository
     */
    public function __construct(
        ChannelExtRepositoryInterface $channelExtRepository
    ) {
        $this->channelExtRepository = $channelExtRepository;
    }

    /**
     * @param array $data
     * @return array
     * @since 100.1.0
     */
    public function modifyData(array $data)
    {
        foreach ($data['items'] as &$item) {
            try {
                $ext = $this->channelExtRepository->getByChannelId((int) $item[ChannelInterface::ID]);
                $item['immediate_send'] = $ext->getImmediateSend();
                $item['retry_for'] = $ext->getRetryFor();
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }

        return $data;
    }

    /**
     * @param array $meta
     * @return array
     * @since 100.1.0
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
