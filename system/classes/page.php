<?php
namespace YAWK {
    /**
     * <b>The default pages class. Provide all functions to handle static html pages.</b>
     *
     * All functions that are required to handle a page. Methods are: create, save, edit, delete and many more.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @link       http://yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @annotation The default pages class. Provide all functions to handle static pages.
     */
    class page
    {
        /** * @var int every page got its own id */
        public $id = -1;
        /** * @var string page filename */
        public $alias = '';
        /** * @var string page title */
        public $title = '';
        /** * @var int 0|1 published status */
        public $published = 0;
        /** * @var int uid (user id) of the page owner */
        public $ownerid = -1;
        /** * @var string should the page owner be public */
        public $owner = false;
        /** * @var int menu id according to this page */
        public $menu = -1;
        /** * @var int group id for this page */
        public $gid;
        /** * @var string date when the site is created */
        public $date_created;
        /** * @var string date when the site is published */
        public $date_publish;
        /** * @var string date when the site should be unpublished */
        public $date_unpublish;
        /** * @var int plugin ID of that page */
        public $plugin;
        /** * @var int blog ID of that page*/
        public $blogid;
        /** * @var int 0|1 to check if the page is locked */
        public $locked;
        /** * @var string meta description for this page */
        public $metadescription;
        /** * @var string meta keywords for this page*/
        public $metakeywords;
        /** * @var string search string for this page */
        public $searchstring;
        /** * @var string bg image */
        public $bgimage;


