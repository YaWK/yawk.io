<?php
namespace YAWK {

    use DirectoryIterator;

    /**
     * @details <b>The default pages class. Provide all functions to handle static html pages.</b>
     *
     * All functions that are required to handle a page. Methods are: create, save, edit, delete and many more.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief The default pages class. Provide all functions to handle static pages.
     */
    class page
    {
        /** * @param int every page got its own id */
        public $id = -1;
        /** * @param string page filename */
        public $alias = '';
        /** * @param string new page filename (used by copy function) */
        public $alias_new = '';
        /** * @param string page title */
        public $title = '';
        /** * @param string new page title (used by copy function) */
        public $title_new = '';
        /** * @param int 0|1 published status */
        public $published = 0;
        /** * @param int uid (user id) of the page owner */
        public $ownerid = -1;
        /** * @param int menu id according to this page */
        public $menu = -1;
        /** * @param int group id for this page */
        public $gid;
        /** * @param string date when the site is created */
        public $date_created;
        /** * @param string date when the site is published */
        public $date_publish;
        /** * @param string date when the site should be unpublished */
        public $date_unpublish;
        /** * @param int plugin ID of that page */
        public $plugin;
        /** * @param int blog ID of that page*/
        public $blogid;
        /** * @param int 0|1 to check if the page is locked */
        public $locked;
        /** * @param string meta description for this page */
        public $metadescription;
        /** * @param string meta keywords for this page*/
        public $metakeywords;
        /** * @param string search string for this page */
        public $searchstring;
        /** * @param string bg image */
        public $bgimage;
        /** * @param string page language */
        public $language;
        /** * @param bool copy page into new language indicator  */
        public $newLanguage;
        /** * @param string the root path where pages are physically stored  */
        public $path = "../content/pages/";
        /** * @param string the meta tags description of this page  */
        public $meta_local = "Meta Tag Description";
        /** * @param string the meta tags keywords of this page  */
        public $meta_keywords = "Meta Tag Keywords";

        /**
         * @brief count and return the pages in database
         * @param object $db database
         * @return int|bool
         */
        static function countPages($db)
        {   /** @param $db db */
            if ($result = $db->query('SELECT count(id) FROM {pages}'))
            {
                $i = mysqli_fetch_row($result);
                return $i[0];
            }
            else
            {
                return false;
            }
        }

