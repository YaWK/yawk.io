<?php
namespace YAWK\WIDGETS\SUBMENU\EMBED
{
    use YAWK\db;
    use YAWK\widget;

    /**
     * @details<b>Empty submenu Widget - for development and demo purpose</b>
     *
     * <p>If you want to embed any menu on any page in any position, this should be
     * the widget of your choice! It can handle every menu that you have created
     * before within YaWK's menu system.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Submenu widget - embed any menu on any page in any position
     */
    class submenu extends widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $submenuHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $submenuSubtext = '';
        /** @param int ID of the menu to display */
        public $menuID = '';

        /** * @param string the class that is applied to the subMenu  */
        public $subMenuClass;

        /** * @param string the class that is applied to a subMenu Item  */
        public $subMenuItemClass;

        /**
         * @brief display any subMenu (used by widgets to get any menu in any position)
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menuID the menuID to get data
         */


        /**
         * @brief Load all widget settings from database and fill object
         * @param object $db Database Object
         * @brief Load all widget settings on object init.
         */
        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * @brief Init submenu widget and call a function for demo purpose
         * @brief submenu Widget Init
         */
        public function init($db)
        {
            // draw headline
            echo $this->getHeading($this->submenuHeading, $this->submenuSubtext);
            $this->drawMenu($db);
        }

        public function drawMenu($db)
        {
            // check if menu obj is set
            if (!isset($menu))
            {
                require_once 'system/classes/menu.php';
                $menu = new \YAWK\menu();
            }
            $this->displaySubMenu($db, $this->menuID);
        }

        public function displaySubMenu($db, $menuID)
        {   /** @param db $db */
            // get menu entries and draw navbar
            $res = $db->query("SELECT * FROM {menu}
                               WHERE published = 1 
                               AND menuID = '".$menuID."' 
                               ORDER by sort, title");

            $subMenuItem = '';
            while ($row = mysqli_fetch_assoc($res))
            {
                // check if target is set
                if (!empty($row['target']))
                {   // target is set
                    $row['target'] = ' target="'.$row['target'].'"';
                }
                else
                {   // target is not set
                    $row['target'] = '';
                }

                // check if subMenu class is set
                if (!empty($this->subMenuClass)){
                    $subMenuClass = ' class="'.$this->subMenuClass.'"';
                }
                else
                {   // subMenuClass is not set
                    $subMenuClass = '';
                }

                // check if icon is set
                if (isset($row['icon']))
                {   // set icon markup
                    $icon = '<i class="'.$row["icon"].' text-muted"></i>';
                }
                else
                {   // no icon set
                    $icon = "";
                }

                $subMenuItem .= '<li class="list-group-item">'.$icon.' &nbsp;&nbsp;<a href="'.$row['href'].'" class="hvr-grow"'.$row['target'].'>'.$row['text'].'</a></li>';
            }
            echo '<div id="subMenu"'.$subMenuClass.'>
                    <ul class="list-group" style="cursor:pointer;">';
            echo '    '.$subMenuItem.'</ul>
                  </div>';
        }


    }
}
?>