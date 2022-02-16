<?php
namespace YAWK {
    /**
     * @details <b>Integrated Webmail</b>
     *
     * YaWK includes a <i>seamless integrated</i> webmail. This means you can handle all emails of your website
     * without leaving the backend. The seamless integration into the backend will help you with your daily work.
     *
     * This class features all the basic webmail functions that are required
     * to build the desired views. It also acts as wrapper for the imap client and serve some low-level API
     * methods to move, purge, delete emails and more.
     *
     * Beside this, this class serves methods to list folders and email headers / messages
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl http://www.yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0/
     * @since      File available since Release 1.0.0
     * @brief Integrated IMAP Webmail
     *
     */

    class webmail
    {
        /** @param string information about the connection */
        public $connectionInfo = '';

        /**
         * @brief Move a message from source to target folder. Requires imap handle, source folder, target folder and the mail UID to move.
         * @param $imap object imap connection resource
         * @param $folder string the source folder from which to move the uid
         * @param $targetFolder string the target folder where to move the uid
         * @param $uid int|string the mail UID
         */
        public function moveMessage($imap, $folder, $targetFolder, $uid)
        {   /** @param $imap \SSilence\ImapClient\ImapClient */

            // check email uid
            if (!isset($uid) || (empty($uid)))
            {   // no uid set
                return false;
                // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no uid set!", "", 0);
            }

            // check target folder
            if (!isset($targetFolder) || (empty($targetFolder)))
            {   // target folder not set or empty
                return false;
                // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no target folder set!", "", 0);
            }

            // check source folder
            if (!isset($folder) || (empty($folder)))
            {
                // folder is not set or empty
                return false;
                // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no source folder set!", "", 0);
            }
            else
            {   // select current source folder
                $imap->selectFolder($folder);
            }

            // move email to target folder
            if ($imap->moveMessage($uid, $targetFolder))
            {   // move email successful
                return true;
            }
            else
            {   // move email failed
                return false;
            }
        }

        /**
         * @brief Delete a message. Requires imap handle, folder and uid of the mail to delete
         * @param $imap object imap connection resource
         * @param $folder string the source folder from which to move the uid
         * @param $uid int|string the mail UID
         */
        public function deleteMessage($imap, $folder, $uid)
        {   /** @param $imap \SSilence\ImapClient\ImapClient */

            // folder is not set or empty
            if (!isset($folder) || (empty($folder)))
            {   // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no source folder set!", "", 0);
            }
            else
            {   // select current source folder
                $imap->selectFolder($folder);
            }

            // mail uid is not set
            if (!isset($uid) || (empty($uid)))
            {   // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no uid set!", "", 0);
            }

            // move email to target folder
            if ($imap->deleteMessage($uid))
            {   // move email successful
                return true;
            }
            else
            {   // move email failed
                return false;
            }
        }


        /**
         * @brief Cleanup trash and spam folder (delete all messages in requested folder)
         * @param $imap object imap connection resource
         */
        public function purgeTrash($imap)
        {   /** @param $imap \SSilence\ImapClient\ImapClient */
            // move email to target folder
            if ($imap->purge() == true)
            {   // purge successful
                return true;
            }
            else
            {   // purge failed
                return false;
            }
        }

