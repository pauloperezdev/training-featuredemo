<ul class="nav navbar-nav navbar-right">
    {if $showThemesMenu}
        {include file='custom_templates/custom_menu_themes.tpl'}
    {/if}

    {include file='custom_templates/custom_menu_languages.tpl'}

    {include file='custom_templates/custom_menu_learn_more.tpl' DemoName = 'PHP Generator Feature Demo' DemoTag = 'Feature' DemoProjectLink = 'feature_demo_project'}
</ul>
