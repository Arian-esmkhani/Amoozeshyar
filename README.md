# دانشگاه آزاد اسلامی - سامانه آموزشیار

این پروژه یک وب‌سایت مدرن برای دانشگاه آزاد اسلامی است که با استفاده از Laravel و Tailwind CSS ساخته شده است.

## ویژگی‌ها

-   طراحی مدرن و واکنش‌گرا
-   پشتیبانی از زبان فارسی و راست به چپ
-   اسلایدر اخبار و اطلاعیه‌ها
-   سیستم خبرنامه
-   بخش تماس با ما
-   پشتیبانی از موبایل و دسکتاپ

## نیازمندی‌ها

-   PHP >= 8.1
-   Composer
-   Node.js >= 16
-   npm

## نصب و راه‌اندازی

1. کلون کردن پروژه:

```bash
git clone https://github.com/yourusername/amoozeshyar.git
cd amoozeshyar
```

2. نصب وابستگی‌های PHP:

```bash
composer install
```

3. نصب وابستگی‌های Node.js:

```bash
npm install
```

4. کپی فایل تنظیمات:

```bash
cp .env.example .env
```

5. تولید کلید برنامه:

```bash
php artisan key:generate
```

6. اجرای مایگریشن‌ها:

```bash
php artisan migrate
```

7. کامپایل دارت‌ها:

```bash
npm run dev
```

8. اجرای سرور توسعه:

```bash
php artisan serve
```

## ساختار پروژه

```
amoozeshyar/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Livewire/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── public/
│   └── images/
└── routes/
```

## تکنولوژی‌های استفاده شده

-   Laravel 10
-   Tailwind CSS
-   Alpine.js
-   Livewire
-   Vazir Font

## مشارکت

برای مشارکت در پروژه، لطفاً مراحل زیر را دنبال کنید:

1. فورک کردن پروژه
2. ایجاد یک برنچ جدید (`git checkout -b feature/amazing-feature`)
3. کامیت تغییرات (`git commit -m 'Add some amazing feature'`)
4. پوش کردن به برنچ (`git push origin feature/amazing-feature`)
5. باز کردن یک Pull Request

## لایسنس

این پروژه تحت لایسنس MIT منتشر شده است. برای اطلاعات بیشتر، فایل `LICENSE` را مطالعه کنید.
