CREATE TABLE IF NOT EXISTS `PREFIX_konfirmasi_produk` (
  `id_konfirmasi_produk` int(11) NOT NULL AUTO_INCREMENT,
  `no_order` varchar(10) NOT NULL,
  `nama_bank` varchar(25) NOT NULL,
  `nama_pengirim` varchar(25) NOT NULL,
  `tanggal_transfer` date NOT NULL,
  `jumlah_dana` int(10) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `date_add_konfirmasi` timestamp NULL DEFAULT NULL,
  `date_terkonfirmasi` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_konfirmasi_produk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;