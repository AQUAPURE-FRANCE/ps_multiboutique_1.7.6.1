<?php

class NrtMegamenuItemsModel extends ObjectModel
{
    public $id_nrtmegamenu;
    public $active = 1;
    public $nleft;
    public $nright;
    public $depth = 1;
    public $icon_class;
    public $menu_type;
    public $menu_class;
    public $menu_layout;
    public $menu_image;
    public $open_in_new = 0;
    public $show_image = 0;

    //Multilang Fields
    public $title;
    public $description;
    public $link;
    public $content;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'nrtmegamenuitems',
        'primary' => 'id_nrtmegamenuitems',
        'multilang' => true,
        'fields' => array(
            //Fields
            'id_nrtmegamenu'     =>  array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'active'      =>  array('type' => self::TYPE_INT, 'validate' => 'isBool'),
            'nleft'       =>  array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'nright'      =>  array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'depth'       =>  array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'icon_class'  =>  array('type' => self::TYPE_STRING, 'size' => 255),
            'menu_type'   =>  array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'menu_class'  =>  array('type' => self::TYPE_STRING, 'size' => 255),
            'menu_layout' =>  array('type' => self::TYPE_STRING, 'size' => 255),
            'menu_image'  =>  array('type' => self::TYPE_STRING, 'size' => 255),
            'open_in_new' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'show_image'  =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),

            //Multilanguage Fields
            'title'       =>  array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'description' =>  array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 125),
            'link'        =>  array('type' => self::TYPE_STRING, 'lang' => true, 'size' => 255),
            'content'     =>  array('type' => self::TYPE_HTML, 'lang' => true, 'size' => 10000),
        )
    );

    /*-------------------------------------------------------------*/
    /*  CONSTRUCT
    /*-------------------------------------------------------------*/
    public function __construct($id_nrtmegamenuitems = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_nrtmegamenuitems, $id_lang, $id_shop);
    }

    /*-------------------------------------------------------------*/
    /*  ADD
    /*-------------------------------------------------------------*/
    public function add($autoddate = true, $null_values = false)
    {
        return parent::add();
    }

    /*-------------------------------------------------------------*/
    /*  DELETE
    /*-------------------------------------------------------------*/
    public function delete()
    {
        return parent::delete();
    }

    /*-------------------------------------------------------------*/
    /*  GET MIN nleft
    /*-------------------------------------------------------------*/
    public static function getMinLeft($id_nrtmegamenu)
    {
        $response = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
            SELECT MIN(nleft)
            FROM '._DB_PREFIX_.'nrtmegamenuitems
            WHERE id_nrtmegamenu = '.$id_nrtmegamenu
        );

        if ($response['MIN(nleft)'] == null){
            return 0;
        }

        return $response['MIN(nleft)'];
    }

    /*-------------------------------------------------------------*/
    /*  GET MAX nright
    /*-------------------------------------------------------------*/
    public static function getMaxRight($id_nrtmegamenu)
    {
        $response = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
            SELECT MAX(nright)
            FROM '._DB_PREFIX_.'nrtmegamenuitems
            WHERE id_nrtmegamenu = '.$id_nrtmegamenu
        );

        if ($response['MAX(nright)'] == null){
            return -1;
        }

        return $response['MAX(nright)'];
    }

    /*-------------------------------------------------------------*/
    /*  GET MENU ITEMS COUNT
    /*-------------------------------------------------------------*/
    public static function getMenuItemsCount($id_nrtmegamenu)
    {
        $response = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
            SELECT COUNT(id_nrtmegamenu)
            FROM '._DB_PREFIX_.'nrtmegamenuitems
            WHERE id_nrtmegamenu = '.$id_nrtmegamenu
        );

        return $response['COUNT(id_nrtmegamenu)'];
    }

    /*-------------------------------------------------------------*/
    /*  GET MENU ITEMS
    /*-------------------------------------------------------------*/
    public static function getMenuItems($id_nrtmegamenu)
    {
        $minNLeft = NrtMegamenuItemsModel::getMinLeft($id_nrtmegamenu);
        $maxNRight = NrtMegamenuItemsModel::getMaxRight($id_nrtmegamenu);

        $response = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT items.id_nrtmegamenuitems
            FROM '._DB_PREFIX_.'nrtmegamenuitems as items
            WHERE items.nleft BETWEEN '.$minNLeft.' AND '.$maxNRight.'
            AND items.id_nrtmegamenu ='.$id_nrtmegamenu.'
            ORDER BY items.nleft'
        );

        return $response;
    }




}