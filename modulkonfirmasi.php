<?php
require_once(dirname(__FILE__). '/classes/konfirmasi.php');
	class ModulKonfirmasi extends Module
	{
		public $id;
		public function __construct()
		{
			//sebagai data tentang modul yang akan dibuat
			$this->name = 'modulkonfirmasi';
			$this->tab = 'front_office_features';
			$this->version = '0.1';
			$this->author = 'Fachrizal Lukman Hakim';
			$this->displayName = 'Modul Konfirmasi';
			$this->description = 'Dengan modul ini, pelanggan dapat mengkonfirmasi pembayarannya';
			$this->confirmUninstall = $this->l('Apakah Anda yakin ingin melakukan uninstallasi?');
			$this->bootstrap = true;
			parent::__construct();
		}

	//------------------------------------------mulai bab 2-------------------------------------------
		public function install()
		{
			if (!parent::install())
				return false;
			//install sql	
			$sql_file = dirname(__FILE__).'/install/install.sql';
			if (!$this->loadSQLFile($sql_file))
				return false;
			//install admin tab
			if(!$this->installTab('AdminParentOrders', 'AdminModulKonfirmasi', 'Konfirmasi Pembayaran'))
				return false;
			//register hook				
			if(!$this->registerHook('displayCustomerAccount') ||
                           !$this->registerHook('displayNav'))
				return false;
			//menampilkan hook di displayProductTabContent, di halaman detail produk, manggil fungsi hookDisplayProductTabContent($params)
			return true;
		}
		public function uninstall(){
			// Call uninstall parent method
			if (!parent::uninstall())
				return false;
			// Execute module install SQL statements
			$sql_file = dirname(__FILE__).'/install/uninstall.sql';
			if (!$this->loadSQLFile($sql_file))
				return false;
			if(!$this->uninstallTab('AdminModulKonfirmasi'))	
				return false;
			return true;
		}
		public function installTab($parent, $class_name, $name){
			$tab = new Tab();
			$tab->id_parent = (int)Tab::getIdFromClassName($parent);
			$tab->name = array();
			foreach (Language::getLanguages(true) as $lang)
				$tab->name[$lang['id_lang']] = $name;
			$tab->class_name = $class_name;
			$tab->module = $this->name;
			$tab->active = 1;
			return $tab->add();
		}
		public function uninstallTab($class_name){
			$id_tab = (int)Tab::getIdFromClassName($class_name);
			$tab = new Tab((int)$id_tab);
			return $tab->delete();
		}
	//--------------------------------------bab 2 buat form--------------------------------------------
	//urutan method yg digunakan nama, process, kemudian assign
	
		public function hookDisplayCustomerAccount($params){
            return $this->display(__FILE__,'navigasi.tpl');
        }
                
                /*public function hookDisplayCustomerAccount($params)
		{
			$this->processProductTabContent();
			$this->assignProductTabContent();
			//$this->setMedia();
			return $this->display(__FILE__, 'KonfirmasiPembayaran.tpl');//buat baca file displayProductTabContent.tpl, jadi nanti yg ditampilin ini, yang return atas satunya tadi cuman buat ngecek jadi dikomen
		}
                
		public function assignProductTabContent(){
			//include jquery
                        $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-ui-1.8.10.custom.min.js');
			$this->context->controller->addJQueryUI('ui.datepicker');
                        $this->context->controller->addJQueryPlugin('validate');
                        //$this->context->controller->addCSS(_THEME_CSS_DIR_.'identity.css');
                        //validate harus buat sendiri jsnya
                        //$this->context->controller->addJS(_PS_JS_DIR_'validate.js');
		}
		public function processProductTabContent()
		{
			if(Tools::isSubmit('mymod_pc_submit_konfirmasi'))
			{
				$id_konfirmasi_produk = Tools::getValue('id_konfirmasi_produk');
				$no_order = Tools::getValue('no_order');
				$nama_bank = Tools::getValue('nama_bank');
				$nama_pengirim = Tools::getValue('nama_pengirim');
				$tanggal_transfer = Tools::getValue('tanggal_transfer');
				$jumlah_dana = Tools::getValue('jumlah_dana');
				//ketiga fungsi diatas untuk mengembalikan data yang dikirim oleh customer, yg dipanggil pada fungsi hookDisplayProductTabContent
				$insert = array(
					'id_konfirmasi_produk' => $id_konfirmasi_produk,
					'no_order' => $no_order,
					'nama_bank' => $nama_bank,
					'nama_pengirim' => $nama_pengirim,
					'tanggal_transfer' => $tanggal_transfer,
					'jumlah_dana' => $jumlah_dana,
				);
				Db::getInstance()->insert('konfirmasi_produk',$insert);
				//mulai dr insert sampai Db, digunakan untuk upload ke database (int) dan pSQL untuk menghindari SQL injection saja
				$this->context->smarty->assign('konfirmasi', 'ok');
			}
		}*/
		public function loadSQLFile($sql_file){
			// Get install SQL file content
			$sql_content = file_get_contents($sql_file);
			// Replace prefix and store SQL command in array
			$sql_content = str_replace('PREFIX_', _DB_PREFIX_, 
			$sql_content);
			$sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);
			// Execute each SQL statement
			$result = true;
			foreach($sql_requests as $request)
			if (!empty($request))
			$result &= Db::getInstance()->execute(trim($request));
			// Return result
			return $result;
		}
	}
?>