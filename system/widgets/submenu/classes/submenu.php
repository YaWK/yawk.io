<?php
namespace YAWK\WIDGETS\SUBMENU\EMBED
{
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
    class submenu extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $submenuHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $submenuSubtext = '';
        /** @param int ID of the menu to display */
        public $menuID = '';

        /**
         * @brief Load all widget settings from database and fill object
         * @param object $db Database Object
         * @brief Load all widget settings on object init.
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
            $menu->displaySubMenu($db, $this->menuID);
        }

    }
}
?>