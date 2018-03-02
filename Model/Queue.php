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
class Queue extends AbstractExtensibleModel implements
    \MSP\NotifierQueueApi\Api\Data\QueueInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\MSP\NotifierQueue\Model\ResourceModel\Queue::class);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }

    /**
     * @inheritdoc
     */
    public function getSentAt()
    {
        return $this->getData(self::SENT_AT);
    }

    /**
     * @inheritdoc
     */
    public function setSentAt($value)
    {
        return $this->setData(self::SENT_AT, $value);
    }

    /**
     * @inheritdoc
     */
    public function getSendTrials()
    {
        return $this->getData(self::SEND_TRIALS);
    }

    /**
     * @inheritdoc
     */
    public function setSendTrials($value)
    {
        return $this->setData(self::SEND_TRIALS, $value);
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatus($value)
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * @inheritdoc
     */
    public function getChannelCode()
    {
        return $this->getData(self::CHANNEL_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setChannelCode($value)
    {
        return $this->setData(self::CHANNEL_CODE, $value);
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage($value)
    {
        return $this->setData(self::MESSAGE, $value);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
       return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(
        \MSP\NotifierQueueApi\Api\Data\QueueExtensionInterface $extensionAttributes
    ) {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
