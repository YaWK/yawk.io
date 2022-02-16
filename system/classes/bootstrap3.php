<?php
namespace YAWK\FRAMEWORK\BOOTSTRAP3
{
    /**
     * @details <b>Bootstrap 3 CSS methods</b>
     * <p>Extends \YAWK\bootstrap - this class serves all bootstrap 3 component methods
     * and set this->cssCode variable that will be used by \YAWK\FRAMEWORK\cssFramework() </p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Helper function to output custom (overriden) bootstrap 3 css (settings.css)
     */
    class bootstrap3 extends \YAWK\FRAMEWORK\cssFramework
    {
        /** @param string all the css as string */
        public $cssCode = '';

        /**
         * @brief Initialize and call bootstrap 3 methods
         * @return string|null the generated css code as (big) string
         * @details  Init calls setBootstrapComponents and return all css code as string on success or null on error
         */
        public function init()
        {
            // set css tags for Bootstrap 3
            $this->bs3_WellCss();
            $this->bs3_ListGroupCss();
            $this->bs3_ButtonsCss();
            $this->bs3_FormsCss();
            $this->bs3_NavbarCss();
            $this->bs3_JumbotronCss();

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
         * @details Bootstrap 3: WELL Component CSS Code
         * @brief add Bootstrap 3 well component to this css code string
         */
        public function bs3_WellCss()
        {
            // well css code
            $this->cssCode = "    
            /* WELL */
            .well {
                min-height: " . $this->tplSettings['well-min-height'] . ";
                padding: " . $this->tplSettings['well-padding'] . ";
                margin-bottom: " . $this->tplSettings['well-margin-bottom'] . ";
                margin-top: " . $this->tplSettings['well-margin-top'] . ";
                background-color: #" . $this->tplSettings['well-bg-color'] . ";
                border: " . $this->tplSettings['well-border'] . " #" . $this->tplSettings['well-border-color'] . ";
                border-radius: " . $this->tplSettings['well-border-radius'] . ";
                -webkit-box-shadow: " . $this->tplSettings['well-shadow'] . " #" . $this->tplSettings['well-shadow-color'] . ";
                box-shadow: " . $this->tplSettings['well-shadow'] . " #" . $this->tplSettings['well-shadow-color'] . ";
            }
            ";
        }

        /**
         * @details Bootstrap 3: LIST GROUP Component CSS Code
         * @brief add Bootstrap 3 list group component to this css code string
         */
        public function bs3_ListGroupCss()
        {
            // list group css code
           $this->cssCode .= "
           /* LIST GROUP */
           
           .list-group-item {
               color: #".$this->tplSettings['fontcolor-listgroup'].";
               background-color: #".$this->tplSettings['background-listgroup'].";
           }
           
           .list-group {
                padding-left: ".$this->tplSettings['listgroup-paddingLeft'].";
                margin-bottom: ".$this->tplSettings['listgroup-marginBottom'].";
             }
             
           .list-group-item {
                position: ".$this->tplSettings['listgroup-itemPosition'].";
                display: ".$this->tplSettings['listgroup-itemDisplay'].";
                padding: ".$this->tplSettings['listgroup-itemPadding'].";
                margin-bottom: -1px;
                background-color: #".$this->tplSettings['listgroup-itemBackgroundColor'].";
                border: ".$this->tplSettings['listgroup-itemBorder'].";
                color: #".$this->tplSettings['listgroup-fontColor'].";
                font-size: ".$this->tplSettings['listgroup-fontSize'].";
                ".$this->tplSettings['listgroup-bg-gradient-longValue'].";
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
           ";
        }

        /**
         * @details Bootstrap 3: BUTTONS Component CSS Code
         * @brief add Bootstrap 3 buttons component to this css code string
         */
        public function bs3_ButtonsCss()
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
         * @details Bootstrap 4: FORMS Component CSS Code
         * @brief add Bootstrap 3 forms component to this css code string
         */
        public function bs3_FormsCss()
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

        /**
         * @details Bootstrap 3: NAVBAR Component CSS Code
         * @brief add Bootstrap 3 navbar component to this css code string
         */
        public function bs3_NavbarCss()
        {
            $this->cssCode .= "
           /* NAVBAR */
           .navbar-fixed-top {
            margin-top: ".$this->tplSettings['navbar-marginTop'].";
            margin-bottom: ".$this->tplSettings['navbar-marginBottom'].";
          }
           .navbar-default {
               text-shadow: 1px 0px #".$this->tplSettings['fontshadow-menucolor'].";
               filter: dropshadow(color=#".$this->tplSettings['fontshadow-menucolor'].", offx=1, offy=1);
               background-color: #".$this->tplSettings['default-menubgcolor'].";
               border-color: #".$this->tplSettings['border-menubgcolor'].";
               margin-bottom: ".$this->tplSettings['navbar-marginBottom'].";
           }
           .navbar-default .navbar-brand {
               color: #".$this->tplSettings['brand-menucolor'].";
           }
           .navbar-default .navbar-brand:hover,
           .navbar-default .navbar-brand:focus {
               color: #".$this->tplSettings['brandhover-menucolor'].";
               background-color: transparent;
           }
           .navbar-default .navbar-text {
               color: #".$this->tplSettings['font-menucolor'].";
           }
           .navbar-default .navbar-nav > li > a {
               color: #".$this->tplSettings['font-menucolor'].";
           }
           .navbar-default .navbar-nav > li > a:hover,
           .navbar-default .navbar-nav > li > a:focus {
               color: #".$this->tplSettings['fonthover-menucolor'].";
               background-color: transparent;
           }
           .navbar-default .navbar-nav > .active > a,
           .navbar-default .navbar-nav > .active > a:hover,
           .navbar-default .navbar-nav > .active > a:focus {
               color: #".$this->tplSettings['fontactive-menucolor'].";
               background-color: #".$this->tplSettings['active-menubgcolor'].";
           }
           .navbar-default .navbar-nav > .disabled > a,
           .navbar-default .navbar-nav > .disabled > a:hover,
           .navbar-default .navbar-nav > .disabled > a:focus {
               color: #".$this->tplSettings['fontdisabled-menucolor'].";
               background-color: transparent;
           }
           .navbar-default .navbar-toggle {
               border-color: #".$this->tplSettings['toggle-menubgcolor'].";
           }
           .navbar-default .navbar-toggle:hover,
           .navbar-default .navbar-toggle:focus {
               border-color:#".$this->tplSettings['toggle-menubgcolor'].";
           }
           .navbar-default .navbar-toggle .icon-bar {
               background-color:#".$this->tplSettings['iconbar-menubgcolor'].";
           }
           .navbar-default .navbar-collapse,
           .navbar-default .navbar-form {
               border-color: #".$this->tplSettings['border-menubgcolor'].";
           }
           .navbar-default .navbar-nav > .open > a,
           .navbar-default .navbar-nav > .open > a:hover,
           .navbar-default .navbar-nav > .open > a:focus {
               background-color: #".$this->tplSettings['active-menubgcolor'].";
               color: #".$this->tplSettings['fontactive-menucolor'].";
           }
           @media (max-width: 767px) {
               .navbar-default .navbar-nav .open .dropdown-menu > li > a {
                   color: #".$this->tplSettings['font-menucolor'].";
               }
               .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
               .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                   color: #".$this->tplSettings['fonthover-menucolor'].";
                   background-color: transparent;
               }
               .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
               .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
               .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
                   color: #".$this->tplSettings['fontactive-menucolor'].";
                   background-color: #".$this->tplSettings['active-menubgcolor'].";
               }
               .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
               .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
               .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
                   color: #".$this->tplSettings['fontdisabled-menucolor'].";
                   background-color: transparent;
               }
           }
           .navbar-default .navbar-link {
               color: #".$this->tplSettings['font-menucolor'].";
           }
           .navbar-default .navbar-link:hover {
               color: #".$this->tplSettings['fonthover-menucolor'].";
           }
           .navbar-default .btn-link {
               color: #".$this->tplSettings['font-menucolor'].";
           }
           .navbar-default .btn-link:hover,
           .navbar-default .btn-link:focus {
               color: #".$this->tplSettings['fonthover-menucolor'].";
           }
           .navbar-default .btn-link[disabled]:hover,
           fieldset[disabled] .navbar-default .btn-link:hover,
           .navbar-default .btn-link[disabled]:focus,
           fieldset[disabled] .navbar-default .btn-link:focus {
               color: #".$this->tplSettings['fontdisabled-menucolor'].";
           }
        
           .dropdown-menu {
               position: absolute;
               top: 100%;
               left: 0;
               z-index: 1000;
               display: none;
               float: left;
               min-width: 160px;
               padding: 5px 0;
               margin: 2px 0 0;
               list-style: none;
               font-size: 14px;
               text-align: left;
               background-color: #".$this->tplSettings['background-menudropdowncolor'].";
               border: 1px solid #".$this->tplSettings['border-menudropdowncolor'].";
               border-radius: 4px;
               -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
               box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
               -webkit-background-clip: padding-box;
               background-clip: padding-box;
           }
           .dropdown-menu.pull-right {
               right: 0;
               left: auto;
           }
           .dropdown-menu > li > a {
               display: block;
               padding: 3px 20px;
               clear: both;
               font-weight: normal;
               line-height: 1.42857143;
               color: #".$this->tplSettings['border-menudropdowncolor'].";
               white-space: nowrap;
           }
           .dropdown-menu > li > a:hover,
           .dropdown-menu > li > a:focus {
               text-decoration: none;
               color: #".$this->tplSettings['fonthover-menudropdowncolor'].";
               background-color: #".$this->tplSettings['hoverbg-menudropdowncolor'].";
           }
           .dropdown-menu > .active > a,
           .dropdown-menu > .active > a:hover,
           .dropdown-menu > .active > a:focus {
               color: #".$this->tplSettings['fontactive-menudropdowncolor'].";
               text-decoration: none;
               outline: 0;
               background-color: #".$this->tplSettings['activebg-menudropdowncolor'].";
           }
           .dropdown-menu > .disabled > a,
           .dropdown-menu > .disabled > a:hover,
           .dropdown-menu > .disabled > a:focus {
               color: #".$this->tplSettings['disabled-menudropdowncolor'].";
           }
           ";
        }

        /**
         * @details Bootstrap 3: JUMBOTRON Component CSS Code
         * @brief add Bootstrap 3 jumbotron component to this css code string
         */
        public function bs3_JumbotronCss()
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
    }
}