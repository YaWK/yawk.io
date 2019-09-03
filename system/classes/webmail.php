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
         * @param $imap resource The current imap handle
         * @param $folders array The mailbox folders as array
         */
        public function drawFolders($imap, $folders)
        {   // check if folder array is set
            if (is_array($folders) || (!empty($folders)))
            {
                // sort folder array to bring inbox more upwards
                ksort($folders);

                // init default active folder markup
                $activeMarkupDefault = '';

                // walk through folders and display them
                foreach ($folders as $folder => $item)
                {   // check if folder is requested via get param
                    if (isset($_GET['folder']) && (!empty($_GET['folder'])))
                    {   // check, if folder is active (current equals request)
                        if ($folder === $_GET['folder'])
                        {   // set markup to view as active
                            $activeMarkup = " class=\"active\"";
                        }
                        // not active, no markup
                        else { $activeMarkup = ''; }
                    }
                    else
                        {   // page called w/o requested folder, set default (inbox) as active
                            $activeMarkup = "";
                            $activeMarkupDefault = " class=\"active\"";
                        }

                    // count unread messages in current folder
                    $unreadMessages = $imap->countUnreadMessages();

                    // check folder value and set markup to display icons corresponding to the folder
                    if ($folder == "INBOX")
                    {   // set inbox icon
                        echo "<li".$activeMarkup.$activeMarkupDefault."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-inbox\"></i> $folder
                              <span class=\"label label-primary pull-right\">".$unreadMessages."</span></a></li>";
                    }

                    else if ($folder == "Sent")
                    {   // set sent icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-envelope-o\"></i> $folder</a></li>";
                    }

                    else if ($folder == "Drafts")
                    {   // set draft icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-file-text-o\"></i> ".$folder."</a></li>";
                    }

                    else if ($folder == "Junk")
                    {   // set junk icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-filter\"></i> ".$folder."</a></li>";
                    }

                    else if ($folder == "Trash")
                    {   // set trash icon
                        echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-trash-o\"></i> ".$folder."</a></li>";
                    }

                    else
                        {   // any other folder: default folder icon
                            echo "<li".$activeMarkup."><a href=\"index.php?page=webmail&folder=$folder\"><i class=\"fa fa-folder-o\"></i> ".$folder."</a></li>";
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
                    }
                    else
                        {   // no markup required
                            $boldMarkupStart = "";
                            $boldMarkupEnd = "";
                        }

                    // calculate human friendly time info
                    $timeAgo = \YAWK\sys::time_ago($email->header->date, $lang);

                    // display every email as single table row
                    echo '
                        <tr>
                            <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                            <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                            <td class="mailbox-name">'.$boldMarkupStart.'<a href="index.php?page=webmail-message&folder='.$currentFolder.'&msgno='.$email->header->msgno.'">'.$email->header->from.'</a>'.$boldMarkupEnd.'</td>
                            <td class="mailbox-subject">'.$boldMarkupStart.$email->header->subject.$boldMarkupEnd.'</td>
                            <td class="mailbox-attachment"></td>
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