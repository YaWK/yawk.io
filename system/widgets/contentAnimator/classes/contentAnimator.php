<?php
namespace YAWK\WIDGETS\CONTENTANIMATOR\ANIMATE
{
    /**
     * @details<b>Add modern fx and motion to any elements of your website.</b>
     *
     * <p>The content animator widget lets you animate any kind of content. Simply add class="animate" to
     * any html object in your DOM and the effect will be applied to the affected element. You can setup,
     * which effect you wish to be drawn, as well as the scroll distance to the object. Be careful to use
     * a not too big value, otherwise your users will think, that there is no more content before it got
     * faded in. (or whichever effect you have activated)</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Add a pre-defined effect to any of your content elements.
     */
    class contentAnimator
    {
        /** @param object global widget object data */
        public $widget = '';

        /** @param string Scroll distance to target which should be effected */
        public $contentAnimatorScrollValue = '620';

        /** @param string Which effect should be drawn on class="animated"
         * At the time of writing this, following effects were available:
           slideUp, slideDown, slideLeft, slideRight, fade, fadeMedium, fadeSlow */
        public $contentAnimatorClass = 'slideUp';

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
         * @brief Print all object data
         * @brief (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Initialize: prepare proerties and load javascript
         * @brief use this method to run the clock
         */
        public function init()
        {
            // check if class is empty
            if (!isset($this->contentAnimatorClass) || (empty($this->contentAnimatorClass)))
            {	// default behavior:
                $this->contentAnimatorClass = "fadeIn";
            }
            // check if scroll value is empty
            if (!isset($this->contentAnimatorScrollValue) || (empty($this->contentAnimatorScrollValue)))
            {	// default value
                $this->contentAnimatorScrollValue = 600;
            }
            // check if infinite is set
            if (!isset($this->contentAnimatorInfinite) || (empty($this->contentAnimatorInfinite)))
            {	// default css value
                $this->contentAnimatorInfinite = "";
            }
            else
            {   // infinite is set to true
                if ($this->contentAnimatorInfinite === "true")
                {   // set the correct value
                    $this->contentAnimatorInfinite = "infinite";
                }
                else
                {   // don't loop animation: leave infinite empty
                    $this->contentAnimatorInfinite = "";
                }
            }
            // load velocity.js
            // echo "<script src=\"system/engines/velocityJS/velocity.min.js\"></script>";
            // echo "<script src=\"system/engines/velocityJS/velocity-ui.min.js\"></script>";

            // load css with animation definitions
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"system/widgets/contentAnimator/animate.css\">";
            // echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"system/engines/animateCSS/animate.min.css\">";
            // echo "<style type=\"text/css\">.animate {visibility:hidden;}</style>";

            // output JS
            echo"<script>
            $(document).ready(function(){
            // Slide in elements on scroll
            $(window).scroll(function() {
                // on each element that go animate class
                $('.animate').each(function()
                {
                    // get position
                    var pos = $(this).offset().top;
                    // get window top position
                    var winTop = $(window).scrollTop();
                    
                    // user-defined params for every element
                    // if they are not filled, default widget settings will be used
                    var fx = $(this).attr(\"data-fx\");     // animation fx for this element
                    var px = $(this).attr(\"data-px\");     // px value from top for this element

                    // check if custom px value is defined
                    if (px !== undefined) {
                        // set custom px value
                        contentAnimatorScrollValue = px;
                    }
                    else {
                        // set default px value from widget settings
                        contentAnimatorScrollValue = $this->contentAnimatorScrollValue;
                    }
               
                    // animate when position is in visible area
                    if (pos < winTop + contentAnimatorScrollValue) {
                        // $(this).velocity(\"transition.fadeIn\", {duration:1000, loop:false});
                    
                    // element got custom FX values
                    if (fx !== undefined) {
                        // set animated custom fx
                        $(this).addClass('animated '+fx);
                        // remove animate class to avoid hide after animation
                        $(this).removeClass('animate');
                    }
                    else
                        {   // add default fx from widget settings
                            $(this).addClass(\"$this->contentAnimatorClass\");
                        }
                    }
                });
            });
          });
</script>";
        }
    }
}
