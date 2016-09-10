<?php
namespace YAWK\PLUGINS\FAQ {
include 'system/classes/db.php';
    class frontend extends \YAWK\PLUGINS\FAQ\faq {
        public $id;
        public $cat;
        public $question;
        public $answer;

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
