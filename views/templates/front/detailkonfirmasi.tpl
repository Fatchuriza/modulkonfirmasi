<!--{$konfirmasis|@var_dump}
{foreach from=$konfirmasis item=konfirm}
	{$konfirm.id_konfirmasi_produk|@var_dump}
{/foreach}
{$lastKonfirmasi|@var_dump}
{foreach from=$lastKonfirmasi item=lastkonfirmas}
	{$lastkonfirmas.id_konfirmasi_produk|@var_dump}
{/foreach}
-->
{capture name=path}
    <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
        {l s='My account'}
    </a>
    <span class="navigation-pipe">{$navigationPipe}</span>
    <span class="navigation_page">{l s='Konfirmasi Pembayaran'}</span>
{/capture}
{include file="$tpl_dir./errors.tpl"}
<h1 class="page-heading bottom-indent">{l s='Konfirmasi Pembayaran'}</h1>
<p class="info-title">{l s='Berikut ini adalah daftar pesanan yang telah Anda pesan sebelumnya'}</p>
{if isset($konfirmasi)}
    <div class="alert alert-success">Konfirmasi Diterima</div>
{/if}
<div class="block-center" id="block-history">
    {if $orders && count($orders)}
        <table id="order-list" class="table table-bordered footab">
            <thead>
            <tr>
                <th class="first_item" data-sort-ignore="true">{l s='Order reference'}</th>
                <th class="item">{l s='Date'}</th>
                <th data-hide="phone" class="item">{l s='Total price'}</th>
                <th data-sort-ignore="true" data-hide="phone,tablet" class="item">{l s='Payment Method'}</th>
                <th class="item">{l s='Payment Status'}</th>
                <th data-sort-ignore="true" data-hide="phone,tablet" class="last_item" width="450">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$orders item=order name=myLoop}
                <tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
                    <td class="history_link bold">
                        {if isset($order.invoice) && $order.invoice && isset($order.virtual) && $order.virtual}
                            <img class="icon" src="{$img_dir}icon/download_product.gif"	alt="{l s='Products to download'}" title="{l s='Products to download'}" />
                        {/if}
                            {$order.reference}
                    </td>
                    <td data-value="{$order.date_add|regex_replace:"/[\-\:\ ]/":""}" class="history_date bold">
                        {dateFormat date=$order.date_add full=0}
                    </td>
                    <td class="history_price" data-value="{$order.total_paid}">
							<span class="price">
								{displayPrice price=$order.total_paid currency=$order.id_currency no_utf8=false convert=false}
							</span>
                    </td>
                    <td class="history_method">{$order.payment|escape:'html':'UTF-8'}</td>
                    <td{if isset($order.order_state)} data-value="{$order.id_order_state}"{/if} class="history_state">
                        {if isset($order.order_state)}
                            <span class="label{if isset($order.order_state_color) && Tools::getBrightness($order.order_state_color) > 128} dark{/if}"{if isset($order.order_state_color) && $order.order_state_color} style="background-color:{$order.order_state_color|escape:'html':'UTF-8'}; border-color:{$order.order_state_color|escape:'html':'UTF-8'};"{/if}>
									{$order.order_state|escape:'html':'UTF-8'}
								</span>
                        {/if}
                    </td>
                    <td class="history_detail">
						{$count = "0"}
						{$counta = "0"}
						{foreach from=$konfirmasis item=konfirm}
							{if $konfirm.no_order == $order.reference}
								{$count=$count+1}
							{/if}
						{/foreach}
						{foreach from=$konfirmasis item=konfirm}
							{if ($konfirm.no_order == $order.reference) && $konfirm.active == 1}
								{$counta=$counta+1}
							{/if}
						{/foreach}
						{if $counta > 0}
						<span class="label" style="background-color:green; border-color:green;">
							{l s='Telah Terkonfirmasi'}
						</span>
						{elseif ($count >0) && ($counta == 0)}
							{l s='Kami sudah menerima konfirmasi Anda dan akan kami proses segera pada hari/jam kerja'}</br>
							<a class="btn btn-default button button-small" href="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getModuleLink('modulkonfirmasi', 'FormKonfirmasi')|escape:'html':'UTF-8'}');">
							<span>
								{l s='Konfirmasi Lagi'}<i class="icon-chevron-right right"></i>
							</span>
							</a>
						{else}
							<a class="btn btn-default button button-small" href="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getModuleLink('modulkonfirmasi', 'FormKonfirmasi')|escape:'html':'UTF-8'}');">
							<span>
								{l s='Konfirmasi Pembayaran'}<i class="icon-chevron-right right"></i>
							</span>
							</a>
						{/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div id="block-order-detail" class="unvisible">&nbsp;</div>
    {else}
        <p class="alert alert-warning">{l s='You have not placed any orders.'}</p>
    {/if}
</div>
<ul class="footer_links clearfix">
    <li>
        <a class="btn btn-default button button-small" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
			<span>
				<i class="icon-chevron-left"></i> {l s='Back to Your Account'}
			</span>
        </a>
    </li>
    <li>
        <a class="btn btn-default button button-small" href="{$base_dir}">
            <span><i class="icon-chevron-left"></i> {l s='Home'}</span>
        </a>
    </li>
</ul>
