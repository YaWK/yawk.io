<?php
namespace YAWK\PLUGINS\FAQ {
    /**
     * <b>Frontend FAQ Class</b>
     * <p>This class extends \YAWK\PLUGINS\FAQ\faq.</p>
     * <p><i>This class covers frontend functionality. See Methods Summary for Details!</i></p>
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Handles the Blog System.
     */
    class frontend extends \YAWK\PLUGINS\FAQ\faq {
        /** * @var int faq ID */
        public $id;
        /** * @var int category ID */
        public $cat;
        /** * @var string question */
        public $question;
        /** * @var string answer */
        public $answer;

        /**
         * get all data from faq database and draw (output) a html list with all FAQ's
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
