<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <?php echo $this->_tpl_vars['availableLangs'][$this->_tpl_vars['currentLang']]; ?>

        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" id="langs">
        <?php $_from = $this->_tpl_vars['availableLangs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['lang']):
?>
            <?php if ($this->_tpl_vars['currentLang'] != $this->_tpl_vars['key']): ?>
                <li><a href="#" data-lang="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['lang']; ?>
</a></li>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</li>