<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['ASSETS'], $lang['SETTINGS']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
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
                            $assetStatus = "<i class=\"label label-success\">$lang[ON_]</i>";
                        }
                        else
                            {
                                $assetStatus = "<i class=\"label label-danger\">$lang[OFF_]</i>";
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
                        echo "              
              <!-- BOX -->
              <div class=\"box box-default collapsed-box\">
                  <div class=\"box-header with-border\">
                      <h3 class=\"box-title\">$row[asset] <small>$lang[EDIT]</small></h3>
                      <!-- box-tools -->
                      <div class=\"box-tools pull-right\">
                          <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-plus\"></i>
                          </button>
                      </div>
                      <!-- /.box-tools -->
                  </div>
                  <div class=\"box-body\" style=\"display: none;\">
                      <!-- BOX BODY -->
                      <input type=\"hidden\" class=\"form-control\" name=\"ID\" value=\"$row[id]\">
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
                      </select>
                      <button class=\"btn btn-success pull-right\" id=\"save\" name=\"save\" style=\"margin-top:2px;\"><i id=\"savebuttonIcon\" class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[SAVE_SETTINGS]</button>
                      <br><br>
                  </div>
              </div>";

                    }
                ?>
    </div>
    <div class="col-md-4">
        <!-- database settings -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['ASSET']; ?>  <small><?php echo $lang['ADD']; ?> </small></h3>
            </div>
            <div class="box-body">
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
                    <option value="1"><?php echo $lang['PLEASE_SELECT']; ?></option>
                    <option value="1"><?php echo $lang['REQUIRED']; ?></option>
                    <option value="2"><?php echo $lang['OPTIONAL']; ?></option>
                </select>
                <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i id="savebuttonIcon" class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['ASSET_ADD']; ?></button>
            </div>
        </div>
    </div>
</div>