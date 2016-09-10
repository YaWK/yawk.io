<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\SIGNUP {
    class backend
    {
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