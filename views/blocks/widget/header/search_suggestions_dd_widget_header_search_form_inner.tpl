[{$smarty.block.parent}]
<div id="suggestionBox" class="row suggestion-box w-lg-50" aria-label="search suggestions" style="display: none">
    <div id="articlesCol" class="col-sm-9 p-0">
        <ul id="suggestionBoxArticles" aria-label="article suggestions" class="suggestion-list">

        </ul>
    </div>
    <div id="articlesCol" class="col-sm-3 p-0">
        <ul id="suggestionBoxCategories" aria-label="category suggestions" class="suggestion-list">

        </ul>
    </div>
</div>
<script>
    [{assign var="config" value=$oViewConf->getConfig()}]
    const shoproot = "[{$config->getShopUrl()}]"
</script>
[{oxstyle include=$oViewConf->getModuleUrl('marvin-search-suggest', 'out/src/css/search-suggest.css')}]
[{oxscript include=$oViewConf->getModuleUrl('marvin-search-suggest', 'out/src/js/search-suggest.js')}]