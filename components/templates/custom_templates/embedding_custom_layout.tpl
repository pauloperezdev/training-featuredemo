<!DOCTYPE html>
<html{if $common->getDirection()} dir="{$common->getDirection()}"{/if}>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    {if $common->getContentEncoding()}
        <meta charset="{$common->getContentEncoding()}">
    {/if}
    {$common->getCustomHead()}
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {if $common}
        <title>{$common->getTitle()}</title>
    {else}
        <title>Error</title>
    {/if}

    <link rel="stylesheet" type="text/css" href="{$StyleFile|default:'components/assets/css/main.css'}" />

    {if $common}
    <script>{literal}
        window.beforePageLoad = function () {
            {/literal}{$common->getClientSideScript('OnBeforeLoadEvent')}{literal}
        }
        window.afterPageLoad = function () {
            {/literal}{$common->getClientSideScript('OnAfterLoadEvent')}{literal}
        }
    {/literal}</script>
    {/if}

    <script type="text/javascript" src="components/js/require-config.js"></script>
    {if UseMinifiedJS()}
        <script type="text/javascript" src="components/js/libs/require.js"></script>
        <script type="text/javascript" src="components/js/main-bundle.js"></script>
    {else}
        <script type="text/javascript" data-main="main" src="components/js/libs/require.js"></script>
    {/if}
</head>

<body{if isset($Page)} id="pgpage-{$Page->GetPageId()}"{/if} data-page-entry="{$common->getEntryPoint()}">

<div class="container-fluid">

        <div class="{if isset($ContentBlockClass)}{$ContentBlockClass}{else}col-md-12{/if}">
                <div class="container-padding">
                    {$ContentBlock}
                </div>
        </div>

</div>
</body>
</html>