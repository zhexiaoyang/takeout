<html lang="en"><head>
    <meta charset="UTF-8">
    <title>小票</title>
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
</head>
<body>
    <a href="javascript:;" id="printStart" style="display: block;">打印</a>
    @for($i=0; $i<2; $i++)
    <div id="printTemplate">
        <div class="print-item f-l tl">
            {{ $i===0?'商家联':'客户联' }}
        </div>
        <div class="print-item f-s tl">
            {{ $order->shop->name }}</div><div class="print-item f-s tl">下单时间：{{ $order->created_at }}</div><div class="print-item f-s tl">订单编号：{{ $order->order_id }}
        </div>
        <p class="br"></p>
        <div class="dashed"></div>
        <div class="print-item f-s tl">
            商品名称<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            数量<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            单价<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            金额<span class="space">&nbsp;</span><span class="space">&nbsp;</span>
        </div>
        @foreach($order->goods as $k => $goods)
        <div class="dashed"></div>
        <div class="print-item f-m tl">
            {{ $k+1 }}<span class="space">&nbsp;</span>
            {{ $goods->good_name }}
        </div>
        <div class="print-item f-m tl">
            <span class="space">&nbsp;</span>x{{ $goods->quantity }}<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            {{ $goods->price }}<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            {{ $goods->quantity * $goods->price }}
        </div>
        <div class="print-item f-s tl">UPC码：{{ $goods->goods->upc }}</div>
        @endforeach

        <div class="dashed"></div>
        <div class="print-item f-s tl">商品金额:{{ $order->total }}</div>
        <div class="print-item f-s tl">配送金额:{{ $order->shipping_fee }}</div>
        <div class="dashed"></div>
        <div class="print-item f-m tl">
            总件数：{{ count($order->goods) }}<span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span><span class="space">&nbsp;</span>
            实付：{{ $order->total }}
        </div>
        <div class="dashed"></div>
        <p class="br"></p>
        <div class="print-item f-s tl">客户:{{ $order->recipient_name }}</div>
        <div class="print-item f-s tl">电话:{{ $order->recipient_phone }}</div>
        <div class="print-item f-s tl">地址:{{ $order->recipient_address }}</div>
        <p class="br"></p>
        <div class="dashed"></div>
        <p class="br"></p>
    </div>
    @endfor
    <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <script>
        $("#printStart").bind("click", function () {
            var self = $(this);
            self.hide();

            setTimeout(function () {
                window.print();
                setTimeout(function () {
                    self.show()
                }, 500);
            }, 500);

            //打印日志
            $.ajax({
                data:{"_token":'{{csrf_token()}}'},
                type: 'POST',
                url: '{{ route('orders.printAdd', $order->id) }}',
                cache: false
            });

        });
    </script>
</body>
</html>