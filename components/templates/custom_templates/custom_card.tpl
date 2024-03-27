{if count($DataGrid.Rows) > 0}

    {foreach item=Row from=$DataGrid.Rows name=RowsGrid}

        {*  The same code is used in single_row.tpl *}
        {if $Row.Classes}
            {assign var="rowClasses" value="pg-row "|cat:$Row.Classes}
        {else}
            {assign var="rowClasses" value="pg-row"}
        {/if}

        <div class="grid-card-item {if $isMasterGrid}col-md-12{else}{$DataGrid.CardClasses}{/if} {$rowClasses}">
            <div class="movie">
                <a href="{$Row.ActionsDataCells.view.Data.link}" class="movie-poster">
                    <img src="{$Row.DataCells.poster.Value}" alt="{$Row.DataCells.title.Value}">

                    {if $Row.DataCells.trailer.Value}
                        <div class="movie-trailer pgui-field-embedded-video" data-url="{$Row.DataCells.trailer.Value}">
                            <span class="pgui-field-embedded-video-thumb"></span>
                            <span class="pgui-field-embedded-video-icon icon-play"></span>
                        </div>
                    {/if}
                </a>

                <div class="movie-content">
                    <h3 class="movie-content-title">
                        {$Row.DataCells.title.Value}
                        <span class="movie-content-title-released">{$Row.DataCells.release_date.Value}</span>
                    </h3>
                    <div class="movie-content-info">
                        <span class="movie-content-info-rating">
                            <span class="movie-content-info-rating-star">★</span>
                            {$Row.DataCells.rating.Value}
                        </span>
                    </div>
                    <div class="movie-content-overview">
                        {$Row.DataCells.overview.Value}
                    </div>

                    {if $DataGrid.HasDetails}
                    <ul class="nav nav-pills nav-justified movie-content-links">
                        {foreach from=$Row.Details.Items item=Detail}
                            <li class="hidden-sm hidden-xs"><a href="{$Detail.SeparatedPageLink|escapeurl}">{$Detail.caption}</a></li>
                        {/foreach}
                        <li><a href="{$Row.ActionsDataCells.view.Data.link}">More info</a></li>
                    </ul>
                    {/if}
                </div>
            </div>
        </div>

    {/foreach}

{/if}