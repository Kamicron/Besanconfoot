<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v11/common/criteria.proto

namespace Google\Ads\GoogleAds\V11\Common;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A YouTube Video criterion.
 *
 * Generated from protobuf message <code>google.ads.googleads.v11.common.YouTubeVideoInfo</code>
 */
class YouTubeVideoInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * YouTube video id as it appears on the YouTube watch page.
     *
     * Generated from protobuf field <code>optional string video_id = 2;</code>
     */
    protected $video_id = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $video_id
     *           YouTube video id as it appears on the YouTube watch page.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V11\Common\Criteria::initOnce();
        parent::__construct($data);
    }

    /**
     * YouTube video id as it appears on the YouTube watch page.
     *
     * Generated from protobuf field <code>optional string video_id = 2;</code>
     * @return string
     */
    public function getVideoId()
    {
        return isset($this->video_id) ? $this->video_id : '';
    }

    public function hasVideoId()
    {
        return isset($this->video_id);
    }

    public function clearVideoId()
    {
        unset($this->video_id);
    }

    /**
     * YouTube video id as it appears on the YouTube watch page.
     *
     * Generated from protobuf field <code>optional string video_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setVideoId($var)
    {
        GPBUtil::checkString($var, True);
        $this->video_id = $var;

        return $this;
    }

}

