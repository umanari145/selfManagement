<!--{* ★ ページャここから ★ *}-->
<div class="pager">
    <ul>
    {foreach from=$arrPagenavi.arrPageno key="key" item="item"}
        <li {if $arrPagenavi.now_page == $item} class="on"{/if}><a href="#" onclick="moveNaviPage({$item}); return false;"><span>{$item}</span></a></li>
    {/foreach}
    </ul>
    {if isset($current_page_message)}
    <p>{$current_page_message}</p>
    {/if}
</div>
<!--{* ★ ページャここまで ★ *}-->
