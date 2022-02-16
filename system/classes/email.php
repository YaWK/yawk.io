<?php
namespace YAWK {
    /**
     * @details <b>send an email.</b>
     *
     * handles the email functions. main method is<br>
     * <i>Example:</i>
     * <code><?php YAWK\email::sendEmail($email_from, $email_to, $email_cc, $email_subject, $email_message); ?></code>
     * Call this anytime when you need to send an email.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Email class serve function sendEmail() to send email
     */
    class email
    {

        /**
         * @brief send an email
         * @param string $email_from
         * @param string $email_to
         * @param string $email_cc
         * @param string $email_subject
         * @param string $email_message
         * @return bool
         */
        static function sendEmail($email_from, $email_to, $email_cc, $email_subject, $email_message)
        {
            /* SEND EMAIL WITH GIVEN PARAMS */

            /* trim fields */
            $email_from = trim($email_from);
            $email_to = trim($email_to);
            $email_cc = trim($email_cc);
            $email_subject = trim($email_subject);
            $email_message = trim($email_message);

            if (!isset($email_cc) || (empty($email_cc)))
            {
                $email_cc = false;
            }

            /* validate email_to adress with regex */
            $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
            if (!preg_match($email_exp, $email_from)) {
                // echo 'Die Emailadresse scheint nicht korrekt zu sein. Tippfehler?<br /><br /><br />';
                // exit;
            }

            /* build email header */
            $headers = 'From: ' . $email_from . "\r\n" .
                'Reply-To: ' . $email_from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if ($email_cc === TRUE)
            {
                /* send email to website admin */
                $sent = @mail($email_to, $email_subject, $email_message, $headers);
                /* send email copy to user */
                $sent = @mail($email_from, $email_subject, $email_message, $headers);
            }
            else
                {
                    /* just send email to website admin */
                    $sent = @mail($email_to, $email_subject, $email_message, $headers);
                }
            if ($sent)
            {
                return true;
            }
            else
            {
                // sending failed
                /*
                if(!isset($db) || (empty($db)))
                {
                    $db = new \YAWK\db();
                }
                \YAWK\sys::setSyslog($db, 15, 1, "send email to $email_to failed", 0, 0, 0, 0);
                */
                return false;
            }

        } /* end function sendEmail(); */
    } /* end class Email */
}
