<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {$availableLangs[$currentLang]}
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" id="langs">
        {foreach item=lang key=key from=$availableLangs}
            {if $currentLang != $key}
                <li><a href="#" data-lang="{$key}">{$lang}</a></li>
            {/if}
        {/foreach}
    </ul>
</li>
