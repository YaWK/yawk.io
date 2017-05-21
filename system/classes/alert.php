<?php
namespace YAWK {
    /**
     * <b>Throw default bootstrap-powered alerts. (warning, succes etc...)</b>
     *
     * This lets you throw a fancy designed alert message box at any
     * time, anywhere in your script. Alert uses 5 Arguments, as shown below.
     * <i>Example:</i>
     * <code><?php YAWK\alert::draw("success", "Yey!", "Test Alert thrown! It worked!", "index.html", 5000); ?></code> at
     * any place of your script where an error, info, success or danger Message
     * needs to be thrown.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.2.0
     * @link       http://yawk.website/
     * @since      File available since Release 1.0.0
     * @annotation Throws a fancy Bootstrap Alert (success, info, warning or danger)
     *
     */

    class alert {

        /**
         * draw a fancy alert notification
         *
         * @param string $type Bootstrap class: success, warning, danger, info or default
         * @param string $title Title of the notification box, drawn in h4
         * @param string $text The Message Text of your notification. You can use HTML tags to format it.
         * @param string $redirect URL to redirect the user via setTimeOut delay(ms). Leave empty if you just want to put on a message, but dont want to redirect the user.
         * @param int $delay How long should the notification stay on top before it hides respectively redirect. Leave empty if it should stay on top forevermore.
         *
         */
        static function draw($type, $title, $text, $redirect, $delay){
            if (empty($type)) { $type="danger"; }
            if (empty($title)) { $title="ERROR!"; }
            if (empty($text)) { $text="Something strange has happened. Sorry that there is no more Information available. (Code 0)"; }
            if (empty($redirect)) { $redirect="null"; }
            if (empty($delay)) { $delay="null"; }

            if ($redirect === "null" && ($delay !== "null"))
            {
                $n_delay = $delay;
            }
            else {
                // calculate delay time for notify before redirect
                $n_delay = $delay;
                $n_delay = $n_delay / 2.5;
                $n_delay = round($n_delay);
            }

            if ($delay === "null")
            {
                $n_delay = "null";
            }

            // switch icon
            switch ($type)
            {
                case "danger":
                    $icon = "fa fa-exclamation-triangle";
                    break;
                case "warning":
                    $icon = "fa fa-flash";
                    break;
                case "success":
                    $icon = "fa fa-check-circle-o";
                    break;
                case "default":
                    $icon = "fa fa-info-circle";
                    break;
                default:
                    $icon = "fa fa-info-circle";
                    break;
            }

            // run notify javascript
            echo "
  <script type=\"text/javascript\">
    $.notify({
        // options
        title: '<h4><i class=\"$icon\"></i>&nbsp; $title</h4>',
        message: '$text',
        url: '#',
        target: '_blank'
    }, {
        // settings
        type: '$type',
        element: 'body',
        position: null,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: 'top',
            align: 'center'
        },
        offset: {
            x: 10,
            y: 62
        },
        spacing: 10,
        z_index: 9999,
        delay: '$n_delay',
        timer: 420,
        url_target: '_blank',
        mouse_over: 'pause',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }
    });
  </script>";

            if ($redirect !== "null" && ($delay !== "null"))
            {
                // redirect after notify with given delay param
                return \YAWK\sys::setTimeout("index.php?$redirect", $delay);
            }
            else {
                return null;
            }
        } // ./draw
    } // ./class alert
} // ./namespace