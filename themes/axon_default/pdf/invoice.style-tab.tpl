{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{assign var=color_header value="#f8f8f8"}
{assign var=color_border value="#43c5b8"}
{assign var=color_divider value="#e6e6e6"}
{assign var=color_border_lighter value="#e5e5e5"}
{assign var=color_line_even value="#FFFFFF"}
{assign var=color_line_odd value="#F9F9F9"}
{assign var=font_size_text value="9pt"}
{assign var=font_size_header value="10pt"}
{assign var=font_size_product value="9pt"}
{assign var=height_header value="15px"}
{assign var=table_padding value="4px"}
{assign var=font_header value="OpenSans-Bold"}

<style>

	table, th, td {
		margin: 0!important;
		padding: 0!important;
		vertical-align: middle;
		font-family: 'OpenSans-Light';
		font-size: {$font_size_text};
		white-space: normal;
	}
	
	table.product {
		border-collapse: separate;
	}

	table#addresses-tab tr td {
		font-size: large;
	}
	
	table#summary-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}
	table#total-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}
	table#note-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}
	table#note-tab td.note{
		word-wrap: break-word;
	}
	table#tax-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}
	table#payment-tab,
	table#shipping-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}
	
	.top-header th {
		height: 30px !important;
		vertical-align: middle;
	}
	
	tr.product,
	tr.shipping,
	tr.discount {
		background-color: {$color_header};
		border-spacing: 1px;
	}

	th.product {
		border-bottom: 1px solid {$color_border};
		border-top: 1px solid {$color_border};
		background-color: #fff;
		font-family: {$font_header};
		color: {$color_border};
		font-size: {$font_size_header};
	}
	
	tr.color_line_even {
		background-color: {$color_line_even};
	}

	tr.color_line_odd {
		background-color: {$color_line_odd};
		overflow: hidden;
	}

	tr.customization_data td {
	}

	tr.product td.product {
		vertical-align: middle;
		font-size: {$font_size_product};
	}

	th.reduction {
		border-bottom: 1px solid {$color_border};
		border-top: 1px solid {$color_border};
		background-color: #fff;
		font-family: {$font_header};
		color: {$color_border};
		font-size: {$font_size_header};
	}

	th.header {
		font-size: {$font_size_header};
		color: {$color_border};
		background-color: {$color_header};
		border-top: 1px solid {$color_border};
		border-bottom: 1px solid {$color_border};
		vertical-align: middle;
		text-align: center;
		font-family: {$font_header};
	}

	th.header-right {
		font-size: {$font_size_header};
		color: {$color_border};
		background-color: {$color_header};
		border-bottom: 1px solid {$color_border};
		border-top: 1px solid {$color_border};
		vertical-align: middle;
		text-align: right;
		font-family: {$font_header};
	}

	th.payment,
	th.shipping {
		background-color: {$color_header};
		vertical-align: middle;
		font-weight: bold;
	}

	th.tva {
		background-color: {$color_header};
		vertical-align: middle;
		font-weight: bold;
	}

	tr.separator td {
		border-top: 1px solid #000000;
	}

	.left {
		text-align: left;
	}
	

	.fright {
		float: right;
	}

	.right {
		text-align: right;
	}

	.center {
		text-align: center;
	}

	.address_title {
		color: #28a6ec;
		font-family: {$font_header};
	}

	.border {
		border: 1px solid black;
	}
	
	.no_bottom_border, .no_bottom_border td.product, {
		border-bottom: none;
	}

	.grey {
		background-color: {$color_header};

	}

	/* This is used for the border size */
	.white {
		background-color: #FFFFFF;
	}

	.big,
	tr.big td{
		font-size: 110%;
	}

	.small, table.small th, table.small td {
		font-size:small;
	}
	
	.icon {
		font-family: "FontAwesome"
	}
			
</style>
