<?php

return [
    'roles' => ['Superman' => '超级管理员', 'Maintainer' => '管理员', 'Finance' => '财务管理员'],
    'order_status' => [
        0 => "等待付款",
        1 => "订单提交成功",
        2 => "订单已确认",
        3 => "订单已打印",
        5 => "药店拣货完成",
        7 => "配送员已取货",
        8 => "配送员正在配送途中",
//        12 => "申请取消",
//        16 => "申请全部退款",
//        17 => "申请部分退款",
        25 => "订单已取消",
        33 => "订单完成",
        35 => "评价完成"
    ],
];