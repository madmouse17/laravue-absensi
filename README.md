# LARAVEL VUE ABSENSI VERIFIKASI MUKA

Website ini adalah sistem absensi verifikasi muka berdasarkan dengan koordinat gps yang sudah ditentukan dan penggajian pegawai.

## Fitur

- Absensi dengan Verifikasi muka 
- Gps Koordinat
- Penggajian Pegawai
- Task Scheduller tanggal absensi


## Installasi

Download atau clone project github.

```sh
git clone https://github.com/madmouse17/laravue-absensi.git
```

Setelah selesai ketikkan ini pada terminal :

```sh
composer install
```
copy atau rubah nama env.example jadi .env dan isi kan nama database anda.
setelah itu ketikkan pada terminal 
```sh
php artisan migrate
php artisan key:generate
php artisan storage:link
php artisan optimize
php artisan db:seed
```
buka **app/http/kernel** cari schedule untuk mengatur tanggal absensi karyawan.
ketikkan ini diterminal
```sh
php artisan schedule:work
```
Jika ingin mensetting task scheduller silahkan kunjungi link ini: https://laravel.com/docs/8.x/scheduling

*\*NB:sebelum memulai absensi silahkan set lokasi dulu dan jangan lupa refresh web soalnya state nya masih belum bisa, jangan lupa membuat pegawai, jika absen melebihi radius yang ditentukan hanya bisa ijin saja, jika dijangkauan bisa absen masuk,ijin dan pulang, dan jangan lupa jalankan task scheduler.*

## User Interface

![admin](https://user-images.githubusercontent.com/33163281/146333803-811d6808-de66-493e-90be-06be4dd44b65.png)
![register](https://user-images.githubusercontent.com/33163281/146333795-5340e685-4d81-4c6a-bdca-72f2a7440a1d.png)
![presensi index](https://user-images.githubusercontent.com/33163281/146333810-3bbeb9b0-7a36-4f66-a66d-05a1e431ab71.png)
![presensi in or permission](https://user-images.githubusercontent.com/33163281/146333807-22cd0686-5de9-4b9e-b6b5-309ad6c779db.png)
![data absensi](https://user-images.githubusercontent.com/33163281/146333804-c3e2cd1d-d960-44e4-b39c-4b88d16fbec6.png)

## Plugins

| Plugin | README |
| ------ | ------ |
| Primevue | [https://www.primefaces.org/primevue/][PlDb] |
| faceapi.js | [https://github.com/justadudewhohacks/face-api.js/][PlGh] |
| Yajra | [https://github.com/yajra/laravel-datatables-html][PlGd] |
| MapBox | [https://www.mapbox.com/][PlOd] |





