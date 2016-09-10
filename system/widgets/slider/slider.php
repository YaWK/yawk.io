<!-- FlexSlider pieces -->
<link rel="stylesheet" href="system/engines/jquery/flexslider/default-five-slides.css" type="text/css" />
<script src="system/engines/jquery/flexslider/jquery.flexslider-min.js"></script>
<script src="system/engines/jquery/flexslider/css3-mediaqueries.js"></script>
<!-- Kwiks pieces -->
<script src="system/engines/jquery/flexslider/kwiks.js"></script>
<!-- Hook up the FlexSlider -->
<script type="text/javascript">
	var Main = Main || {};

	jQuery(window).load(function() {
		window.responsiveFlag = jQuery('#responsiveFlag').css('display');
		Main.gallery = new Gallery();

		jQuery(window).resize(function() {
			Main.gallery.update();
		});
	});

	function Gallery(){
		var self = this,
			container = jQuery('.flexslider'),
			clone = container.clone( false );

		this.init = function (){
			if( responsiveFlag == 'block' ){
				var slides = container.find('.slides');

				slides.kwicks({
					max : 500,
					spacing : 0
				}).find('li > a').click(function (){
					return false;
				});
			} else {
				container.flexslider();
			}
		}
		this.update = function () {
			var currentState = jQuery('#responsiveFlag').css('display');

			if(responsiveFlag != currentState) {

				responsiveFlag = currentState;
				container.replaceWith(clone);
				container = clone;
				clone = container.clone( false );

				this.init();
			}
		}

		this.init();
	}
</script>


<h2><i class="fa fa-heart-o"></i> Was ich f&uuml;r Dich tun kann... <small>was Man(n) gl&uuml;cklich macht</small></h2>
<div class="flexslider">
	<ul class="slides">
		<li>
			<img src="media/images/slider-01-bw.jpg" class="protected" />
			<div class="flex-caption">
				<h2><a href="hure-wien-buchen.html">Der Quickie</a></h2>
				<p>Wenn die Lust gro&szlig;, Deine freie Zeit aber knapp ist, bietet sich eine halbe
				Stunde an. In der Zeit k&ouml;nnen wir all das machen, was auch in einer Stunde m&ouml;glich ist.
				Ideal zur schnellen Entspannung.
				<br><small>Kosten: &euro; 100,- / Dauer ca. 30 Minuten.</small></p>
			</div>
		</li>
		<li>
			<img src="media/images/slider-02-hj-bw.jpg" class="protected" />
			<div class="flex-caption">
				<h2><a href="hure-wien-buchen.html">Der perfekte Handjob</a></h2>
				<p>Ich nehme pjur light (Gleitgel) zur Hand und massiere Dein bestes St&uuml;ck mit meinen H&auml;nden
					nach allen Regeln der Kunst. Ich liebe es, einen Schwanz mit sanftem Druck abzuwichsen. Es wird Dir gefallen!
				<br><small>Kosten: &euro; 100,- / Dauer ca. 30 Minuten.</small></p>
			</div>
		</li>
		<li>
			<img src="media/images/slider-03-bw.jpg" class="protected" />
			<div class="flex-caption">
				<h2><a href="hure-wien-buchen.html">1 Stunde zu zweit</a></h2>
				<p>Zu zweit ist es ganz besonders sch&ouml;n, romantisch, kuschelig. Eine Stunde, in der es vorwiegend um
					Deine Bed&uuml;rfnisse geht. Ich freue mich, wenn ich mich ausgiebig um Dich k&uuml;mmern kann.
					<br><small>Kosten: &euro; 160.- / Dauer ca. 60 Minuten.</small></p>
			</div>
		</li>
		<li>
			<img src="media/images/slider-05-2legs-bw.jpg" class="protected" />
			<div class="flex-caption">
				<h2><a href="hure-wien-buchen.html"><b>1 Stunde zu dritt (FFM)</b></a></h2>
				<p>2 Girls und Du - welcher Mann tr&auml;umt nicht ab und zu davon, sich mit zwei Frauen gleichzeitig zu vergn&uuml;gen?
					Ist das auch eine Phantasie von Dir? Mo., Di., oder Mi. ist ein Date zu dritt mit meiner Freundin m&ouml;glich.
					<br><small>Kosten: &euro; 320.- / Dauer ca. 60 Minuten.</small></p>
			</div>
		</li>
		<li>
			<img src="media/images/slider-05-2butts-bw.jpg" class="protected" />
			<div class="flex-caption">
				<h2><a href="hure-wien-buchen.html">2 Stunden zu dritt (FFM)</a></h2>
				<p>2 Girls und Du - wenn eine Stunde nicht ausreicht und Du uns intensiver genie&szlig;en m&ouml;chtest,
					ist dieses Arrangement genau das richtige f&uuml;r Dich. L&auml;ngere Buchungen
					sind nur auf Anfrage m&ouml;glich.
					<br><small>Kosten: &euro; 600.- / Dauer ca. 120 Minuten.</small></p>
			</div>
		</li>
	</ul>
</div>
<span id="responsiveFlag"></span>