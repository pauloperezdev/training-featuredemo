<div style="max-width: 800px">
{foreach item=Row from=$Rows name=RowsGrid}
    <div style="width: 50%; float: left; padding-bottom: 2em; border-bottom: 1px solid #ddd">
        <h3>{$Row.1} <small>({$Row.2})</small></h3>
        <table>
            <tr>
                <td style="text-align:right"><strong>Become independent (year)</strong></td>
                <td style="text-align:left">{$Row.3}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Population</strong></td>
                <td style="text-align:left">{$Row.4}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Life Expectancy</strong></td>
                <td style="text-align:left">{$Row.5}</td>
            </tr>
        </table>
    </div>
{/foreach}
</div>