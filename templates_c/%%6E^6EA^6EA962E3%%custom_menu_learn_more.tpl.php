<li class="dropdown learn-more">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
        Learn more
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-header"><?php echo $this->_tpl_vars['DemoName']; ?>
</li>

        <li><a href="#" data-toggle="modal" data-target="#demo-about">About this demo</a></li>
        <li>
            <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/download/<?php echo $this->_tpl_vars['DemoProjectLink']; ?>
/" title="Download project file for this demo" target="_blank">
                Download project file for this demo
            </a>
        </li>

        <li role="separator" class="divider"></li>
        <li class="dropdown-header">Check out other PHP Generator demos</li>

        <?php if ($this->_tpl_vars['DemoTag'] != 'Feature'): ?>
            <li><a href="http://demo.sqlmaestro.com/feature_demo/" title="Visit Feature Demo project" target="_blank">Feature Showcase Demo</a></li>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['DemoTag'] != 'NBA'): ?>
            <li><a href="http://demo.sqlmaestro.com/nba/" title="Visit NBA Database Demo project" target="_blank">NBA Database Demo</a></li>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['DemoTag'] != 'Security'): ?>
            <li><a href="http://demo.sqlmaestro.com/security_demo/" title="Visit Security Demo" target="_blank">Security Demo</a></li>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['DemoTag'] != 'Schema Browser'): ?>
            <li><a href="http://demo.sqlmaestro.com/mysql_schema_browser/" title="Visit MySQL Schema Browser Demo project" target="_blank">MySQL Schema Browser Demo</a></li>
        <?php endif; ?>

        <li role="separator" class="divider"></li>
        <li class="dropdown-header">Learn more about our products</li>

        <li>
            <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/" title="Visit PHP Generator for MySQL home page" target="_blank">
                Try PHP Generator for free
            </a>
        </li>

        <li>
            <a href="http://www.sqlmaestro.com" title="Visit sqlmaestro.com" target="_blank">
                SQL Maestro Group website
            </a>
        </li>

        <li role="separator" class="divider"></li>
        <li class="dropdown-header">Follow us</li>
        <li><a href="https://www.facebook.com/SQLMaestro/" title="Follow us on Facebook" target="_blank"><i class="icon-facebook-square"></i>Facebook</a></li>
        <li><a href="https://twitter.com/SQLMaestroSoft" title="Follow us on Twitter" target="_blank"><i class="icon-twitter"></i>Twitter</a></li>
        <li><a href="https://www.youtube.com/SQLMaestro/" title="Follow us on YouTube" target="_blank"><i class="icon-youtube"></i>YouTube</a></li>
    </ul>
</li>