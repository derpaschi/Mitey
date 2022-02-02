<?php

namespace Mite;

/**
 * Represents the mite tracker object of the current active time entry
 *
 * @author Thomas Lauria <thomas@mittagqi.com>
 */
class MiteTracker extends MiteEntity
{
    /**
     * ID to the current active time entry (MiteTime)
     * @var integer
     */
	public $id = null;

    /**
     * The duration of the current time entry in minutes
     * @var integer
     */
	public $minutes = null;

    /**
     * The start time of the current time entry in DATE_RFC3339 format
     * @var string
     */
	public $since = null;

    /**
     * factory for MiteTracker entities, out of a response object
     * @param \stdClass $response
     * @return MiteTracker|null
     */
	public static function fromResponse(\stdClass $response) {
        if(!empty($response->tracker->stopped_time_entry)) {
            return new self($response->tracker->stopped_time_entry);
        }
        if(!empty($response->tracker->tracking_time_entry)) {
            return new self($response->tracker->tracking_time_entry);
        }
        return null;
    }
}
