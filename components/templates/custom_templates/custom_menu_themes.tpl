<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
       aria-expanded="false">Themes
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" id="themes">
        {foreach from=$themes item=postfix key=name}
            <li><a href="#"{if $themePostfix == $postfix} style="font-weight: 800"{/if}>{$name}</a></li>
        {/foreach}
    </ul>
</li>
