<?php

class konfirmasi extends ObjectModel
{
    public $active = 1;
    public $date_add;
    public $date_upd;
	public $konfirmasi;
	public static $definition = array(
        'table' => 'konfirmasi_produk',
        'primary' => 'id_konfirmasi_produk',
        'fields' => array(
            'active' => 				array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
        ),
    );
	public static function getKonfirmasi()
	{
		$konfirmasi = Db::getInstance()->executeS('
		SELECT '._DB_PREFIX_.'orders.reference, '._DB_PREFIX_.'konfirmasi_produk.no_order, '._DB_PREFIX_.'konfirmasi_produk.active, '._DB_PREFIX_.'konfirmasi_produk.id_konfirmasi_produk
		FROM '._DB_PREFIX_.'orders
		INNER JOIN '._DB_PREFIX_.'konfirmasi_produk
		ON '._DB_PREFIX_.'orders.reference='._DB_PREFIX_.'konfirmasi_produk.no_order');
		return $konfirmasi;
	}
	public static function getIdKonfirmasi(){
		$IDakhir = Db::getInstance()->executeS('SELECT id_konfirmasi_produk
		FROM '._DB_PREFIX_.'konfirmasi_produk');
		return $IDakhir;
	}
}