<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 作成した画面を実際にブラウザで確認する方法

- ターミナルでサーバーを起動する


VS Codeの下の方にある「ターミナル」に、以下のコマンドを打ち込んで Enter。  
```bash
php artisan serve
```

- URLにアクセスする


コマンドを打つと、ターミナルに以下のような表示が出る。  
Server running on [[http://127.0.0.1:8000](http://127.0.0.1:8000)]  
この [http://127.0.0.1:8000](http://127.0.0.1:8000) をクリックするか、ブラウザのURL欄に直接入力する。

- 作った画面を表示する


(例)タスク作成画面」を確認するには、URLの末尾に /tasks/create を付け足します。  
ブラウザに入力するURL：  
[http://127.0.0.1:8000/tasks/create](http://127.0.0.1:8000/tasks/create)