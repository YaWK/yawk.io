<?php
/**
 * Copyright (C) 2016-2017  SSilence
 * For the full license, please see LICENSE.
 */

namespace SSilence\ImapClient;

/**
 * Class TypeAttachments that holds attachment types.
 *
 * @copyright  Copyright (c) Tobias Zeising (http://www.aditu.de)
 * @author     Tobias Zeising <tobias.zeising@aditu.de>
 */
class TypeAttachments
{
    /**
     * Types of attachments.
     *
     * @var array
     */
    private static $types = array('JPEG', 'JPG', 'PNG', 'PSD', 'GIF', 'PDF', 'X-MPEG', 'MSWORD', 'OCTET-STREAM', 'TXT', 'TEXT', 'MWORD', 'ZIP', 'X-ZIP-COMPRESSED', 'ARCHIVE', 'WAV', 'MP3', 'MP4', 'DOC', 'MPG', 'MPEG', 'DBASE', 'ACROBAT', 'POWERPOINT', 'BMP', 'BITMAP', 'PDF', 'XLS', 'PPT');

    /**
     * Get the allowed types.
     *
     * @return array
     */
    public static function get()
    {
        return static::$types;
    }
}
