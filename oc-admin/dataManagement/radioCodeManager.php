<?php

/**

Open source CAD system for RolePlaying Communities.
Copyright (C) 2017 Shane Gill

This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

This program comes with ABSOLUTELY NO WARRANTY; Use at your own risk.
**/

    if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
    }
    require_once('../../oc-config.php');
    require_once( ABSPATH . '/oc-functions.php');
    require_once( ABSPATH . '/oc-settings.php');
    require_once( ABSPATH . "/oc-includes/adminActions.php");
    require_once( ABSPATH . "/oc-includes/dataActions.php");

    if (empty($_SESSION['logged_in']))
    {
        header('Location: ../index.php');
        die("Not logged in");
    }
    else
    {
      $name = $_SESSION['name'];
    }


    if ( $_SESSION['admin_privilege'] == 3)
    {
      if ($_SESSION['admin_privilege'] == 'Administrator')
      {
          //Do nothing
      }
    }
    else if ($_SESSION['admin_privilege'] == 2)
    {
      if ($_SESSION['admin_privilege'] == 'Moderator')
      {
          // Do Nothing
      }
    }
    else
    {
        permissionDenied();
    }

    $accessMessage = "";
    if(isset($_SESSION['accessMessage']))
    {
        $accessMessage = $_SESSION['accessMessage'];
        unset($_SESSION['accessMessage']);
    }
    $adminMessage = "";
    if(isset($_SESSION['adminMessage']))
    {
        $adminMessage = $_SESSION['adminMessage'];
        unset($_SESSION['adminMessage']);
    }

    $successMessage = "";
    if(isset($_SESSION['successMessage']))
    {
        $successMessage = $_SESSION['successMessage'];
        unset($_SESSION['successMessage']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include(ABSPATH . "/oc-includes/header.inc.php"); ?>


<body class="app header-fixed">

    <header class="app-header navbar">
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="<?php echo BASE_URL; ?>/oc-content/themes/<?php echo THEME; ?>/images/tail.png" width="30" height="25" alt="OpenCAD Logo">
      </a>
      <?php include( ABSPATH . "oc-admin/oc-admin-includes/topbarNav.inc.php"); ?>
      <?php include( ABSPATH . "oc-includes/topProfile.inc.php"); ?>

    </header>

      <div class="app-body">
        <main class="main">
        <div class="breadcrumb" />
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
                      <div class="card-header">
          <i class="fa fa-align-justify"></i> <?php echo lang_key("RADIOCODE_MANAGER"); ?></div>
              <div class="card-body">
                                    <?php echo $accessMessage;?>
                                    <?php getRadioCodes();?>
                </div>
                <!-- /.row-->

              </div>
            </div>
            <!-- /.card-->
        </main>

        </div>
      </div>
        <footer class="app-footer">
        <div>
            <a href="<?php echo BASE_URL; ?>/oc-content/themes/<?php echo THEME; ?>/images/tail.png">CoreUI Pro</a>
            <span>&copy; 2018 creativeLabs.</span>
        </div>
        <div class="ml-auto">

        </div>
    
        </footer>

    <!-- Edit Radio Code Modal -->
    <div class="modal" id="editRadioCodeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editRadioCodeModal">Edit Radio Codes</h4>
                    <button type="button" class="close" data-dismiss="modal">
                      <span aria-hidden="true">×</span></button>
                    </button>
                </div>
                <!-- ./ modal-header -->
                <div class="modal-body">
                    <form role="form" method="post" action="<?php echo BASE_URL.'/'.OCINC; ?>/dataActions.php"
                        class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Radio Code</label>
                            <div class="col-md-9">
                                <input type="text" name="code" class="form-control" id="code" required />
                                <span class="fas fa-road form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <!-- ./ col-sm-9 -->
                        </div>
                        <!-- ./ form-group -->
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Code Description</label>
                            <div class="col-md-9">
                                <input type="text" name="code_description" class="form-control" id="code_description" required />
                                <span class="fas fa-map form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <!-- ./ col-sm-9 -->
                        </div>
                        <!-- ./ form-group -->
                </div>
                <!-- ./ modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="id" id="id" aria-hidden="true">
                    <input type="submit" name="editRadioCode" class="btn btn-primary" value="Edit Radio Code" />
                </div>
                <!-- ./ modal-footer -->
                </form>
            </div>
            <!-- ./ modal-content -->
        </div>
        <!-- ./ modal-dialog modal-lg -->
    </div>
    <!-- ./ modal fade bs-example-modal-lg -->

    <?php
    include ( ABSPATH . "/oc-admin/oc-admin-includes/globalModals.inc.php");
    include ( ABSPATH . "/oc-includes/jquery-colsolidated.inc.php"); ?>

        <script>
    $(document).ready(function() {
        $('#allRadioCodes').DataTable({});
    });

    $('#editRadioCodeModal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            id = e.relatedTarget.id;

        $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo BASE_URL; ?>/<?php echo OCINC ?>/dataActions.php',
            data: {
                'getRadioCodeDetails': 'yes',
                'id': id
            },
            success: function(result) {
                console.log(result);
                data = JSON.parse(result);

                $('input[name="code"]').val(data['code']);
                $('input[name="code_description"]').val(data['code_description']);
                $('input[name="id"]').val(data['id']);
            },

            error: function(exception) {
                alert('Exeption:' + exception);
            }
        });
    })
    </script>
</body>

            <script type="text/javascript"
        src="https://jira.opencad.io/s/a0c4d8ca8eced10a4b49aaf45ec76490-T/-f9bgig/77001/9e193173deda371ba40b4eda00f7488e/2.0.24/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=en-US&collectorId=ede74ac1">
    </script>

</html>