{if count($DataGrid.Rows) > 0}
    {foreach item=Row from=$DataGrid.Rows name=RowsGrid}

        {if $Row.Classes}
            {assign var="rowClasses" value="pg-row "|cat:$Row.Classes}
        {else}
            {assign var="rowClasses" value="pg-row"}
        {/if}

        <tr class="{$rowClasses}" style="{$Row.Style}">
            {if $DataGrid.AllowSelect}
                <td style="{$Row.Style}">
                    <div class="row-selection">
                        <input id="record_{'_'|@implode:$Row.PrimaryKeys|@escape}" type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" data-value="{to_json value=$Row.PrimaryKeys escape=true}" />
                    </div>
                </td>
            {/if}

            {if $DataGrid.HasDetails}
                <td dir="ltr" class="details" style="width: 40px;{$Row.Style}">
                    {include file="list/details_icon.tpl" Details=$Row.Details}
                </td>
            {/if}

            {if $DataGrid.ShowLineNumbers}
                <td class="line-number" style="{$Row.Style}">{$Row.LineNumber}</td>
            {/if}

            {if $DataGrid.Actions and $DataGrid.Actions.PositionIsLeft}
                <td class="operation-column">
                    {include file="list/action_list.tpl" Actions=$Row.ActionsDataCells}
                </td>
            {/if}

            {* Custom Template *}
            <td>
                <a class="image gallery-item" data-name="poster" href="{$Row.DataCells.poster.Value}" title="{$Row.DataCells.title.Value}">
                    <img style="width: 100px" data-image-column="true" src="{$Row.DataCells.poster.Value}" alt="{$Row.DataCells.title.Value}">
                </a>
            </td>
            <td style="text-align: left; width: 30%">
                <strong><big>{$Row.DataCells.title.Data}</big></strong>
                <p>{$Row.DataCells.tagline.Data}</p>
            </td>
            <td data-column-name="Overview" style="max-width: 350px; text-align: left">{$Row.DataCells.overview.Data}</td>
            <td>{$Row.DataCells.release_date.Data}</td>
            <td><span class="movie-content-info-rating-star">★</span> {$Row.DataCells.rating.Data}</td>
            {* /Custom Template *}

            {* Default template
            {foreach item=Column from=$Columns}
                {assign var=CellName value=$Column->getName()}
                {include file="list/data_cell.tpl" Cell=$Row.DataCells[$CellName]}
            {/foreach}
            *}

            {if $DataGrid.Actions and $DataGrid.Actions.PositionIsRight}
                <td class="operation-column">
                    {include file="list/action_list.tpl" Actions=$Row.ActionsDataCells}
                </td>
            {/if}
        </tr>
    {/foreach}
{/if}