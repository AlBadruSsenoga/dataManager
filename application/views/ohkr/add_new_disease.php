<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Add Disease Details</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">

                <?php echo form_open('ohkr/add_new_disease', 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_disease_name") ?> <span>*</span></label>
                    <input type="text" name="name" placeholder="Enter disease name" class="form-control"
                           value="<?php echo set_value('name'); ?>">
                </div>
                <div class="error" style="color: red"><?php echo form_error('name'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                    <select name="specie" id="specie" class="form-control">
                        <option value="">Choose Specie</option>
                        <?php foreach ($species as $specie) { ?>
                            <option value="<?php echo $specie->id; ?>"><?php echo $specie->title; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="error" style="color: red"><?php echo form_error('specie'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_scd") ?> :</label>
                        <textarea class="form-control" name="scd"
                                  id="scd"><?php echo set_value('scd'); ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('scd'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('description'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
