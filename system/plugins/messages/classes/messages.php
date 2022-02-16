<?php
namespace YAWK\PLUGINS\MESSAGES {
    /**
     * <b>Messages Plugin</b>
     * <p>Basic Messaging functions. This class serve functions fetch and draw messages, inbox and so on</p>
     * <p><b>Basic Features:</b></p>
     * <ul>
     * <li>fetch all messages</li>
     * <li>fetch a single message</li>
     * <li>get Inbox Data</li>
     * <li>draw Inbox</li>
     * <li>mark messages as spam, read, unread</li>
     * <li>trash messages and many more</li></ul><br>
     * <p>This plugin is definitly still in development.</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @version    1.0.0/
     * @brief The Messages Plugin Class. Allow your users to write messages to each other.
     */
    class messages {
        /**
         * @brief messages constructor - check if class is called from frontend or backend
         * @param object $db database
         * @param string $location frontend or backend
         */
        public function __construct($db, $location)
        {
            if (isset($location) && (!empty($location)))
            {   // check where the script is called from...
                // get hostname
                $host = \YAWK\sys::getHost($db);
                if ($location === "backend")
                {   // backend: set directory prefix
                    $prefix = "../";
                }
                else if ($location === "frontend")
                {   // frontend: no prefix needed
                    $prefix = $host.'';
                }
                else {
                    // default:
                    $prefix = $host.'';
                }
            }
            else
            {   // if location is not set: no prefix as default
                $host = \YAWK\settings::getSetting($db, "host");
                $prefix = '';
            }

            echo "<script type=\"text/javascript\" src=\"$prefix"."system/plugins/messages/js/message-send.js\"></script>";
            echo "<script type='text/javascript'>
               function markAsSpam(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-spam.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                           $('#row-'+msg_id).css('color', '#610B0B').fadeToggle(400);
                        }
                    }
                    });
               }

               function markAsTrash(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-trash.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                           $('#row-'+msg_id).fadeToggle(400);
                        }
                    }
                    });
               }

               function closeMessage(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-read.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                           $('#messagebox').fadeToggle(400);
                           window.location.href = 'index.php?plugin=messages&pluginpage=mailbox';

                        }
                    }
                    });
               }

               function restoreFromTrash(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-restore-trash.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                           $('#row-'+msg_id).css('color', '#088A29').fadeToggle(400);
                        }
                    }
                    });
               }

               function markAsDeleted(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-delete.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                         $('#row-'+msg_id).css('color', '#FF0000').fadeToggle(400);
                        }
                    }
                    });
               }

               function markAsRead(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-read.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                            // $('#row-'+msg_id).toggleClass('bold', 'normal').fadeTo('fast', 0.8);
                            // $('#row-'+msg_id).toggleClass('normal', 'bold').fadeTo('fast', 1);
                            // $('#read-icon-'+msg_id).toggleClass('fa fa-envelope-o fa fa-envelope');
                        }
                    }
                    });
               }

               function messageToggle(msg_id)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-toggle.php',
                    type:'post',
                    data:'msg_id='+msg_id,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                             $('#row-'+msg_id).toggleClass('bold', 'normal').fadeTo('fast', 0.8);
                             $('#row-'+msg_id).toggleClass('normal', 'bold').fadeTo('fast', 1);
                             $('#read-icon-'+msg_id).toggleClass('fa fa-envelope-o fa fa-envelope');
                        }
                    }
                    });
               }
               function refreshInbox(type)
               {
                    $.ajax({
                    url:'$prefix"."system/plugins/messages/js/message-fetch.php',
                    type:'post',
                    data:'type='+type,
                    success:function(data){
                        if(! data ){
                            alert('Something went wrong!');
                            return false;
                        }
                        else {
                           // hide affected row
                            // alert('REFRESH! '+type);
                             //  $('#row-'+id).fadeOut(420);
                        }
                    }
                    });
               }

                  </script>
                  <style type='text/css'>
                  .bold { font-weight: bold; }
                  .normal { font-weight: normal; opacity: 0.6; }
                  </style> ";
        }

        /**
         * @brief init the messaging page - check if user is logged in, else draw a login box
         * @param object $db database
         * @return string
         */
        public function init($db, $lang)
        {
            /** @var \YAWK\db $db */
            // check if session vars exist
            if (!empty(@$_SESSION['username'] && (!empty(@$_SESSION['uid']))))
            {   // check if user is logged in
                if (\YAWK\user::isLoggedIn($db, $_SESSION['username']))
                {   // ok, load inbox
                    return self::getInbox($db, $lang);
                }
                else
                {   // session vars are here, but user is not set online in db atm,
                    // that should not be, so invite the user to login
                    echo "<h2>$lang[REGISTERED_ONLY]</h2>";
                    return \YAWK\user::drawLoginBox('', '');
                }
            }
            else
            {   // session vars are not set. invite the user to login
                echo "<h2>$lang[REGISTERED_ONLY]</h2>";
                return \YAWK\user::drawLoginBox('', '');
            }
        }

        /**
         * @brief get inbox and draw menu
         * @param object $db database
         * @return string
         */
        public function getInbox($db, $lang){
            $html = "";
            $html .= self::drawMenu($db, $lang);
            return $html;
        }

        /**
         * @brief fetch messages into array
         * @param object $db database
         * @param string $type all, trash or spam
         * @return array|string
         */
        public function fetchMessages($db, $type){
            /** @var $db \YAWK\db */
            $sql = '';
            if (isset($_SESSION['username']) && isset($_SESSION['uid'])) {
                $username = $_SESSION['username'];
                $uid = $_SESSION['uid'];

                if ($type === "all")
                {
                    $sql = $db->query("SELECT * FROM {plugin_msg} AS msg
                                       LEFT JOIN {users} AS u ON msg.fromUID=u.id
                                       WHERE toUID = '".$uid."' AND trash ='0' AND spam ='0'
                                       ORDER BY msg_read,msg_date DESC");
                }
                elseif ($type === "trash")
                {
                    $sql = $db->query("SELECT * FROM {plugin_msg} AS msg
                                       LEFT JOIN {users} AS u ON msg.fromUID=u.id
                                       WHERE toUID = '".$uid."' AND trash ='1' AND spam ='0'
                                       ORDER BY msg_read,msg_date DESC");
                }
                elseif ($type === "spam")
                {
                    $sql = $db->query("SELECT * FROM {plugin_msg} AS msg
                                       LEFT JOIN {users} AS u ON msg.fromUID=u.id
                                       WHERE toUID = '".$uid."' AND trash ='0' AND spam ='1'
                                       ORDER BY msg_read,msg_date DESC");
                }

                $messages = array();
                while ($row = mysqli_fetch_assoc($sql)){
                    $messages[] = $row;
                }
                return $messages;
            }
            else {
                return "Something strange has happened. Are you logged in? Please re-login.";
            }
        }

        /**
         * @brief fetch a single message from database
         * @param object $db database
         * @param int $msg_id the message ID to get
         * @return array|null
         */
        public function fetchSingleMessage($db, $msg_id)
        {   /** @var $db \YAWK\db */
            $sql = $db->query("SELECT * FROM {plugin_msg} WHERE msg_id = '".$msg_id."'");
            $row = mysqli_fetch_assoc($sql);
            return $row;
        }


        /**
         * @brief fetch related messages into array
         * @param object $db database
         * @param int $fromUID from user ID
         * @param int $toUID to user ID
         * @param int $msg_id message ID
         * @return array|string
         */
        public function fetchRelatedMessages($db, $fromUID, $toUID, $msg_id)
        {   /** @var $db \YAWK\db */
            // query related messages from db
            if ($sql = $db->query("SELECT * FROM {plugin_msg} AS msg
                                        LEFT JOIN {users} AS u ON msg.fromUID=u.id
                                        WHERE fromUID = '".$fromUID."' AND msg_id NOT LIKE '".$msg_id."' AND toUID ='".$toUID."' AND trash ='0' AND spam ='0'
                                        ORDER BY msg_read,msg_date DESC"))
            {   // create messages array
                $relatedMessages = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // fill array with data...
                    $relatedMessages[] = $row;
                }
                // return related messages
                return $relatedMessages;
            }
            else
            {   // q failed...
                return "Could not fetch more related messages from this user.";
            }
        }

        /**
         * @brief draw html (output) related messages from array, each message as own box
         * @param object $db database
         * @param array $relatedMessages related messages array
         * @return string
         */
        public function drawRelatedMessages($db, $relatedMessages, $lang)
        {   /** @var $db \YAWK\db */
            $i = '';
            $html = '';
            if (isset($relatedMessages) && is_array($relatedMessages))
            {   // if array is set, loop data
                foreach ($relatedMessages as $relatedMessage)
                {   // count related messages
                    $i++;
                    // build message data
                    $from = \YAWK\user::getUserNameFromID($db, $relatedMessage['fromUID']);
                    $picture = \YAWK\user::getUserImage("backend", $from, "img-circle", 64, 64);
                    $timeAgo = \YAWK\sys::time_ago($relatedMessage['msg_date'], $lang);
                    $splitDate = \YAWK\sys::splitDateShort($relatedMessage['msg_date']);
                    $html .= "
                     <div class=\"box box-primary\">
                       <div class=\"box-header with-border\">
                         <h3 class=\"box-title\">$picture &nbsp;$lang[MESSAGE] $lang[FROM] <b>$from</b> $timeAgo <small>($splitDate[month], $splitDate[day] $splitDate[year], $splitDate[time])</small> </h3>
                         <div class=\"box-tools pull-right\">
                           <span class=\"label label-primary\">$relatedMessage[msg_date]</span>
                           <button class=\"btn btn-box-tool\" data-widget=\"remove\" onclick=\"closeMessage('$relatedMessage[msg_id]')\" data-toggle=\"tooltip\" title=\"$lang[CLOSE]\"><i class=\"fa fa-times\"></i></button>
                         </div>
                         <div class=\"box-body\">
                            <h3>$relatedMessage[msg_body]</h3><hr>
                         </div>
                       </div>
                     </div>";
                }
                return $html;
            }
        }

        /**
         * @brief view messages
         * @param object $db database
         * @param int $msg_id message ID
         * @return string
         */
        public function MessageView($db, $msg_id, $lang)
        {
            $message = self::fetchSingleMessage($db, $msg_id);
            $from = \YAWK\user::getUserNameFromID($db, $message['fromUID']);
            $picture = \YAWK\user::getUserImage("backend", $from, "img-circle", 64, 64);
            $timeAgo = \YAWK\sys::time_ago($message['msg_date'], $lang);
            $splitDate = \YAWK\sys::splitDateShort($message['msg_date']);
            self::markAsRead($db, $msg_id);

            $html = "<br><br><br>
            <div class=\"row\">
             <div class=\"col-md-8\"><div class=\"box box-primary\">
                       <div class=\"box-header with-border\">
                         <h3 class=\"box-title\">$picture &nbsp;$lang[MESSAGE] $lang[FROM] <b><a href=\"index.php?page=user-edit&user=$from\">$from</a></b> $timeAgo <small>($splitDate[month], $splitDate[day] $splitDate[year], $splitDate[time])</small> </h3>
                         <div class=\"box-tools pull-right\">
                           <span class=\"label label-primary\">$message[msg_date]</span>
                           <button class=\"btn btn-box-tool\" data-widget=\"remove\" onclick=\"closeMessage('$message[msg_id]')\" data-toggle=\"tooltip\" title=\"$lang[CLOSE]\"><i class=\"fa fa-times\"></i></button>
                         </div>
                         <div class=\"box-body\"><h3>$message[msg_body]</h3><hr></div></div></div></div>
            <div class=\"col-md-4\" id=\"messagebox\">";
            $html .= self::drawNewMessage($from, $lang); $html .="</div>
            </div>";

            $html .= "
            <div class=\"row\">
              <div class=\"col-md-8\">";
            $html .= self::drawRelatedMessages($db, self::fetchRelatedMessages($db, $message['fromUID'], $message['toUID'], $message['msg_id']), $lang);

            $html .= "</div>
              <div class=\"col-md-4\">&nbsp;</div>
            </div>";
            return $html;
        }

        /**
         * @brief draw the complete Inbox
         * @param string $type spam, trash or all
         * @param array $messages messages array
         * @return string
         */
        public function drawInbox($type, $messages, $lang){
            $html = "<table class='table table-striped' id=\"table-sort\">
                     <tr style='font-weight:bold;' class='small'>
                        <td width='15%'>$lang[DATE]</td>
                        <td width='25%'>$lang[FROM] $lang[USER]</td>
                        <td width='50%'>$lang[MESSAGE] <small>($lang[PREVIEW])</small></td>
                        <td width='20%' style=\"text-align: center;\">$lang[ACTIONS]</td>
                     </tr>";
            foreach ($messages as $email){
                if ($email['msg_read'] === '0') { $style = "bold"; $envelope = "fa fa-envelope"; }
                if ($email['msg_read'] === '1') { $style = "normal"; $envelope = "fa fa-envelope-o"; }

                if ($type === "trash" || $type === "spam")
                {
                    if ($type === "spam")
                    {
                        $style = "text-danger";
                        $spam_icon = '';
                        $spam_action = '';
                        $spam_title = '';
                    }

                    if ($type === "trash")
                    {
                        $spam_icon = '';
                        $spam_action = '';
                        $spam_title = '';
                    }

                    $reply_icon = '';
                    $reply_action = '';
                    $reply_title = '';

                    $revert_icon = "fa fa-undo";
                    $revert_action = "restoreFromTrash('$email[msg_id]')";
                    $revert_title = "$lang[RESTORE_MSG]";

                    $trash_icon = "fa fa-trash";
                    $trash_action = "markAsDeleted('$email[msg_id]')";
                    $trash_title = "$lang[DEL_MSG]";
                }
                else
                {
                    $revert_icon = $envelope;
                    $revert_action = "messageToggle('$email[msg_id]')";
                    $revert_title = "$lang[MARK_AS_READ]";

                    $trash_icon = "fa fa-trash-o";
                    $trash_action = "markAsTrash('$email[msg_id]')";
                    $trash_title = "$lang[MOVE_TO_TRASH]";

                    // $reply_icon = "fa fa-reply";
                    // $reply_action = "replyMessage('$email[msg_id]')";
                    // $reply_title = "reply";
                    // <i id=\"reply-$email[msg_id]\" class=\"$reply_icon\" onclick=\"$reply_action\" title=\"$reply_title\"></i>&nbsp;


                    $spam_icon = "fa fa-user-secret";
                    $spam_action = "markAsSpam('$email[msg_id]')";
                    $spam_title = "$lang[MARK_AS_SPAM]";
                }
                $msg_preview = substr($email['msg_body'],0 -64);
                $html .= "
                          <tr id=\"row-$email[msg_id]\" class=\"$style\">
                            <td>$email[msg_date]</td>
                            <td><a href=\"index.php?plugin=messages&pluginpage=mailbox&msg_id=$email[msg_id]\"><div style=\"width:100%\">$email[username]</div></a></td>
                            <td><a href=\"index.php?plugin=messages&pluginpage=mailbox&msg_id=$email[msg_id]\"><div style=\"width:100%\">$msg_preview <small>[...]</small></div></a></td>
                            <td style=\"text-align:center\">
                                <i id=\"read-icon-$email[msg_id]\" class=\"$revert_icon\" onclick=\"$revert_action\" title=\"$revert_title\"></i>&nbsp;
                                <i class=\"$trash_icon\" onclick=\"$trash_action\" title=\"$trash_title\"></i>&nbsp;
                                <i class=\"$spam_icon\" onclick=\"$spam_action\" title=\"$spam_title\"></i>&nbsp;</td>
                          </tr>";
            }
            $html .= "</table>";
            return $html;
        }

        /**
         * @brief draw html (output) messages menu
         * @param object $db database
         * @return string
         */
        public function drawMenu($db, $lang)
        {   // check if there is an active tab request
            if (isset($_GET['active']) && (!empty($_GET['active'])))
            {   // switch vars
                switch ($_GET['active'])
                {   // set inbox as active tab
                    case "inbox":
                        $active_inbox = "class=\"active\"";
                        $active_inbox_tab_pane = 'class="tab-pane active"';
                        $active_compose = '';
                        $active_compose_tab_pane = 'tab-pane';
                        break;
                    // set compose as active tab
                    case "compose":
                        $active_inbox = '';
                        $active_inbox_tab_pane = 'class="tab-pane"';
                        $active_compose = "class=\"active\"";
                        $active_compose_tab_pane = "class='tab-pane active'";
                }
            }
            else
            {   // set inbox as default active tab
                $active_inbox = "class=\"active\"";
                $active_inbox_tab_pane = 'class="tab-pane active"';
                $active_compose = '';
                $active_compose_tab_pane = "class='tab-pane'";
            }
            $html = "<div>
          <!-- Nav tabs -->
          <ul class=\"nav nav-tabs\" role=\"tablist\">
            <li role=\"presentation\" $active_inbox onclick=\"refreshInbox('all')\"><a href=\"#inbox\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-envelope-o\"></i> &nbsp;$lang[INBOX]</a></li>

            <li role=\"presentation\" $active_compose><a href=\"#newmessage\" aria-controls=\"newmessage\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-plus-square-o\"></i> &nbsp;$lang[MESSAGE]</a></li>

            <li role=\"presentation\"><a href=\"#trash\" aria-controls=\"messages\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-trash-o\"></i> &nbsp;$lang[RECYCLE_BIN]</a></li>

            <li role=\"presentation\"><a href=\"#spam\" aria-controls=\"messages\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-user-secret\"></i> &nbsp;$lang[SPAM]</a></li>
          </ul>

          <!-- Tab panes -->
          <div class=\"tab-content\">

            <!-- inbox -->
            <div role=\"tabpanel\" $active_inbox_tab_pane id=\"inbox\">
            <h4><i class=\"fa fa-envelope-o fa-2x\"></i> &nbsp;$lang[INBOX]</h4>";
            // get inbox
            $html .= self::drawInbox('all', self::fetchMessages($db, 'all'), $lang);
            $html .= "
            </div>

            <!-- new msg -->
            <div role=\"tabpanel\" $active_compose_tab_pane id=\"newmessage\">
            <h4><i class=\"fa fa-envelope fa-2x\"></i> &nbsp;$lang[MSG_COMPOSE]</h4>";
            // get new message form
            $html .= self::drawNewMessage('', $lang);
            $html .= "</div>
            <!-- trash -->
            <div role=\"tabpanel\" class=\"tab-pane\" id=\"trash\">
            <h4><i class=\"fa fa-trash fa-2x\"></i> &nbsp;$lang[RECYCLE_BIN_HEADING]</h4>";
            // get trashed items
            $html .= self::drawInbox('trash', self::fetchMessages($db, 'trash'), $lang);
            $html .="</div>
            <!-- spam -->
            <div role=\"tabpanel\" class=\"tab-pane\" id=\"spam\">
            <h4><i class=\"fa fa-user-secret fa-2x\"></i> &nbsp;$lang[SPAM_HEADING]</h4>";
            // get spam items
            $html .= self::drawInbox('spam', self::fetchMessages($db, 'spam'), $lang);
            $html .= "</div>
          </div>
        </div>";
            return $html;
        }

        /**
         * @brief draw a new message
         * @param string $to username to send
         * @return string message fieldset
         */
        public function drawNewMessage($to, $lang){
            $key = "U3E44ERG0H0M3";
            if (isset($_GET['to']) && (!empty($_GET['to'])))
            {   // set new message recipient from given GET var
                $to= $_GET['to'];
            }
            if (isset($to) && (!empty($to)))
            {
                $replyLabel = "$lang[REPLY_TO]";
                $msg_to = "value=\"$to\"";
            }
            else
            {
                $replyLabel = "$lang[RECIPIENT_USERNAME]";
                $msg_to = '';
            }
            return "
                    <fieldset id=\"comment_thread\" class=\"animated zoomInDown\">
                      <label for=\"msg_to\">$replyLabel</label> <input id=\"msg_to\" type=\"text\" $msg_to class=\"form-control\" name=\"msg_to\" size=\"16\" placeholder=\"to:\" maxlength=\"64\">
                      <label for=\"msg_body\">$lang[YOUR_MSG]</label> <textarea id=\"msg_body\" name=\"msg_body\" class=\"form-control\" cols=\"68\" rows=\"12\"></textarea><br>
                      <input type=\"button\" class=\"btn btn-success\" id=\"submit_post\" name=\"save_comment\" title=\"$lang[SEND]\" value=\"$lang[MSG_SEND_BTN]\">
                      <input type=\"hidden\" name=\"msg_from\" value=\"$_SESSION[username]\" id=\"msg_from\">
                      <input type=\"hidden\" name=\"fromUID\" value=\"$_SESSION[uid]\" id=\"fromUID\">
                      <input type=\"hidden\" name=\"token\" value=\"".$key."\" id=\"token\">
                      </fieldset>
                    ";
        }

        /**
         * @brief mark a message as read
         * @param object $db database
         * @param int $msg_id message ID
         * @return bool
         */
        public function markAsRead($db, $msg_id)
        {   /** @var $db \YAWK\db */
            if ($db->query("UPDATE {plugin_msg} SET msg_read = '1' WHERE msg_id = '".$msg_id."'"))
            {   // marked as read
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }
    }
}