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
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public string $submenuHeading = '';
        /** @var string Subtext will be displayed beside title */
        public string $submenuSubtext = '';
        /** @var string|int ID of the menu to display */
        public string|int $menuID = '';
        /** * @var string the class that is applied to the subMenu */
        public string $subMenuClass;
        /** * @var string the class that is applied to a subMenu Item */
        public string $subMenuItemClass;
        /** @var bool true|false display menu as sidebar   */
        public string $sidebar = 'false';
        /** @var bool true|false show menu name on top   */
        public bool $showMenuName = false;

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

            // set sidebar property
            $this->sidebar = $this->widget->data['sidebar'];

            // check if sidebar is set
            if ($this->sidebar === 'true')
            {   // include sidebar js
                echo '<script src="system/widgets/submenu/sidebar.js" type="text/javascript"></script>';
                // include sidebar css
                echo '<link rel="stylesheet" href="system/widgets/submenu/sidebar.css">';
            }

            // check if menu obj is set
            if (!isset($menu))
            {
                require_once 'system/classes/menu.php';
                $menu = new \YAWK\menu();
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

        /**
         * @brief draw sidebar start
         * @details If $this->sidebar is set to true, this function will be called before menu entry
         * and wrap the menu in a sidebar div.
         * @return void
         */
        public function drawSidebarStart(): void
        {
            echo '<div id="mySidebar" class="sidebar shadow"><a href="javascript:void(0)" class="btn btn-default" onclick="closeNav()">x</a>';
        }

        /**
         * @brief draw sidebar end
         * @details If $this->sidebar is set to true, this function will be called after menu entry
         * and closes the wrapping menu sidebar div.
         * @return void
         */
        public function drawSidebarEnd(): void
        {
            echo '</div>';
        }

        public function drawMenu($db)
        {
            $this->displaySubMenu($db, $this->menuID);
        }

        /**
         * @brief display any subMenu (used by widgets to get any menu in any position)
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menuID the menuID to get data
         */
        public function displaySubMenu($db, $menuID)
        {   /** @param db $db */

            // check if menu name should be displayed
            if ($this->showMenuName)
            {   // get menu name from db
                $menuName = "<li class=\"list-group-item\"><b>".\YAWK\menu::getMenuNameByID($db, $menuID)."</b><li>";
            }
            else
            {   // don't show menu name
                $menuName = '';
            }

            // get menu entries and draw navbar
            $res = $db->query("SELECT * FROM {menu}
                               WHERE published = 1 
                               AND menuID = '".$menuID."' 
                               ORDER by sort, title");

            $subMenuItem = '';
            $subMenuClass = '';
            $subMenuItemClass = '';
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

                // check if subMenuItem class is set
                if (!empty($this->subMenuItemClass)){
                    $submenuItemClass = ' class="'.$this->subMenuItemClass.'"';
                }
                else
                {   // subMenuItemClass is not set
                    $subMenuItemClass = '';
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

                // add menu item to menu
                $subMenuItem .= '<li class="list-group-item hvr-grow"><small>'.$icon.'&nbsp;&nbsp;<a href="'.$row['href'].'"'.$subMenuItemClass.$row['target'].'>'.$row['text'].'</a></small></li>';
            }

            // if sidebar is set, start sidebar markup
            if ($this->sidebar === 'true') {   // include sidebar js
                echo '<button class="openbtn" id="openSubmenuBtn">☰</button>';
                // wrap menu in sidebar (start)
                $this->drawSidebarStart();
            }

            // draw subMenu
            echo '<div id="subMenu"'.$subMenuClass.'>
                    <ul class="list-group" style="cursor:pointer;">'.$menuName.' ';
            echo ' '.$subMenuItem.'</ul>
                  </div>';

            // if sidebar is set, close sidebar
            if ($this->sidebar === 'true')
            {   // wrap menu in sidebar (end)
                $this->drawSidebarEnd();
            }
        }
    }
}