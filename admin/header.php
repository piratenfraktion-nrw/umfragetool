<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>UmfrageTool Administration</title>

  <link rel="stylesheet" href="/admin/jquery-ui-1.11.4.custom/jquery-ui.theme.css">
  <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/node_modules/ionicons/css/ionicons.css">
  <link rel="stylesheet" href="/node_modules/angular-bootstrap-colorpicker/css/colorpicker.css">
  <link rel="stylesheet" href="/admin/AdminLTE2/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/admin/AdminLTE2/dist/css/skins/skin-blue.min.css">

  <link rel="stylesheet" href="/admin/css/style.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="/admin/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>U</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Umfrage</b>Tool</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navigation</span>
      </a>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <ul class="sidebar-menu">

        <li class="header">Konfiguration</li>

        <li class="treeview <?php if (in_array($match['name'], array("back_messages"))) echo "active"; ?>">
          <a href="/admin/question">
            <i class="fa fa-list-ul"></i> <span>Fragen</span>
          </a>
        </li>
        <li class="treeview <?php if ($match['name'] == "back_categories") echo "active"; ?>">
          <a href="/admin/questionnaire">
            <i class="fa fa-th"></i> <span>Fragebögen</span>
          </a>
        </li>

        <li class="header">Umfrage</li>

        <li class="treeview <?php if ($match['name'] == "back_categories") echo "active"; ?>">
          <a href="/admin/survey/add">
            <i class="fa fa-play"></i> <span>Neue Umfrage starten</span>
          </a>
        </li>

        <li class="treeview <?php if (in_array($match['name'], array("back_messages"))) echo "active"; ?>">
          <a href="/admin/surveys/stopped">
            <i class="fa fa-list-ul"></i> <span>Beendete Umfragen</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>