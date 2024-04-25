[{$smarty.block.parent}]
<ul id="suggestionBox" role="menu" aria-label="search suggestions" class="suggestion-box" style="display: none">

</ul>
[{oxstyle include=$oViewConf->getModuleUrl('marvin-search-suggest', 'out/src/css/search-suggest.css')}]
[{oxscript include=$oViewConf->getModuleUrl('marvin-search-suggest', 'out/src/js/search-suggest.js')}]