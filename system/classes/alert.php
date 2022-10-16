<?php
namespace YAWK {
    /**
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl www.yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @brief      Throws a fancy Bootstrap Alert (success, info, warning or danger)
     * @details    Throw default bootstrap-powered alerts. (warning, succes etc...)
     * This lets you throw an alert message box at any time, anywhere in your script.
     * Alert uses 5 Arguments, as shown below. Example: any place of your script where
     * an error, info, success or danger Message needs to be thrown.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     */

    class alert
    {
        /**
         * @brief draw a fancy alert notification
         * @param string $type Bootstrap class: success, warning, danger, info or default
         * @param string $title Title of the notification box, drawn in h4
         * @param string $text The Message Text of your notification. You can use HTML tags to format it.
         * @param string $redirect URL to redirect the user via setTimeOut delay(ms). Leave empty if you just want to put on a message, but dont want to redirect the user.
         * @param int $delay How long should the notification stay on top before it hides respectively redirect. Leave empty if it should stay on top forevermore.
         * @example <?php YAWK\alert::draw("success", "Yey!", "Test Alert thrown! It worked!", "index.html", 5000); ?>
         *
         */
        static function draw($type, $title, $text, $redirect, $delay)
        {

            // default animation when alert pops in
            $animatedEnter = "animated fadeInDown";
            // default animation when alert pops out
            $animatedExit = "animated fadeOutUp";
            // default placementFrom (top, bottom)
            $placementFrom = "top";
            // default placementFrom (left, center, right)
            $placementAlign = "center";
            // any URL to link to
            $url = "";
            // URL target
            $urlTarget = "_blank";
            // should it be allowed to dismiss this alert?
            $allowDismiss = "true";
            // display newest on top if there are more simultaneous alerts?
            $newestOnTop = "false";
            // display a progressbar to show how long the alert will stay
            $progressBar = "false";
            // offest X axis
            $offsetX = "10";
            // offest Y axis
            $offsetY = "62";
            // spacing
            $spacing = "10";
            // z-index
            $zIndex = "9999";
            // icon
            $icon = "fa fa-info-circle";

            if (!isset($type) || (empty($type)))
            {
                $type = "info";
            }
            if (!isset($title) || (empty($title)))
            {
                $title = "";
            }
            if (!isset($text) || (empty($text)))
            {
                $text = "";
            }
            if (!isset($redirect) || (empty($redirect)))
            {
                $redirect = "";
            }
            if (!isset($delay) || (empty($delay)))
            {
                $delay = 0;
            }

            if (empty($type)) { $type="danger"; }
            if (empty($title)) { $title="ERROR!"; }
            if (empty($text)) { $text="Something strange has happened. Text is empty. Sorry that there is no more Information available. (Code 0)"; }
            if (empty($redirect)) { $redirect="null"; }
            if (empty($delay)) { $delay="null"; }

            if ($redirect === "null" && ($delay !== "null"))
            {
                $n_delay = $delay;
            }
            else {
                // calculate delay time for notify before redirect
                $n_delay = $delay;
                if (is_int($n_delay)){
                    $n_delay = $n_delay / 3;
                    $n_delay = round($n_delay);
                }
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
                case "tipofday":
                    $icon = "fa fa-lightbulb-o";
                    $type = "success";
                    $animatedEnter = "animated fadeInRight";
                    $animatedExit = "animated fadeOutRight";
                    $placementFrom = "top";
                    $placementAlign = "right";
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
        url: '$url',
        target: '$urlTarget'
    }, {
        // settings
        type: '$type',
        element: 'body',
        position: null,
        allow_dismiss: '$allowDismiss',
        newest_on_top: '$newestOnTop',
        showProgressbar: $progressBar,
        placement: {
            from: '$placementFrom',
            align: '$placementAlign'
        },
        offset: {
            x: $offsetX,
            y: $offsetY
        },
        spacing: $spacing,
        z_index: $zIndex,
        delay: '$n_delay',
        timer: 420,
        url_target: '$urlTarget',
        mouse_over: 'pause',
        animate: {
            enter: '$animatedEnter',
            exit: '$animatedExit'
        }
    });
  </script>";

            if ($redirect !== "null" && ($delay !== "null"))
            {
                // redirect after notify with given delay param
                return \YAWK\sys::setTimeout("index.php?$redirect", $delay);
            }
            else
            {
                return null;
            }
        } // ./draw
    } // ./class alert
} // ./namespace