{* Custom filter icon *}
<svg  viewBox="0 0 48 48" enable-background="new 0 0 48 48" class="hide">
    <defs>
        <symbol id="icon-custom-filter">
            <path id="path0_fill" d="M 46.522 3.55271e-15L 0.0750411 0C -0.0269589 0 0.0580411 17.636 0.0190411 17.73C -0.0199589 17.824 0.00204105 17.934 0.0750411 18.005L 17.57 35.406L 17.57 47.747C 17.57 47.888 17.683 48 17.822 48L 28.775 48C 28.914 48 29.027 47.888 29.027 47.747L 29.027 35.408L 46.522 18.005C 46.595 17.933 46.617 17.824 46.578 17.73C 46.538 17.635 46.522 3.55271e-15 46.522 3.55271e-15Z"/>
        </symbol>
    </defs>
</svg>
{* /Custom filter icon *}

<div class="custom-filter-container">
    <form class="js-custom-filter-container" method="get">
        <ul class="nav nav-pills pull-right grid-card-column-filter">
            <li {if $LifeExpectancyFilterActive}class="active"{/if}>
                <a href="#" class="js-filter-trigger" title="">
                    <svg viewBox="0 0 48 48" class="svg-icon">
                        <use xlink:href="#icon-custom-filter"></use>
                    </svg>&nbsp;Life expectancy
                </a>
                <div class="js-content hide">
                    <div class="form-group">
                        <table width="100%">
                            <tr>
                                <td width="45%">
                                    <label for="minLifeExpectancy">Min age</label>
                                    <input type="number" id="minLifeExpectancy" class="form-control input-sm"
                                           name="lifeExpectancyFilter[min]" value="{$LifeExpectancyFilter.min}"
                                           min="{$MinLifeExpectancy}" max="{$MaxLifeExpectancy}"
                                            >
                                </td>
                                <td width="10%">&nbsp;</td>
                                <td width="45%">
                                    <label for="maxLifeExpectancy">Max age</label>
                                    <input type="number" id="maxLifeExpectancy" class="form-control input-sm"
                                           name="lifeExpectancyFilter[max]" value="{$LifeExpectancyFilter.max}"
                                           min="{$MinLifeExpectancy}" max="{$MaxLifeExpectancy}"
                                            >
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div>

<script type="text/html" id="custom_filter_content">
    <div class="custom_filter">
        <button data-dismiss="alert" class="close" type="button">&times;</button>
        <div class="js-content"></div>
        <hr class="custom_filter_separator">
        <div class="btn-toolbar pull-right custom_filter_toolbar">
            <button type="submit" class="btn btn-sm btn-primary js-apply">Apply</button>
        </div>
        <div class="clearfix"></div>
    </div>
</script>
