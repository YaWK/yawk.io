<?php
namespace YAWK\PLUGINS\FAQ {
    /**
     * @details <b>Build FAQ's for your users.</b>
     * <p>FAQs are useful. Beware to underrate this. You can answer the most interesting questions
     * before your user even ask. This saves time - your website should be informative. If you answer
     * a question on your website, users may not need to ask your email or phone support. If you do
     * it clever, this could be a big selling helper for you!</p>
     * <p><i>This class covers backend functionality. See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @version    1.0.0
     * @brief Handles the FAQ backend methods.
     */
    class faq {
        /** * @param int faq ID */
        public $id;
        /** * @param int order sortation number */
        public $sort;
        /** * @param int category ID */
        public $cat;
        /** * @param string question */
        public $question;
        /** * @param string answer */
        public $answer;
        /** * @param int 0|1 published or not */
        public $published;

        /**
         * @brief get all FAQ data and draw (output) as html table
         * @param object $db database
         */
        function drawBackEndTableBody($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {plugin_faq} ORDER BY id"))
            {   // fetch data in loop
                while ($row = mysqli_fetch_assoc($res))
                {   // set object properties
                    $this->id = $row['id'];
                    $this->sort = $row['sort'];
                    $this->published = $row['published'];
                    $this->cat = $row['cat'];
                    $this->question = $row['question'];
                    $this->answer = $row['answer'];

                    // get published status
                    if ($row['published'] == 1)
                    {   // published
                        $pub = "success";
                        $pubtext = "On";
                    }
                    else
                    {   // not published
                        $pub = "danger";
                        $pubtext = "Off";
                    }

                    echo "<tr>
              <td><a href=\"index.php?plugin=faq&pluginpage=faq-toggleitem&published=" . $this->published . "&id=" . $this->id . "\">
                <span class=\"label label-$pub\">$pubtext</span></a></td>
              <td class=\"text-center\">$this->id</td>
              <td class=\"text-center\">$this->sort</td>
              <td><a href=\"index.php?plugin=faq&pluginpage=faq-edit&id=".$this->id."\"><b>$this->question</a></b><br><small>$this->answer</small></td>
              <td class=\"text-center\">$this->cat</td>
              <td class=\"text-center\">
              <a class=\"fa fa-edit\" title=\"edit\" href=\"index.php?plugin=faq&pluginpage=faq-edit&id=" . $this->id . "\"></a>&nbsp;
              <a class=\"fa fa-trash\" data-confirm=\"Soll der Eintrag &laquo;" . $this->id . " - " . $this->question . " &raquo; wirklich gel&ouml;scht werden?\"
              title=\"DELETE ".$this->id."\" href=\"index.php?plugin=faq&pluginpage=faq-delete&delete=1&id=".$this->id."\">
                  </a>
               </td>
          </tr>";
                }
            }
        }

        /**
         * @brief create a new question
         * @param object $db database
         * @param string $question question
         * @param string $answer answer
         * @return bool|mixed
         */
        function create($db, $question, $answer)
        {   /** @var $db \YAWK\db */
                if ($res = $db->query("INSERT INTO {plugin_faq}
                                       (sort, question , answer)
	                        VALUES('" . $this->sort . "',
	                        '" . $question . "',
	                        '" . $answer . "')"))
                {   // success
                    return true;
                }
                else
                {
                    // q failed
                    return false;
                }
        }

        /**
         * @brief delete an FAQ entry
         * @param object $db database
         * @param int $id faq ID to delete
         * @return bool|mixed
         */
        function delete($db, $id)
        {   /** @var $db \YAWK\db */
            // remove data from db
            if ($res = $db->query("DELETE FROM {plugin_faq} WHERE id = '" . $id . "'"))
            {   // success
                return $res;
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief save (update) an faq entry
         * @param object $db database
         * @return bool
         */
        function save($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("UPDATE {plugin_faq} SET
                    sort = '" . $this->sort . "',
                    question = '" . $this->question . "',
                    answer = '" . $this->answer . "'
                    WHERE id = '" . $this->id . "'"))
            {   // success
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief load faq item properties into faq object
         * @param object $db database
         * @param int $id affected faq ID
         * @return bool
         */
        function loadItemProperties($db, $id)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {plugin_faq}
                        WHERE id = '" . $id . "'"))
            {
                if ($row = mysqli_fetch_assoc($res))
                {   // set object vars
                $this->id = $row['id'];
                $this->sort = $row['sort'];
                $this->question = $row['question'];
                $this->answer = $row['answer'];
                return true;
                }
                else
                {   // fetch failed
                    return false;
                }
            }
            else
            {   // q failed
                return false;
            }
        }
    } // end class
} // end namespace
