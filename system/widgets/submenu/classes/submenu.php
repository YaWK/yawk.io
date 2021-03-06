<?php
namespace YAWK\WIDGETS\SUBMENU\EMBED
{
    /**
     * <b>Empty submenu Widget - for development and demo purpose</b>
     *
     * <p>If you want to embed any menu on any page in any position, this should be
     * the widget of your choice! It can handle every menu that you have created
     * before within YaWK's menu system.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Submenu widget - embed any menu on any page in any position
     */
    class submenu extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $submenuHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $submenuSubtext = '';
        /** @var int ID of the menu to display */
        public $menuID = '';

        /**
         * Load all widget settings from database and fill object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @annotation Load all widget settings on object init.
         */
        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * Init submenu widget and call a function for demo purpose
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation submenu Widget Init
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
            $menu->displaySubMenu($db, $this->menuID);
        }

    }
}
?>