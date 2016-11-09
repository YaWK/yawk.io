<?php
namespace YAWK {
    /**
     * <b>The default pages class. Provide all functions to handle static html pages.</b>
     *
     * All functions that are required to handle a page. Methods are: create, save, edit, delete and many more.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.io
     * @since      File available since Release 0.0.1
     * @annotation The default pages class. Provide all functions to handle static pages.
     */
    class page
    {
        public $id = -1;
        public $alias = '';
        public $title = '';
        public $published = '';
        public $ownerid = -1;
        public $owner = false;
        public $menu = -1;
        public $gid;
        public $date_publish;
        public $date_unpublish;
        public $plugin;
        public $blogid;
        public $locked;
        public $metadescription;
        public $metakeywords;
        public $searchstring;


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
                \YAWK\alert::draw("warning", "Warning", "Could not fetch meta $type for page ID $id", "",4200);
            }
            // q failed
            return false;
        }

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

                if ($published === "0") { $status = "offline"; } else { $status = "online"; }

                // TOGGLE PAGES
                if (!$res = $db->query("UPDATE {pages}
                                        SET published = '" . $published . "'
                                        WHERE id = '" . $id . "'")) {
                    // could not update pages db table
                    print alert::draw("danger", "Error", "Site Status could not be toggled.", "", 4200);
                }
                else
                    {   // ok, set syslog entry
                        \YAWK\sys::setSyslog($db, 2, "toggled page $id to $status", 0, 0, 0, 0);
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
                    \YAWK\sys::setSyslog($db, 7, "toggled menu $id to $status", 0, 0, 0, 0);
                }
            }
            else
            {   // data type is incorrect, throw yoda's hint
                print \YAWK\alert::draw("danger", "Error", "YaWK said: variable manipulate you shall not do!", "", 4200);
            }
            return true;
        }

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
            else {
                print \YAWK\alert::draw("danger", "Error", "Site Lock could not be toggled.","page=pages",4200);
                if ($locked === "0") { $status = "unlocked"; } else { $status = "locked"; }
                \YAWK\sys::setSyslog($db, 2, "$status page id #$id", 0, 0, 0, 0);
                return false;
            }
        }

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
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                die ("Sorry, database error: could not fetch MAX(id).");
            }
            // ## add new page to db pages
            if ($res = $db->query("INSERT INTO {pages} (id,gid,date_created,date_publish,alias,title,blogid,locked,plugin)
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
                if (!$res2 = $db->query("INSERT INTO {meta_local} (name,page,content)
                                          VALUES ('" . $desc . "', '" . $id . "', '" . $title . "')"))
                {
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }

                // add local meta tags to db meta_local
                if (!$res3 = $db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $keyw . "','" . $id . "','" . $words . "')"))
                {
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not store local meta tags", "", "");
                }

                // prepare files
                $file = "../content/pages/" . $alias_old . ".php";
                $newfile = "../content/pages/" . $alias . ".php";
                // copy file
                if (!copy($file, $newfile) && !chmod($newfile, 0777))
                {
                    \YAWK\sys::setSyslog($db, 5, "copy failed: $file to $newfile", 0, 0, 0, 0);
                    print \YAWK\alert::draw("danger", "Error!", "File could not be copied. permissions of /content/pages !", "", "");
                }

                // ## selectmenuID from menu db
                if ($res = $db->query("SELECT menuID FROM {menu} WHERE title LIKE '" . $title . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    $menuID = $row[0];
                }
                else
                {   // select failed, throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
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
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
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
                    if ($res = $db->query("INSERT INTO {menu} (id,sort,menuID,title,href)
                          VALUES('" . $id . "','" . $sort . "', '" . $menuID . "', '" . $title_new . "', '" . $link . "')"))
                    {
                        \YAWK\sys::setSyslog($db, 2, "copy $newfile successful", 0, 0, 0, 0);
                       return true;
                    }
                    else
                    {
                        // insert failed, throw error
                        \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                        echo \YAWK\alert::draw("warning","Warning", "Could not insert menu entry for: $title_new", "", "");
                    }
                }
                else
                {
                    // select failed, throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    echo \YAWK\alert::draw("warning","Warning", "Could not select menu entry for: $menuID", "", "");
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                die ("Sorry, database error: could not insert data into pages table.");
            }
            \YAWK\sys::setSyslog($db, 5, "copy $newfile failed.", 0, 0, 0, 0);
            return false;
        }

        function delete($db)
        {
            /** @var $db \YAWK\db */
            // delete item from pages db
            if (!$res_pages = $db->query("DELETE FROM {pages} WHERE alias = '" . $this->alias . "'")) {
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error:", "could not delete page from database", "pages", "4300");
            }
            // delete item from menu db
            if (!$res_menu = $db->query("DELETE FROM {menu} WHERE href = '" . $this->alias . ".html'")) {
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error:", "could not delete menu entry from database", "pages", "4300");
            }
            // delete item from meta_local db
            if (!$res_menu = $db->query("DELETE FROM {meta_local} WHERE page = '" . $this->id. "'")) {
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning:", "could not delete local meta tags from database", "pages", "4300");
            }
            // build path + filename
            $filename = "../content/pages/" . $this->alias . ".php";
            if (file_exists($filename)) {
                if (!unlink($filename)) {
                    \YAWK\alert::draw("danger", "Error:", "could not delete file from /content/ folder", "pages", "4300");
                    return false;
                } else {
                    \YAWK\sys::setSyslog($db, 2, "deleted $filename", 0, 0, 0, 0);
                    return true;
                }
            }
            \YAWK\sys::setSyslog($db, 5, "file $filename does not exist. page->delete() failed", 0, 0, 0, 0);
            return false;
        }

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
            $date_publish = $date_created;
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
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
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
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger","Error:", "Could not fetch MAX(id) FROM {menu}", "page=page-new", "4300");
                }
                // to increment sort var correctly, check if there is an entry in the menu
                if ($res = $db->query("SELECT MAX(sort) FROM {menu} WHERE menuID = '" . $menuID . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if (!isset($row[0])) { // if not, give it a ID of 1
                        $sort = 1;
                    } else {
                        $sort = $row[0] + 1; // if entry exists, add +1 to sort #
                    }
                }
                else
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
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
                if (!$res = $db->query("INSERT INTO {menu} (id,sort,menuID,published,title,href,blogid)
	                                   VALUES('" . $id . "',
	                                          '" . $sort . "',
	                                          '" . $menuID . "',
	                                          '" . $menu_published . "',
	                                          '" . $title . "',
	                                          '" . $link . "',
	                                          '" . $blogid . "')"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Error:", "Could not fetch MAX(id) FROM {menu} WHERE menuID = $menuID", "page=page-new", "4300");
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
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                }

            $alias = htmlentities($alias);
            // ## add new page to db pages
            if ($res = $db->query("INSERT INTO {pages} (id,published,date_created,date_publish,alias,title,locked,blogid,plugin)
                                   VALUES ('" . $id . "',
                                           '" . $published . "',
                                           '" . $date_created . "',
                                           '" . $date_created . "',
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
                   // \YAWK\alert::draw("warning", "Error!", "Failed to insert meta description.", "", 4300);
                }
                if (!$db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ($keyw, $id, $words)"))
                {   // error inserting page into database - throw error
                    // \YAWK\alert::draw("warning", "Error!", "Failed to insert meta keywords.", "", 4300);
                }
            }
            else
            {   // error inserting page into database - throw error
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Could not insert page into database.", "", 4300);
            }

            // create file
            $filename = "../content/pages/" . $alias . ".php";
            if (!file_exists($filename)) {
                $handle = fopen($filename, "wr");
                $res = fwrite($handle, $content);
                fclose($handle);
                chmod($filename, 0777);
            }
            \YAWK\sys::setSyslog($db, 2, "added $filename", 0, 0, 0, 0);
            return true;
        }

        function save($db)
        {
            /** @var $db \YAWK\db */
            $date_changed = date("Y-m-d G:i:s");
            // $alias = $this->alias;
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
                { // throw error
                 \YAWK\alert::draw("warning","Warning!","Could not rename $oldFilename to new file: $newFilename","","");
                }
                else {
                    // new file was stored, now do all the database stuff
                    // update meta tags, menu entries and finally the pages db itself
                }
                // update local meta description
                if (!$result = $db->query("UPDATE {meta_local}
  					SET content = '" . $this->metadescription . "'
                    WHERE name = 'description'
                    AND page = '" . $this->id . "'"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "local meta description could not be stored in database.", "", 4200);
                }
                // update local meta tag keywords
                if (!$result = $db->query("UPDATE {meta_local}
  					SET content = '" . $this->metakeywords . "'
                    WHERE name = 'keywords'
                    AND page = '" . $this->id . "'"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "local meta keywords could not be stored in database.", "", 4200);
                }
                // update menu entry
                if (!$result = $db->query("UPDATE {menu}
  				    SET title = '". $this->title ."',
  				        href = '" . $this->alias . ".html',
  					 	gid = '" . $this->gid . "',
  						published = '" . $this->published . "'
                  WHERE href = '" . $this->searchstring . "'"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "menu entry could not be stored in database.", "", 4200);
                }
                // update menu entry
                if (!$result = $db->query("UPDATE {pages} SET
                                        published = '" . $this->published . "',
                                        gid = '" . $this->gid . "',
                                        date_changed = '" . $date_changed . "',
                                        date_publish = '" . $this->date_publish . "',
                                        date_unpublish = '" . $this->date_unpublish . "',
                                        title = '" . $this->title . "',
                                        alias = '" . $this->alias . "',
                                        menu = '" . $this->menu . "',
                                        bgimage = '" . $this->bgimage . "'
                      WHERE id = '" . $this->id . "'"))
                {   // throw error
                    \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning", "menu entry could not be stored in database.", "", 4200);
                }
                else {
                    // update pages db worked, all fin
                    \YAWK\sys::setSyslog($db, 2, "saved $filename", 0, 0, 0, 0);
                    return true;
                }
            }
            // something went wrong...
            \YAWK\sys::setSyslog($db, 5, "file $oldFilename does not exist.", 0, 0, 0, 0);
            return false;
        } // ./ save function

        function deleteContent($dirprefix)
        {
            global $dirprefix;
            $filename = $dirprefix . "../content/pages/" . $this->alias . ".php";
            if (file_exists($filename)) {
                unlink($filename);
            }
        }

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
            $res = fwrite($handle, $content);
            fclose($handle);
            chmod($filename, 0777);
            return $res;
        }

        function readContent($dirpraefix)
        {
            $filename = $dirpraefix . "content/pages/" . $this->alias . ".php";
            $handle = @fopen($filename, "rw");
            $content = @fread($handle, filesize($filename));
            fclose($handle);
            return $content;
        }

        function loadProperties($db, $alias)
        {
            /** @var $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {pages} WHERE alias = '".$alias."'");
            if ($row = mysqli_fetch_assoc($res)) {
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
               {   // could not load properties, set syslog entry
                   \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
               }
        }

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
                \YAWK\sys::setSyslog($db, 5, "".$db->error()."", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning", "Could not get property: $property from Paged Database.", "", "4200");
                return false;
            }
            // q failed
            return null;
        }

        function getContent($db)
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
                        return false;
                        // echo "Sorry!! You (Group ID: $_SESSION[gid]) ARE not allowed to view this content. This page is for users with >= roleID: $currentpage->gid";
                        // exit;
                    }
                }
                else if ($currentpage->gid > 1)
                {   // public user not allowed here, so....
                    return false;
                    // echo "Sorry Public User! You are not allowed to view this content. This page is for users with >= roleID: $currentpage->gid";
                    // exit;
                }
            }
            // GET STATUS
            $zukunft = (isset($currentpage->date_publish));        // publish date + time
            if (isset($currentpage->date_publish_end)) {        // end publish date + time
                $publish_end = $currentpage->date_publish_end;
            }

            $jetzt = date("Y-m-d G:i:s");                  // current date + time
            // trim vars
            $date_published = trim($zukunft);
            $publish_end = trim(isset($publish_end));
            $date_now = trim($jetzt);

            // de-construct string
            $date_now = substr($jetzt, 0, 10);    // get the first 10 chars, start from left
            $time_now = substr($jetzt, -8);    // get the last 8 chars, start from right

            $date_published = substr($zukunft, 0, 10);
            $time_published = substr($zukunft, -8);

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
                return include(\YAWK\controller::filterfilename("content/errors/404.html"));

            } else {

                if ($currentpage->date_publish > $jetzt) {
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "<br>Content Pending. Publishing is scheduled for $currentpage->date_publish<br><br>";
                    } else {
                        echo "&nbsp;";
                    }

                    $start = strtotime($jetzt);
                    $end = strtotime($currentpage->date_publish);
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        sys::showTimeDiff($start, $end);
                    }
                    exit;
                }
                if ($currentpage->date_unpublish < $jetzt XOR $currentpage->date_unpublish === "0000-00-00 00:00:00") {
                    echo "<br>Dieser Inhalt ist leider nicht mehr verf&uuml;gbar. <br><br>";
                    $start = strtotime($jetzt);
                    $end = strtotime($currentpage->date_publish);
                    $timediff = settings::getSetting($db, "timediff");
                    if ($timediff === '1') {
                        echo "Publishing has ended on $currentpage->date_unpublish.<br><br>";
                        // YAWK\sys::showTimeDiff($start, $end);
                    }
                    exit;
                }
                return include(\YAWK\controller::filterfilename("content/pages/" . $this->alias));
            }
        }

    } // ./ class page
} // ./ namespace