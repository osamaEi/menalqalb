<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="rtl"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/')}}"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Menalqalb</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/remixicon/remixicon.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}" />


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/plyr/plyr.css')}}" />

    <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/core.css')}}">
    
     <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/theme-default.css')}}">


    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-academy.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js')}} in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js')}}.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}">

  </script>

<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">

<style>

  :root {
            --primary-color: #cb2126;
            --primary-color-light: #FF6666;
            --primary-color-dark: #CC0000;
            --primary-color-transparent: rgba(255, 0, 0, 0.1);
        }
        
          body {
            font-family: 'Cairo', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .bg-label-primary {
  background-color: #e7e7ff !important;
  color: #cb2126 !important;
}
        /* Primary heading elements */
        h1, h2, h3 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color-light);
            padding-bottom: 5px;
        }
        .form-check-input:checked {
  background-color: #cb2126;
  border-color: #cb2126;
}
        /* Primary button styling */
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-color-dark);
        }
        
        .btn-primary:active, .btn-primary.active {
            background-color: var(--primary-color-dark);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
        }
        
        /* Primary links */
        a.primary {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s;
            border-bottom: 1px dotted var(--primary-color);
        }
        
        a.primary:hover, a.primary:active, a.primary.active {
            color: var(--primary-color-dark);
            border-bottom: 1px solid var(--primary-color-dark);
        }
        
        /* Primary borders */
        .primary-border {
            border: 2px solid var(--primary-color);
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        .primary-border.active {
            border-width: 3px;
            box-shadow: 0 0 5px var(--primary-color);
        }
        
        /* Primary text */
        .primary-text {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        /* Primary background */
        .primary-bg {
            background-color: var(--primary-color);
            color: white;
            padding: 10px;
            border-radius: 4px;
        }
        
        .primary-bg-light {
            background-color: var(--primary-color-transparent);
            padding: 10px;
            border-radius: 4px;
        }
        
        /* Primary active state for non-specific elements */
        .primary.active {
            border: 2px solid var(--primary-color);
            background-color: var(--primary-color-transparent);
        }
        
        /* Primary focus state */
        .btn-primary:focus, input.primary:focus, select.primary:focus, textarea.primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--primary-color-transparent);
        }
        
        /* Primary form elements */
        input.primary, select.primary, textarea.primary {
            border: 2px solid var(--primary-color);
            border-radius: 4px;
            padding: 8px;
            font-family: 'Cairo', sans-serif;
        }
        
        input.primary:active, select.primary:active, textarea.primary:active,
        input.primary.active, select.primary.active, textarea.primary.active {
            border-color: var(--primary-color-dark);
        }
        
        /* Primary checkbox and radio */
        input[type="checkbox"].primary, input[type="radio"].primary {
            accent-color: var(--primary-color);
        }
        .bg-menu-theme .menu-item.active > .menu-link:not(.menu-toggle) {

          background-color: var(--primary-color);

        }
        /* Primary divider */
        hr.primary {
            border: none;
            height: 2px;
            background-color: var(--primary-color);
            margin: 20px 0;
        }
        
        /* Primary list items */
        ul.primary li, ol.primary li {
            border-left: 3px solid var(--primary-color);
            padding-left: 10px;
            margin: 5px 0;
        }
        
        /* Primary navigation */
        nav.primary a {
            color: var(--primary-color);
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        nav.primary a:hover, nav.primary a.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Demo section */
        .demo-section {
            margin: 30px 0;
            padding: 15px;
            border-radius: 4px;
            background-color: #f8f8f8;
        }
        
        h2 {
            margin-top: 0;
        }
        
        /* Demo active toggle */
        #toggle-active {
            margin: 20px 0;
        }
    </style>