        /**
         * @brief Draw mailbox control buttons (trash, reply, forward...)
         * @param $imap object imap object
         * @param $type string inbox|message| select proper button set which to display
         * @param $uid int the current email uid to work with
         * @param $folder string the current folder (to detect if folder is trash)
         * @param $lang array language array
         */
        public function drawMailboxControls($imap, $type, $uid, $folder, $lang)
        {
            /** @param $imap \SSilence\ImapClient\ImapClient */
            // check if uid is set
            if (!isset($uid) || (empty($uid)))
            {   // set uid to zero
                $uid = 0;
            }
            // check if folder is set (required for correct delete action)
            if (!isset($folder) || (empty($folder)))
            {   // set folder to inbox
                $folder = "INBOX";
            }

            // check if type is set
            if (isset($type) && (is_string($type)))
            {   // check, which type of button set is wanted
                switch ($type)
                {
                    // button iconset for message overview
                    case "inbox":
                        // if current folder is trash...
                        if ($folder == "trash" || ($folder == "Trash"))
                        {   // link: do not move to trash, DELETE finally
                            $deleteClassicLink = "index.php?page=webmail&purgeTrash=true";
                            $deleteLink = '<a id="moveIconLink_'.$uid.'" onclick="moveMessage('.$uid.', \''.$_GET['folder'].'\', \''.$folder.'\');return false;" href="#"><i class="fa fa-trash-o" id="moveIcon_'.$uid.'"></i></a>';
                            $deleteClass = "btn btn-default btn-sm";
                            $refreshClass = "btn btn-default btn-sm hidden";
                            $markAsReadClass = "btn btn-default btn-sm checkbox-toggle hidden";
                        }
                        else
                        {   // move to trash link
                            $deleteClassicLink = "index.php?page=webmail&moveMessage=true&folder=".$folder."&targetFolder=Trash&uid=".$uid."";
                            if (!isset($_GET['folder']) || (empty($_GET['folder']))) { ($folder = 'Inbox'); } else { ($folder = $_GET['folder']); }
                            $deleteLink = '<a id="moveIconLink_'.$uid.'" onclick="moveMessage('.$uid.', \''.$folder.'\', \'Trash\');return false;" href="#"><i class="fa fa-trash-o" id="moveIcon_'.$uid.'"></i></a>';
                            $deleteClass = "btn btn-default btn-sm hidden";
                            $refreshClass = "btn btn-default btn-sm";
                            $markAsReadClass = "btn btn-default btn-sm checkbox-toggle";

                        }
                        echo "
                    <div class=\"mailbox-controls\">
                        <!-- Check all button -->
                        <a href=\"#\" class=\"".$markAsReadClass."\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[MARK_ALL_AS_READ]\" data-original-title=\"$lang[MARK_ALL_AS_READ]\"><i class=\"fa fa-square-o\"></i></a>
                        <div class=\"btn-group\">";
                        // echo $deleteLink;
                        // classic link
                         echo "<a href=\"".$deleteClassicLink."\" id=\"icon-trash\" class=\"".$deleteClass."\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[DELETE_ALL]\" data-original-title=\"$lang[DELETE_ALL]\"><i class=\"fa fa-trash-o\"></i> &nbsp;Empty Trash</a>
                               <a href=\"index.php?page=webmail\" id=\"icon-refresh\" class=\"".$refreshClass."\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[REFRESH]\" data-original-title=\"$lang[REFRESH]\"><i class=\"fa fa-refresh\"></i></a>
                        </div>
                        <!-- /.btn-group -->
                        <!-- additional buttons: settings + new mail -->
                        <div class=\"pull-right\">
                            <a href=\"index.php?page=settings-webmail\" id=\"icon-settings\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[SETTINGS]\" data-original-title=\"$lang[SETTINGS]\"><i class=\"fa fa-gear\"></i></a>
                            <a href=\"index.php?page=webmail-compose\" id=\"icon-compose\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[EMAIL_COMPOSE]\" data-original-title=\"$lang[EMAIL_COMPOSE]\"><i class=\"fa fa-plus\"></i></a>
                            <!-- /.btn-group -->
                        </div>    
                    </div>";
                    break;

                    // button iconset for wwbmail-message page
                    case "message":
                        // if current folder is trash...
                        if ($folder == "trash" || ($folder == "Trash"))
                        {   // link: do not move to trash, DELETE finally
                            $deleteLink = "index.php?page=webmail&purgeTrash=true";
                            $deleteClass = "btn btn-default btn-sm";
                        }
                        else
                        {   // move to trash link
                            // $deleteLink = "index.php?page=webmail&moveMessage=true&folder=".$folder."&targetFolder=Trash&uid=".$uid."";
                            $deleteClass = "btn btn-default btn-sm";
                            if (!isset($_GET['folder']) || (empty($_GET['folder']))) { ($folder = 'Inbox'); } else { ($folder = $_GET['folder']); }
                            $deleteLink = '<a id="moveIconLink_'.$uid.'" class="btn btn-default btn-sm" onclick="moveMessage('.$uid.', \''.$folder.'\', \'Trash\');return false;" href="#" title="'.$lang['DELETE'].'" data-toggle="tooltip" data-container="body" data-original-title="'.$lang['DELETE'].'"><i class="fa fa-trash-o" id="moveIcon_'.$uid.'"></i></a>';
                        }
                        echo "
                    <div class=\"mailbox-controls\">
                        <div class=\"btn-group\">
                            <a id=\"btn-markAsUnseen\" href=\"index.php?page=webmail-message&markAsUnread=true&folder=".$_GET['folder']."&msgno=".$_GET['msgno']."\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[MARK_AS_UNSEEN]\" data-original-title=\"$lang[MARK_AS_UNSEEN]\"><i class=\"fa fa-envelope\" id=\"icon-markAsUnseen\"></i></a>
                            ";
                            echo $deleteLink;

                            // <a href=\"".$deleteLink."\" id=\"icon-delete\" class=\"".$deleteClass."\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[DELETE]\" data-original-title=\"$lang[DELETE]\"><i class=\"fa fa-trash-o\"></i></a>
                            echo "<a id=\"icon-reply\" href=\"#summernote\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[REPLY]\" data-original-title=\"$lang[REPLY]\"><i class=\"fa fa-reply\"></i></a>
                            <a href=\"index.php?page=webmail\" id=\"icon-forward\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[FORWARD]\" data-original-title=\"$lang[FORWARD]\"><i class=\"fa fa-mail-forward\"></i></a>
                            <a href=\"#\" id=\"icon-print\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[PRINT]\" data-original-title=\"$lang[PRINT]\"><i class=\"fa fa-print\"></i></a>
                        </div>
                        <div class=\"btn-group pull-right\">
                            <a href=\"index.php?page=webmail-compose\" id=\"icon-compose\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"\" data-original-title=\"Email verfassen\"><i class=\"fa fa-plus\"></i></a>
                        </div>
                        <!-- /.btn-group -->
                    </div>";
                    break;
                }
            }
        }

