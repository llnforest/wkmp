{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}

{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl4">
    <img class="list-mini-image" src="{{ d.col4 != "" ?  '__ImagePath__'+d.col4 : '' }}">
</script>
<script type="text/html" id="imgTpl5">
    <img class="list-mini-image" src="{{ d.col5 != "" ?  '__ImagePath__'+d.col5 : '' }}">
</script>
<script type="text/html" id="imgTpl8">
    <img class="list-mini-image" src="{{ d.col8 != "" ?  '__ImagePath__'+d.col8 : '' }}">
</script>
<script type="text/html" id="imgTpl11">
    <img class="list-mini-image" src="{{ d.col11 != "" ?  '__ImagePath__'+d.col11 : '' }}">
</script>
<script type="text/html" id="imgTpl14">
    <img class="list-mini-image" src="{{ d.col14 != "" ?  '__ImagePath__'+d.col14 : '' }}">
</script>
<script type="text/html" id="imgTpl17">
    <img class="list-mini-image" src="{{ d.col17 != "" ?  '__ImagePath__'+d.col17 : '' }}">
</script>

<script>


</script>
{/block}