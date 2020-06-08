<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/kms/v1/service.proto

namespace Google\Cloud\Kms\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for [KeyManagementService.Decrypt][google.cloud.kms.v1.KeyManagementService.Decrypt].
 *
 * Generated from protobuf message <code>google.cloud.kms.v1.DecryptRequest</code>
 */
class DecryptRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption.
     * The server will choose the appropriate version.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';
    /**
     * Required. The encrypted data originally returned in
     * [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
     *
     * Generated from protobuf field <code>bytes ciphertext = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $ciphertext = '';
    /**
     * Optional. Optional data that must match the data originally supplied in
     * [EncryptRequest.additional_authenticated_data][google.cloud.kms.v1.EncryptRequest.additional_authenticated_data].
     *
     * Generated from protobuf field <code>bytes additional_authenticated_data = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $additional_authenticated_data = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption.
     *           The server will choose the appropriate version.
     *     @type string $ciphertext
     *           Required. The encrypted data originally returned in
     *           [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
     *     @type string $additional_authenticated_data
     *           Optional. Optional data that must match the data originally supplied in
     *           [EncryptRequest.additional_authenticated_data][google.cloud.kms.v1.EncryptRequest.additional_authenticated_data].
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Kms\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption.
     * The server will choose the appropriate version.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption.
     * The server will choose the appropriate version.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Required. The encrypted data originally returned in
     * [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
     *
     * Generated from protobuf field <code>bytes ciphertext = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getCiphertext()
    {
        return $this->ciphertext;
    }

    /**
     * Required. The encrypted data originally returned in
     * [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
     *
     * Generated from protobuf field <code>bytes ciphertext = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setCiphertext($var)
    {
        GPBUtil::checkString($var, False);
        $this->ciphertext = $var;

        return $this;
    }

    /**
     * Optional. Optional data that must match the data originally supplied in
     * [EncryptRequest.additional_authenticated_data][google.cloud.kms.v1.EncryptRequest.additional_authenticated_data].
     *
     * Generated from protobuf field <code>bytes additional_authenticated_data = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getAdditionalAuthenticatedData()
    {
        return $this->additional_authenticated_data;
    }

    /**
     * Optional. Optional data that must match the data originally supplied in
     * [EncryptRequest.additional_authenticated_data][google.cloud.kms.v1.EncryptRequest.additional_authenticated_data].
     *
     * Generated from protobuf field <code>bytes additional_authenticated_data = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setAdditionalAuthenticatedData($var)
    {
        GPBUtil::checkString($var, False);
        $this->additional_authenticated_data = $var;

        return $this;
    }

}

