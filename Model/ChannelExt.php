<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ChannelExt extends AbstractExtensibleModel implements
    \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\MSP\NotifierQueue\Model\ResourceModel\ChannelExt::class);
    }

    /**
     * @inheritdoc
     */
    public function getChannelId()
    {
        return $this->getData(self::CHANNEL_ID);
    }

    /**
     * @inheritdoc
     */
    public function setChannelId($value)
    {
        return $this->setData(self::CHANNEL_ID, $value);
    }

    /**
     * @inheritdoc
     */
    public function getImmediateSend()
    {
        return $this->getData(self::IMMEDIATE_SEND);
    }

    /**
     * @inheritdoc
     */
    public function setImmediateSend($value)
    {
        return $this->setData(self::IMMEDIATE_SEND, $value);
    }

    /**
     * @inheritdoc
     */
    public function getRetryFor()
    {
        return $this->getData(self::RETRY_FOR);
    }

    /**
     * @inheritdoc
     */
    public function setRetryFor($value)
    {
        return $this->setData(self::RETRY_FOR, $value);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): \MSP\NotifierQueueApi\Api\Data\ChannelExtExtensionInterface
    {
        $extensionAttributes = $this->_getExtensionAttributes();
        if (null === $extensionAttributes) {
            $extensionAttributes = $this->extensionAttributesFactory->create(
                \MSP\NotifierQueueApi\Api\Data\ChannelExtExtensionInterface::class
            );
            $this->setExtensionAttributes($extensionAttributes);
        }
        return $extensionAttributes;
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(
        \MSP\NotifierQueueApi\Api\Data\ChannelExtExtensionInterface $extensionAttributes
    ) {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
