<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
       aria-expanded="false">Themes
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" id="themes">
        <?php $_from = $this->_tpl_vars['themes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['postfix']):
?>
            <li><a href="#"<?php if ($this->_tpl_vars['themePostfix'] == $this->_tpl_vars['postfix']): ?> style="font-weight: 800"<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</li>