        /**
         * count and return the pages in database
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool
         */
        static function countPages($db)
        {   /** @var $db \YAWK\db */
            if ($result = $db->query("SELECT count(id) FROM {pages}"))
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
         * get and return meta tags for requested page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected page ID
         * @param string $type meta description
         * @return string|bool meta tags as string
         */
        function getMetaTags($db, $id, $type)
        {   /** @var $db \YAWK\db $res */
            if (!isset($type) or (empty($type))) {
                // set default type description | keywords
                $type = "description";
            }
            if ($res = $db->query("SELECT content
                                  FROM {meta_local}
                                  WHERE page = ".$id."
                                  AND name = '$type'"))
            {   // output meta content description
                $row = $res->fetch_assoc();
                return $row['content'];
            }
            else {
                // throw alert
                \YAWK\sys::setSyslog($db, 5, 1, "Could not fetch meta $type for page ID $id", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning", "Could not fetch meta $type for page ID $id", "",4200);
            }
            // q failed
            return false;
        }


        /**
         * toggle page status online or offline (plus corresponding menu entries)
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected page ID
         * @param int $published 0|1 page publish status
         * @param string $title page title
         * @return string|bool meta tags as string
         */
        function toggleOffline($db, $id, $published, $title)
        {   /* @var $db \YAWK\db */
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

                $status = \YAWK\sys::iStatusToString($published, "online", "offline");

                if ($published === "0") { $status = "offline"; } else { $status = "online"; }

                // TOGGLE PAGES
                if (!$res = $db->query("UPDATE {pages}
                                        SET published = '" . $published . "'
                                        WHERE id = '" . $id . "'"))
                {   // could not update pages db table
                    $status = \YAWK\sys::iStatusToString($published, "online", "offline");
                    \YAWK\sys::setSyslog($db, 5, 1, "failed to toggle $title status to $status", 0, 0, 0, 0);
                    print alert::draw("danger", "Error", "Site Status could not be toggled.", "", 4200);
                }
                else
                    {   // ok, set syslog entry
                        \YAWK\sys::setSyslog($db, 2, 0, "toggled page $id to $status", 0, 0, 0, 0);
                    }

                // TOGLE MENU STATUS
                if (!$res = $db->query("UPDATE {menu}
                                        SET published = '" . $published . "'
                                        WHERE title = '" . $title . "'")) {
                    // could not update pages db table
                    print alert::draw("danger", "Error", "Menu Status could not be toggled.", "", 4200);
                }
                else
                {   // ok, set syslog entry
                    \YAWK\sys::setSyslog($db, 7, 0, "toggled menu $id to $status", 0, 0, 0, 0);
                }
            }
            else
            {   // data type is incorrect, throw yoda's hint
                print \YAWK\alert::draw("danger", "Error", "YaWK said: variable manipulate you shall not do!", "", 4200);
            }
            return true;
        }

        /**
         * toggle page lock to avoid unintended changes
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected page id
         * @param int $locked 0|1 lock status
         * @return bool
         */
        function toggleLock($db, $id, $locked)
        {
            /* @var $db \YAWK\db */
            $id = $db->quote($id);
            $locked = $db->quote($locked);
            if ($res = $db->query("UPDATE {pages} SET locked = ".$locked." WHERE id = ".$id."")) {
                /* free result set */
                // $res->close();
                return true;
            }
            else
            {   //
                print \YAWK\alert::draw("danger", "Error", "Site Lock could not be toggled.","page=pages",4200);
                if ($locked === "0") { $status = "unlocked"; } else { $status = "locked"; }
                \YAWK\sys::setSyslog($db, 2,0,  "$status page id #$id", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * make a copy of a page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool
         */
        function copy($db)
        {
            /** @var $db \YAWK\db */
            // group id
            $gid = "$this->gid";
            // old page alias (filename)
            $alias_old = "$this->alias";
            // copied alias (new filename)
            $alias = "$this->alias-copy";
            // copied title (new title)
            $title_new = "$this->title-copy";
            // title
            $title = "$this->title";
            // creation date
            $date_created = date("Y-m-d G:i:s");
            // plugin
            $plugin = "$this->plugin";
            // blog id
            $blogid = "$this->blogid";
            // locked
            $locked = "$this->locked";

            // if page name is not given
            if (!$alias) {
                return false;
            }
            // ## select max id from pages
            if ($res = $db->query("SELECT MAX(id) FROM {pages}"))
            {
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, 1, "could not fetch MAX(id)", 0, 0, 0, 0);
                die ("Sorry, database error: could not fetch MAX(id).");
            }
            // ## add new page to db pages
            if ($db->query("INSERT INTO {pages} (id,gid,date_created,date_publish,alias,title,blogid,locked,plugin)
                                   VALUES ('" . $id . "',
                                           '" . $gid . "',
                                           '" . $date_created . "',
                                           '" . $date_created . "',
                                           '" . $alias . "',
                                           '" . $title_new . "',
                                           '" . $blogid . "',
                                           '" . $locked . "',
                                           '" . $plugin . "')"))
            {

                // generate local meta tags
                $desc = "description";
                $keyw = "keywords";
                $words = "";
                // add local meta tags
                if (!$db->query("INSERT INTO {meta_local} (name,page,content)
                                          VALUES ('" . $desc . "', '" . $id . "', '" . $title . "')"))
                {
                    \YAWK\sys::setSyslog($db, 5, 1, "could not store local meta tags", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }

                // add local meta tags to db meta_local
                if (!$db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $keyw . "','" . $id . "','" . $words . "')"))
                {
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not store local meta tags", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }

                // prepare files
                $file = "../content/pages/" . $alias_old . ".php";
                $newfile = "../content/pages/" . $alias . ".php";
                // copy file
                if (!copy($file, $newfile) && !chmod($newfile, 0777))
                {
                    \YAWK\sys::setSyslog($db, 5, 1, "copy failed: $file to $newfile", 0, 0, 0, 0);
                    print \YAWK\alert::draw("danger", "Error!", "File could not be copied. permissions of /content/pages !", "", "");
                }

                // ## selectmenuID from menu db
                if ($db->query("SELECT menuID FROM {menu} WHERE title LIKE '" . $title . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    $menuID = $row[0];
                }
                else
                {   // select failed, throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "could not select menu entry for $title", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not select menu entry for: $title", "", "");
                }

                // ## select max ID from menu
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
                {
                    // select MAX(id) from menu failed, throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not fetch MAX(id) from menu", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not fetch MAX(id) from menu", "", "");
                }

                // to increment sort var correctly, check if there is an entry in the menu
                if ($res = $db->query("SELECT MAX(sort) FROM {menu} WHERE menuID = '" . $menuID . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if (!isset($row[0])) { // if not, give it a sort ID of 1
                        $sort = 1;
                    } else {
                        $sort = $row[0] + 1; // if entry exists, add +1 to sort #
                    }

                    $link = "$alias" . ".html";
                    if ($db->query("INSERT INTO {menu} (id,sort,menuID,text,href)
                          VALUES('" . $id . "','" . $sort . "', '" . $menuID . "', '" . $title_new . "', '" . $link . "')"))
                    {
                        \YAWK\sys::setSyslog($db, 5, 0, "menu entry $title_new added", 0, 0, 0, 0);
                       return true;
                    }
                    else
                    {
                        // insert failed, throw error
                        \YAWK\sys::setSyslog($db, 5, 1, "Could not insert menu entry for: $title_new", 0, 0, 0, 0);
                        echo \YAWK\alert::draw("warning","Warning", "Could not insert menu entry for: $title_new", "", "");
                    }
                }
                else
                {
                    // select failed, throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not select menu entry for: $menuID", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not select menu entry for: $menuID", "", "");
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, 1, "could not insert data into pages table", 0, 0, 0, 0);
                die ("Sorry, database error: could not insert data into pages table.");
            }
            \YAWK\sys::setSyslog($db, 5, 1, "copy $newfile failed.", 0, 0, 0, 0);
            return false;
        }

        /**
         * delete a page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool
         */
        function delete($db)
        {
            /** @var $db \YAWK\db */
            // delete item from pages db
            if (!$res_pages = $db->query("DELETE FROM {pages} WHERE alias = '" . $this->alias . "'")) {
                \YAWK\sys::setSyslog($db, 5, 1, "could not delete page from database", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error:", "could not delete page from database", "pages", "4300");
            }
            // delete item from menu db
            if (!$res_menu = $db->query("DELETE FROM {menu} WHERE href = '" . $this->alias . ".html'")) {
                \YAWK\sys::setSyslog($db, 5, 1, "could not delete menu entry from database", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error:", "could not delete menu entry from database", "pages", "4300");
            }
            else
                {   // deleted menu syslog entry
                    \YAWK\sys::setSyslog($db, 2, 0, "deleted menu of ../content/pages/$this->alias.php", 0, 0, 0, 0);
                }
            // delete item from meta_local db
            if (!$res_menu = $db->query("DELETE FROM {meta_local} WHERE page = '" . $this->id. "'")) {
                \YAWK\sys::setSyslog($db, 5, 1, "could not delete local meta tags from database", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning:", "could not delete local meta tags from database", "pages", "4300");
            }
            // build path + filename
            $filename = "../content/pages/" . $this->alias . ".php";
            if (file_exists($filename)) {
                if (!unlink($filename)) {
                    \YAWK\sys::setSyslog($db, 2, 2, "unable to delete $filename", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Error:", "could not delete file from /content/ folder", "pages", "4300");
                    return false;
                } else {
                    \YAWK\sys::setSyslog($db, 2, 0, "deleted $filename", 0, 0, 0, 0);
                    return true;
                }
            }
            \YAWK\sys::setSyslog($db, 5, 1, "file $filename does not exist. page->delete() failed", 0, 0, 0, 0);
            return false;
        }

        /**
         * create a new page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
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
            /** @var $db \YAWK\db */
            // init variables
            // if page name is not given
            if (!$alias) {
                return false;
            }
            $alias = html_entity_decode($alias);
            // creation date
            $date_created = date("Y-m-d G:i:s");
//            $date_unpublish = date('Y-m-d', strtotime('+25 year', strtotime($date_created)) );
            $date_unpublish = NULL;
            $title = $alias;
            /* alias string manipulation */
            $alias = mb_strtolower($alias); // lowercase
            $alias = str_replace(" ", "-", $alias); // replace all ' ' with -
            // special chars

            $ersetze = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $umlaute = array("ae", "ue", "oe", "Ae", "Ue", "Oe", "ss"); // array of replacement chars
            $alias = preg_replace($ersetze, $umlaute, $alias);      // replace with preg

            // convert special chars
            $alias = \YAWK\sys::encodeChars($alias);
            // final check: just numbers and chars are allowed
            $alias = preg_replace("/[^a-z0-9\-\/]/i", "", $alias);
            // final filename
            $link = "$alias" . ".html";

            if ($blogid !== '0')
            {
                // it must be a blog...
                // ## select max id from blog
                if ($res = $db->query("SELECT MAX(id) FROM {blog}"))
                {
                    $row = mysqli_fetch_row($res);
                    $blogid = $row[0];
                }
                else
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not fetch MAX(id) FROM {blog}", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {blog}", "page=page-new", "4300");
                }
            }

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
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not fetch MAX(id) FROM {menu}", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {menu}", "page=page-new", "4300");
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
                    \YAWK\sys::setSyslog($db, 5, 1, "Could not fetch MAX(id) FROM {menu} WHERE menuID = $menuID", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {menu} WHERE menuID = $menuID", "page=page-new", "4300");
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
                // insert menu data
                if (!$res = $db->query("INSERT INTO {menu} (id,sort,menuID,published,text,href,blogid)
	                                   VALUES('" . $id . "',
	                                          '" . $sort . "',
	                                          '" . $menuID . "',
	                                          '" . $menu_published . "',
	                                          '" . $title . "',
	                                          '" . $link . "',
	                                          '" . $blogid . "')"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "could not insert data into {menu}", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Error:", "could not insert menu data", "page=page-new", "4300");
                }
                else
                    {   // success syslog entry
                        \YAWK\sys::setSyslog($db, 7, 0, "added new menu: $title (id: $id)", 0, 0, 0, 0);
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
                    \YAWK\sys::setSyslog($db, 2, 1, "could not select MAX(id) from pages db", 0, 0, 0, 0);
                }

            $alias = htmlentities($alias);
            // ## add new page to db pages
            if ($res = $db->query("INSERT INTO {pages} (id,published,date_created,date_changed,date_publish,date_unpublish,alias,title,locked,blogid,plugin)
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
                                           '".$plugin."')"))
            {
                // insert page successful, now generate some local meta tags
                $desc = "description";
                $keyw = "keywords";
                $words = "keyword1, keyword2, keyword3, keyword4";
                $desc = htmlentities($desc);
                $keyw = htmlentities($keyw);
                // add local metatags
                if (!$db->query("INSERT INTO {meta_local} (name, page, content)
                        VALUES ($desc, $id, $title)"))
                {   // error inserting page into database - throw error
                    \YAWK\sys::setSyslog($db, 2, 2, "local meta tags could not be stored", 0, 0, 0, 0);
                    // \YAWK\alert::draw("warning", "Error!", "Failed to insert meta description.", "", 4300);
                }
            }
            else
            {   // error inserting page into database - throw error
                \YAWK\sys::setSyslog($db, 2, 2, "unable to add page into database.", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "unable to add new page ($alias) id: $id into pages database.", "", 4300);
            }

            // create file
            $filename = "../content/pages/" . $alias . ".php";
            if (!file_exists($filename)) {
                $handle = fopen($filename, "wr");
                $res = fwrite($handle, $content);
                fclose($handle);
                chmod($filename, 0777);
            }
            //
            \YAWK\sys::setSyslog($db, 2, 0, "created $filename", 0, 0, 0, 0);
            return true;
        }

        /**
         * save a static page including all settings
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool
         */
        public function save($db)
        {
            /** @var $db \YAWK\db */
            $date_changed = date("Y-m-d G:i:s");

            /* alias string manipulation */
            $this->alias = mb_strtolower($this->alias); // lowercase
            $this->alias = str_replace(" ", "-", $this->alias); // replace all ' ' with -
            // special chars
            $umlaute = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $ersetze = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
            $this->alias = preg_replace($umlaute, $ersetze, $this->alias);        // replace with preg
            $this->alias = preg_replace("/[^a-z0-9\-\/]/i", "", $this->alias); // final check: just numbers and chars are allowed

            // rename file
            $oldAlias = substr($this->searchstring, 0, -5);  // remove last 5 chars (.html) to get the plain filename
            $oldFilename = "../content/pages/" . $oldAlias . ".php";
            $newFilename = "../content/pages/" . $this->alias . ".php";
            if (file_exists($oldFilename)) {
                // try to rename the new file
                if (!rename($oldFilename, $newFilename))
                { // throw error msg
                    \YAWK\sys::setSyslog($db, 5, 2, "unable to rename $oldFilename to new file: $newFilename", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning","Warning!","unable to rename $oldFilename to new file: $newFilename","","");
                }
                else
                {
                    // new file was stored, now do all the database stuff
                    // update meta tags, menu entries and finally the pages db itself
                    \YAWK\sys::setSyslog($db, 5, 0, "updated file $oldFilename to new file $newFilename", 0, 0, 0, 0);
                }

                // update local meta description
                if (!$db->query("UPDATE {meta_local}
  					SET content = '" . $this->metadescription . "'
                    WHERE name = 'description'
                    AND page = '" . $this->id . "'"))
                {
                    // throw error msg
                    \YAWK\sys::setSyslog($db, 5, 2, "local meta description could not be updated in database.", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "local meta description could not be stored in database.", "", 4200);
                }

                // update local meta tag keywords
                if (!$db->query("UPDATE {meta_local}
  					SET content = '" . $this->metakeywords . "'
                    WHERE name = 'keywords'
                    AND page = '" . $this->id . "'"))
                {
                    // throw error msg
                    \YAWK\sys::setSyslog($db, 5, 2, "local meta keywords could not be stored in database.", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "local meta keywords could not be stored in database.", "", 4200);
                }

                // update menu entry
                if (!$db->query("UPDATE {menu}
  				    SET text = '" . $this->title ."',
  				        href = '" . $this->alias . ".html',
  					 	gid = '" . $this->gid . "',
  						published = '" . $this->published . "'
                    WHERE href = '" . $this->searchstring . "'"))
                {
                    // throw error
                    \YAWK\sys::setSyslog($db, 5, 1, "menu entry could not be stored in database.", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "menu entry could not be stored in database.", "", 6200);
                }

                // update page db
                // check unpublish date
                if ($this->date_unpublish == "0000-00-00 00:00:00" || (empty($this->date_unpublish)))
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
                        menu = '" . $this->menu . "',
                        bgimage = '" . $this->bgimage . "'
                    WHERE id = '" . $this->id . "'"))
                    {
                        // throw error
                        \YAWK\sys::setSyslog($db, 5, 1, "page data could not be stored in database.", 0, 0, 0, 0);
                        // \YAWK\alert::draw("warning", "Warning", "page data could not be stored in database.", "", 6200);
                        \YAWK\alert::draw("danger", 'MySQL Error: ('.mysqli_errno($db).')', 'Database error: '.mysqli_error($db).'', "", 0);
                        return false;
                    }
                    else
                    {
                        // update pages db worked, all fin
                        \YAWK\sys::setSyslog($db, 2, 0, "updated $this->alias", 0, 0, 0, 0);
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
                        menu = '" . $this->menu . "',
                        bgimage = '" . $this->bgimage . "'
                    WHERE id = '" . $this->id . "'"))
                        {
                            // throw error
                            \YAWK\sys::setSyslog($db, 5, 1, "page data could not be stored in database.", 0, 0, 0, 0);
                            // \YAWK\alert::draw("warning", "Warning", "page data could not be stored in database.", "", 6200);
                            \YAWK\alert::draw("danger", 'MySQL Error: ('.mysqli_errno($db).')', 'Database error: '.mysqli_error($db).'', "", 0);
                            return false;
                        }
                        else
                        {
                            // update pages db worked, all fin
                            \YAWK\sys::setSyslog($db, 2, 0, "updated $this->alias", 0, 0, 0, 0);
                            return true;
                        }
                    }
            }
            else
                {
                    // something went wrong...
                    \YAWK\sys::setSyslog($db, 5, 2, "file $oldFilename does not exist - unable to update and save file", 0, 0, 0, 0);
                }
            return true;
        } // ./ save function


        /**
         * delete a static content page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param string $dirprefix directory prefix
         */
        function deleteContent($dirprefix)
        {
            global $dirprefix;
            $filename = $dirprefix . "../content/pages/" . $this->alias . ".php";
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
            return true;
        }

        /**
         * write content to static page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param string $dirprefix directory prefix
         * @param string $content the content to write
         * @return bool true|false
         */
        function writeContent($dirprefix, $content)
        {
            $alias = $this->alias;
            /* alias string manipulation */
            $alias = mb_strtolower($alias); // lowercase
            $alias = str_replace(" ", "-", $alias); // replace all ' ' with -
            // special chars
            $umlaute = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $ersetze = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
            $alias = preg_replace($umlaute, $ersetze, $alias);        // replace with preg
            $alias = preg_replace("/[^a-z0-9\-\/]/i", "", $alias); // final check: just numbers and chars are allowed
            $filename = $dirprefix . "content/pages/" . $alias . ".php";
            $handle = fopen($filename, "w+");
            if ($res = fwrite($handle, $content))
            {
                fclose($handle);
                chmod($filename, 0777);
                return true;
            }
            else
                {
                    return false;
                }
        }

        /**
         * read content from static page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param string $dirprefix directory prefix
         * @return string html content
         */
        function readContent($dirprefix)
        {
            $filename = $dirprefix . "content/pages/" . $this->alias . ".php";
            $handle = @fopen($filename, "rw");
            $content = @fread($handle, filesize($filename));
            fclose($handle);
            return $content;
        }

        /**
         * load page properties and store as object properties
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $alias page filename
         */
        function loadProperties($db, $alias)
        {
            /** @var $db \YAWK\db $res */
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
                    $this->alias = $alias;
                }
                else
                    {   // unable to load page properties
                        \YAWK\sys::setSyslog($db, 2, 2, "unable to load properties of page $alias", 0, 0, 0, 0);
                    }
            }
            else
                {   // page not set - nunable to load page properties
                    \YAWK\sys::setSyslog($db, 2, 2, "unable to load properties because page alias was not set", 0, 0, 0, 0);
                }
        }

        /**
         * get latest pages
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $limit limit to n entries
         * @return array|string
         */
        static function getLatest($db, $limit)
        {   /** @var $db \YAWK\db */
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
         * get any requested page property
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected page ID
         * @param string $property database field to get
         * @return string|bool the selected property or false
         */
        function getProperty($db, $id, $property)
        {   /** @var $db \YAWK\db $res */
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
                \YAWK\sys::setSyslog($db, 5, 1, "unable to get property: $property from Paged Database.", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning", "unable to get property: $property from Paged Database.", "", "4200");
                return false;
            }
            // q failed
            return null;
        }

        /**
         * get and include static page content
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param object $lang language obj
         * @return mixed
         */
        function getContent($db, $lang)
        {
            global $currentpage;
            if (isset($currentpage->date_publish)) {
                // ROLE CHECK
                if (isset($_SESSION['gid'])) {
                    // if SESSION ROLE is bigger or equal than current PAGE ROLE
                    if ($_SESSION['gid'] >= $currentpage->gid)
                    {

                    }
                    else
                    {   // user is not allowed to view this content
                        \YAWK\sys::setSyslog($db, 3, 1, "user with group ID $_SESSION[gid] is not allowed to view $currentpage->alias (required GID: $currentpage->gid)", 0, 0, 0, 0);
                        return false;
                    }
                }
                else if ($currentpage->gid > 1)
                {   // public user not allowed here, so....
                    \YAWK\sys::setSyslog($db, 3, 1, "public user tried to get content of $currentpage->alias (required GID: $currentpage->gid)", 0, 0, 0, 0);
                    return false;
                }
            }
            // GET STATUS
            $future = (isset($currentpage->date_publish));        // publish date + time
            if (isset($currentpage->date_publish_end)) {        // end publish date + time
                $publish_end = $currentpage->date_publish_end;
            }

            $now = date("Y-m-d G:i:s");                  // current date + time
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
            ) {
                // show error
                return include(\YAWK\controller::filterfilename($db, $lang, "content/errors/404.html"));

            } else {

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
                        sys::showTimeDiff($start, $end);
                    }
                    exit;
                }
                if ($currentpage->date_unpublish < $now XOR $currentpage->date_unpublish === NULL) {
                    echo "<br>Dieser Inhalt ist leider nicht mehr verf&uuml;gbar. <br><br>";
                    $start = strtotime($now);
                    $end = strtotime($currentpage->date_publish);
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "Publishing has ended on $currentpage->date_unpublish.<br><br>";
                        // YAWK\sys::showTimeDiff($start, $end);
                    }
                    exit;
                }
                return include(\YAWK\controller::filterfilename($db, $lang, "content/pages/" . $this->alias));
            }
        }

    } // ./ class page
} // ./ namespace