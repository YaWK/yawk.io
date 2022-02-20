<?php
namespace YAWK\FRAMEWORK\BOOTSTRAP4
{
    /**
     * @details TODO: add all bootstrap 4 methods
     * <b>Bootstrap 4 CSS methods</b>
     * <p>Extends \YAWK\bootstrap - this class serves all bootstrap 4 component methods
     * and set this->cssCode variable that will be used by \YAWK\FRAMEWORK\cssFramework() </p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief  Helper function to output custom (overriden) bootstrap 4 css (settings.css)
     */
    class bootstrap4 extends \YAWK\FRAMEWORK\cssFramework
    {
        /** @param string all the css as string */
        public $cssCode = '';

        /**
         * @brief  Call all the methods to set bootstrap 4 custom css and return it as string.
         * @return string|null
         */
        public function init(): ?string
        {
            // set css tags for Bootstrap 4
            $this->bs4_CardsCss();
            // bootstrap 4 buttons
            $this->bs4_ButtonsCss();
            // bootstrap 4 jumbotron
            $this->bs4_JumbotronCss();
            // bootstrap 4 list groups
            $this->bs4_ListGroupCss();
            // bootstrap 4 navbar (globalmenu)
            $this->bs4_navbarCss();
            // $this->bs4_globalmenu();
            // bootstrap 4 form settings
            $this->bs4_FormsCss();

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
         * @brief  Bootstrap 4: CARDS Component CSS Code
         * @details add bootstrap 4 cards component to this css code string
         */
        public function bs4_CardsCss()
        {
            // cards css code
            $this->cssCode .= "   
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
              text-decoration: ".$this->tplSettings['card-link-decoration'].";
            }
            
            .card-link + .card-link {
              margin-left: ".$this->tplSettings['card-link-margin-left'].";
            }
            
            .card-header {
              padding: ".$this->tplSettings['card-header-padding'].";
              margin-bottom: 0;
              background-color: #".$this->tplSettings['card-header-bgcolor'].";
              border-bottom: ".$this->tplSettings['card-header-border-bottom']." #".$this->tplSettings['card-header-border-bottom-color'].";
            }
            
            .card-header:first-child {
              border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
            }
            
            .card-header + .list-group .list-group-item:first-child {
              border-top: 0;
            }
            
            .card-footer {
              padding: ".$this->tplSettings['card-footer-padding'].";
              background-color: #".$this->tplSettings['card-footer-bgcolor'].";
              border-top: ".$this->tplSettings['card-footer-border-top']." #".$this->tplSettings['card-footer-border-top-color'].";
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

        /**
         * @brief  Bootstrap 4: BUTTONS Component CSS Code
         * @details add Bootstrap 3 buttons component to this css code string
         */
        public function bs4_ButtonsCss()
        {
            // all css code for buttons
            $this->cssCode .= "
           /* BUTTONS */
            .btn {
              color: #".$this->tplSettings['btn-default-color'].";
              display: inline-block;
              padding: 6px 12px;
              margin-bottom: 0;
              font-size: ".$this->tplSettings['btn-fontsize'].";
              font-weight: ".$this->tplSettings['btn-font-weight'].";
              line-height: 1.42857143;
              text-align: center;
              white-space: nowrap;
              vertical-align: middle;
              -ms-touch-action: manipulation;
                  touch-action: manipulation;
              cursor: pointer;
              -webkit-user-select: none;
                 -moz-user-select: none;
                  -ms-user-select: none;
                      user-select: none;
              background-image: none;
              border: ".$this->tplSettings['btn-border']." ".$this->tplSettings['btn-border-style']." transparent;
              border-radius: ".$this->tplSettings['btn-border-radius'].";
            }
        
            .btn-default {
                color: #".$this->tplSettings['btn-default-color'].";
                background-color: #".$this->tplSettings['btn-default-background-color'].";
                border-color: #".$this->tplSettings['btn-default-border-color'].";
            }
            .btn-default:focus,
            .btn-default.focus {
                color: #".$this->tplSettings['btn-default-color'].";
                background-color: #".$this->tplSettings['btn-default-focus-background-color'].";
                border-color: #".$this->tplSettings['btn-default-focus-background-color'].";
            }
            .btn-default:hover {
              color: #".$this->tplSettings['btn-default-hover-color'].";
              background-color: #".$this->tplSettings['btn-default-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-default-hover-border-color'].";
            }
            .btn-default:active,
            .btn-default.active,
            .open > .dropdown-toggle.btn-default {
              color: #".$this->tplSettings['btn-default-color'].";
              background-color: #".$this->tplSettings['btn-default-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-default-hover-border-color'].";
            }
            .btn-default:active:hover,
            .btn-default.active:hover,
            .open > .dropdown-toggle.btn-default:hover,
            .btn-default:active:focus,
            .btn-default.active:focus,
            .open > .dropdown-toggle.btn-default:focus,
            .btn-default:active.focus,
            .btn-default.active.focus,
            .open > .dropdown-toggle.btn-default.focus {
              color: #".$this->tplSettings['btn-default-color'].";
              background-color: #".$this->tplSettings['btn-default-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-default-hover-border-color'].";
            }
            .btn-default:active,
            .btn-default.active,
            .open > .dropdown-toggle.btn-default {
              background-image: none;
            }
            .btn-default.disabled:hover,
            .btn-default[disabled]:hover,
            fieldset[disabled] .btn-default:hover,
            .btn-default.disabled:focus,
            .btn-default[disabled]:focus,
            fieldset[disabled] .btn-default:focus,
            .btn-default.disabled.focus,
            .btn-default[disabled].focus,
            fieldset[disabled] .btn-default.focus {
              background-color: #".$this->tplSettings['btn-default-background-color'].";
              border-color: #".$this->tplSettings['btn-default-border-color'].";
            }
            .btn-default .badge {
              color: #".$this->tplSettings['btn-default-background-color'].";
              background-color: #".$this->tplSettings['btn-default-color'].";
            }
        
            .btn-primary {
              color: #".$this->tplSettings['btn-primary-color'].";
              background-color: #".$this->tplSettings['btn-primary-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-border-color'].";
            }
            .btn-primary:focus,
            .btn-primary.focus {
              color: #".$this->tplSettings['btn-primary-color'].";
              background-color: #".$this->tplSettings['btn-primary-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-focus-border-color'].";
            }
            .btn-primary:hover {
              color: #".$this->tplSettings['btn-primary-color'].";
              background-color: #".$this->tplSettings['btn-primary-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-hover-border-color'].";
            }
            .btn-primary:active,
            .btn-primary.active,
            .open > .dropdown-toggle.btn-primary {
              color: #".$this->tplSettings['btn-primary-color'].";
              background-color: #".$this->tplSettings['btn-primary-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-hover-border-color'].";
            }
            .btn-primary:active:hover,
            .btn-primary.active:hover,
            .open > .dropdown-toggle.btn-primary:hover,
            .btn-primary:active:focus,
            .btn-primary.active:focus,
            .open > .dropdown-toggle.btn-primary:focus,
            .btn-primary:active.focus,
            .btn-primary.active.focus,
            .open > .dropdown-toggle.btn-primary.focus {
              color: #".$this->tplSettings['btn-primary-color'].";
              background-color: #".$this->tplSettings['btn-primary-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-hover-border-color'].";
            }
            .btn-primary:active,
            .btn-primary.active,
            .open > .dropdown-toggle.btn-primary {
              background-image: none;
            }
            .btn-primary.disabled:hover,
            .btn-primary[disabled]:hover,
            fieldset[disabled] .btn-primary:hover,
            .btn-primary.disabled:focus,
            .btn-primary[disabled]:focus,
            fieldset[disabled] .btn-primary:focus,
            .btn-primary.disabled.focus,
            .btn-primary[disabled].focus,
            fieldset[disabled] .btn-primary.focus {
              background-color: #".$this->tplSettings['btn-primary-background-color'].";
              border-color: #".$this->tplSettings['btn-primary-border-color'].";
            }
            .btn-primary .badge {
              color: #".$this->tplSettings['btn-primary-background-color'].";
              background-color: #".$this->tplSettings['btn-primary-color'].";
            }
        
            .btn-success {
              color: #".$this->tplSettings['btn-success-color'].";
              background-color: #".$this->tplSettings['btn-success-background-color'].";
              border-color: #".$this->tplSettings['btn-success-background-color'].";
            }
            .btn-success:focus,
            .btn-success.focus {
              color: #".$this->tplSettings['btn-success-color'].";
              background-color: #".$this->tplSettings['btn-success-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-success-focus-border-color'].";
            }
            .btn-success:hover {
              color: #".$this->tplSettings['btn-success-hover-color'].";
              background-color: #".$this->tplSettings['btn-success-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-success-hover-border-color'].";
            }
            .btn-success:active,
            .btn-success.active,
            .open > .dropdown-toggle.btn-success {
              color: #".$this->tplSettings['btn-success-color'].";
              background-color: #".$this->tplSettings['btn-success-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-success-hover-border-color'].";
            }
            .btn-success:active:hover,
            .btn-success.active:hover,
            .open > .dropdown-toggle.btn-success:hover,
            .btn-success:active:focus,
            .btn-success.active:focus,
            .open > .dropdown-toggle.btn-success:focus,
            .btn-success:active.focus,
            .btn-success.active.focus,
            .open > .dropdown-toggle.btn-success.focus {
              color: #".$this->tplSettings['btn-success-color'].";
              background-color: #".$this->tplSettings['btn-success-hover-border-color'].";
              border-color: #".$this->tplSettings['btn-success-focus-border-color'].";
            }
            .btn-success:active,
            .btn-success.active,
            .open > .dropdown-toggle.btn-success {
              background-image: none;
            }
            .btn-success.disabled:hover,
            .btn-success[disabled]:hover,
            fieldset[disabled] .btn-success:hover,
            .btn-success.disabled:focus,
            .btn-success[disabled]:focus,
            fieldset[disabled] .btn-success:focus,
            .btn-success.disabled.focus,
            .btn-success[disabled].focus,
            fieldset[disabled] .btn-success.focus {
              background-color: #5cb85c;
              border-color: #4cae4c;
            }
            .btn-success .badge {
              color: #".$this->tplSettings['btn-success-background-color'].";
              background-color: #".$this->tplSettings['btn-success-color'].";
            }
        
            .btn-info {
              color: #".$this->tplSettings['btn-info-color'].";
              background-color: #".$this->tplSettings['btn-info-background-color'].";
              border-color: #".$this->tplSettings['btn-info-border-color'].";
            }
            .btn-info:focus,
            .btn-info.focus {
              color: #".$this->tplSettings['btn-info-color'].";
              background-color: #".$this->tplSettings['btn-info-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-info-focus-border-color'].";
            }
            .btn-info:hover {
              color: #".$this->tplSettings['btn-info-hover-color'].";
              background-color: #".$this->tplSettings['btn-info-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-info-hover-border-color'].";
            }
            .btn-info:active,
            .btn-info.active,
            .open > .dropdown-toggle.btn-info {
              color: #".$this->tplSettings['btn-info-color'].";
              background-color: #".$this->tplSettings['btn-info-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-info-hover-border-color'].";
            }
            .btn-info:active:hover,
            .btn-info.active:hover,
            .open > .dropdown-toggle.btn-info:hover,
            .btn-info:active:focus,
            .btn-info.active:focus,
            .open > .dropdown-toggle.btn-info:focus,
            .btn-info:active.focus,
            .btn-info.active.focus,
            .open > .dropdown-toggle.btn-info.focus {
              color: #".$this->tplSettings['btn-info-color'].";
              background-color: #".$this->tplSettings['btn-info-hover-border-color'].";
              border-color: #".$this->tplSettings['btn-info-focus-border-color'].";
            }
            .btn-info:active,
            .btn-info.active,
            .open > .dropdown-toggle.btn-info {
              background-image: none;
            }
            .btn-info.disabled:hover,
            .btn-info[disabled]:hover,
            fieldset[disabled] .btn-info:hover,
            .btn-info.disabled:focus,
            .btn-info[disabled]:focus,
            fieldset[disabled] .btn-info:focus,
            .btn-info.disabled.focus,
            .btn-info[disabled].focus,
            fieldset[disabled] .btn-info.focus {
              background-color: #5bc0de;
              border-color: #46b8da;
            }
            .btn-info .badge {
              color: #".$this->tplSettings['btn-info-background-color'].";
              background-color: #".$this->tplSettings['btn-info-color'].";
            }
        
            .btn-warning {
              color: #".$this->tplSettings['btn-warning-color'].";
              background-color: #".$this->tplSettings['btn-warning-background-color'].";
              border-color: #".$this->tplSettings['btn-warning-border-color'].";
            }
            .btn-warning:focus,
            .btn-warning.focus {
              color: #".$this->tplSettings['btn-warning-color'].";
              background-color: #".$this->tplSettings['btn-warning-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-warning-focus-border-color'].";
            }
            .btn-warning:hover {
              color: #".$this->tplSettings['btn-warning-hover-color'].";
              background-color: #".$this->tplSettings['btn-warning-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-warning-hover-border-color'].";
            }
            .btn-warning:active,
            .btn-warning.active,
            .open > .dropdown-toggle.btn-warning {
              color: #".$this->tplSettings['btn-warning-color'].";
              background-color: #".$this->tplSettings['btn-warning-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-warning-hover-border-color'].";
            }
            .btn-warning:active:hover,
            .btn-warning.active:hover,
            .open > .dropdown-toggle.btn-warning:hover,
            .btn-warning:active:focus,
            .btn-warning.active:focus,
            .open > .dropdown-toggle.btn-warning:focus,
            .btn-warning:active.focus,
            .btn-warning.active.focus,
            .open > .dropdown-toggle.btn-warning.focus {
              color: #".$this->tplSettings['btn-warning-color'].";
              background-color: #".$this->tplSettings['btn-warning-hover-border-color'].";
              border-color: #".$this->tplSettings['btn-warning-focus-border-color'].";
            }
            .btn-warning:active,
            .btn-warning.active,
            .open > .dropdown-toggle.btn-warning {
              background-image: none;
            }
            .btn-warning.disabled:hover,
            .btn-warning[disabled]:hover,
            fieldset[disabled] .btn-warning:hover,
            .btn-warning.disabled:focus,
            .btn-warning[disabled]:focus,
            fieldset[disabled] .btn-warning:focus,
            .btn-warning.disabled.focus,
            .btn-warning[disabled].focus,
            fieldset[disabled] .btn-warning.focus {
              background-color: #f0ad4e;
              border-color: #eea236;
            }
            .btn-warning .badge {
              color: #".$this->tplSettings['btn-warning-background-color'].";
              background-color: #".$this->tplSettings['btn-warning-color'].";
            }
        
            .btn-danger {
              color: #".$this->tplSettings['btn-danger-color'].";
              background-color: #".$this->tplSettings['btn-danger-background-color'].";
              border-color: #".$this->tplSettings['btn-danger-border-color'].";
            }
            .btn-danger:focus,
            .btn-danger.focus {
              color: #".$this->tplSettings['btn-danger-color'].";
              background-color: #".$this->tplSettings['btn-danger-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-danger-focus-border-color'].";
            }
            .btn-danger:hover {
              color: #".$this->tplSettings['btn-danger-hover-color'].";
              background-color: #".$this->tplSettings['btn-danger-hover-background-color'].";
              border-color: #".$this->tplSettings['btn-danger-hover-border-color'].";
            }
            .btn-danger:active,
            .btn-danger.active,
            .open > .dropdown-toggle.btn-danger {
              color: #".$this->tplSettings['btn-danger-color'].";
              background-color: #".$this->tplSettings['btn-danger-focus-background-color'].";
              border-color: #".$this->tplSettings['btn-danger-hover-border-color'].";
            }
            .btn-danger:active:hover,
            .btn-danger.active:hover,
            .open > .dropdown-toggle.btn-danger:hover,
            .btn-danger:active:focus,
            .btn-danger.active:focus,
            .open > .dropdown-toggle.btn-danger:focus,
            .btn-danger:active.focus,
            .btn-danger.active.focus,
            .open > .dropdown-toggle.btn-danger.focus {
              color: #".$this->tplSettings['btn-danger-color'].";
              background-color: #".$this->tplSettings['btn-danger-hover-border-color'].";
              border-color: #".$this->tplSettings['btn-danger-focus-border-color'].";
            }
            .btn-danger:active,
            .btn-danger.active,
            .open > .dropdown-toggle.btn-danger {
              background-image: none;
            }
            .btn-danger.disabled:hover,
            .btn-danger[disabled]:hover,
            fieldset[disabled] .btn-danger:hover,
            .btn-danger.disabled:focus,
            .btn-danger[disabled]:focus,
            fieldset[disabled] .btn-danger:focus,
            .btn-danger.disabled.focus,
            .btn-danger[disabled].focus,
            fieldset[disabled] .btn-danger.focus {
              background-color: #d9534f;
              border-color: #d43f3a;
            }
            .btn-danger .badge {
              color: #".$this->tplSettings['btn-danger-background-color'].";
              background-color: #".$this->tplSettings['btn-danger-color'].";
            }";
        }
        /**
         * @brief Bootstrap 4: JUMBOTRON Component CSS Code
         * @details add Bootstrap 4 jumbotron component to this css code string
         */
        public function bs4_JumbotronCss()
        {
            $this->cssCode .= "
            /* JUMBOTRON */
            .jumbotron {
            padding-top: ".$this->tplSettings['jumbotron-paddingTop'].";
            padding-bottom: ".$this->tplSettings['jumbotron-paddingBottom'].";
            margin-bottom: ".$this->tplSettings['jumbotron-marginBottom'].";
            color: #".$this->tplSettings['jumbotron-fontColor'].";
            background-color: #".$this->tplSettings['jumbotron-backgroundColor'].";
            padding-right: ".$this->tplSettings['jumbotron-containerPaddingRight'].";
            padding-left: ".$this->tplSettings['jumbotron-containerPaddingLeft'].";
            border-radius: ".$this->tplSettings['jumbotron-borderRadius'].";
            }
            .jumbotron h1,
            .jumbotron .h1 {
                color: #".$this->tplSettings['jumbotron-h1Color'].";
            }
            .jumbotron p {
                margin-bottom: ".$this->tplSettings['jumbotron-pMarginBottom'].";
                font-size: ".$this->tplSettings['jumbotron-pFontSize'].";
                font-weight: ".$this->tplSettings['jumbotron-pFontWeight'].";
            }
            .jumbotron > hr {
                border-top-color: #".$this->tplSettings['jumbotron-hrColor'].";
            }
            .container .jumbotron,
            .container-fluid .jumbotron {
                padding-right: ".$this->tplSettings['jumbotron-containerPaddingRight'].";
                padding-left: ".$this->tplSettings['jumbotron-containerPaddingLeft'].";
                border-radius: ".$this->tplSettings['jumbotron-borderRadius'].";
            }
            .jumbotron .container {
                max-width: ".$this->tplSettings['jumbotron-containerMaxWidth'].";
            }
            @media screen and (min-width: 768px) {
              .jumbotron {
                padding-top: 48px;
                padding-bottom: 48px;
              }
              .container .jumbotron,
              .container-fluid .jumbotron {
                padding-right: ".$this->tplSettings['jumbotron-fluidPaddingRight'].";
                padding-left: ".$this->tplSettings['jumbotron-fluidPaddingLeft'].";
              }
              .jumbotron h1,
              .jumbotron .h1 {
                font-size: ".$this->tplSettings['jumbotron-h1FontSize'].";
              }
            }
            ";
        }

        /**
         * @brief Bootstrap 4: LIST GROUP Component CSS Code
         * @details add Bootstrap 4 list group component to this css code string
         */
        public function bs4_ListGroupCss()
        {
            // list group css code
            $this->cssCode .= "
            /* LIST GROUP */
            .list-group {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-direction: column;
                flex-direction: column;
                padding-left: ".$this->tplSettings['listgroup-paddingLeft'].";
                margin-bottom: ".$this->tplSettings['listgroup-marginBottom'].";
                color: #".$this->tplSettings['listgroup-fontColor'].";
            }
            
            .list-group-item-action {
                width: 100%;
                color: #".$this->tplSettings['listgroup-fontColor'].";
                text-align: inherit;
            }
            
            .list-group-item-action:hover, .list-group-item-action:focus {
                color: #".$this->tplSettings['listgroup-fontColor'].";
                text-decoration: none;
                background-color: #f8f9fa;
            }
            
            .list-group-item-action:active {
                color: #212529;
                background-color: #e9ecef;
            }
            
            .list-group-item {
                position: ".$this->tplSettings['listgroup-itemPosition'].";
                display: ".$this->tplSettings['listgroup-itemDisplay'].";
                padding: ".$this->tplSettings['listgroup-itemPadding'].";
                margin-bottom: -1px;
                background-color: #".$this->tplSettings['background-listgroup'].";
                border: ".$this->tplSettings['listgroup-itemBorder'].";
            }
            
            .list-group-item:first-child {
                border-top-left-radius: ".$this->tplSettings['listgroup-firstChild-topLeft-radius'].";
                border-top-right-radius: ".$this->tplSettings['listgroup-firstChild-topRight-radius'].";
            }
            
            .list-group-item:last-child {
                margin-bottom: 0;
                border-bottom-right-radius: ".$this->tplSettings['listgroup-lastChild-bottomRight-radius'].";
                border-bottom-left-radius: ".$this->tplSettings['listgroup-lastChild-bottomLeft-radius'].";
            }
            
            .list-group-item:hover, .list-group-item:focus {
                z-index: 1;
                text-decoration: none;
            }
            
            .list-group-item.disabled, .list-group-item:disabled {
                color: #6c757d;
                background-color: #fff;
            }
            
            .list-group-item.active {
                z-index: 2;
                color: #".$this->tplSettings['listgroup-itemActiveColor'].";
                background-color: #".$this->tplSettings['listgroup-itemActiveBackgroundColor'].";
                border-color: #".$this->tplSettings['listgroup-itemActiveBorderColor'].";
            }";

            /*
            
            .list-group-flush .list-group-item {
              border-right: 0;
              border-left: 0;
              border-radius: 0;
            }
            
            .list-group-flush:first-child .list-group-item:first-child {
              border-top: 0;
            }
            
            .list-group-flush:last-child .list-group-item:last-child {
              border-bottom: 0;
            }
            
            .list-group-item-primary {
              color: #004085;
              background-color: #b8daff;
            }
            
            .list-group-item-primary.list-group-item-action:hover, .list-group-item-primary.list-group-item-action:focus {
              color: #004085;
              background-color: #9fcdff;
            }
            
            .list-group-item-primary.list-group-item-action.active {
              color: #fff;
              background-color: #004085;
              border-color: #004085;
            }
            
            .list-group-item-secondary {
              color: #383d41;
              background-color: #d6d8db;
            }
            
            .list-group-item-secondary.list-group-item-action:hover, .list-group-item-secondary.list-group-item-action:focus {
              color: #383d41;
              background-color: #c8cbcf;
            }
            
            .list-group-item-secondary.list-group-item-action.active {
              color: #fff;
              background-color: #383d41;
              border-color: #383d41;
            }
            
            .list-group-item-success {
              color: #155724;
              background-color: #c3e6cb;
            }
            
            .list-group-item-success.list-group-item-action:hover, .list-group-item-success.list-group-item-action:focus {
              color: #155724;
              background-color: #b1dfbb;
            }
            
            .list-group-item-success.list-group-item-action.active {
              color: #fff;
              background-color: #155724;
              border-color: #155724;
            }
            
            .list-group-item-info {
              color: #0c5460;
              background-color: #bee5eb;
            }
            
            .list-group-item-info.list-group-item-action:hover, .list-group-item-info.list-group-item-action:focus {
              color: #0c5460;
              background-color: #abdde5;
            }
            
            .list-group-item-info.list-group-item-action.active {
              color: #fff;
              background-color: #0c5460;
              border-color: #0c5460;
            }
            
            .list-group-item-warning {
              color: #856404;
              background-color: #ffeeba;
            }
            
            .list-group-item-warning.list-group-item-action:hover, .list-group-item-warning.list-group-item-action:focus {
              color: #856404;
              background-color: #ffe8a1;
            }
            
            .list-group-item-warning.list-group-item-action.active {
              color: #fff;
              background-color: #856404;
              border-color: #856404;
            }
            
            .list-group-item-danger {
              color: #721c24;
              background-color: #f5c6cb;
            }
            
            .list-group-item-danger.list-group-item-action:hover, .list-group-item-danger.list-group-item-action:focus {
              color: #721c24;
              background-color: #f1b0b7;
            }
            
            .list-group-item-danger.list-group-item-action.active {
              color: #fff;
              background-color: #721c24;
              border-color: #721c24;
            }
            
            .list-group-item-light {
              color: #818182;
              background-color: #fdfdfe;
            }
            
            .list-group-item-light.list-group-item-action:hover, .list-group-item-light.list-group-item-action:focus {
              color: #818182;
              background-color: #ececf6;
            }
            
            .list-group-item-light.list-group-item-action.active {
              color: #fff;
              background-color: #818182;
              border-color: #818182;
            }
            
            .list-group-item-dark {
              color: #1b1e21;
              background-color: #c6c8ca;
            }
            
            .list-group-item-dark.list-group-item-action:hover, .list-group-item-dark.list-group-item-action:focus {
              color: #1b1e21;
              background-color: #b9bbbe;
            }
            
            .list-group-item-dark.list-group-item-action.active {
              color: #fff;
              background-color: #1b1e21;
              border-color: #1b1e21;
            } */

        }

        /**
         * @brief Bootstrap 4 Navbar CSS Code
         * @details add Bootstrap 4 navbar component to this css code string
         */
        public function bs4_navbarCss()
        {
            $this->cssCode .= "

            .navbar {
                border-style: ".$this->tplSettings['navbar-borderstyle'].";
                border-width: ".$this->tplSettings['navbar-bordersize'].";
                border-color: #".$this->tplSettings['border-menubgcolor'].";
                text-shadow: ".$this->tplSettings['globaltext-fontshadowsize']." #".$this->tplSettings['fontshadow-menucolor'].";
            }
            
            .navbar-bg-custom {
                background-color:#".$this->tplSettings['default-menubgcolor'].";
            }
                
            .navbar-toggler-custom {
                color:#".$this->tplSettings['iconbar-menubgcolor'].";
            }    
            
            .navbar .navbar-light {
                color:#".$this->tplSettings['font-menucolor'].";
                border-color: #".$this->tplSettings['border-menubgcolor'].";
                margin-bottom: ".$this->tplSettings['navbar-marginBottom'].";
            }
            
            .dropdown-menu {
                background-color: #".$this->tplSettings['background-menudropdowncolor'].";
            }
            
            .navbar-brand {
                color: #".$this->tplSettings['brand-menucolor'].";
                text-shadow: ".$this->tplSettings['globaltext-fontshadowsize']." #".$this->tplSettings['fontshadow-menucolor'].";
            }
            
            .navbar-brand:hover, .navbar-brand:focus {
                text-decoration: none;
            }
            
            .navbar-light .navbar-brand {
                color: #".$this->tplSettings['brand-menucolor'].";
            }
            
            .navbar-light .navbar-brand:hover, .navbar-light .navbar-brand:focus {
                color: #".$this->tplSettings['brandhover-menucolor'].";
            }
            
            .navbar-light .navbar-nav .nav-link {
                color: #".$this->tplSettings['font-menucolor'].";
            }
            
            .navbar-light .navbar-nav .nav-link:hover, .navbar-light .navbar-nav .nav-link:focus {
                color: #".$this->tplSettings['fonthover-menucolor'].";
            }
            
            .navbar-light .navbar-nav .nav-link.disabled {
                color: #".$this->tplSettings['fontdisabled-menucolor'].";
            }
            
            .navbar-light .navbar-nav .show > .nav-link,
            .navbar-light .navbar-nav .active > .nav-link,
            .navbar-light .navbar-nav .nav-link.show,
            .navbar-light .navbar-nav .nav-link.active {
                color: #".$this->tplSettings['fontactive-menucolor'].";
            }
            
            .custom-toggler.navbar-toggler {
                border-color:#".$this->tplSettings['toggle-menubgcolor'].";
                background-color:#".$this->tplSettings['toggle-menu-bordercolor'].";
            }";

// to avoid encoding errors, the icon bars will be held in this variable:
$svg = "data:image/svg+xml;charset=utf8,%3Csvg%20viewBox='0 0 30 30'%20xmlns='http://www.w3.org/2000/svg'%3E%3Cpath%20stroke='%23".$this->tplSettings['iconbar-menubgcolor']."'%20stroke-width='2'%20stroke-linecap='round'%20stroke-miterlimit='10'%20d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E";

            // css goes on with custom toggle icon
            $this->cssCode .= "
            .navbar-light .custom-toggler .navbar-toggler-icon {
            background-image: url(\"".$svg."\");
            }";

    // check, if navbar brand should be shown
    if ($this->tplSettings['navbar-brand'] == "0")
    {   // if not, set display to none
        $this->cssCode .= ".navbar-brand { display:none; }";
    }

    // check, if vertical divider should be shown
    if ($this->tplSettings['navbar-vertical-divider'] == 1)
    {   // css markup for v divider
        $this->cssCode .= ".navbar-nav > li {border-right: 1px solid #ebebeb;}
                           .navbar-nav {border-left: 1px solid #ebebeb;}";
    }

    // check, if navbar should be sticky
    if ($this->tplSettings['navbar-sticky'] == "1")
    {   // set sticky css tags
        $this->cssCode .="
        .sticky {
          position: fixed;
          top: 0;
          width: 100%;
          z-index: 9998;
        }
        
        .sticky + .main {
          padding-top: 120px;
        }
        ";
    }

        }

        /**
         * @brief Bootstrap 4: FORMS Component CSS Code
         * @details add Bootstrap 4 forms component to this css code string
         */
        public function bs4_FormsCss()
        {
            $this->cssCode .= "
            /* FORMS */
            .form-control {
              display: ".$this->tplSettings['form-display'].";
              width: ".$this->tplSettings['form-width'].";
              height: ".$this->tplSettings['form-height'].";
              padding: ".$this->tplSettings['form-padding'].";
              font-size: ".$this->tplSettings['form-textSize'].";
              line-height: ".$this->tplSettings['form-lineHeight'].";
              color: #".$this->tplSettings['form-textColor'].";
              background-color: #".$this->tplSettings['form-bgcolor'].";
              background-image: none;
              border: ".$this->tplSettings['form-border'].";
              border-radius: ".$this->tplSettings['form-border-radius'].";
              -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
              -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                   -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                      transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }
            .form-control:focus {
              border-color: #".$this->tplSettings['form-activeBorderColor'].";
              outline: 0;
              -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
                      box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            }
            .form-control::-moz-placeholder {
              color: #".$this->tplSettings['form-placeholderColor'].";
              opacity: 1;
            }
            .form-control:-ms-input-placeholder {
              color: #999;
            }
            .form-control::-webkit-input-placeholder {
              color: #999;
            }
            ";
        }
    }
}