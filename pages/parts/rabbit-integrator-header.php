
<?php 
$page_class = "";
if(in_array($_GET['page'], array('rabbit-integrator-new-template','rabbit-integrator-edit-template'))) 
{
    $page_class = "rabbit-integrator-admin-new-template";
}
else if(in_array($_GET['page'], array('rabbit-integrator-template-list'))) 
{
    $page_class = "rabbit-integrator-admin-template-list";
}
?>
<section class="rabbit-integrator-admin-wrap <?php echo $page_class; ?>">
    <div class="rabbit-integrator-admin-container">
        <div class="rabbit-integrator-admin-header">
            <div class="rabbit-integrator-admin-logo"><a data-assets-url="<?php echo RI_PLUGIN_URL; ?>" href="?page=rabbit-integrator-dashboard"><img src="<?php echo RI_PLUGIN_URL; ?>assets/images/rc-text.png" alt="rabbit integrator logo" /><span>Integrator</span></a></div>
            <div class="rabbit-integrator-admin-calendar">
                <?=date('d')?> <strong><?=date('F')?></strong>
            </div>
        </div>
        <div class="rabbit-integrator-admin-path"><a href="?page=rabbit-integrator-dashboard" class="rabbit-integrator-link">Dashboard</a> 
        <?php 
            if(isset($nav)) {
                if($nav == 'new-temp') {
        ?>
        <a href="?page=rabbit-integrator-template-list" class="rabbit-integrator-link">PayPal Template List</a>
        <?php   } else if($nav == 'temp-list') { ?>
        <a href="?page=rabbit-integrator-new-template" class="rabbit-integrator-link">New PayPal Template</a>
        <?php   } ?>
        <?php } ?>
    </div>

