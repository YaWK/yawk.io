<?php
namespace YAWK\FRAMEWORK\BOOTSTRAP4
{
    /**
     * TODO: add all bootstrap 4 methods
     * <b>Bootstrap 4 CSS methods</b>
     * <p>Extends \YAWK\bootstrap - this class serves all bootstrap 4 component methods
     * and set this->cssCode variable that will be used by \YAWK\FRAMEWORK\cssFramework() </p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Helper function to output custom (overriden) bootstrap 4 css (settings.css)
     */
    class bootstrap4 extends \YAWK\FRAMEWORK\cssFramework
    {
        /** @var string all the css as string */
        public $cssCode = '';

        public function init()
        {
            // set css tags for Bootstrap 4
            $this->bs4_Cards();

            // check if css code is set, not empty and correct type
            if (isset($this->cssCode) && (is_string($this->cssCode) && (!empty($this->cssCode))))
            {   // all good, return all generated code
                return $this->cssCode;
            }
            else
            {   // css code is not set properly
                return null;
            }
        }

        /**
         * Bootstrap 4: CARDS Component CSS Code
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation add bootstrap 4 cards component to this css code string
         */
        public function bs4_Cards()
        {
            // cards css code
            $this->cssCode = "   
            /* CARDS */
            .card {
              position: relative;
              display: -ms-flexbox;
              display: flex;
              -ms-flex-direction: column;
              flex-direction: column;
              min-width: 0;
              word-wrap: break-word;
              background-color: #" . $this->tplSettings['card-bgcolor'] . ";
              background-clip: border-box;
              border: ".$this->tplSettings['card-border']." #".$this->tplSettings['card-bordercolor'].";
              border-radius: ".$this->tplSettings['card-border-radius'].";
            }
            
            .card > hr {
              margin-right: 0;
              margin-left: 0;
            }
            
            .card > .list-group:first-child .list-group-item:first-child {
              border-top-left-radius: ".$this->tplSettings['card-border-radius'].";
              border-top-right-radius: ".$this->tplSettings['card-border-radius'].";
            }
            
            .card > .list-group:last-child .list-group-item:last-child {
              border-bottom-right-radius: ".$this->tplSettings['card-border-radius'].";
              border-bottom-left-radius: ".$this->tplSettings['card-border-radius'].";
            }
            
            .card-body {
              -ms-flex: 1 1 auto;
              flex: 1 1 auto;
              padding: ".$this->tplSettings['card-body-padding'].";
            }
            
            .card-title {
              margin-bottom: ".$this->tplSettings['card-title-margin-bottom'].";
            }
            
            .card-subtitle {
              margin-top: -0.375rem;
              margin-bottom: 0;
            }
            
            .card-text:last-child {
              margin-bottom: 0;
            }
            
            .card-link:hover {
              text-decoration: none;
            }
            
            .card-link + .card-link {
              margin-left: ".$this->tplSettings['card-link-margin-left'].";
            }
            
            .card-header {
              padding: 0rem 0rem;
              margin-bottom: 0;
              background-color: rgba(0, 0, 0, 0.03);
              border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            }
            
            .card-header:first-child {
              border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
            }
            
            .card-header + .list-group .list-group-item:first-child {
              border-top: 0;
            }
            
            .card-footer {
              padding: 0.75rem 1.25rem;
              background-color: rgba(0, 0, 0, 0.03);
              border-top: 1px solid rgba(0, 0, 0, 0.125);
            }
            
            .card-footer:last-child {
              border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
            }
            
            .card-header-tabs {
              margin-right: -0.625rem;
              margin-bottom: -0.75rem;
              margin-left: -0.625rem;
              border-bottom: 0;
            }
            
            .card-header-pills {
              margin-right: -0.625rem;
              margin-left: -0.625rem;
            }
            
            .card-img-overlay {
              position: absolute;
              top: 0;
              right: 0;
              bottom: 0;
              left: 0;
              padding: 1.25rem;
            }
            
            .card-img {
              width: 100%;
              border-radius: calc(0.25rem - 1px);
            }
            
            .card-img-top {
              width: 100%;
              border-top-left-radius: calc(0.25rem - 1px);
              border-top-right-radius: calc(0.25rem - 1px);
            }
            
            .card-img-bottom {
              width: 100%;
              border-bottom-right-radius: calc(0.25rem - 1px);
              border-bottom-left-radius: calc(0.25rem - 1px);
            }
            
            .card-deck {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-direction: column;
              flex-direction: column;
            }
            
            .card-deck .card {
              margin-bottom: 15px;
            }
            
            @media (min-width: 576px) {
              .card-deck {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
                margin-right: -15px;
                margin-left: -15px;
              }
              .card-deck .card {
                display: -ms-flexbox;
                display: flex;
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                -ms-flex-direction: column;
                flex-direction: column;
                margin-right: 15px;
                margin-bottom: 0;
                margin-left: 15px;
              }
            }
            
            .card-group {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-direction: column;
              flex-direction: column;
            }
            
            .card-group > .card {
              margin-bottom: 15px;
            }
            
            @media (min-width: 576px) {
              .card-group {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
              }
              .card-group > .card {
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                margin-bottom: 0;
              }
              .card-group > .card + .card {
                margin-left: 0;
                border-left: 0;
              }
              .card-group > .card:first-child {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
              }
              .card-group > .card:first-child .card-img-top,
              .card-group > .card:first-child .card-header {
                border-top-right-radius: 0;
              }
              .card-group > .card:first-child .card-img-bottom,
              .card-group > .card:first-child .card-footer {
                border-bottom-right-radius: 0;
              }
              .card-group > .card:last-child {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
              }
              .card-group > .card:last-child .card-img-top,
              .card-group > .card:last-child .card-header {
                border-top-left-radius: 0;
              }
              .card-group > .card:last-child .card-img-bottom,
              .card-group > .card:last-child .card-footer {
                border-bottom-left-radius: 0;
              }
              .card-group > .card:only-child {
                border-radius: 0.25rem;
              }
              .card-group > .card:only-child .card-img-top,
              .card-group > .card:only-child .card-header {
                border-top-left-radius: 0.25rem;
                border-top-right-radius: 0.25rem;
              }
              .card-group > .card:only-child .card-img-bottom,
              .card-group > .card:only-child .card-footer {
                border-bottom-right-radius: 0.25rem;
                border-bottom-left-radius: 0.25rem;
              }
              .card-group > .card:not(:first-child):not(:last-child):not(:only-child) {
                border-radius: 0;
              }
              .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-img-top,
              .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-img-bottom,
              .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-header,
              .card-group > .card:not(:first-child):not(:last-child):not(:only-child) .card-footer {
                border-radius: 0;
              }
            }
            
            .card-columns .card {
              margin-bottom: 0.75rem;
            }
            
            @media (min-width: 576px) {
              .card-columns {
                -webkit-column-count: 3;
                -moz-column-count: 3;
                column-count: 3;
                -webkit-column-gap: 1.25rem;
                -moz-column-gap: 1.25rem;
                column-gap: 1.25rem;
                orphans: 1;
                widows: 1;
              }
              .card-columns .card {
                display: inline-block;
                width: 100%;
              }
            }

            ";
        }
    }
}