<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php _e("Invoice") ?> - <?php _esc($config['site_title']) ?></title>
    <style>
        :root{--theme-color-1: <?php _esc($config['theme_color']) ?>;}
    </style>
    <link rel="stylesheet" href="<?php _esc(TEMPLATE_URL);?>/css/invoice.css?1">
</head>
<body>

<!-- Print Button -->
<div class="print-button-container">
    <a href="javascript:window.print()" class="print-button"><?php _e("Print this invoice") ?></a>
</div>

<!-- Invoice -->
<div id="invoice">
    <!-- Header -->
    <div class="row">
        <div class="col-xl-6">
            <div id="logo"><img src="<?php _esc($config['site_url']) ?>storage/logo/<?php _esc($config['site_logo']) ?>" alt="<?php _esc($config['site_title']) ?>"></div>
        </div>
        <div class="col-xl-6">
            <p id="details">
                <strong><?php _e("Invoice") ?>:</strong> <?php _esc($config['invoice_nr_prefix']); _esc($invoice_id); ?> <br>
                <strong><?php _e("Date") ?>:</strong> <?php _esc($invoice_date) ?>
            </p>
        </div>
    </div>


    <!-- Client & Supplier -->
    <div class="row">
        <div class="col-xl-12">
            <h2 style="text-align: center">Hóa Đơn Bán Hàng</h2>
        </div>
        <div class="invoice-header">
            <div class="col-md-6">
                <h4 class="margin-bottom-5">Tên Người Bán</h4>
                <p>
                    <?php
                    if($config['invoice_admin_name'] != "")
                        echo '<strong>'.__("Name").':</strong> <b style="font-weight: 600; color: #000;">'._esc($config['invoice_admin_name'],false).'</b><br>';
                    if($config['invoice_admin_address'] != "")
                        echo '<strong>'.__("Address").':</strong> '._esc($config['invoice_admin_address'],false).'<br>';
                    if($config['invoice_admin_tax_type'] != "" && $config['invoice_admin_tax_id'] != "")
                        echo '<strong>'._esc($config['invoice_admin_tax_type'],false).':</strong> '._esc($config['invoice_admin_tax_id'],false).'<br>';

                    ?>
                </p>
            </div>
            <div class="col-md-6">
                <h4 class="margin-bottom-5">Tên Người Mua</h4>
                <p>
                    <?php
                    if($billing_name != "")
                        echo '<strong>'.__("Name").':</strong> <b style="font-weight: 600; color: #000;">'._esc($billing_name,false).'</b><br>';
                    if($billing_address != "")
                        echo '<strong>'.__("Address").':</strong> '._esc($billing_address,false).'<br>';
                    if($billing_details_type != "business"){
                        if($config['invoice_admin_tax_type'] != ""){
                            $taxid = $config['invoice_admin_tax_type'];
                        }else{
                            $taxid = __("Tax ID");
                        }
                        echo '<strong>'.$taxid.':</strong> '._esc($billing_tax_id,false).'<br>';
                    }
                    ?>
                </p>
            </div>         
        </div>
    </div>
    <!-- Invoice -->
    <div class="row">
        <div class="col-xl-12">
            <table class="margin-top-20">
                <tr>
                    <th>Miêu tả</th>
                    <th>Thành tiền</th>
                </tr>
                <tr>
                    <td><?php _esc($item_name) ?></td>
                    <td><?php _esc($item_amount) ?></td>
                </tr>
            </table>
            <table id="totals"  style="background: #F5F5F5;">
                <tr>
                    <th><?php _e("Total") ?><br><small><?php _e("Paid via");?> <?php _esc($paid_via) ?></small></th>
                    <th><span><?php _esc($total_amount) ?></span></th>
                </tr>
            </table>
        </div>
    </div>
    <!-- Footer -->
    <div class="row">
        <div class="col-xl-12">
            <ul id="footer">
                <li><?php _esc($config['site_url']) ?></span></li>
                <li><?php _esc($config['invoice_admin_email']) ?></li>
                <li><?php _esc($config['invoice_admin_phone']) ?></li>
            </ul>
        </div>
    </div>
</div>
</html>