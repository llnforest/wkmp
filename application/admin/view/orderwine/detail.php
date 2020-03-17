{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
<table class="layui-table">
    <thead>
    <tr>
        <th colspan="8" style="text-align:center;">订单酒品</th>
    </tr>
    <tr>
        <th width="35">图片</th>
        <th>酒品名称</th>
        <th width="65">包装规格</th>
        <th width="50">系列</th>
        <th width="35">数量</th>
        <th width="35">单价</th>
        <th width="35">总额</th>
        <th width="35">返佣</th>
    </tr>
    </thead>
    <tbody>
    {foreach $goodsList as $v}
    <tr>
        <th><img class="list-mini-image" src="__ImagePath__{$v.img}"></th>
        <th>{$v.wine_name}</th>
        <th>{$v.wine_size|raw}</th>
        <th>{$v.wine_style|raw}</th>
        <th>{$v.quantity}</th>
        <th>{$v.mall_price}</th>
        <th>{$v.mall_price * $v.quantity} </th>
        <th>{$user.level != 0?($v.mall_price - $v.vip_price) * $v.quantity : 0}</th>
    </tr>
    {/foreach}

    </tbody>
</table>

<table class="layui-table">
    <thead>
    <tr>
        <th colspan="4" style="text-align:center;">订单信息</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="70">订单编号</td>
        <td width="35%">{$info.id??''}</td>
        <td width="70">订单状态</td>
        <td width="35%">{$info.status_text|raw}</td>
    </tr>
    <tr>
        <td>用户信息</td>
        <td>{$user.name??''}-{$user.phone??''}-{$user.level_text|raw}</td>
        <td>微信交易</td>
        <td>{$info.transaction_id??''}</td>
    </tr>
    <tr>
        <td>订单金额</td>
        <td>{$info.total_money??''}元</td>
        <td>酒品总额</td>
        <td>{$info.mall_wine_money??''}元</td>
    </tr>
    <tr>
        <td>快递费用</td>
        <td>{$info.express_price??''}元{if $info.express != '' }（<span class="layui-tx-green">实际：{$info.true_express_price}元</span>）{/if}</td>
        <td>酒品返佣</td>
        <td>{$user.level >0 ?$info.mall_wine_money - $info.vip_wine_money : 0}元</td>
    </tr>
    <tr>
        <td>配送类型</td>
        <td>{$info.express_type_text|raw}</td>
        <td>快递信息</td>
        <td>{$info.express != ''?$express.express.'（'.$info.express.'）' : ''}</td>
    </tr>
    <tr>
        <td>{$info.express_type == 1?'寄件地址' : '取件门店'}</td>
        <td colspan="3">{$info.express_type == 1?$info.address_info : $info.shop_info}</td>
    </tr>
    <tr>
        <td>酒品种类</td>
        <td>{$goodsList|count}种</td>
        <td>下单时间</td>
        <td>{$info.create_time??''}</td>
    </tr>
    <tr>
        <td>用户备注</td>
        <td colspan="3">{$info.user_remark??''}</td>
    </tr>
    <tr>
        <td>后台备注</td>
        <td colspan="3">{$info.remark??''}</td>
    </tr>

    </tbody>
</table>

{/block}

{block name="jsBody"}

{/block}
