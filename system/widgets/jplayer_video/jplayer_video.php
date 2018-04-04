<?php
if (!isset($jPlayerVideo) || (empty($jPlayerVideo)))
{   // include player class
    require_once ("system/widgets/jplayer_video/classes/jplayer_video.class.php");
    // create new player object
    $jPlayerVideo = new \YAWK\WIDGETS\JPLAYER\VIDEO\jPlayerVideo();
}
?>
<?php
// set default values
$jPlayerRootMediaFolder = 'media/video/';
$jPlayerUserMediaFolder = 'demo';
$jPlayerInstance = 1;
$jPlayerInitialMute = false;
$jPlayerDefaultVolume = "0.3";
$jPlayerWidth = "100%";
$jPlayerSkin = "light";
$jPlayerPoster = '';
$jPlayerDownload = "false";
$heading = '';
$subtext = '';

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];

    // make sure, the player got it's own instance ID
    $jPlayerInstance = $_GET['widgetID'];

    // get widget settings from db
    $res = $db->query("SELECT * FROM {widget_settings}
    WHERE widgetID = '".$widgetID."'
    AND activated = '1'");
    while($row = mysqli_fetch_assoc($res))
    {   // set widget properties and values into vars
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget properties */

        /* filter and load those widget properties */
        if (isset($w_property)){
            switch($w_property)
            {
                /* url of the video to stream */
                case 'jPlayerVideoUserMediaFolder';
                    $jPlayerUserMediaFolder = $w_value;
                    break;

                /* width */
                case 'jPlayerVideoWidth';
                    $jPlayerWidth = $w_value;
                    break;

                /* skin */
                case 'jPlayerVideoSkin';
                    $jPlayerSkin = $w_value;
                    $jPlayerSkin = mb_strtolower($jPlayerSkin);
                    break;

                /* heading */
                case 'jPlayerVideoHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'jPlayerVideoSubtext';
                    $subtext = $w_value;
                    break;

                /* initial volume */
                case 'jPlayerVideoDefaultVolume';
                    $jPlayerDefaultVolume = $w_value;
                    break;

                /* initial mute true|false */
                case 'jPlayerVideoInitialMute';
                    $jPlayerInitialMute = $w_value;
                    break;

                /* url to a any poster image */
                case 'jPlayerVideoPoster';
                    $jPlayerPoster = $w_value;
                    break;

                /* allow to download file? */
                case 'jPlayerVideoDownload';
                    $jPlayerDownload = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}


// if a heading is set and not empty
if (isset($heading) && (!empty($heading)))
{   // add a h1 tag to heading string
    $heading = "$heading";

    // if subtext is set, add <small> subtext to string
    if (isset($subtext) && (!empty($subtext)))
    {   // build a headline with heading and subtext
        $subtext = "<small>$subtext</small>";
        $headline = "<h1>$heading&nbsp;"."$subtext</h1>";
    }
    else
    {   // build just a headline - without subtext
        $headline = "<h1>$heading</h1>";    // draw just the heading
    }
}
else
{   // leave empty if it's not set
    $headline = '';
}
echo $headline;
?>
    <!-- jplayer -->
    <link type="text/css" href="system/widgets/jplayer/skins/<?php echo $jPlayerSkin; ?>/jplayer.<?php echo $jPlayerSkin; ?>.css" rel="stylesheet">
    <script type="text/javascript" src="system/widgets/jplayer/js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="system/widgets/jplayer/js/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="system/widgets/jplayer/js/browser.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function(){

            var Playlist = function(instance, playlist, options) {
                var self = this;

                this.instance = instance; // String: To associate specific HTML with this playlist
                this.playlist = playlist; // Array of Objects: The playlist
                this.options = options; // Object: The jPlayer constructor options for this playlist

                this.current = 0;

                this.cssId = {
                    jPlayer: "jquery_jplayer_",
                    interface: "jp_interface_",
                    playlist: "jp_playlist_"
                };
                this.cssSelector = {};

                $.each(this.cssId, function(entity, id) {
                    self.cssSelector[entity] = "#" + id + self.instance;
                });

                if(!this.options.cssSelectorAncestor) {
                    this.options.cssSelectorAncestor = this.cssSelector.interface;
                }

                $(this.cssSelector.jPlayer).jPlayer(this.options);

                $(this.cssSelector.interface + " .jp-previous").click(function() {
                    self.playlistPrev();
                    $(this).blur();
                    return false;
                });

                $(this.cssSelector.interface + " .jp-next").click(function() {
                    self.playlistNext();
                    $(this).blur();
                    return false;
                });
            };

            Playlist.prototype = {
                displayPlaylist: function() {
                    var self = this;
                    $(this.cssSelector.playlist + " ul").empty();
                    for (i=0; i < this.playlist.length; i++) {
                        var listItem = (i === this.playlist.length-1) ? "<li class='jp-playlist-last'>" : "<li>";
                        listItem += "<a href='#' id='" + this.cssId.playlist + this.instance + "_item_" + i +"' tabindex='1'>"+ this.playlist[i].name +"</a>";

                        // Create links to free media
                        if(this.playlist[i].free) {
                            var first = true;
                            listItem += "<div class='jp-free-media'>(";
                            $.each(this.playlist[i], function(property,value) {
                                if($.jPlayer.prototype.format[property]) { // Check property is a media format.
                                    if(first) {
                                        first = false;
                                    } else {
                                        listItem += " | ";
                                    }
                                    listItem += "<a id='" + self.cssId.playlist + self.instance + "_item_" + i + "_" + property + "' href='" + value + "' tabindex='1'>" + property + "</a>";
                                }
                            });
                            listItem += ")</span>";
                        }

                        listItem += "</li>";

                        // Associate playlist items with their media
                        $(this.cssSelector.playlist + " ul").append(listItem);
                        $(this.cssSelector.playlist + "_item_" + i).data("index", i).click(function() {
                            var index = $(this).data("index");
                            if(self.current !== index) {
                                self.playlistChange(index);
                            } else {
                                $(self.cssSelector.jPlayer).jPlayer("play");
                            }
                            $(this).blur();
                            return false;
                        });

                        // Disable free media links to force access via right click
                        if(this.playlist[i].free) {
                            $.each(this.playlist[i], function(property,value) {
                                if($.jPlayer.prototype.format[property]) { // Check property is a media format.
                                    $(self.cssSelector.playlist + "_item_" + i + "_" + property).data("index", i).click(function() {
                                        var index = $(this).data("index");
                                        $(self.cssSelector.playlist + "_item_" + index).click();
                                        $(this).blur();
                                        return false;
                                    });
                                }
                            });
                        }
                    }
                },
                playlistInit: function(autoplay) {
                    if(autoplay) {
                        this.playlistChange(this.current);
                    } else {
                        this.playlistConfig(this.current);
                    }
                },
                playlistConfig: function(index) {
                    $(this.cssSelector.playlist + "_item_" + this.current).removeClass("jp-playlist-current").parent().removeClass("jp-playlist-current");
                    $(this.cssSelector.playlist + "_item_" + index).addClass("jp-playlist-current").parent().addClass("jp-playlist-current");
                    this.current = index;
                    $(this.cssSelector.jPlayer).jPlayer("setMedia", this.playlist[this.current]);
                },
                playlistChange: function(index) {
                    this.playlistConfig(index);
                    $(this.cssSelector.jPlayer).jPlayer("play");
                },
                playlistNext: function() {
                    var index = (this.current + 1 < this.playlist.length) ? this.current + 1 : 0;
                    this.playlistChange(index);
                },
                playlistPrev: function() {
                    var index = (this.current - 1 >= 0) ? this.current - 1 : this.playlist.length - 1;
                    this.playlistChange(index);
                }
            };


            var videoPlaylist = new Playlist("<?php echo $jPlayerInstance; ?>",

                [<?php $jPlayerVideo->getVideoFiles($jPlayerRootMediaFolder, $jPlayerUserMediaFolder, $jPlayerPoster, $jPlayerDownload); ?>],
                {
                ready: function() {
                    videoPlaylist.displayPlaylist();
                    videoPlaylist.playlistInit(false); // Parameter is a boolean for autoplay.
                },
                ended: function() {
                    videoPlaylist.playlistNext();
                },
                play: function() {
                    $(this).jPlayer("pauseOthers");
                },
                swfPath: "js",
                supplied: "ogv, m4v, mp4, mpg, flv",
                volume: "<?php echo $jPlayerDefaultVolume; ?>",     // intial volume value from 0 to 1 eg 0.3
                muted: <?php echo $jPlayerInitialMute; ?>         // inital mute? false | true
            });

        });
        //]]>
    </script>
    <div class="jp-video jp-video-270p">
        <div class="jp-type-playlist">
            <div id="jquery_jplayer_<?php echo $jPlayerInstance; ?>" class="jp-jplayer"></div>
            <div id="jp_interface_<?php echo $jPlayerInstance; ?>" class="jp-interface">
                <div class="jp-video-play"></div>
                <ul class="jp-controls">
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    <li><a href="#" class="jp-previous" tabindex="1">previous</a></li>
                    <li><a href="#" class="jp-next" tabindex="1">next</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>
            </div>
            <div id="jp_playlist_<?php echo $jPlayerInstance; ?>" class="jp-playlist">
                <ul>
                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                    <li></li>
                </ul>
            </div>
        </div>
    </div>


<?php
// }   // end namespace
?>