<?php
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
/** @var $db db */
/** @var $lang language */

// DELETE ASSET
if (isset($_GET['delete']) && ($_GET['delete'] == 1))
{   // check if ID is set
    if (isset($_GET['id']) && (!empty($_GET['id'])))
    {   // delte asset from db
        if ($db->query("DELETE from {assets_types} WHERE id = $_GET[id]"))
        {   // success, throw msg
            alert::draw("success", "$lang[SUCCESS]", "$lang[ASSET_DEL_OK]", "", "800");
        }
        else
        {   // failed to delete, throw error msg
            alert::draw("danger", "$lang[ERROR]", "$lang[ASSET_DEL_FAILED]", "", "2600");
        }
    }
}
// ENABLE / DISABLE ASSET
if (isset($_GET['toggle']) && $_GET['toggle'] == 1)
{
    // prepare user data
    $id = $db->quote($_GET['id']);
    $published = $db->quote($_GET['published']);

    // toggle publish state
    if ($published == 1)
    { $published = 0; }
    else if ($published == 0)
    { $published = 1; }

    // add asset to db
    if ($db->query(("UPDATE {assets_types}
                            SET published = '" . $published . "'
                            WHERE id = '" . $id . "'")))
    {   // all good, throw success msg
        alert::draw("success", "$lang[SUCCESS]", "$lang[ASSET_TOGGLE_OK]", "", "800");
    }
    else
    {   // failed to add new asset - throw error msg
        alert::draw("danger", "$lang[ERROR]", "$lang[ASSET_TOGGLE_FAILED]", "", "2600");
    }
}

// POST DATA SENT
if (isset($_POST) && (!empty($_POST)))
{
    // ADD NEW ASSET
    if (isset($_GET['newAsset']) && $_GET['newAsset'] == true)
    {
        // prepare user data
        $assetType = $db->quote($_POST['assetType']);
        $assetName = $db->quote($_POST['assetName']);
        $property = $db->quote($_POST['assetName']);
        $internal = $db->quote($_POST['internal']);
        $url1 = $db->quote($_POST['url1']);
        $url2 = $db->quote($_POST['url2']);
        $url3 = $db->quote($_POST['url3']);

        $row = $db->query("SELECT MAX(sortation) FROM {assets_types}");
        $res = mysqli_fetch_row($row);
        if (isset($res[0])){
            $sortation = $res[0];
        }
        else {
            $sortation = 0;
        }

        // add asset to db
        if ($db->query("INSERT INTO {assets_types} (type, sortation, asset, property, internal, url1, url2, url3) 
                        VALUES ('".$assetType."', '".$sortation."', '".$assetName."', '".$property."', '".$internal."', 
                        '".$url1."', '".$url2."', '".$url3."')"))
        {   // all good, throw success msg
            alert::draw("success", "$lang[SUCCESS]", "$lang[ASSET_ADD_OK]", "", "1800");
        }
        else
        {   // failed to add new asset - throw error msg
            alert::draw("danger", "$lang[ERROR]", "$lang[ASSET_ADD_FAILED]", "", "2600");
        }
    }

    // UPDATE EXISTING ASSET
    if (isset($_GET['edit']) && $_GET['edit'] == 1)
    {
        // prepare user data
        $id = $db->quote($_POST['id']);
        $assetType = $db->quote($_POST['assetType']);
        $assetName = $db->quote($_POST['assetName']);
        $property = $db->quote($_POST['assetName']);
        $internal = $db->quote($_POST['internal']);
        $url1 = $db->quote($_POST['url1']);
        $url2 = $db->quote($_POST['url2']);
        $url3 = $db->quote($_POST['url3']);
        $sortation = $db->quote($_POST['sortation']);

        // add asset to db
        if ($db->query(("UPDATE {assets_types}
                            SET type = '" . $assetType . "',
                                asset = '" . $assetName . "',
                                property = '" . $property . "',
                                internal = '" . $internal . "',
                                url1 = '" . $url1 . "',
                                url2 = '" . $url2 . "',
                                url3 = '" . $url3 . "',
                                sortation = '" . $sortation . "'
                            WHERE id = '" . $id . "'")))
        {   // all good, throw success msg
            alert::draw("success", "$lang[SUCCESS]", "$lang[ASSET_UPDATE_OK]", "", "800");
        }
        else
        {   // failed to add new asset - throw error msg
            alert::draw("danger", "$lang[ERROR]", "$lang[ASSET_UPDATE_FAILED]", "", "2600");
        }
    }
}

?>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['ASSETS'], $lang['SETTINGS']);
echo backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- DATABASE -->
<div class="box">
    <div class="box-body">
        <div class="col-md-12">
            <?php echo "<h4><i class=\"fa fa-puzzle-piece\"></i> &nbsp;$lang[ASSETS]&nbsp;<small>$lang[ASSETS_SUBTEXT]</small></h4>"; ?>
        </div>
    </div>
</div>
<div class="row animated fadeIn">
    <div class="col-md-8">
        <?php
        $res = $db->query("SELECT * FROM {assets_types} ORDER BY asset");
        while ($row = mysqli_fetch_assoc($res))
        {
            if ($row['published'] == 1)
            {
                $assetStatus = "<i class=\"label label-success\">$lang[ONLINE]</i>";
            }
            else
            {
                $assetStatus = "<i class=\"label label-danger\">$lang[OFFLINE]</i>";
            }

            if ($row['type'] == 1)
            {
                $assetType1Selected = "selected";
            }
            else
            {
                $assetType1Selected = '';
            }
            if ($row['type'] == 2)
            {
                $assetType2Selected = "selected";
            }
            else
            {
                $assetType2Selected = '';
            }
            if ($row['type'] == 3)
            {
                $assetType3Selected = "selected";
            }
            else
            {
                $assetType3Selected = '';
            }
            echo "              
              <!-- BOX -->
              <div class=\"box box-default collapsed-box\">
                  <div class=\"box-header with-border\">
                      <h3 class=\"box-title\"><b>$row[sortation].</b> $row[asset] <small>$lang[EDIT]</small></h3>
                      <!-- box-tools -->
                      <div class=\"box-tools pull-right\">
                      <small><a href=\"index.php?page=settings-assets&toggle=1&published=$row[published]&id=$row[id]\">$assetStatus</a></small>
                          <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-plus\"></i>
                          </button>
                      </div>
                      <!-- /.box-tools -->
                  </div>
                  <div class=\"box-body\" style=\"display: none;\">
                      <!-- BOX BODY --> 
                  <form name=\"form\" role=\"form\" action=\"index.php?page=settings-assets&edit=1&id=$row[id]\" method=\"POST\">
                      <input type=\"hidden\" class=\"form-control\" name=\"id\" value=\"$row[id]\">
                      <label for=\"assetName\">$lang[NAME]</label>
                        <input type=\"text\" class=\"form-control\" name=\"assetName\" id=\"assetName\" value=\"$row[asset]\" placeholder=\"$lang[ASSET_NAME_PH]\">
                      <label for=\"internal\">$lang[INTERNAL]</label>
                        <input type=\"text\" class=\"form-control\" name=\"internal\" id=\"internal\" value=\"$row[internal]\" placeholder=\"$lang[ASSET_INTERNAL_PH]\">
                      <label for=\"url1\">$lang[URL] 1</label>
                        <input type=\"text\" class=\"form-control\" name=\"url1\" id=\"url1\" value=\"$row[url1]\" placeholder=\"$lang[ASSET_URL_PH]\">
                      <label for=\"url2\">$lang[URL] 2</label>
                        <input type=\"text\" class=\"form-control\" name=\"url2\" id=\"url2\" value=\"$row[url2]\" placeholder=\"$lang[ASSET_URL_PH]\">
                      <label for=\"url3\">$lang[URL] 3</label>
                        <input type=\"text\" class=\"form-control\" name=\"url3\" id=\"url3\" value=\"$row[url3]\" placeholder=\"$lang[ASSET_URL_PH]\">
                      <label for=\"assetType\">$lang[TYPE]</label>                                
                      <select class=\"form-control\" name=\"assetType\" id=\"assetType\">
                        <option value=\"1\">$lang[PLEASE_SELECT]</option>
                        <option value=\"1\" $assetType1Selected>$lang[REQUIRED]</option>
                        <option value=\"2\" $assetType2Selected>$lang[OPTIONAL]</option>
                        <option value=\"3\" $assetType3Selected>$lang[USER_DEFINED]</option>
                      </select>
                      <label for=\"sortation\">$lang[LOADING_ORDER]</label>
                       <input type=\"text\" class=\"form-control\" name=\"sortation\" id=\"sortation\" value=\"$row[sortation]\" placeholder=\"$lang[ORDER_PH]\">
                      <a style=\"margin-top:2px;\" role=\"dialog\" data-confirm=\"$lang[ASSET_DEL] &laquo;$row[asset]&raquo;\"
                   title=\"$lang[ASSET] $lang[DELETE]\" href=\"index.php?page=settings-assets&delete=1&id=$row[id]&asset=$row[asset]\" class=\"btn btn-default pull-left\"><i class=\"fa fa-trash-o\"></i> $lang[DELETE]</a>
                      <button class=\"btn btn-success pull-right\" type=\"submit\" value=\"save\" id=\"savebutton\" title=\"$lang[SAVE]\" name=\"save\" style=\"margin-top:2px;\"><i id=\"savebuttonIcon\" class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[SAVE_SETTINGS]</button>
                      <br><br>
                  </form>
                  </div>
              </div>";

        }
        ?>
    </div>
    <div class="col-md-4">
        <!-- add new asset form -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['ASSET']; ?>  <small><?php echo $lang['ADD']; ?> </small></h3>
            </div>
            <div class="box-body">
                <form name="newAsset" role="form" action="index.php?page=settings-assets&newAsset=true" method="POST">
                    <label for="assetName"><?php echo $lang['NAME']; ?></label>
                    <input type="text" class="form-control" name="assetName" id="assetName" placeholder="<?php echo $lang['ASSET_NAME_PH']; ?>">
                    <label for="internal"><?php echo $lang['INTERNAL']; ?></label>
                    <input type="text" class="form-control" name="internal" id="internal" placeholder="<?php echo $lang['ASSET_INTERNAL_PH']; ?>">
                    <label for="url1"><?php echo $lang['URL']; ?> 1</label>
                    <input type="text" class="form-control" name="url1" id="url1" placeholder="<?php echo $lang['ASSET_URL_PH']; ?>">
                    <label for="url2"><?php echo $lang['URL']; ?> 2</label>
                    <input type="text" class="form-control" name="url2" id="url2" placeholder="<?php echo $lang['ASSET_URL_PH']; ?>">
                    <label for="url3"><?php echo $lang['URL']; ?> 3</label>
                    <input type="text" class="form-control" name="url3" id="url3" placeholder="<?php echo $lang['ASSET_URL_PH']; ?>">
                    <label for="assetType"><?php echo $lang['TYPE']; ?></label>
                    <select class="form-control" name="assetType" id="assetType">
                        <option value="1"><?php echo $lang['REQUIRED']; ?></option>
                        <option value="2" selected><?php echo $lang['OPTIONAL']; ?></option>
                        <option value="3"><?php echo $lang['USER_DEFINED']; ?></option>
                    </select>
                    <button class="btn btn-success pull-right" id="newAsset" name="newAsset" style="margin-top:2px;"><i id="savebuttonIcon" class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['ASSET_ADD']; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
