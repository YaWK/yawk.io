<?php
namespace YAWK {
    /**
     * <b>Integrated Webmail</b>
     *
     * This class features all webmail functions to fetch and send messages and build required views.
     *
     * @category   CMS
     * @package    System
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    https://opensource.org/licenses/MIT
     * @version    1.2.0
     * @link       http://yawk.io/
     * @since      File available since Release 1.0.0
     * @annotation Integrated IMAP Webmail
     *
     */

    class webmail
    {
        /** @var string information about the connection */
        public $connectionInfo = '';

        /**
         * @param $imap object imap connection resource
         * @param $folder string the source folder from which to move the uid
         * @param $targetFolder string the target folder where to move the uid
         * @param $uid int|string the mail UID
         */
        public function moveMessage($imap, $folder, $targetFolder, $uid)
        {   /** @var $imap \SSilence\ImapClient\ImapClient */

            // folder is not set or empty
            if (!isset($folder) || (empty($folder)))
            {   // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no source folder set!", "", 0);
            }
            else
            {   // select current source folder
                $imap->selectFolder($folder);
            }

            // target folder not set or empty
            if (!isset($targetFolder) || (empty($targetFolder)))
            {   // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no target folder set!", "", 0);
            }

            if (!isset($uid) || (empty($uid)))
            {   // todo: add syslog call
                // \YAWK\alert::draw("warning", "Warning", "Failed to delete email because there is no uid set!", "", 0);
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
         * @param $imap object imap connection resource
         * @param $folder string the source folder from which to move the uid
         * @param $uid int|string the mail UID
         */
        public function deleteMessage($imap, $folder, $uid)
        {   /** @var $imap \SSilence\ImapClient\ImapClient */

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
         * Draw buttons to control the mailbox with icons (trash, reply, forward...)
         * @param $imap object imap object
         * @param $type string inbox|message|
         * @param $lang array language array
         */
        public function drawMailboxControls($imap, $type, $uid, $folder, $lang)
        {
            /** @var $imap \SSilence\ImapClient\ImapClient */
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
            else
                {
                    // if current folder is trash...
                    if ($folder == "trash" || ($folder == "Trash"))
                    {   // set delete button to final
                        $deleteLink = "index.php?page=webmail&deleteMessage=true&folder=".$folder."&targetFolder=Trash&uid=".$uid."";
                    }
                    else
                        {
                            $deleteLink = "index.php?page=webmail&moveMessage=true&folder=".$folder."&targetFolder=Trash&uid=".$uid."";
                        }
                }

            // check if type is set
            if (isset($type) && (is_string($type)))
            {   // check, which type of button set is wanted
                switch ($type)
                {   // button iconset for inbox
                    case "inbox":
                        echo "
                    <div class=\"mailbox-controls\">
                        <!-- Check all button -->
                        <button type=\"button\" class=\"btn btn-default btn-sm checkbox-toggle\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[MARK_ALL_AS_READ]\" data-original-title=\"$lang[MARK_ALL_AS_READ]\"><i class=\"fa fa-square-o\"></i>
                        </button>
                        <div class=\"btn-group\">
                            <a href=\"index.php?page=webmail\" id=\"icon-trash\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[DELETE_ALL]\" data-original-title=\"$lang[DELETE_ALL]\"><i class=\"fa fa-trash-o\"></i></a>
                            <a href=\"index.php?page=webmail\" id=\"icon-refresh\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[REFRESH]\" data-original-title=\"$lang[REFRESH]\"><i class=\"fa fa-refresh\"></i></a>
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

                    // button iconset for message page
                    case "message":
                        echo "
                    <div class=\"mailbox-controls\">
                        <div class=\"btn-group\">
                            <a id=\"btn-markAsUnseen\" href=\"index.php?page=webmail-message&markAsUnread=true&folder=".$_GET['folder']."&msgno=".$_GET['msgno']."\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[MARK_AS_UNSEEN]\" data-original-title=\"$lang[MARK_AS_UNSEEN]\"><i class=\"fa fa-envelope\" id=\"icon-markAsUnseen\"></i></a>
                            <a href=\"".$deleteLink."\" id=\"icon-delete\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[DELETE]\" data-original-title=\"$lang[DELETE]\"><i class=\"fa fa-trash-o\"></i></a>
                            <a href=\"index.php?page=webmail\" id=\"icon-reply\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[REPLY]\" data-original-title=\"$lang[REPLY]\"><i class=\"fa fa-reply\"></i></a>
                            <a href=\"index.php?page=webmail\" id=\"icon-forward\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[FORWARD]\" data-original-title=\"$lang[FORWARD]\"><i class=\"fa fa-mail-forward\"></i></a>
                            <a href=\"#\" id=\"icon-print\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" data-container=\"body\" title=\"$lang[PRINT]\" data-original-title=\"$lang[PRINT]\"><i class=\"fa fa-print\"></i></a>
                        </div>
                        <!-- /.btn-group -->
                    </div>";
                    break;
                }
            }
        }

        /**
         * @param $imap object The current imap handle
         * @param $folders array The mailbox folders as array
         */
        public function drawFolders($imap, $folders)
        {   // check if folder array is set
            /* @var $imap \SSilence\ImapClient\Imapclient  */

            if (is_array($folders) || (!empty($folders)))
            {
                // sort folder array to bring inbox more upwards
                ksort($folders);

                // count unread messages in current folder
                $unreadMessages = $imap->countUnreadMessages();

                // count total messages in current folder
                $totalMessages = $imap->countMessages();

                // init default active folder markup
                $activeMarkupDefault = '';

                // walk through folders and display them
                foreach ($folders as $folder => $item)
                {   // check if folder is requested via get param
                    if (isset($_GET['folder']) && (!empty($_GET['folder'])))
                    {   // check, if folder is active (current equals request)
                        if ($folder === $_GET['folder'])
                        {

                            // set markup to view as active
                            $activeMarkup = " class=\"active\"";
                            $activeLabelNew = "<span class=\"label label-success pull-right\">+ ".$unreadMessages."</span>";
                            $activeLabelInbox = '';
                            $activeLabelTotal = " <small>(".$totalMessages.")</small>";
                        }
                        // not active, no markup
                        else {
                                $activeMarkup = '';
                                $activeLabelNew= '';
                                $activeLabelInbox = '';
                                $activeLabelTotal = '';
                            }
                    }
                    else
                        {   // page called w/o requested folder, set default (inbox) as active
                            $activeMarkup = "";
                            $activeLabelNew = "";
                            $activeLabelTotal = "";
                            $activeLabelInbox = "<span class=\"label label-success pull-right\">+ ".$unreadMessages."</span>";

                            $activeMarkupDefault = " class=\"active\"";
                        }


                    // check folder value and set markup to display icons corresponding to the folder
                    if ($folder == "INBOX")
                    {   // set inbox icon
                        echo "<li".$activeMarkup.$activeMarkupDefault."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-inbox\"></i> $folder
                              ".$activeLabelNew." ".$activeLabelInbox." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Sent")
                    {   // set sent icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-envelope-o\"></i> $folder 
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Drafts")
                    {   // set draft icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-file-text-o\"></i> ".$folder."
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Junk")
                    {   // set junk icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-filter\"></i> ".$folder."
                             ".$activeLabelNew." ".$activeLabelTotal." </a></li>";
                    }

                    else if ($folder == "Trash")
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
         * @param $emails array email headers
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
                        $boldMarkupStart = "<b>";
                        $boldMarkupEnd = "</b>";
                        // $starIcon = "fa fa-star text-yellow";
                        $seenIcon = "fa fa-envelope text-muted";
                        $seenLink = 'index.php?page=webmail&markAsRead=true&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                        // $seenTooltip = 'data-toggle="tooltip" data-container="body" title="'.$lang['MARK_AS_READ'].'" data-original-title="'.$lang['MARK_AS_READ'].'"';
                        $seenTooltip = '';
                        $messageLink = 'index.php?page=webmail-message&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                    }
                    else
                        {   // no markup required
                            $boldMarkupStart = "";
                            $boldMarkupEnd = "";
                            // $starIcon = "fa fa-star-o text-yellow";
                            $seenIcon = "fa fa-envelope-open-o text-muted";
                            $seenLink = 'index.php?page=webmail&markAsUnread=true&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
                            // $seenTooltip = 'data-toggle="tooltip" data-container="body" title="'.$lang['MARK_AS_UNSEEN'].'" data-original-title="'.$lang['MARK_AS_UNSEEN'].'"';
                            $seenTooltip = '';
                            $messageLink = 'index.php?page=webmail-message&folder='.$currentFolder.'&msgno='.$email->header->msgno.'';
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

                    // display every email as single table row
                    echo '
                        <tr id="emailRow">
                            <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                            <td class="mailbox-star"><a href="'.$seenLink.'"'.$seenTooltip.'><i class="'.$seenIcon.'"></i></a></td>
                            <td class="mailbox-name" style="cursor:pointer;" onclick="window.location=\''.$messageLink.'\';"><a href="#">'.$boldMarkupStart.$email->header->from.$boldMarkupEnd.'</a>
                            <br><small>'.$email->header->details->from[0]->mailbox.'@'.$email->header->details->from[0]->host.'</small></td>
                            <td class="mailbox-subject" style="cursor:pointer;" onclick="window.location=\''.$messageLink.'\';">'.$boldMarkupStart.$email->header->subject.$boldMarkupEnd.'</td>
                            <td class="mailbox-attachment text-center">'.$attachClip.'</td>
                            <td class="mailbox-date">'.$email->header->date.'<br><small>'.$timeAgo.'</small></td>
                        </tr>';
                }
            }
            else
            {
                // echo "<b>This folder is empty.</b>";
            }
        }
    } // ./class webmail
} // ./namespace