        /**
         * @brief get and return meta tags for requested page
         * @param object $db database
         * @param int $id affected page ID
         * @param string $type meta description
         * @return string|bool meta tags as string
         */
        public static function getMetaTags($db, $id, $type)
        {   /** @param $db db $res */
            if ($row = $db->query("SELECT meta_local, meta_keywords
                                  FROM {pages}
                                  WHERE id = '".$id."'"))
            {   // output meta content description
                $res = $row->fetch_assoc();
                if (!empty($type))
                {
                    if ($type == "meta_local"){
                        if (!empty($res['meta_local'])){
                            return $res['meta_local'];
                        }
                        else {
                            return null;
                        }
                    }
                    else if ($type == "meta_keywords"){
                        if (!empty($res['meta_keywords'])){
                            return $res['meta_keywords'];
                        }
                        else {
                            return null;
                        }
                    }
                    else {
                        return null;
                    }
                }
            }
            else {
                // throw alert
                sys::setSyslog($db, 7, 1, "failed to fetch meta $type for page ID $id", 0, 0, 0, 0);
                return alert::draw("warning", "Warning", "Could not fetch meta $type for page ID $id", "",4200);
            }
            // q failed
            return false;
        }

        /**
         * @brief get and return meta tags of requested page as array
         * @param object $db database
         * @param int $id affected page ID
         * @param string $type meta description
         * @return array|bool meta tags as array
         */
        public static function getMetaTagsArray($db, $id)
        {   /** @param $db db $res */
            if ($row = $db->query("SELECT meta_local, meta_keywords
                                  FROM {pages}
                                  WHERE id = '".$id."'"))
            {   // output meta content description
                $res = $row->fetch_assoc();
                if (is_array($res)
                    && (!empty($res['meta_local'])
                        && (!empty($res['meta_keywords'])))){
                    return $res;
                }
                else {
                    // meta tags not set, get global meta tags
                    $res['meta_local'] = \YAWK\settings::getSetting($db, "globalmetatext");
                    $res['meta_keywords'] = \YAWK\settings::getSetting($db, "globalmetakeywords");
                    if (!empty($res['meta_local']) && (!empty($res['meta_keywords']))){
                        return $res;
                    }
                    else {
                        $res['meta_local'] = "Unable to get Meta Description for this page. Neither local or global meta description found.";
                        $res['meta_keywords'] = "Unable to get Meta Keywords for this page. Neither local or global meta keywords found.";
                        return $res;
                    }
                }
            }
            else {
                // throw alert
                sys::setSyslog($db, 7, 1, "failed to fetch meta tags for page ID $id", 0, 0, 0, 0);
                $res['meta_local'] = "Unable to get Meta Description for this page. Neither local or global meta description found.";
                $res['meta_keywords'] = "Unable to get Meta Keywords for this page. Neither local or global meta keywords found.";
                return $res;
            }
        }

        /**
         * @brief toggle page status online or offline (plus corresponding menu entries)
         * @param object $db database
         * @param int $id affected page ID
         * @param int $published 0|1 page publish status
         * @param string $title page title
         * @return bool page toggle on/offline status
         */
        function toggleOffline($db, $id, $published, $title)
        {   /* @param $db db */
            // check data types
            if (is_numeric($id) && (is_numeric($published) && is_string($title)))
            {
                if ($published === '1')
                { $published = 0; }
                else if ($published === '0')
                { $published = 1; }

                // escape vars
                $id = $db->quote($id);
                $published = $db->quote($published);
                $title = $db->quote($title);

                if ($published === "0") { $status = "offline"; } else { $status = "online"; }

                // TOGGLE PAGES
                if (!$db->query("UPDATE {pages}
                                        SET published = '" . $published . "'
                                        WHERE id = '" . $id . "'"))
                {   // could not update pages db table
                    $status = sys::iStatusToString($published, "online", "offline");
                    sys::setSyslog($db, 7, 1, "failed to toggle $title status to $status", 0, 0, 0, 0);
                    print alert::draw("danger", "Error", "Site Status could not be toggled.", "", 4200);
                }
                else
                {   // ok, set syslog entry
                    sys::setSyslog($db, 5, 0, "toggled page $id to $status", 0, 0, 0, 0);
                }

                // TOGGLE MENU STATUS
                if (!$db->query("UPDATE {menu}
                                        SET published = '" . $published . "'
                                        WHERE title = '" . $title . "'")) {
                    // could not update pages db table
                    print alert::draw("danger", "Error", "Menu Status could not be toggled.", "", 4200);
                }
                else
                {   // ok, set syslog entry
                    sys::setSyslog($db, 21, 0, "toggled menu $id to $status", 0, 0, 0, 0);
                }
            }
            else
            {   // data type is incorrect, throw yoda's hint
                print alert::draw("danger", "Error", "YaWK said: variable manipulate you shall not do!", "", 4200);
            }
            return true;
        }

        /**
         * @brief toggle page lock to avoid unintended changes
         * @param object $db database
         * @param int $id affected page id
         * @param int $locked 0|1 lock status
         * @return bool page toggle lock status
         */
        function toggleLock($db, $id, $locked)
        {
            /* @param $db db */
            $id = $db->quote($id);
            $locked = $db->quote($locked);
            if ($db->query("UPDATE {pages} SET locked = '".$locked."' WHERE id = '".$id."'")) {
                /* free result set */
                // $res->close();
                return true;
            }
            else
            {   //
                print alert::draw("danger", "Error", "Site Lock could not be toggled.","page=pages",4200);
                if ($locked === "0") { $status = "unlocked"; } else { $status = "locked"; }
                sys::setSyslog($db, 5,0,  "set status $status page id #$id", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief make a copy of a page
         * @param object $db database
         * @return bool
         */
        function copy($db)
        {
            /** @param $db db */
            // creation date
            $currentDateTime = date("Y-m-d G:i:s");


            // init helper vars for copy processing
            $page = '';
            $newPage = '';

            // if page name is not given
            if (!$this->alias) {
                return false;
            }
            // ## select max id from pages
            if ($res = $db->query("SELECT MAX(id) FROM {pages}"))
            {
                $row = mysqli_fetch_row($res);
                $this->id = $row[0] + 1;
            }
            else
            {
                sys::setSyslog($db, 7, 1, "could not fetch MAX(id) of pages database", 0, 0, 0, 0);
                die ("Sorry, database error: could not fetch MAX(id).");
            }

            $this->id++;

            // ## add new page to db pages
            if ($result = $db->query("INSERT INTO {pages} (id,gid,date_created,date_publish,alias,title,blogid,locked,lang,meta_local,meta_keywords,plugin)
                                   VALUES ('" . $this->id . "',
                                           '" . $this->gid . "',
                                           '" . $currentDateTime . "',
                                           '" . $currentDateTime . "',
                                           '" . $this->alias.'-copy'."',
                                           '" . $this->title .'-copy'."',
                                           '" . $this->blogid . "',
                                           '" . $this->locked . "',
                                           '" . $this->language . "',
                                           '" . $this->meta_local . "',
                                           '" . $this->meta_keywords . "',
                                           '" . $this->plugin . "')"))
            {
                /* TODO: COPY META TAGS when COPY PAGE
                // generate local meta tags
                $desc = "description";
                $keyw = "keywords";
                $words = "";
                // add local meta tags
                if (!$db->query("INSERT INTO {meta_local} (name,page,content)
                                          VALUES ('" . $desc . "', '" . $id . "', '" . $title . "')"))
                {
                    \YAWK\sys::setSyslog($db, 8, 1, "failed to store local meta tags", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }

                // add local meta tags to db meta_local
                if (!$db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $keyw . "','" . $id . "','" . $words . "')"))
                {
                    \YAWK\sys::setSyslog($db, 8, 1, "failed to store local meta tags", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }
                */

                // copy page as new language requested
                if ($this->newLanguage === true)
                {   // check, if requested language dir exists
                    if (!is_dir($this->path.$this->language))
                    {   // if not, try to create it
                        mkdir($this->path.$this->language);

                        // prepare files to get copied into new language sub folder
                        $page = $this->path.$this->alias.".php";
                        $newPage = $this->path.$this->language."/".$this->alias."-copy.php";
                    }
                }
                else
                {   // prepare files to get copied into content/pages/ root folder
                    $page = $this->path.$this->alias.".php";
                    $newPage = $this->path.$this->alias."-copy.php";
                }

                // copy file
                if (!copy($page, $newPage) && !chmod($newPage, 0777))
                {
                    sys::setSyslog($db, 8, 1, "copy failed: $page to $newPage", 0, 0, 0, 0);
                    print alert::draw("danger", "Error!", "File could not be copied. Check folder permissions of /content/pages !", "", "");
                }
                else {
                    // file copies successfully...
                    return true;
                }
                /*

                // ## selectmenuID from menu db
                if ($row = $db->query("SELECT menuID FROM {menu} WHERE title LIKE '" . $this->title . "'"))
                {
                    $res = mysqli_fetch_row($row);
                    if (isset($res[0])){
                        $menuID = $res[0];
                    }
                    else {
                        $menuID = 0;
                    }
                }
                else
                {   // select failed, throw error
                    sys::setSyslog($db, 23, 1, "failed to select menu entry for $this->title", 0, 0, 0, 0);
                    echo alert::draw("warning","Warning", "Could not select menu entry for: $this->title", "", "");
                    $menuID = '0';
                }

                // ## select max ID from menu
                if ($row = $db->query("SELECT MAX(id) FROM {menu}"))
                {
                    $res = mysqli_fetch_row($row);
                    if (!isset($res[0]))
                    { // if not, give it a ID of 1
                        $newMenuID = 1;
                    }
                    else
                    {   // if entry exists, add +1 to ID #
                        $newMenuID = $res[0]++;
                    }
                }
                else
                {
                    $newMenuID = 0;
                    // select MAX(id) from menu failed, throw error
                    sys::setSyslog($db, 23, 1, "failed to fetch MAX(id) from menu", 0, 0, 0, 0);
                    echo alert::draw("warning","Warning", "Could not fetch MAX(id) from menu", "", "");
                }


                // to increment sort var correctly, check if there is an entry in the menu
                if ($res = $db->query("SELECT MAX(sort) FROM {menu} WHERE menuID = '" . $menuID . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if (!isset($row[0]))
                    {   // if not, give it a sort ID of 1
                        $sort = 1;
                    }
                    else
                    {   // if entry exists, add +1 to sort #
                        $sort = $row[0]++;
                    }

                    $link = "$this->alias" . ".html";
                    if ($db->query("INSERT INTO {menu} (id,sort,menuID,text,href)
                          VALUES('" . $newMenuID . "','" . $sort . "', '" . $menuID . "', '" . $this->title_new . "', '" . $link . "')"))
                    {
                        sys::setSyslog($db, 21, 0, "menu entry $this->title_new added", 0, 0, 0, 0);
                        return true;
                    }
                    else
                    {
                        // insert failed, throw error
                        sys::setSyslog($db, 23, 1, "failed to insert menu entry for: $this->title_new", 0, 0, 0, 0);
                        echo alert::draw("warning","Warning", "Could not insert menu entry for: $this->title_new", "", "");
                    }
                }
                else
                {
                    // select failed, throw error
                    sys::setSyslog($db, 23, 1, "failed to select menu entry for: $menuID", 0, 0, 0, 0);
                    echo alert::draw("warning","Warning", "Could not select menu entry for: $menuID", "", "");
                }
                    */
            }
            else
            {
                sys::setSyslog($db, 7, 1, "could not insert data into pages table", 0, 0, 0, 0);
            }
            sys::setSyslog($db, 8, 1, "copy $this->path.$this->alias failed.", 0, 0, 0, 0);
            return false;
        }

        /**
         * @brief delete a page
         * @param object $db database
         * @return bool
         */
        function delete($db)
        {
            /** @param $db db */
            // delete item from pages db
            if (!$db->query("DELETE FROM {pages} WHERE id = '" . $this->id . "'")) {
                sys::setSyslog($db, 7, 1, "failed to delete page $this->alias from database", 0, 0, 0, 0);
                alert::draw("danger", "Error:", "could not delete page from database", "pages", "4300");
            }
            else
            {   // page deleted
                sys::setSyslog($db, 5, 0, "deleted page $this->alias from database", 0, 0, 0, 0);
            }
            // delete item from menu db
            if (!$db->query("DELETE FROM {menu} WHERE href = '" . $this->alias . ".html'")) {
                sys::setSyslog($db, 23, 1, "failed to delete menu entry of page $this->alias from database", 0, 0, 0, 0);
                alert::draw("danger", "Error:", "could not delete menu entry from database", "pages", "4300");
            }
            else
            {   // deleted menu syslog entry
                sys::setSyslog($db, 21, 0, "deleted menu of ../content/pages/$this->alias.php", 0, 0, 0, 0);
            }

            // check, if language is set and build path + filename
            if (isset($this->language) && (!empty($this->language)))
            {   // file should be in corresponding language folder
                $filename = $this->path.$this->language."/".$this->alias.".php";
            }
            else
            {   // file should be in pages root folder
                $filename = $this->path.$this->alias.".php";
            }

            // check if file exists
            if (file_exists($filename))
            {   // delete file
                if (!unlink($filename))
                {   // delete failed
                    sys::setSyslog($db, 8, 2, "unable to delete $filename", 0, 0, 0, 0);
                    alert::draw("danger", "Error:", "could not delete file from /content/ folder", "pages", "4300");
                    return false;
                }
                else
                {   // delete successful
                    sys::setSyslog($db, 5, 0, "deleted $filename", 0, 0, 0, 0);
                    return true;
                }
            }
            // file does not exist.
            sys::setSyslog($db, 7, 1, "file $filename does not exist. page->delete() failed", 0, 0, 0, 0);
            return false;
        }

        /**
         * @brief create a new page
         * @param object $db database
         * @param string $alias page filename
         * @param int $menuID menu ID
         * @param int $locked 0|1 page lock status
         * @param int $blogid blog ID, if any
         * @param int $plugin plugin ID, if any
         * @return bool
         */
        function create($db, $alias, $menuID, $locked, $blogid, $plugin)
        {
            // TODO: refactor this method to oop code
            $this->alias = $alias;
            $this->menu = $menuID;
            $this->locked = $locked;
            $this->blogid = $blogid;
            $this->plugin = $plugin;

            /** @param $db db */
            // init variables
            // if page name is not given
            if (!$alias) {
                return false;
            }
            $alias = html_entity_decode($alias);
            // creation date
            $date_created = date("Y-m-d G:i:s");
//            $date_unpublish = date('Y-m-d', strtotime('+25 year', strtotime($date_created)) );
//            $date_unpublish = NULL;
            $title = $alias;
            /* alias string manipulation */
            $alias = mb_strtolower($alias); // lowercase
            $alias = str_replace(" ", "-", $alias); // replace all ' ' with -
            // special chars
            $ersetze = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $umlaute = array("ae", "ue", "oe", "Ae", "Ue", "Oe", "ss"); // array of replacement chars
            $alias = preg_replace($ersetze, $umlaute, $alias);      // replace with preg

            // convert special chars
            $alias = sys::encodeChars($alias);
            // final check: just numbers and chars are allowed
            $alias = preg_replace("/[^a-z0-9\-\/]/i", "", $alias);
            // final filename
            $link = "$alias" . ".html";

            // if menu select field is not empty
            if ($menuID !== "empty") {
                // ## select max ID from menu + add menu entry
                if ($res = $db->query("SELECT MAX(id) FROM {menu}"))
                {
                    $row = mysqli_fetch_row($res);
                    if (!isset($row[0])) { // if not, give it a ID of 1
                        $id = 1;
                    } else {
                        $id = $row[0] + 1; // if entry exists, add +1 to ID #
                    }
                }
                else
                {   // throw error
                    $id = 1;
                    sys::setSyslog($db, 7, 1, "failed to fetch MAX(id) FROM {menu}", 0, 0, 0, 0);
                    alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {menu}", "page=page-new", "4300");
                }
                // to increment sort var correctly, check if there is an entry in the menu
                if ($res = $db->query("SELECT MAX(sort) FROM {menu} WHERE menuID = '" . $menuID . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if (!isset($row[0]))
                    {   // if not, give it a ID of 1
                        $sort = 1;
                    }
                    else
                    {   // if entry exists, add +1 to sort #
                        $sort = $row[0] + 1;
                    }
                }
                else
                {   // throw error
                    $sort = 1;
                    sys::setSyslog($db, 7, 1, "failed to fetch MAX(id) FROM {menu} WHERE menuID = $menuID", 0, 0, 0, 0);
                    alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {menu} WHERE menuID = $menuID", "page=page-new", "4300");
                }

                if ($plugin) {
                    if (strlen($plugin) >= 1) {
                        $menu_published = 1;
                    }
                    else {
                        $menu_published = 0;
                    }
                }
                else {
                    $menu_published = 0;
                }
                $title = htmlentities($title);
                $tmpID = 0;
                $titleText = '';
                // insert menu data
                if (!$res = $db->query("INSERT INTO {menu} (id,sort,menuID,published,title,text,href,blogid, menuLanguage)
	                                   VALUES('" . $id . "',
	                                          '" . $sort . "',
	                                          '" . $menuID . "',
	                                          '" . $menu_published . "',
                                            '" . $titleText . "',
	                                          '" . $title . "',
	                                          '" . $link . "',
	                                          '" . $blogid . "',
	                                          '" . $this->language . "')"))
                {   // throw error
                    sys::setSyslog($db, 23, 1, "failed to insert data into {menu}", 0, 0, 0, 0);
                    alert::draw("danger", "Error:", "could not insert menu data", "page=page-new", "4300");
                }
                else
                {   // success syslog entry
                    sys::setSyslog($db, 21, 0, "added new menu: $title (id: $id)", 0, 0, 0, 0);
                }
            } // ./ if menu != empty

            // if the method is called from the blog, set settings
            if ($locked === '0' && $blogid === '0') {
                $locked = 0;
                $published = 0;
                $content = "leer";
            } else {
                $published = 0;
                $content = "<?php \$blog_id = $blogid; include 'system/plugins/blog/blog.php'; ?>";
            }

            // if the method is called from the plugin, set settings
            if ($plugin) {
                if (is_array($plugin)){
                    $plugin = array("tos", $_POST['signup_tospage'], $_POST['signup_terms-long']);
                    if ($plugin[0] === 'tos'){
                        $published = 1;
                        $locked = 1;
                        $alias = "$plugin[1]";
                        $content = "$plugin[2]";
                        $plugin = "signup";
                    }
                }
                else if (strlen($plugin) >= 1) {
                    $published = 1;
                    $locked = 1;
                    $content = "<?php include 'system/plugins/$plugin/$plugin.php'; ?>";
                }
            }
            else {
                $plugin = 0;
            }

            // ## select max id from pages
            if ($res = $db->query("SELECT MAX(id) FROM {pages}"))
            {
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
            }
            else
            {
                $id = 1;
                sys::setSyslog($db, 7, 1, "failed to select MAX(id) from pages db", 0, 0, 0, 0);
            }

            $alias = htmlentities($alias);
            // ## add new page to db pages
            if (!$db->query("INSERT INTO {pages} (id,published,date_created,date_changed,date_publish,date_unpublish,alias,title,locked,blogid,plugin,lang)
                                   VALUES ('" . $id . "',
                                           '" . $published . "',
                                           '" . $date_created . "',
                                           '" . $date_created . "',
                                           '" . $date_created . "',
                                           NULL,
                                           '" . $alias . "',
                                           '" . $title . "',
                                           '" . $locked . "',
                                           '" . $blogid . "',
                                           '".$plugin."',
                                           '".$this->language."')"))
            {   // error inserting page into database - throw error
                sys::setSyslog($db, 7, 2, "unable to add page $alias into database.", 0, 0, 0, 0);
                alert::draw("danger", "Error!", "unable to add new page ($alias) id: $id into pages database.", "", 4300);
            }

            // check if language is set
            if (isset($this->language) && (!empty($this->language)))
            {   // set path for new language page
                $filename = $this->path.$this->language."/".$alias.".php";
                if (!is_dir($this->path.$this->language)){
                    if (!mkdir($this->path.$this->language)){
                        sys::setSyslog($db, 7, 2, "failed to create language folder: $this->path.$this->language");
                        return false;
                    }
                }
            }
            else
            {   // set path for root dir
                $filename = $this->path.$alias.".php";
            }

            // create file
            if (!file_exists($filename)) {
                $handle = fopen($filename, "wr");
                fwrite($handle, $content);
                fclose($handle);
                chmod($filename, 0777);
            }

            // page created successfully
            sys::setSyslog($db, 5, 0, "created $filename", 0, 0, 0, 0);
            return true;
        }

        /**
         * @brief save a static page including all settings
         * @param object $db database
         * @return bool
         */
        public function save($db)
        {
            /** @param $db db */
            $date_changed = date("Y-m-d G:i:s");

            /* alias string manipulation */
            $this->alias = mb_strtolower($this->alias); // lowercase
            $this->alias = str_replace(" ", "-", $this->alias); // replace all ' ' with -
            // special chars
            $umlaute = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $ersetze = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
            $this->alias = preg_replace($umlaute, $ersetze, $this->alias);        // replace with preg
            $this->alias = preg_replace("/[^a-z0-9\-\/]/i", "", $this->alias); // final check: just numbers and chars are allowed


            // old alias string
            $oldAlias = substr($this->searchstring, 0, -5);  // remove last 5 chars (.html) to get the plain filename

            // update menu entry
            /*
            if (!$db->query("UPDATE {menu}
                  SET text = '" . $this->title ."',
                      href = '" . $this->alias . ".html',
                       gid = '" . $this->gid . "',
                      published = '" . $this->published . "'
                WHERE href = '" . $this->searchstring . "'"))
            {
                // throw error
                \YAWK\sys::setSyslog($db, 23, 1, "failed to update menu entry $this->title.", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning", "menu entry could not be stored in database.", "", 6200);
            }
            */

            // update page db
            // check unpublish date
            if ($this->date_unpublish == "0000-00-00 00:00:00" || (empty($this->date_unpublish) || $this->date_unpublish == NULL))
            {
                // sql code with NULL unpublish date
                if (!$db->query("UPDATE {pages} 
                    SET published = '" . $this->published . "',
                        gid = '" . $this->gid . "',
                        date_changed = '" . $date_changed . "',
                        date_publish = '" . $this->date_publish . "',
                        date_unpublish = NULL,
                        title = '" . $this->title . "',
                        alias = '" . $this->alias . "',
                        bgimage = '" . $this->bgimage . "',
                        lang = '" . $this->language . "',
                        meta_local = '" . $this->meta_local . "',
                        meta_keywords = '" . $this->meta_keywords . "'
                    WHERE id = '" . $this->id . "'"))
                {
                    // throw error
                    sys::setSyslog($db, 23, 1, "failed to update database of page $this->title", 0, 0, 0, 0);
                    // \YAWK\alert::draw("warning", "Warning", "page data could not be stored in database.", "", 6200);
                    // \YAWK\alert::draw("danger", 'MySQL Error: ('.mysqli_errno().')', 'Database error: '.mysqli_error($db).'', "", 0);
                    return false;
                }
                else
                {
                    // update pages db worked, all fin
                    sys::setSyslog($db, 5, 0, "updated $this->alias", 0, 0, 0, 0);
                    return true;
                }
            }
            else
            {
                // sql code with correct, user-selected unpublish date
                if (!$db->query("UPDATE {pages} 
                    SET published = '" . $this->published . "',
                        gid = '" . $this->gid . "',
                        date_changed = '" . $date_changed . "',
                        date_publish = '" . $this->date_publish . "',
                        date_unpublish = '" . $this->date_unpublish . "',
                        title = '" . $this->title . "',
                        alias = '" . $this->alias . "',
                        bgimage = '" . $this->bgimage . "',
                        lang = '" . $this->language . "',
                        meta_local = '" . $this->meta_local . "',
                        meta_keywords = '" . $this->meta_keywords . "'
                    WHERE id = '" . $this->id . "'"))
                {
                    // throw error
                    sys::setSyslog($db, 23, 1, "failed to update page $this->title", 0, 0, 0, 0);
                    alert::draw("warning", "Warning", "failed to store data of $this->alias in database.", "", 6200);
                    return false;
                }
                else
                {
                    // update pages db worked, all fin
                    sys::setSyslog($db, 5, 0, "updated $this->alias", 0, 0, 0, 0);
                    return true;
                }
            }
        } // ./ save function


        /**
         * @brief delete a static content page
         * @param string $dirprefix directory prefix
         */
        function deleteContent($dirprefix)
        {
            global $dirprefix;
            if (isset($this->language) && (!empty($this->language)))
            {
                $filename = $dirprefix.$this->path.$this->language."/".$this->alias.".php";
            }
            else
            {
                $filename = $dirprefix.$this->path.$this->alias."php";
            }

            if (file_exists($filename))
            {
                if (unlink($filename))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
        }

        /**
         * @brief write content to static page
         * @param string $content the content to write
         * @return bool true|false
         */
        function writeContent($content)
        {
            /** @param $db db $alias */
            /* alias string manipulation */
            $this->alias = mb_strtolower($this->alias); // lowercase
            $this->alias = str_replace(" ", "-", $this->alias); // replace all ' ' with -
            // special chars
            $specialChars = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $replacementChars = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
            $this->alias = preg_replace($specialChars, $replacementChars, $this->alias);        // replace with preg
            $this->alias = preg_replace("/[^a-z0-9\-\/]/i", "", $this->alias); // final check: just numbers and chars are allowed
            if (!empty($this->language))
            {
                $this->language = mb_substr($this->language, 0, 2);
                // check if requested language directory exists
                if (!is_dir($this->path.$this->language))
                {   // if not, create it
                    mkdir ($this->path.$this->language);
                }
                // store file to corresponding language folder
                $filename = $this->path.$this->language."/".$this->alias.".php";
            }
            else
            {   // store file to content/pages root folder
                $filename = $this->path.$this->alias.".php";
            }

            // open file
            $handle = fopen($filename, "w+");
            if (fwrite($handle, $content))
            {   // write content + close
                fclose($handle);
                // set file perms
                chmod($filename, 0777);
                return true;
            }
            else
            {   // writeContent failed
                sys::setSyslog($db, 7, 2, "unable to write content to file $filename", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief read content from static page
         * @param string $dirPrefix directory prefix
         * @return string html content
         */
        function readContent($dirPrefix): string
        {
            // check, if language is set
            if (isset($this->language) && (!empty($this->language)))
            {   // if so, build path including language folder
                $filename = $this->path.$this->language."/".$this->alias.".php";
            }
            else
            {   // no language set, build path for content/pages root folder
                $filename = $this->path.$this->alias.".php";
            }
            if(file_exists($filename)){
                // open page file
                $handle = @fopen($filename, "rw");
                // read content into var
                $content = @fread($handle, filesize($filename));
                // close resource
                fclose($handle);
                // and return page content
                return $content;
            }
            else
            {
                return 'ERROR: Unable to read content of file: '.$filename.'
Maybe the file has been physically deleted, moved or renamed.';
            }
        }

        function getCurrentLanguageByID($db, $id){
            /** @param $db db $res */
            if (isset($id) && (!empty($id)))
            {   // query db for given page ID
                $res = $db->query("SELECT lang FROM {pages} WHERE id ='".$id."'");
                $currentLanguage = mysqli_fetch_row($res);
            }
            // check, if page got a language set
            if (isset($currentLanguage[0]) && (!empty($currentLanguage[0])))
            {   // return page language
                return $currentLanguage[0];
            }
            else
            {   // no language set, return empty string
                return "";
            }
        }

        /**
         * @brief load page properties and store as object properties
         * @param object $db database
         * @param string $alias page filename
         */
        function loadProperties($db, $alias)
        {
            /** @param $db db $res */
            if (isset($alias) && (!empty($alias)))
            {
                $res = $db->query("SELECT * FROM {pages} WHERE alias = '".$alias."'");
                if ($row = mysqli_fetch_assoc($res))
                {
                    $this->id = $row['id'];
                    $this->date_created = $row['date_created'];
                    $this->date_publish = $row['date_publish'];
                    $this->date_unpublish = $row['date_unpublish'];
                    $this->published = $row['published'];
                    $this->gid = $row['gid'];
                    $this->title = $row['title'];
                    $this->ownerid = $row['owner'];
                    $this->menu = $row['menu'];
                    $this->bgimage = $row['bgimage'];
                    $this->locked = $row['locked'];
                    $this->blogid = $row['blogid'];
                    $this->plugin = $row['plugin'];
                    $this->language = $row['lang'];
                    $this->meta_local = $row['meta_local'];
                    $this->meta_keywords = $row['meta_keywords'];
                    $this->alias = $alias;
                }
                else
                {   // 404 error handling
                    if ($this->alias == "content/errors/404")
                    {   // check if user is logged in (session uid is set in that case)
                        if (isset($_SESSION['uid']) && (!empty($_SESSION['uid'])))
                        {   // logged in user created a 404 error
                            sys::setSyslog($db, 7, 2, "404: file not found - displayed $alias instead", $_SESSION['uid'], 0, 0, 0);
                        }
                        else
                        {   // user is not logged in - unknown user created a 404 error
                            sys::setSyslog($db, 7, 2, "404: file not found - displayed $alias instead", 0, 0, 0, 0);
                        }
                    }
                }
            }
            else
            {   // page not set - unable to load page properties
                sys::setSyslog($db, 7, 2, "failed to load properties because page alias was not set", 0, 0, 0, 0);
            }
        }

        /**
         * @brief load page properties and store as object properties
         * @param object $db database
         * @param string $id page id
         */
        function loadPropertiesByID($db, $id)
        {
            /** @param $db db $res */
            if (isset($id) && (!empty($id)))
            {
                $res = $db->query("SELECT * FROM {pages} WHERE id = '".$id."'");
                if ($row = mysqli_fetch_assoc($res))
                {
                    $this->id = $row['id'];
                    $this->date_created = $row['date_created'];
                    $this->date_publish = $row['date_publish'];
                    $this->date_unpublish = $row['date_unpublish'];
                    $this->published = $row['published'];
                    $this->gid = $row['gid'];
                    $this->alias = $row['alias'];
                    $this->title = $row['title'];
                    $this->ownerid = $row['owner'];
                    $this->menu = $row['menu'];
                    $this->bgimage = $row['bgimage'];
                    $this->locked = $row['locked'];
                    $this->blogid = $row['blogid'];
                    $this->plugin = $row['plugin'];
                    $this->language = $row['lang'];
                    $this->meta_local = $row['meta_local'];
                    $this->meta_keywords = $row['meta_keywords'];
                }
                else
                {   // 404 error handling
                    if ($this->alias == "content/errors/404")
                    {   // check if user is logged in (session uid is set in that case)
                        if (isset($_SESSION['uid']) && (!empty($_SESSION['uid'])))
                        {   // logged in user created a 404 error
                            sys::setSyslog($db, 7, 2, "404: file not found - displayed $this->alias instead", $_SESSION['uid'], 0, 0, 0);
                        }
                        else
                        {   // user is not logged in - unknown user created a 404 error
                            sys::setSyslog($db, 7, 2, "404: file not found - displayed $this->alias instead", 0, 0, 0, 0);
                        }
                    }
                }
            }
            else
            {   // page ID not set - unable to load page properties
                sys::setSyslog($db, 7, 2, "failed to load properties because page ID was not set", 0, 0, 0, 0);
            }
        }


        /**
         * @brief get latest pages
         * @param object $db database
         * @param int $limit limit to n entries
         * @return array|string
         */
        static function getLatest($db, $limit)
        {   /** @param $db db */
            // check and set default value
            if (!isset($limit) && (empty($limit))) { $limit = 4; }
            // select latest n page titles
            if ($res = $db->query("SELECT id, alias, title, published, date_publish 
                                   FROM {pages} 
                                   WHERE blogid = 0 
                                   AND plugin = 0
                                   ORDER BY date_created 
                                   DESC LIMIT $limit"))
            {
                $latestPages = array();
                while ($row = mysqli_fetch_assoc($res))
                {
                    $latestPages[] = $row;
                }
                return $latestPages;
            }
            else
            {
                return "no pages found.";
            }
        }

        /**
         * @brief get any requested page property
         * @param object $db database
         * @param int $id affected page ID
         * @param string $property database field to get
         * @return string|bool the selected property or false
         */
        function getProperty($db, $id, $property)
        {   /** @param $db db $res */
            // select property from pages db
            if ($res = $db->query("SELECT $property FROM {pages}
                        WHERE id = '" . $id . "'"))
            {   // fetch data
                if ($row = mysqli_fetch_row($res)){
                    return $row[0];
                }
            }
            else
            {   // throw error
                sys::setSyslog($db, 7, 1, "unable to get property: $property from pages database.", 0, 0, 0, 0);
                alert::draw("warning", "Warning", "unable to get property: $property from Paged Database.", "", "4200");
                return false;
            }
            // q failed
            return null;
        }

        /**
         * @brief get and include static page content
         * @param object $db database
         * @param object $lang language obj
         * @return mixed
         */
        function getContent($db, $lang)
        {
            global $currentpage;
            if (!isset($currentpage) || (empty($currentpage)))
            {
                die("CRITICAL ERROR: unable to display content - currentpage var is not set.");
            }
            if (isset($currentpage->date_publish))
            {
                // ROLE CHECK
                if (isset($_SESSION['gid'])) {
                    // if SESSION ROLE is bigger or equal than current PAGE ROLE
                    if ($_SESSION['gid'] <= $currentpage->gid)
                    {   // user is not allowed to view this content
                        sys::setSyslog($db, 11, 1, "user with group ID $_SESSION[gid] is not allowed to view $currentpage->alias (required GID: $currentpage->gid)", 0, 0, 0, 0);
                        return false;
                    }
                }
                else if ($currentpage->gid > 1)
                {   // public user not allowed here, so....
                    sys::setSyslog($db, 11, 1, "public user tried to get content of $currentpage->alias (required GID: $currentpage->gid)", 0, 0, 0, 0);
                    return false;
                }
            }
            // GET STATUS
            $future = (isset($currentpage->date_publish));
            // publish date + time
            if (isset($currentpage->date_publish_end))
            {   // end publish date + time
                $publish_end = $currentpage->date_publish_end;
            }

            // current date + time
            $now = date("Y-m-d G:i:s");
            // trim vars
            $date_published = trim($future);
            $publish_end = trim(isset($publish_end));
            $date_now = trim($now);

            // de-construct string
            $date_now = substr($now, 0, 10);    // get the first 10 chars, start from left
            $time_now = substr($now, -8);    // get the last 8 chars, start from right

            $date_published = substr($future, 0, 10);
            $time_published = substr($future, -8);

            $date_publish_end = substr($publish_end, 0, 10);
            $time_publish_end = substr($publish_end, -8);

            // remove special chars
            $time_publish_end = str_replace(":", "", $time_publish_end);
            $time_published = str_replace(":", "", $time_published);
            $time_now = str_replace(":", "", $time_now);
            $date_published = str_replace("-", "", $date_published);
            $date_now = str_replace("-", "", $date_now);

            if ($time_now >= $time_publish_end &&
                $date_now >= $date_publish_end &&
                $time_now <= $time_published &&
                $date_now <= $date_published ||
                $currentpage->published == 0
            )
            {
                // show error
                return include(controller::filterfilename($db, $lang, "content/errors/404.html"));
            }
            else
            {
                if ($currentpage->date_publish > $now) {
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "<br>Content Pending. Publishing is scheduled for $currentpage->date_publish<br><br>";
                    } else {
                        echo "&nbsp;";
                    }

                    $start = strtotime($now);
                    $end = strtotime($currentpage->date_publish);
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "time diff here";
                        // TODO: search for sys::showTimeDiff($start, $end);
                    }
                    exit;
                }
                if ($currentpage->date_unpublish < $now XOR $currentpage->date_unpublish === NULL) {
                    echo "<br>Sadly, this content is not available anymore. <br><br>";
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "Publishing has ended on $currentpage->date_unpublish.<br><br>";
                        // YAWK\sys::showTimeDiff($start, $end);
                    }
                    exit;
                }

                // create language obj
                $language = new language();

                // $language->httpAcceptedLanguage = substr($language->getClientLanguage(), 0, 2);
                $language->httpAcceptedLanguage = $language->getClientLanguage();

                // set path to content folder (where pages are stored)
                $path = "content/pages/";

                // the file extension of files used in path to store pages (typically .php)
                $fileExt = ".php";

                // check users browser language, store first 2 chars as $tag
                $language->httpAcceptedLanguage = mb_substr($language->httpAcceptedLanguage, 0,2);


                // init language folder var
                $languageFolder = '';
                $trailingSlash = '';

                // build array containing all content sub folders
                $contentLanguageFolders = array();
                foreach (new DirectoryIterator($path) as $fileInfo) {
                    if($fileInfo->isDot()) continue;
                    if($fileInfo->isFile()) continue;
                    if($fileInfo->isDir())
                        $contentLanguageFolders[] = $fileInfo->getFilename();

                    // check if user's language is available in content folder
                    if ($language->httpAcceptedLanguage == $fileInfo->getFilename())
                    {   // this is the language we have detected from the user - you want it, we got it
                        $languageFolder = $fileInfo->getFilename();
                        $trailingSlash = "/";
                        // echo "<script>document.cookie = \"userSelectedLanguage=$languageFolder; expires=Thu, 04 Nov 2021 12:00:00 UTC\"; </script>";
                    }
                    else
                    {   // leave empty, take from root dir
                        $languageFolder = '';
                    }
                }

                if (isset($_GET['language']) && (!empty($_GET['language'])))
                {
                    $languageFolder = mb_substr($_GET['language'], 0,2);
                    $trailingSlash = "/";
                    // outdated: this has moved to template index page
                    // echo "<script>document.cookie = \"userSelectedLanguage=$languageFolder; expires=Thu, 04 Nov 2021 12:00:00 UTC\"; </script>";
                    // $_COOKIE['userSelectedLanguage'] = $languageFolder;
                }
                // print_r($_COOKIE);

                if (isset($_COOKIE['userSelectedLanguage']) && (!empty($_COOKIE['userSelectedLanguage']))){
                    $languageFolder = $_COOKIE['userSelectedLanguage'];
                    $trailingSlash = "/";
                }
                /*
                    echo "<pre>";
                    print_r($contentLanguageFolders);
                    echo "lang folder: ".$languageFolder;
                    echo "</pre>";

                    echo "<br>";
                    echo $path.$languageFolder.$trailingSlash.$this->alias.$fileExt."<br>";
                */

                if (in_array("$languageFolder", $contentLanguageFolders)) {
                    // check if folder for this language is available
                    if (is_dir($path.$languageFolder))
                    {
                        // echo "yes, $languageFolder is supported!";
                        if (is_file($path.$languageFolder.$trailingSlash.$this->alias.$fileExt))
                        {
                            // include content page from language folder
                            /** @noinspection PhpIncludeInspection */
                            return include(controller::filterfilename($db, $lang, $path.$languageFolder.$trailingSlash.$this->alias));
                        }
                        else
                        {   // file not found in this language folder - check if file is found in root directory
                            if (is_file($path.$this->alias))
                            {   // include content page from root folder
                                /** @noinspection PhpIncludeInspection */
                                return include(controller::filterfilename($db, $lang, $path.$this->alias));
                            }
                        }
                    }
                    else
                    {
                        // echo "no, $languageFolder is not supported yet.";
                        // language folder not found - check if file is found in root directory
                        if (is_file($path.$this->alias))
                        {   // include content page from root folder
                            /** @noinspection PhpIncludeInspection */
                            return include(controller::filterfilename($db, $lang, $path.$this->alias));
                        }
                    }
                }
                else
                {       // echo "desired language $languageFolder not in array, loading file from root folder";
                    /** @noinspection PhpIncludeInspection */
                    return include(controller::filterfilename($db, $lang, $path.$this->alias));
                }
            }
            return true;
        }
    } // ./ class page
} // ./ namespace