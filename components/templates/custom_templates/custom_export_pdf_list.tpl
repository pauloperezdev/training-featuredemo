{foreach item=Row from=$Rows name=RowsGrid}
    <div style="width: 50%; float: left; margin-bottom: 1em">
        <h1>{$Row.name.Value} <small>({$Row.continent.Value})</small></h1>
        <table>
            <tr>
                <td style="text-align:right"><strong>Become independent (year)</strong></td>
                <td style="text-align:left">{$Row.indepyear.Value}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Population</strong></td>
                <td style="text-align:left">{$Row.population.Value}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Life Expectancy</strong></td>
                <td style="text-align:left">{$Row.lifeexpectancy.Value}</td>
            </tr>
        </table>
    </div>

    {if $smarty.foreach.RowsGrid.index % 2 == 1}
        <hr>
    {/if}
{/foreach}
