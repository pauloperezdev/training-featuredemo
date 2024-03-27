<?php ob_start(); ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'custom_templates/custom_menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if (isset ( $this->_tpl_vars['NavbarContent'] )): ?><?php echo $this->_tpl_vars['NavbarContent']; ?>
<?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('NavbarContent', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?>
    <?php echo $this->_tpl_vars['ContentBlock']; ?>

    <?php if (isset ( $this->_tpl_vars['pageDemoVideoLink'] )): ?><?php echo $this->_tpl_vars['pageDemoVideoLink']; ?>
<?php endif; ?>
    <?php if (isset ( $this->_tpl_vars['runDemoTour'] )): ?><?php echo $this->_tpl_vars['runDemoTour']; ?>
<?php endif; ?>
    <div class="modal fade" id="demo-about" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">About this demo</h4>
            </div>
            <div class="modal-body">
                <p>This demo application contains 100+ pages and illustrates most of features provided by PHP Generator. Hope it will help you to create even more powerful websites for your users.</p>
                <p>You can <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/download/feature_demo_project/" target="_blank">download the demo project</a> from our website and run the demo on your webserver as described in readme.txt.</p>
            </div>
            <div class="modal-footer">
                <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/download/" class="btn btn-primary" target="_blank">Download PHP Generator Free Trial</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?><?php if (isset ( $this->_tpl_vars['ContentBlockClass'] )): ?><?php echo $this->_tpl_vars['ContentBlockClass']; ?>
<?php endif; ?> col-md-12 <?php if (isset ( $this->_tpl_vars['pageContentBlockClass'] )): ?><?php echo $this->_tpl_vars['pageContentBlockClass']; ?>
<?php endif; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlockClass', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/layout.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>