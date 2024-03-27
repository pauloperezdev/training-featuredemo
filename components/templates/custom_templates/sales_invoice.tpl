<div id="sales-invoice-content">

    <table class="invoice-header" width="100%" align="center">
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="50%" style="text-align: left;">
                            <img src="external_data/images/company_logo.png" style="max-height:80px;">
                        </td>
                        <td width="50%" style="text-align: right;font-size: 4em;font-weight: bold;">
                            Sales Invoice
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="70%" style="text-align: left;">
                            Company Name, Inc.<br>
                            5553 Cash Avenue<br>
                            Phoenix, AZ 85004
                        </td>
                        <td width="30%">
                            <table class="invoice-info">
                                <tr>
                                    <th style="width: 100px;text-align: right;">Date:</th>
                                    <td style="text-align: center;">{$InvoiceDate}</td>
                                </tr>
                                <tr>
                                    <th style="width: 100px;text-align: right;">Invoice #:</th>
                                    <td style="text-align: center;">{$InvoiceNumber}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                <table style="margin-top:20px">
                    <tr>
                        <td style="text-align: left">
                            <strong>Bill to:</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left">
                            {$InvoiceCustomer}<br>
                            {$BillToAddress}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="invoice-detail" align="center">
        <tr>
            <th>
                #
            </th>
            <th>
                Item
            </th>
            <th>
                Description
            </th>
            <th>
                Quantity
            </th>
            <th>
                Unit Price
            </th>
            <th>
                Line Total
            </th>
        </tr>
        {foreach from=$InvoiceDetails item=detail name=foo}
            <tr>
                <td style="text-align:center;">
                    {$smarty.foreach.foo.index+1}
                </td>
                <td style="text-align:left;">
                    [{$detail.product_number}]
                </td>
                <td style="text-align:left;">
                    {$detail.product_name}
                </td>
                <td style="text-align:center;">
                    {$detail.quantity}
                </td>
                <td style="text-align:right;">
                    ${$detail.unit_price|number_format:2}
                </td>
                <td style="text-align:right;">
                    ${$detail.total|number_format:2}
                </td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="6" style="border:0">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:0">
            </td>
            <th style="text-align:right;">
                Subtotal:
            </th>
            <td style="text-align:right;">
                ${$InvoiceSubtotal|number_format:2}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:0">
            </td>
            <th style="text-align:right;">
                Tax rate:
            </th>
            <td style="text-align:right;">
                6%
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:0">
            </td>
            <th style="text-align:right;">
                Tax:
            </th>
            <td style="text-align:right;">
                ${$InvoiceTax|number_format:2}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border:0">
            </td>
            <th style="text-align:right;">
                Total:
            </th>
            <td style="text-align:right;">
                ${$InvoiceTotal|number_format:2}
            </td>
        </tr>
    </table>

    <div style="text-align: center">
        <p><em>Total payment due in 30 days</em></p>
        <p><small>If you have any questions about this invoice, please contact<br>
            Martha Hamilton, Phone: (802) 555-3623, Email: m.hamilton@example.com</small></p>
        <p><strong>Thank You For Your Business!</strong></p>
    </div>

</div>