        /**
         * @brief Draw a list with all folders of this mailbox
         * @param $imap object The current imap handle
         * @param $folders array The mailbox folders as array
         */
        public function drawFolders($imap, $folders)
        {   // check if folder array is set
            /* @param $imap \SSilence\ImapClient\Imapclient  */

            if (is_array($folders) || (!empty($folders)))
            {
                // sort folder array to bring inbox more upwards
                ksort($folders);

                // count unread messages in current folder
                $unreadMessages = $imap->countUnreadMessages();

                // init default active folder markup
                $activeMarkupDefault = '';

                // if all mails in this folder are seen
                if ($unreadMessages > 0)
                {   // hide new mail label
                    $newMessagesLabel = "<span id=\"newMessagesLabel\" class=\"label label-success pull-right\">+ ".$unreadMessages."</span>";
                }
                else
                    {
                        $newMessagesLabel = "";
                    }

                // walk through folders and display them
                foreach ($folders as $folder => $item)
                {

                    // select current folder
                    $imap->selectFolder($folder);
                    // and count messages within
                    $messageCount = $imap->countMessages();

                    // check if folder is requested via get param
                    if (isset($_GET['folder']) && (!empty($_GET['folder'])))
                    {   // check, if folder is active (current equals request)
                        if ($folder === $_GET['folder'])
                        {
                            // set markup to view as active
                            $activeMarkup = " class=\"active\"";
                            $activeLabelNew = $newMessagesLabel;
                            $activeLabelInbox = '';
                            $activeLabelTotal = " <span id=\"messageCount_".$folder."\"><small>(".$messageCount.")</small></span>";
                        }
                        else
                            {   // folder not active - no markup needed
                                $activeMarkup = '';
                                $activeLabelNew = '';
                                $activeLabelInbox = '';
                                $activeLabelTotal = " <span id=\"messageCount_".$folder."\"><small>(".$messageCount.")</small></span>";
                            }
                    }
                    else
                        {   // page called w/o requested folder, set default (inbox) as active
                            $activeMarkup = "";
                            $activeLabelNew = "";
                            $activeLabelTotal = "";
                            $activeLabelInbox = $newMessagesLabel;
                            // $activeLabelInbox = "<span class=\"label label-success pull-right".$labelClass."\">+ ".$unreadMessages."</span>";

                            $activeLabelTotal = " <span id=\"messageCount_".$folder."\"><small>(".$messageCount.")</small></span>";
                            $activeMarkupDefault = " class=\"active\"";
                        }


                    // check folder value and set markup to display icons corresponding to the folder
                    if ($folder == "INBOX" || $folder == "inbox" || $folder == "Inbox")
                    {   // set inbox icon
                        echo "<li '".$activeMarkup.$activeMarkupDefault."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-inbox\"></i> $folder
                              ".$activeLabelNew." ".$activeLabelInbox." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "SENT" || $folder == "sent" || $folder == "Sent")
                    {   // set sent icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-envelope-o\"></i> $folder 
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Drafts" || $folder == "drafts" || $folder == "DRAFTS")
                    {   // set draft icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-file-text-o\"></i> ".$folder."
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Junk" || $folder == "junk" || $folder == "JUNK")
                    {   // set junk icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-filter\"></i> ".$folder."
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Trash" || $folder == "trash" || $folder == "TRASH")
                    {   // set trash icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-trash-o\"></i> ".$folder."
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else
                        {   // any other folder: default folder icon
                            echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-folder-o\"></i> ".$folder."
                                 ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                        }
                }
            }
            else
                {   // folders array not set or empty
                    echo "Failed to draw folders because folders is not an array (or empty).";
                }
        }


        /**
         * @brief Draw email headers (will be used to overview the email list)
         * @param $emails array email headers
         * @param $currentFolder string the current folder from where to get the emails
         * @param $lang array language array
         */
        public function drawHeaders($emails, $currentFolder, $lang)
        {   // check, if email array is set and not empty
            if (is_array($emails) && (!empty($emails)))
            {
                // walk through every email...
                foreach ($emails as $item => $email)
                {
                    // mail is new (not seen)
                    if ($email->header->seen === 0)
                    {   // display it bold
                        $state = "setSeen";
                        $boldRow = "text-bold";
                        $seenIcon = "fa fa-envelope text-muted";
                        $seenLink = 'index.php?page=webmail&markAsRead=true&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                        // $seenTooltip = 'data-toggle="tooltip" data-container="body" title="'.$lang['MARK_AS_READ'].'" data-original-title="'.$lang['MARK_AS_READ'].'"';
                        $seenTooltip = '';
                        $messageLink = 'index.php?page=webmail-message&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                        $markAsReadIcon = '<a id="seenIconLink_'.$email->header->msgno.'" onclick="markAsSeen('.$email->header->msgno.', \''.$state.'\');return false;" href="#" '.$seenTooltip.'><i id="seenIcon_'.$email->header->msgno.'" class="'.$seenIcon.'"></i></a>';
                    }
                    else
                        {   // message already seen
                            $state = "setUnseen";
                            $boldRow = "";
                            $seenIcon = "fa fa-envelope-open-o text-muted";
                            $seenLink = 'index.php?page=webmail&markAsUnread=true&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                            // $seenTooltip = 'data-toggle="tooltip" data-container="body" title="'.$lang['MARK_AS_UNSEEN'].'" data-original-title="'.$lang['MARK_AS_UNSEEN'].'"';
                            $seenTooltip = '';
                            $messageLink = 'index.php?page=webmail-message&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                            $markAsReadIcon = '<a id="seenIconLink_'.$email->header->msgno.'" onclick="markAsSeen('.$email->header->msgno.', \''.$state.'\');return false;" href="#" '.$seenTooltip.'><i id="seenIcon_'.$email->header->msgno.'" class="'.$seenIcon.'"></i></a>';
                        }

                    // get mail size
                    $size = \YAWK\filemanager::sizeFilter($email->header->size, 0);

                    // count attachments
                    $attachment = count ($email->attachments);

                    // check if attachment is set
                    if ($attachment >= 1)
                    {   // set paperclip icon
                        $attachClip = '<b><i class="fa fa-paperclip"></i></b><br><small>'.$size.'</small>';
                    }
                    else
                        {   // no paperclip
                            $attachClip = "";
                        }

                    // calculate human friendly time info
                    $timeAgo = \YAWK\sys::time_ago($email->header->date, $lang);

                    if ($currentFolder == "trash" || $currentFolder == "Trash" || $currentFolder == "TRASH")
                    {
                        $starIcon = '';
                        // set action icon to "RESTORE"
                        $markAsReadIcon = '<a id="moveIconLink_'.$email->header->uid.'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'Inbox\', );return false;" href="#"><i class="fa fa-undo text-dark" id="moveIcon_'.$email->header->uid.'"></i></a>';
                        // delete icon
                        $deleteIcon = '<a id="moveIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['DELETE_FINALLY'].'" data-original-title="'.$lang['DELETE_FINALLY'].'" onclick="deleteMessage('.$email->header->uid.', \''.$currentFolder.'\');return false;" href="#"><i class="fa fa-trash-o" id="moveIcon_'.$email->header->uid.'"></i></a>';
                        // spam icon
                        $spamIcon = '<a id="spamIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['SPAM'].'" data-original-title="'.$lang['SPAM'].'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'Junk\');return false;" href="#"><i class="fa fa-filter" id="spamIcon_'.$email->header->uid.'"></i></a>';
                    }
                    elseif ($currentFolder == "junk" || $currentFolder == "Junk" || $currentFolder == "JUNK"
                    || $currentFolder == "spam" || $currentFolder == "Spam" || $currentFolder == "SPAM")
                    {
                        $deleteIcon = '<a id="moveIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['RECYCLE_BIN'].'" data-original-title="'.$lang['RECYCLE_BIN'].'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'Trash\');return false;" href="#"><i class="fa fa-trash-o" id="moveIcon_'.$email->header->uid.'"></i></a>';
                        // spam icon (move back to inbox)
                        $spamIcon = '<a id="spamIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['MOVE_INBOX'].'" data-original-title="'.$lang['MOVE_INBOX'].'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'INBOX\');return false;" href="#"><i class="fa fa-inbox" id="spamIcon_'.$email->header->uid.'"></i></a>';
                    }
                    else
                        {
                            // in any other case:
                            $deleteIcon = '<a id="moveIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['RECYCLE_BIN'].'" data-original-title="'.$lang['RECYCLE_BIN'].'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'Trash\');return false;" href="#"><i class="fa fa-trash-o" id="moveIcon_'.$email->header->uid.'"></i></a>';
                            // spam icon
                            $spamIcon = '<a id="spamIconLink_'.$email->header->uid.'" data-toggle="tooltip" data-container="body" title="'.$lang['SPAM'].'" data-original-title="'.$lang['SPAM'].'" onclick="moveMessage('.$email->header->uid.', \''.$currentFolder.'\', \'Junk\');return false;" href="#"><i class="fa fa-filter" id="spamIcon_'.$email->header->uid.'"></i></a>';
                        }

                    // check if email is flagged
                    if ($email->header->flagged === 0)
                    {   // if not, draw open star
                        $starIcon = '<a id="starIconLink_'.$email->header->uid.'" onclick="markAsFlagged('.$email->header->uid.', \'setFlagged\');return false;" href="#"><i id="starIcon_'.$email->header->uid.'" class="fa fa-star-o text-orange"></i></a>';
                    }
                    else
                        {   // if mail is flagged, draw full star
                            $starIcon = '<a id="starIconLink_'.$email->header->uid.'" onclick="markAsFlagged('.$email->header->uid.', \'setUnFlagged\');return false;" href="#"><i id="starIcon_'.$email->header->uid.'" class="fa fa-star text-orange"></i></a>';
                        }

                    // echo "<pre>";
                    // print_r($email);
                    // echo "</pre>";
                    // display every email as single table row
                    echo '
                        <tr id="emailRow_'.$email->header->uid.'">
                            <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                            <td class="mailbox-star">'.$markAsReadIcon.'</td>
                            <td class="mailbox-star">'.$starIcon.'</td>
                            <td id="mailboxName_'.$email->header->msgno.'" class="mailbox-name '.$boldRow.'" style="cursor:pointer;" onclick="window.location=\''.$messageLink.'\';"><a href="#">'.$email->header->from.'</a>
                            <br><small>'.$email->header->details->from[0]->mailbox.'@'.$email->header->details->from[0]->host.'</small></td>
                            <td id="mailboxSubject_'.$email->header->msgno.'" class="mailbox-subject '.$boldRow.'" style="cursor:pointer;" onclick="window.location=\''.$messageLink.'\';">'.$email->header->subject.'</td>
                            <td class="mailbox-attachment text-center">'.$attachClip.'</td>
                            <td class="mailbox-date">'.substr($email->header->date, 0, -6).'<br><small>'.$timeAgo.'</small></td>
                            <td class="mailbox-star">'.$spamIcon.'&nbsp;&nbsp;&nbsp;&nbsp;'.$deleteIcon.'</td>
                        </tr>';

                }
            }
            else
            {
                // echo "<b>This folder is empty.</b>";
            }
        }


        /**
         * Mark email as flagged
         * @param $imap
         * @param $uid
         * @return bool
         */
        public function markAsFlagged($imap, $uid)
        {
            // /** @param $imap \SSilence\ImapClient\ImapClient */
            return imap_setflag_full($imap, $uid, "\\Flagged", ST_UID);
        }

        /**
         * Clear flags from email
         * @param $imap
         * @param $uid
         * @return bool
         */
        public function removeFlags($imap, $uid)
        {
            return imap_clearflag_full($imap, $uid, "\\Flagged", ST_UID);
        }
    } // ./class webmail
} // ./namespace