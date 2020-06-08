<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/spanner/admin/instance/v1/spanner_instance_admin.proto

namespace Google\Cloud\Spanner\Admin\Instance\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Metadata type for the operation returned by
 * [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance].
 *
 * Generated from protobuf message <code>google.spanner.admin.instance.v1.CreateInstanceMetadata</code>
 */
class CreateInstanceMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * The instance being created.
     *
     * Generated from protobuf field <code>.google.spanner.admin.instance.v1.Instance instance = 1;</code>
     */
    private $instance = null;
    /**
     * The time at which the
     * [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance] request was
     * received.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     */
    private $start_time = null;
    /**
     * The time at which this operation was cancelled. If set, this operation is
     * in the process of undoing itself (which is guaranteed to succeed) and
     * cannot be cancelled again.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_time = 3;</code>
     */
    private $cancel_time = null;
    /**
     * The time at which this operation failed or was completed successfully.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 4;</code>
     */
    private $end_time = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Spanner\Admin\Instance\V1\Instance $instance
     *           The instance being created.
     *     @type \Google\Protobuf\Timestamp $start_time
     *           The time at which the
     *           [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance] request was
     *           received.
     *     @type \Google\Protobuf\Timestamp $cancel_time
     *           The time at which this operation was cancelled. If set, this operation is
     *           in the process of undoing itself (which is guaranteed to succeed) and
     *           cannot be cancelled again.
     *     @type \Google\Protobuf\Timestamp $end_time
     *           The time at which this operation failed or was completed successfully.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Spanner\Admin\Instance\V1\SpannerInstanceAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * The instance being created.
     *
     * Generated from protobuf field <code>.google.spanner.admin.instance.v1.Instance instance = 1;</code>
     * @return \Google\Cloud\Spanner\Admin\Instance\V1\Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * The instance being created.
     *
     * Generated from protobuf field <code>.google.spanner.admin.instance.v1.Instance instance = 1;</code>
     * @param \Google\Cloud\Spanner\Admin\Instance\V1\Instance $var
     * @return $this
     */
    public function setInstance($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Spanner\Admin\Instance\V1\Instance::class);
        $this->instance = $var;

        return $this;
    }

    /**
     * The time at which the
     * [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance] request was
     * received.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     * @return \Google\Protobuf\Timestamp
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * The time at which the
     * [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance] request was
     * received.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setStartTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->start_time = $var;

        return $this;
    }

    /**
     * The time at which this operation was cancelled. If set, this operation is
     * in the process of undoing itself (which is guaranteed to succeed) and
     * cannot be cancelled again.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_time = 3;</code>
     * @return \Google\Protobuf\Timestamp
     */
    public function getCancelTime()
    {
        return $this->cancel_time;
    }

    /**
     * The time at which this operation was cancelled. If set, this operation is
     * in the process of undoing itself (which is guaranteed to succeed) and
     * cannot be cancelled again.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_time = 3;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCancelTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->cancel_time = $var;

        return $this;
    }

    /**
     * The time at which this operation failed or was completed successfully.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 4;</code>
     * @return \Google\Protobuf\Timestamp
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * The time at which this operation failed or was completed successfully.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 4;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setEndTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->end_time = $var;

        return $this;
    }

}

