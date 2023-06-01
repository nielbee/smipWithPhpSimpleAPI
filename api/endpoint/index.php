<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <u><h1>PHP simple API by DanielBeeh</h1></u> 
    <hr><hr>
    <h1>Apa ini?</h1>

    Framework ini dirancang untuk kebutuhan dasar pembuatan API, dengan beberapa fitur antara lain :</br>
    <h4>1. Sistem login</h4>
    dengan menggunakan metode <b>generateTokenByAuth(params)</b>, akan mengembalikan token dalam format JSON, untuk diperhatikan bahwa didalam tabel yang digunakan diperlukan field 'role' untuk dapat menggunakan metode ini
    <h4>2. Pengamanan endpoint dengan sistem role</h4>
    endpoint yang dibuat dapat dibatasi oleh role dari pengguna, jalankan "create secure endpoint.bat" untuk membuat endpoint ini</br>
    - saat program terbuka, ketikan url endpoint.</br>
    - akan ada file baru di folder "./endpoint/URL-FILE.php"</br>
    - terdapat array yang berisi role yang bisa mengakses endpoint ini, ubah sesuai dengan kebutuhan</br>
    gunakan metode <b>getRoleFromToken(params)</b> untuk mendapatkan role yang dimiliki oleh pemilik token
    <h4>3. endpoint terbuka</h4>
    Endpoint ini dapat diakses secara umum. jalankan "create open endpoint.bat" untuk membuat endpoint ini
    <h4>4. Query ke JSON dengan mudah</h4>
    Secara otomatis, endpoint yang dibuat akan mengembalikan file JSON, dengan perintah <b>queryToJson(params)</b> akan otomatis mengembalikan hasil query select dalam format json
    <h4>5. CRUD database dengan mudah</h4>
    <hr>
    
</body>
</html>


