<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\SIGNUP {
    /**
     * <b>backend helper functions for signup plugin.</b>
     * <p><i>This class covers backend functionality. See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @version    1.0.0
     * @brief Handles the Blog System.
     */
    class backend
    {
        /**
         * @brief allow user group to signup
         * @param object $db database
         * @param int $gid group ID to allow signup
         * @return bool
         */
        public static function setAllowedGroup($db, $gid)
        {   /** @var $db \YAWK\db */
            foreach ($gid as $id) {
                if ($id === '0')
                {
                    if (!$res = $db->query("UPDATE {user_groups} SET signup_allowed = '0'"))
                    {   // q failed
                        return false;
                    }
                }
                if (!$res = $db->query("UPDATE {user_groups} SET signup_allowed = 1 WHERE id = '".$id."'"))
                {
                    // q failed
                    return false;
                }
            }
            return true;
        }

        /**
         * @brief get user groups and draw select option value
         * @param object $db database
         * @return bool|null
         */
        static function getUserGroupSelector($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, value, signup_allowed FROM {user_groups}"))
            {
                echo "<option value=\"0\">none</option>";
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<option value=\"" . $row['id'] . "\"";
                    if ($row['signup_allowed'] === '1') {
                        echo " selected=\"selected\"";
                    }
                    echo ">" . $row['value'] . "</option>";
                }
                return null;
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief frontend? group selector
         * @param object $db database
         * @return bool
         */
        static function getGroupSelector($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, value FROM {user_groups}"))
            {
                echo "<option value=\"0\">default</option>";
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<option value=\"" . $row['id'] . "\">".$row['value']."</option>";
                }
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}