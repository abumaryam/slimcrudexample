# Contoh Penggunaan API dengan Slim

Buat databasenya dulu
```SQL

DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `nama_mahasiswa` varchar(255) NOT NULL ,
  `nim_mahasiswa` varchar(10) NOT NULL ,
  `umur_mahasiswa` int(11) NOT NULL COMMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='datatable demo table';

```



<ul>
<li>Test api</li>
<li>[get]http://localhost/namaaplikasi/api/v1/mahasiswas'</li>
<li>[get]http://localhost/namaaplikasi/api/v1/mahasiswa/{id}</li>
<li>[post]http://localhost/namaaplikasi/api/v1/create'</li>
<li>[put]http://localhost/namaaplikasi/api/v1/update/{id}</li>
<li>[delete]http://localhost/namaaplikasi/api/v1/delete/{id}</li>
</ul>

Sumber Aslinya dari: https://github.com/phpflow/rest-api-using-slim-framework
