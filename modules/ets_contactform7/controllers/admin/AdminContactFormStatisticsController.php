<?php
/**
 * 2007-2018 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2018 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
require_once(_PS_MODULE_DIR_.'ets_contactform7/classes/ctf_paggination_class.php');
if (!defined('_PS_VERSION_'))
    	exit;
class AdminContactFormStatisticsController extends ModuleAdminController
{
    public function __construct()
    {
       parent::__construct();
       if($ip=Tools::getValue('addtoblacklist'))
       {
            $black_list = explode("\n",Configuration::get('ETS_CTF7_IP_BLACK_LIST'));
            $black_list[]=$ip;
            Configuration::updateValue('ETS_CTF7_IP_BLACK_LIST',implode("\n",$black_list));
            if(Tools::isSubmit('ajax_ets'))
            {
                die(
                  Tools::jsonEncode(
                    array(
                        'ok'=>true,
                    )
                  )  
                );
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormStatistics').'&tab_ets=view-log');
       }
       if(Tools::isSubmit('clearLogSubmit'))
       {
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'ets_ctf_log WHERE id_contact IN (SELECT id_contact FROM '._DB_PREFIX_.'ets_ctf_contact_shop WHERE id_shop='.(int)$this->context->shop->id.')');
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminContactFormStatistics').'&tab_ets=view-log&conf=1');
       }
       $this->bootstrap = true;
    }
    public function initContent()
    {
        parent::initContent();
    }
    public function renderList()
    {
        
        $months=Tools::dateMonths();
        $now_year = date('Y')+2;
        $start_year = Db::getInstance()->getValue('SELECT MIN(YEAR(date_add)) FROM '._DB_PREFIX_.'ets_ctf_contact WHERE 1 '.((int)Tools::getValue('id_contact')? ' AND id_contact='.(int)Tools::getValue('id_contact') :''));
        $years = array();
        if($start_year)
        {
            for($i=$start_year-2;$i<=$now_year;$i++)
            {
                $years[]=$i;
            }
        }
        $messages=array();
        $views=array();
        $replies =array();
        if(!Tools::getValue('years',date('Y')))
        {
            if($years)
            {
                foreach($years as $year)
                {
                    $messages[] =array(
                        0 => $year,
                        1 => $this->getCountMesssage($year,'','',Tools::getValue('id_contact')),
                    );
                    $views[] =array(
                        0 => $year,
                        1 => $this->getCountView($year,'','',Tools::getValue('id_contact')),
                    );
                    $replies[] =array(
                        0 => $year,
                        1 => $this->getCountReplies($year,'','',Tools::getValue('id_contact')),
                    );
                }
            }
        }
        elseif($year = Tools::getValue('years',date('Y')))
        {
            if(!Tools::getValue('months',date('m'))){
                if($months)
                {
                    foreach($months as $key=> $month)
                    {
                        $messages[] =array(
                            0 => $key,
                            1 => $this->getCountMesssage($year,$key,'',Tools::getValue('id_contact')),
                        );
                        $views[] =array(
                            0 => $key,
                            1 => $this->getCountView($year,$key,'',Tools::getValue('id_contact')),
                        );
                        $replies[] =array(
                            0 => $key,
                            1 => $this->getCountReplies($year,$key,'',Tools::getValue('id_contact')),
                        );
                    }
                }
            }
            elseif($month=Tools::getValue('months',date('m')))
            {
                $days = function_exists('cal_days_in_month') ? cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year) : (int)date('t', mktime(0, 0, 0, (int)$month, 1, (int)$year));
                if($days)
                {
                    for($day=1; $day<=$days;$day++)
                    {
                        $messages[] =array(
                            0 => $day,
                            1 => $this->getCountMesssage($year,$month,$day,Tools::getValue('id_contact')),
                        );
                        $views[] =array(
                            0 => $day,
                            1 => $this->getCountView($year,$month,$day,Tools::getValue('id_contact')),
                        );
                        $replies[] =array(
                            0 => $day,
                            1 => $this->getCountReplies($year,$month,$day,Tools::getValue('id_contact')),
                        );
                    }
                }
            }
        }
        $contacts = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'ets_ctf_contact c, '._DB_PREFIX_.'ets_ctf_contact_lang cl WHERE c.id_contact=cl.id_contact AND cl.id_lang='.(int)$this->context->language->id);
        $lineChart =array(
            array(
                'key'=> $this->module->l('Messages'),
                'values'=>$messages,
                'disables'=>1,
            ), 
            array(
                'key'=> $this->module->l('Views'),
                'values'=>$views,
                'disables'=>1,
            ),
            array(
                'key'=> $this->module->l('Replies'),
                'values'=>$replies,
                'disables'=>1,
            ), 
        );
        $sql = "SELECT * FROM "._DB_PREFIX_."ets_ctf_log l 
        INNER JOIN "._DB_PREFIX_."ets_ctf_contact c ON (l.id_contact=c.id_contact)
        LEFT JOIN "._DB_PREFIX_."ets_ctf_contact_lang cl ON (c.id_contact=cl.id_contact AND cl.id_lang='".(int)$this->context->language->id."')
        GROUP BY l.ip,l.id_contact,l.datetime_added";
        $total= count(Db::getInstance()->executeS($sql));
        $limit=20;
        $page = Tools::getValue('page',1);
        if($page<=0)
            $page=1;
        $start= ($page-1)*$limit;
        $pagination = new Ctf_paggination_class();
        $pagination->url = $this->context->link->getAdminLink('AdminContactFormStatistics').'&tab_ets=view-log&page=_page_';
        $pagination->limit=$limit;
        $pagination->page= $page;
        $pagination->total=$total;
        $sql = "SELECT * FROM "._DB_PREFIX_."ets_ctf_log l 
        INNER JOIN "._DB_PREFIX_."ets_ctf_contact c ON (l.id_contact=c.id_contact)
        LEFT JOIN "._DB_PREFIX_."ets_ctf_contact_lang cl ON (c.id_contact=cl.id_contact AND cl.id_lang='".(int)$this->context->language->id."')
        LEFT JOIN "._DB_PREFIX_."customer cu ON (l.id_customer=cu.id_customer)
        GROUP BY l.ip,l.id_contact,l.datetime_added ORDER BY l.datetime_added DESC LIMIT ".(int)$start.", ".(int)$limit;
        $logs=Db::getInstance()->executeS($sql);
        if($logs)
        {
            $black_list = explode("\n",Configuration::get('ETS_CTF7_IP_BLACK_LIST'));
            foreach($logs as &$log)
            {
                if(in_array($log['ip'],$black_list))
                    $log['black_list']=true;
                else
                    $log['black_list']=false;
                $browser = explode(' ',$log['browser']);
                if(isset($browser[0]))
                    $log['class'] = Tools::strtolower($browser[0]);
                else
                    $log['class']='default';
            }   
        }
        $this->context->smarty->assign(
            array(
                'months' => $months,
                'ctf_month' => (string)Tools::getValue('months',date('m')),
                'action'=> $this->context->link->getAdminLink('AdminContactFormStatistics'),
                'contacts' => $contacts,
                'years'=>$years,
                'ctf_year' => Tools::getValue('years',date('Y')),
                'lineChart' => $lineChart,
                'ctf_contact' => (int)Tools::getValue('id_contact'),
                'js_dir_path' => $this->module->_path_module.'views/js/',
                'logs'=>$logs,
                'tab_ets' => Tools::getValue('tab_ets','chart'),
                'pagination_text' => $pagination->render(),
                'show_reset' => Tools::isSubmit('submitFilterChart'),
            )
        );
        return  $this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'statistics.tpl');
    }
    public function getCountMesssage($year='',$month='',$day='',$id_contact=0)
    {
        return Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_contact_message m, '._DB_PREFIX_.'ets_ctf_contact_shop cs WHERE m.id_contact=cs.id_contact AND cs.id_shop='.(int)$this->context->shop->id.($id_contact ? ' AND cs.id_contact='.(int)$id_contact : '').($year ? ' AND YEAR(m.date_add) ="'.pSQL($year).'"':'').($month ? ' AND MONTH(m.date_add) ="'.pSQL($month).'"':'').($day ? ' AND DAY(m.date_add) ="'.pSQL($day).'"':''));
    }
    public function getCountView($year='',$month='',$day='',$id_contact=0)
    {
        return Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_log l, '._DB_PREFIX_.'ets_ctf_contact_shop cs WHERE l.id_contact=cs.id_contact AND cs.id_shop='.(int)$this->context->shop->id.($id_contact ? ' AND cs.id_contact='.(int)$id_contact : '').($year ? ' AND YEAR(l.datetime_added) ="'.pSQL($year).'"':'').($month ? ' AND MONTH(l.datetime_added) ="'.pSQL($month).'"':'').($day ? ' AND DAY(l.datetime_added) ="'.pSQL($day).'"':''));
    }
    public function getCountReplies($year='',$month='',$day='',$id_contact=0)
    {
        $sql ='SELECT COUNT(*) FROM '._DB_PREFIX_.'ets_ctf_message_reply r
        INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_message m ON (r.id_contact_message = m.id_contact_message)
        INNER JOIN '._DB_PREFIX_.'ets_ctf_contact c ON (c.id_contact=m.id_contact)
        INNER JOIN '._DB_PREFIX_.'ets_ctf_contact_shop cs ON (c.id_contact=cs.id_contact AND cs.id_shop='.(int)$this->context->shop->id.')
        WHERE 1'.($id_contact ? ' AND cs.id_contact='.(int)$id_contact : '').($year ? ' AND YEAR(r.date_add) ="'.pSQL($year).'"':'').($month ? ' AND MONTH(r.date_add) ="'.pSQL($month).'"':'').($day ? ' AND DAY(r.date_add) ="'.pSQL($day).'"':'');
        return Db::getInstance()->getValue($sql);
    }
}