<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit Module</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/module_list') ?>">Modules</a></li>
                <li class="active">Edit Module</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open(uri_string(), 'class="form-horizontal" role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Module <span>*</span></label>
                            <?= form_input($name) ?>
                        </div><!-- /form-group -->

                        <div class="form-group">
                            <label>Controller <span>*</span></label>
                            <?= form_input($controller) ?>
                        </div><!-- /form-group -->

                        <div class="form-group">
                            <?= form_submit('submit', 'Edit', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/module_list', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-md-6 -->
                    <?= form_close() ?>

                </div><!--./col-sm-12 -->
            </div><!--./row -->

        </div>
    </div><!--./row -->
</div><!--./container -->
