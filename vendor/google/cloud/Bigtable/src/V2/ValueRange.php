<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/v2/data.proto

namespace Google\Cloud\Bigtable\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specifies a contiguous range of raw byte values.
 *
 * Generated from protobuf message <code>google.bigtable.v2.ValueRange</code>
 */
class ValueRange extends \Google\Protobuf\Internal\Message
{
    protected $start_value;
    protected $end_value;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $start_value_closed
     *           Used when giving an inclusive lower bound for the range.
     *     @type string $start_value_open
     *           Used when giving an exclusive lower bound for the range.
     *     @type string $end_value_closed
     *           Used when giving an inclusive upper bound for the range.
     *     @type string $end_value_open
     *           Used when giving an exclusive upper bound for the range.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Bigtable\V2\Data::initOnce();
        parent::__construct($data);
    }

    /**
     * Used when giving an inclusive lower bound for the range.
     *
     * Generated from protobuf field <code>bytes start_value_closed = 1;</code>
     * @return string
     */
    public function getStartValueClosed()
    {
        return $this->readOneof(1);
    }

    /**
     * Used when giving an inclusive lower bound for the range.
     *
     * Generated from protobuf field <code>bytes start_value_closed = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setStartValueClosed($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Used when giving an exclusive lower bound for the range.
     *
     * Generated from protobuf field <code>bytes start_value_open = 2;</code>
     * @return string
     */
    public function getStartValueOpen()
    {
        return $this->readOneof(2);
    }

    /**
     * Used when giving an exclusive lower bound for the range.
     *
     * Generated from protobuf field <code>bytes start_value_open = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setStartValueOpen($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Used when giving an inclusive upper bound for the range.
     *
     * Generated from protobuf field <code>bytes end_value_closed = 3;</code>
     * @return string
     */
    public function getEndValueClosed()
    {
        return $this->readOneof(3);
    }

    /**
     * Used when giving an inclusive upper bound for the range.
     *
     * Generated from protobuf field <code>bytes end_value_closed = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setEndValueClosed($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Used when giving an exclusive upper bound for the range.
     *
     * Generated from protobuf field <code>bytes end_value_open = 4;</code>
     * @return string
     */
    public function getEndValueOpen()
    {
        return $this->readOneof(4);
    }

    /**
     * Used when giving an exclusive upper bound for the range.
     *
     * Generated from protobuf field <code>bytes end_value_open = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setEndValueOpen($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getStartValue()
    {
        return $this->whichOneof("start_value");
    }

    /**
     * @return string
     */
    public function getEndValue()
    {
        return $this->whichOneof("end_value");
    }

}

