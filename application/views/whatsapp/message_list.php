<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-12">
                <h3>Messsage List</h3>

                <?php if (!empty($messages)) { ?>

                    <table class="table table-striped table-responsive table-hover table-bordered">
                        <tr>
                            <th class="col-md-2">Sent Date</th>
                            <th class="col-md-2">Full name</th>
                            <th class="col-md-8">Message</th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($messages as $message) { ?>
                            <tr>
                                <td><?php echo date('j F Y, H:i:s', strtotime($message->date_sent_received)); ?></td>
                                <td><?php echo $message->fullname; ?></td>
                                <td><?php echo $message->message; ?></td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>
                    <?php if (!empty($links)): ?>
                        <div class="widget-foot">
                            <?= $links ?>
                            <div class="clearfix"></div>
                        </div>
                    <?php endif; ?>
                <?php } else { ?>
                    <div class="fail_message">Nothing to display here!</div>
                <?php } ?>
            </div>
        </div>
    </div>