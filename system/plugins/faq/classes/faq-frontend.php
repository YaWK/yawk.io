<?php
namespace YAWK\PLUGINS\FAQ {
    /**
     * @details <b>Frontend FAQ Class</b>
     * <p>This class extends \YAWK\PLUGINS\FAQ\faq.</p>
     * <p><i>This class covers frontend functionality. See Methods Summary for Details!</i></p>
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @version    1.0.0
     * @brief Handles the FAQ Frontend methods.
     */
    class frontend extends \YAWK\PLUGINS\FAQ\faq {
        /** * @param int faq ID */
        public $id;
        /** * @param int category ID */
        public $cat;
        /** * @param string question */
        public $question;
        /** * @param string answer */
        public $answer;

        /**
         * @brief get all data from faq database and draw (output) a html list with all FAQ's
         * @param object $db database
         */
        function draw_faq($db) {
            /** @var $db \YAWK\db */
            echo "<h1><i class=\"fa fa-question-circle\"></i> &nbsp;F.A.Q. <small>H&auml;ufig gestellte Fragen &amp; Antworten...</small></h1><br>";
            if ($res = $db->query("SELECT * FROM {plugin_faq} ORDER by sort,id"))
            {   // get faq as html list item in loop
                while($row = mysqli_fetch_assoc($res))
                {   // 1 list item per FAQ entry
                    print "<ul class=\"list-group\">
                        <li class=\"list-group-item\"><h4>".$row['question']."</h4>".$row['answer']."<br><br></li>
                       </ul>";
                }
            }
            else
            {   // q failed
                \YAWK\alert::draw("danger", "Error!", "Could not get FAQ Entries. This could be a database error.","","2400");
            }
        } // end function

    } // end class
} // end namespace
